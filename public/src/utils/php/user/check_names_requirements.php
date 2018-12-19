<?php


function check_family_name_req($family_name, $min_family_name, $limit_family_name, $other_chars, $my_regex, $errors){
    
    if(strlen($family_name) > $limit_family_name) {
        array_push($errors, "El apellido familiar debe tener menos de " . $limit_family_name . " caracteres.");
    }
    
    if(strlen($family_name) < $min_family_name) {
        array_push($errors, "El apellido familia debe tener más de " . $min_family_name . " caracteres.");
    }
    
    // Let's make sure that both the sting values are all alphanumeric
    if (!preg_match($my_regex, str_replace($other_chars, '', $family_name))){
        array_push($errors, 'El apellido familiar contiene caracteres no válidos.');
    }
    
    // first check the database to make sure 
    // a user does not already exist with the same username
    try {
        $user_check_query = mysqli_prepare($GLOBALS['db'],
            "SELECT username FROM users WHERE username=? LIMIT 1");
        mysqli_stmt_bind_param($user_check_query, "s", $family_name);
        mysqli_stmt_execute($user_check_query);
        mysqli_stmt_bind_result($user_check_query, $my_family_name);
        mysqli_stmt_fetch($user_check_query);
        if (!is_null($my_family_name)) { // if user exists
            if ($my_family_name == $family_name) {
              array_push($errors, "Este apellido familiar ya existe.");
            }
        }
        mysqli_stmt_close($user_check_query);
    } catch (Exception $e){
        array_push($errors, 'Hubo un problema con la base de datos. Por favor, intentalo de nuevo.');
    }
    
    return $errors;
}

function check_email_req($email, $other_chars_email, $my_regex, $errors){
    // Let's make sure that both the sting values are all alphanumeric
    if (!preg_match($my_regex, str_replace($other_chars_email, '', $email))){
        array_push($errors, 'Tu correo electrónico no tiene el formato adecuado.');
    }
    
    // first check the database to make sure 
    // a user does not already exist with the same email
    try {
        $user_check_query = mysqli_prepare($GLOBALS['db'],
            "SELECT email FROM users WHERE email=? LIMIT 1");
        mysqli_stmt_bind_param($user_check_query, "s", $email);
        mysqli_stmt_execute($user_check_query);
        mysqli_stmt_bind_result($user_check_query, $my_mail);
        mysqli_stmt_fetch($user_check_query);
        if (!is_null($my_mail)) { // if user exists
            if ($my_mail == $email) {
              array_push($errors, "Este correo electrónico ya existe");
            }
        }
        mysqli_stmt_close($user_check_query);
    } catch (Exception $e){
        array_push($errors, 'Hubo un problema con la base de datos mientras buscábamos por correos similares. Por favor, intentalo de nuevo.');
    }

    return $errors;
    
}

function check_property_name_req($property_name, $min_property_name, $limit_property_name, $other_chars, $my_regex, $errors){
    if(strlen($property_name) > $limit_property_name) {
        array_push($errors, "El nombre de tu castillo/monasterio debe tener menos de " . $limit_property_name . " caracteres.");
    }
    if(strlen($property_name) < $min_property_name) {
        array_push($errors, "El nombre de tu castillo/monasterio debe tener más de " . $min_property_name . " caracteres.");
    }
    return $errors;
    
    // Let's make sure that both the sting values are all alphanumeric
    if (!preg_match($my_regex, str_replace($other_chars, '', $property_name))){
        array_push($errors, 'El nombre de tu castillo/monasterio contiene carateres no válidos.');
    }   
    
}

function check_pass_req($password_1, $password_2, $min_password, $limit_password, $other_chars_pass, $my_regex, $errors){
    if ($password_1 != $password_2) {
	array_push($errors, "¡Las contraseñas no coinciden!");
    }
    
    if(strlen($password_1) > $limit_password) {
        array_push($errors, "Tu contraseña debe tener menos de " . $limit_password . " caracteres.");
    }
    if(strlen($password_1) < $min_password) {
        array_push($errors, "Tu contraseña debe tener más de " . $min_password . " caracteres.");
    }
    
    // Let's make sure that both the sting values are all alphanumeric (we also allow for spaces. And '.',',(commas)','-' and '_' for passwords )
    if (!preg_match($my_regex, str_replace($other_chars_pass, '', $password_1))){
        array_push($errors, 'Tu contraseña tiene caracteres inapropiados.');
    }
    
    return $errors;
    
}

function check_char_name_req($char_name, $min_char_name, $limit_char_name, $other_chars, $my_regex, $errors){
    
    if(strlen($char_name) > $limit_char_name) {
        array_push($errors, "El nombre de tu personaje debe tener menos de " . $limit_char_name . " caracteres.");
    }
    if(strlen($char_name) < $min_char_name) {
        array_push($errors, "El nombre de tu personaje debe tener más de " . $min_char_name . " caracteres.");
    }
    
    
    // Let's make sure that both the sting values are all alphanumeric
    if (!preg_match($my_regex, str_replace($other_chars, '', $char_name))){
        array_push($errors, 'El nombre de tu personaje contiene caracteres no válidos.');
    }    
    
    return $errors;
    
}