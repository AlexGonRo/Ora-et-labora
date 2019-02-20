<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$alert_msg = "";
$alert_type = "danger"; # Danger or success

$default_msg_success = "La solicitud se ha procesado correctamente. Si el correo electrónico que nos has proporcionado está asociado a una cuenta en Ora et Labora deberías recibir un mensaje en breve.";
$default_msg_danger = "Algo inesperado ha ocurrido mientras se procesaba la solicitud. Vuelve a intentarlo o contacta con el administrador si el problema persiste.";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once '../private/db_connect.php';
    require_once '../private/vars/global_vars.php';
    require_once '../private/vars/user_data_vars.php';
    require_once '../private/vars/encryption_vars.php';
    
    require_once '../utils/php/other/pass_generator.php';
    require_once '../utils/php/cookie_management/auth_cookie.php';


    require '../../../private/src/php/vendor/autoload.php';
    
    # Get $POST info
    $email = $_POST['email'];
    # Check if the email exists
    $email_query = mysqli_prepare($db,
    "SELECT id, username "
        . "FROM users "
        . "WHERE email=?");
    mysqli_stmt_bind_param($email_query, 's', $email);
    mysqli_stmt_execute($email_query);
    mysqli_stmt_bind_result($email_query, $user_id, $username);
    mysqli_stmt_fetch($email_query);
    mysqli_stmt_close($email_query);
    
    if(isset($username)){
        
        # Let's generate a random password
        $new_pass = get_pass(LIMIT_PASSWORD);
        $encrypted_pass = password_hash($new_pass, ENCRYPT_ALGORITHM, ENCRYPT_OPTIONS);  # Does it take too much time? Have a look at example 3 (http://php.net/manual/en/function.password-hash.php)

        
        # Delete all cookies of this user (Just in case so no one can login without using the new password)
        delete_server_cookie_by_user_id($user_id);
        
        # Read configuration file for username and password of our email
        $config = parse_ini_file(BASE_PATH_PRIVATE.'config.ini'); 
        
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = $config['email_host'];
            $mail->Port       = $config['email_port'];
            $mail->SMTPSecure = $config['email_SMTPSecure'];
            $mail->SMTPAuth   = $config['email_SMTPAuth'];
            if ($config['email_SMTPAuth']){
                $mail->Username = $config['email_admin'];
                $mail->Password = $config['email_pass'];
            }
            $mail->SetFrom($config['email_admin'], 'Ora et Labora');
            $mail->addAddress($email, $username);
            $mail->IsHTML(true);
            $mail->Subject = 'Recuperación de contraseña - Ora et Labora';
            $mail->Body    = "Buenos días <b>$username</b>, <br>"
                    . "¿Has solicitado una nueva contraseña para tu cuenta en <a href='http://orabora.net'>Ora et Labora</a>? Prueba a entrar usando la siguiente: <b>$new_pass</b><br>"
                    . "¿No has sido tú quien ha solicitado la contraseña? En tal caso es posible que alguien haya descubierto qué correo electrónico usas. Considera cambiarlo y contacta con nosotros en caso de que detectes alguna otra irregularidad. <br>"
                    . "Un saludo, <br>"
                    . "Alejandro";
            $mail->AltBody = "Buenos días $username, Has solicitado una nueva contraseña para http://orabora.net. Esta es tu nueva contraseña: $new_pass. ¿No has sido tú quien ha solicitado la contraseña? En tal caso es posible que alguien haya descubierto qué correo electrónico usas. Considera cambiarlo y contacta con nosotros en caso de que detectes alguna otra irregularidad. Un saludo, Alejandro.";
            if(!$mail->send()) {
                $alert_msg = $default_msg_danger;
                $alert_type = "danger";
            } else {
                $alert_msg = $default_msg_success;
                $alert_type = "success";
                # Did everything go well? Then update the db with the new password
                $email_query = mysqli_prepare($db,
                    "UPDATE users "
                        . "SET password = ? "
                        . "WHERE email=?");
                    mysqli_stmt_bind_param($email_query, 'ss', $encrypted_pass, $email);
                    mysqli_stmt_execute($email_query);
                    mysqli_stmt_close($email_query);
            }
            
        } catch (Exception $e) {    # Something happened when setting up PHPmailer
            $alert_msg = $default_msg_danger;
            $alert_type = "danger";
            echo $e->getMessage();
        }

        
    } else {
        # The email is not in our database, but we won't give that info to the user.
        usleep(rand(4000000,8000000));   # Just so the answer is not inmediate. Quick dirty patch, I know.
        $alert_msg = $default_msg_success;
        $alert_type = "success";
    }
}


require 'tmpl/forgotten_pass.php';