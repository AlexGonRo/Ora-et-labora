<?php 
require '../private/db_connect.php';
require '../private/vars/registration_vars.php';
require '../private/vars/encryption_vars.php';
require '../private/vars/global_vars.php';
require '../private/vars/user_data_vars.php';
require '../private/vars/names.php';
require '../private/vars/worker_vars.php';
require '../private/vars/land_resources_vars.php';
require '../private/vars/item_vars.php';
require '../private/vars/building_vars.php';
include '../utils/php/other/get_client_ip.php';
require '../utils/php/worker/create_worker.php';
require '../utils/php/time/get_ingame_time.php';
require '../utils/php/user/check_names_requirements.php';
require 'php/login_methods.php';
require '../utils/php/character/generate_date_birth.php';


$errors = array();
$default_char_name = '';    // Default values for the inputs in case a submission is made but not accepted.
$default_family_name='';
$default_role='0';
$default_property_name='';
$default_email='';

// If the user submited the registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  ob_start();   // Make sure we don't output anything until the end so we can redirect changing the header
  $family_name = $_POST['family_name'] ?? '';
  $char_name = $_POST['char_name'] ?? '';
  $property_name = $_POST['property_name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password_1 = $_POST['password_1'] ?? '';
  $password_2 = $_POST['password_2'] ?? '';
  $role = $_POST['role'] ?? '';
  $read_terms = $_POST['terms_checkbox'] ?? '';
  $forteen_or_more = $_POST['14_checkbox'] ?? '';

  # Are all the chosen names valid?
  $errors = validate_reg_form($family_name, $char_name, $property_name, $email,
          $password_1, $password_2, $read_terms, $forteen_or_more, $errors);
  
    if (count($errors) == 0) {
        $registration_output = register($family_name, $char_name, $property_name, $email, $password_1, $role, $errors);
        if($registration_output) {
            log_user_in($registration_output, $family_name);
            ob_end_flush(); # Output whatever we have
            exit();
        } else {
            array_push($errors, "Algo ha pasado mientras registrabamos al "
               . "usuario en nuestra base de datos.<br>"
               . "Por favor, intentalo de nuevo en un rato o contacta con el "
               . "administrador si el problema persiste.");
            // TODO I might need to create a better exception handlign system
        }
    }
    
    if(!empty($errors)){
        // Let's fill the form with the information the user already submitted
        $default_char_name = $char_name;
        $default_family_name= $family_name;
        $default_role= $role;
        $default_property_name= $property_name;
        $default_email= $email;
    }
  
}
ob_end_flush();

$registration_errors = implode("<br>", $errors);  // Pass errors to string format

require 'tmpl/register.php';

/**************************************************
 * ************************************************
 * Just validating all the information that we got
 * ************************************************
**************************************************/

// Check if all the information that was introduced during the registration 
// period is correct
function validate_reg_form($family_name, $char_name, $property_name, $email, 
        $password_1, $password_2, $read_terms, $forteen_or_more, $errors){
    
    $errors = all_info_filled($family_name, $char_name, $property_name, $email,
            $password_1, $password_2, $read_terms, $forteen_or_more, $errors);
    $errors = check_requirements($family_name, $char_name, $property_name, $email, $password_1, $password_2, $errors);
    return $errors;
}

// Ensures that the form is correctly filled
function all_info_filled($family_name, $char_name, $property_name, $email, 
        $password_1, $password_2, $read_terms, $forteen_or_more, $errors){

  if (empty($family_name)) { array_push($errors, "El apellido familiar es obligatorio."); }
  if (empty($char_name)) { array_push($errors, "El nombre del personaje es obligatorio."); }
  if (empty($property_name)) { array_push($errors, "Se necesita un nombre para el castillo/monasterio"); }
  if (empty($email)) { array_push($errors, "Necesitamos una dirección de correo válida."); }
  if (empty($password_1)) { array_push($errors, "Se necesita una contraseña."); }
  if (empty($password_2)) { array_push($errors, "Se necesita confirmar la contraseña."); }
  if (empty($read_terms)) { array_push($errors, "Necesitas aceptar los Términos y condiciones."); }
  if (empty($forteen_or_more)) { array_push($errors, "Necesitas ser mayor de 14 años o el consentimiento de tus padres/tutores."); }
  return $errors;

}

function check_requirements($family_name, $char_name, $property_name, $email, $password_1, $password_2, $errors){

    $errors = check_family_name_req($family_name, MIN_FAMILY_NAME, LIMIT_FAMILY_NAME, OTHER_CHARS, MY_REGEX, $errors);
    $errors = check_char_name_req($char_name, MIN_CHAR_NAME, LIMIT_CHAR_NAME, OTHER_CHARS, MY_REGEX, $errors);
    $errors = check_email_req($email, OTHER_CHARS_EMAIL, MY_REGEX, $errors);
    $errors = check_property_name_req($property_name, MIN_PROPERTY_NAME, LIMIT_PROPERTY_NAME, OTHER_CHARS, MY_REGEX, $errors);
    $errors = check_pass_req($password_1, $password_2, MIN_PASSWORD, LIMIT_PASSWORD, OTHER_CHARS_PASS, MY_REGEX, $errors);
  
    return $errors;
    
}

/*************************************************
**************************************************/

function handle_registration_error($step_name, $error, $user_id = null, 
        $my_field_id=null, $my_pantry_id=null, $my_warehouse_id=null){
    
    $keep_going = False;
    echo $error;
    if ($step_name == "insert_worker_query"){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM workers WHERE owner_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "fill_warehouse_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM warehouses WHERE building_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $my_warehouse_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "fill_pantry_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM pantries WHERE building_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $my_pantry_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_buildings_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM buildings WHERE owner_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_castle_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM castles_monasteries WHERE owner_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_field_info_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM field_resource WHERE resource_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $my_field_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_resource_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM land_resources WHERE owner_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_village_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM towns WHERE owner_id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_char_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM characters WHERE belongs_to = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    if ($step_name == "create_user_query" || $keep_going){
        $delete_query = mysqli_prepare($GLOBALS['db'],
            "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($delete_query, "i", $user_id);
        mysqli_stmt_execute($delete_query);
        mysqli_stmt_close($delete_query);
        $keep_going = True;
    }
    return ;
}


// Register a new user into the system
function register($family_name, $char_name, $property_name, $email, $password, $role, $errors){     //TODO Error control here is quite basic
    
    # Encript pass
    $encrypted_password = password_hash($password, ENCRYPT_ALGORITHM, ENCRYPT_OPTIONS);  # Does it take too much time? Have a look at example 3 (http://php.net/manual/en/function.password-hash.php)
    
    // Create user
    try {
        $create_user_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO users (username, email, password, role, kingdom_id) VALUES(?,?,?,?,".INIT_KINGDOM_ID.")");
        mysqli_stmt_bind_param($create_user_query, "sssi", $family_name, $email, $encrypted_password, $role);
        mysqli_stmt_execute($create_user_query);
        mysqli_stmt_close($create_user_query);
    } catch(Exception $e) {
        handle_registration_error('create_user_query', $e->getMessage());
        return False ;
    }
    
    // --------------------------------------
    // --------------------------------------

    try {
        // Get user's id
        $get_user_id_query = mysqli_prepare($GLOBALS['db'],
                "SELECT id FROM users WHERE username=? LIMIT 1");
        mysqli_stmt_bind_param($get_user_id_query, "s", $family_name);
        mysqli_stmt_execute($get_user_id_query);
        mysqli_stmt_bind_result($get_user_id_query, $user_id);
        mysqli_stmt_fetch($get_user_id_query);
        mysqli_stmt_close($get_user_id_query);


        // Get current in-game time
        $get_ingame_time_query = mysqli_prepare($GLOBALS['db'],
                "SELECT value_char FROM variables WHERE name='time' LIMIT 1");
        mysqli_stmt_execute($get_ingame_time_query);
        mysqli_stmt_bind_result($get_ingame_time_query, $ingame_time);
        mysqli_stmt_fetch($get_ingame_time_query);
        mysqli_stmt_close($get_ingame_time_query);

    // --------------------------------------
    // --------------------------------------
    // Create character
    
        $create_char_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO characters (name, belongs_to, age, birthday, location_id) 
                      VALUES(?, ?, ".DEFAULT_CHAR_AGE.", ?, ".INIT_REGION_ID.")");
        $birthday = generate_date_birth($ingame_time, 25);
        mysqli_stmt_bind_param($create_char_query, "sis", $char_name, $user_id, $birthday );
        mysqli_stmt_execute($create_char_query);
        mysqli_stmt_close($create_char_query);
    
    } catch (Exception $e) {
        handle_registration_error('create_char_query', $e->getMessage(),$user_id);
        return False ;
    }

    // --------------------------------------
    // --------------------------------------
    // Create new village

    try {

        $create_village_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO `towns`(`name`,`population` ,`region_id`, `kingdom_id`, `owner_id`) "
                . "VALUES ('".INIT_TOWN_NAME."', ".INIT_TOWN_POPULATION.", ".INIT_REGION_ID.", ".INIT_KINGDOM_ID.", ?)");

        mysqli_stmt_bind_param($create_village_query, "i", $user_id);
        mysqli_stmt_execute($create_village_query);
        mysqli_stmt_close($create_village_query);
    
    } catch (Exception $e) {
        handle_registration_error('create_village_query', $e->getMessage(),$user_id);
        return False ;
    }
    
    // --------------------------------------
    // --------------------------------------
    // Create fields
    try {
        // Get village's id
        $get_village_query = mysqli_prepare($GLOBALS['db'],
                "SELECT id FROM towns WHERE owner_id= ? ");
        mysqli_stmt_bind_param($get_village_query, "i", $user_id);
        mysqli_stmt_bind_result($get_village_query, $town_id);
        mysqli_stmt_execute($get_village_query);
        mysqli_stmt_fetch($get_village_query);
        mysqli_stmt_close($get_village_query);
                        
        // Create fields
        $create_resource_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO land_resources(resource, region_id, owner_id, town_id) "
                . "VALUES (".FIELD_RES_ID.", ".INIT_REGION_ID.", ?, ?), "
                . "(".QUARRY_RES_ID.", ".INIT_REGION_ID.", ?, ?)");
        
        mysqli_stmt_bind_param($create_resource_query, "iiii", $user_id, $town_id,
                $user_id, $town_id);
        mysqli_stmt_execute($create_resource_query);
        mysqli_stmt_close($create_resource_query);
        
    } catch (Exception $e) {
        handle_registration_error('create_resource_query', $e->getMessage(),$user_id);
        return False ;
    }
    # -------------------------------------------
    # Insert information about the field in the corresponding table    
    try {
        # Get field id
        $get_field_query = mysqli_prepare($GLOBALS['db'],
            "SELECT id FROM land_resources WHERE owner_id= ? AND resource = ".FIELD_RES_ID);
        mysqli_stmt_bind_param($get_field_query, "i", $user_id);
        mysqli_stmt_bind_result($get_field_query, $my_field_id);
        mysqli_stmt_execute($get_field_query);
        mysqli_stmt_fetch($get_field_query);
        mysqli_stmt_close($get_field_query);


        $create_field_info_query = mysqli_prepare($GLOBALS['db'],
        "INSERT INTO field_resource (resource_id) VALUES (?)");
        mysqli_stmt_bind_param($create_field_info_query, "i", $my_field_id);
        mysqli_stmt_execute($create_field_info_query);
        mysqli_stmt_close($create_field_info_query);

    } catch (Exception $e) {
        handle_registration_error('create_field_info_query', $e->getMessage(),$user_id, $my_field_id);
        return False ;
    }
    
    
    // --------------------------------------
    // --------------------------------------
    // Create user's castle/monastery
    try {
        $create_castle_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO castles_monasteries (name, owner_id, region_id, town_id) 
                      VALUES(?, ?, ".INIT_REGION_ID.", ?)");
        mysqli_stmt_bind_param($create_castle_query, "sii", $property_name, $user_id, $town_id);
        mysqli_stmt_execute($create_castle_query);
        mysqli_stmt_close($create_castle_query);
    
    } catch (Exception $e) {
        handle_registration_error('create_castle_query', $e->getMessage(),$user_id, $my_field_id);
        return False ;
    }
    
    
    # Get castle/monastery id
    $get_castle_query = mysqli_prepare($GLOBALS['db'],
        "SELECT id FROM castles_monasteries WHERE owner_id= ?");
    mysqli_stmt_bind_param($get_castle_query, "i", $user_id);
    mysqli_stmt_bind_result($get_castle_query, $castle_id);
    mysqli_stmt_execute($get_castle_query);
    mysqli_stmt_fetch($get_castle_query);
    mysqli_stmt_close($get_castle_query);
    
    
    
    // --------------------------------------
    // --------------------------------------
    // Create buildings
    
    if ($role=='1'){
        $query = "INSERT INTO `buildings`(`building_id`, `owner_id`, `castle_mon_id`)"
            . " VALUES (".CLAUSTRO_ID.", ?, ?)";
    } else {
        $query = "INSERT INTO `buildings`(`building_id`, `owner_id`, `castle_mon_id`)"
            . " VALUES (".PATIO_ID.", ? , ?)";
    }
    $query = $query . ", (".KITCHEN_ID.", ? , ?), (".PANTRY_ID.", ? , ?), (".WAREHOUSE_ID.", ? , ?), (".DORMITORY_ID.", ? , ?)";
    
    try {
        $create_buildings_query = mysqli_prepare($GLOBALS['db'], $query);
        
        mysqli_stmt_bind_param($create_buildings_query, "iiiiiiiiii", $user_id, $castle_id, 
                $user_id, $castle_id, $user_id, $castle_id, $user_id, $castle_id, $user_id, $castle_id);
        mysqli_stmt_execute($create_buildings_query);
        mysqli_stmt_close($create_buildings_query);
    
    } catch (Exception $e) {
        handle_registration_error('create_buildings_query', $e->getMessage(), $user_id, $my_field_id);
        return False ;
    }
    
    // --------------------------------------
    // --------------------------------------
    // Initialize user's possessions
    
    
    try {
        // Get pantry id and warehouse id
        $get_buildings_query = mysqli_prepare($GLOBALS['db'],
            "SELECT id, building_id FROM buildings "
                . "WHERE owner_id= ? AND (building_id=".PANTRY_ID." OR building_id=".WAREHOUSE_ID.") "
                . "ORDER BY building_id ASC"); // TODO We assume that pantry_id is lower than warehouse_id
        mysqli_stmt_bind_param($get_buildings_query, "i", $user_id);
        mysqli_stmt_execute($get_buildings_query);
        mysqli_stmt_bind_result($get_buildings_query, $my_id, $tmp);
        $flag =  True;
        while (mysqli_stmt_fetch($get_buildings_query)) {
            if ($flag){
                $my_pantry_id = $my_id;
                $flag=False;
            } else {
                $my_warehouse_id = $my_id;
            }
        }
        mysqli_stmt_close($get_buildings_query);
    
        // Fill the pantry
        $fill_pantry_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO `pantries`(`building_id`, `item_id`, `quantity`) "
                . "VALUES (?,".BREAD_ID.",".INIT_BREAD."), "
                . "(?,".VEGETABLES_ID.",".INIT_VEGETABLES.")");
        mysqli_stmt_bind_param($fill_pantry_query, "ii", $my_pantry_id, $my_pantry_id);
        mysqli_stmt_execute($fill_pantry_query);
        mysqli_stmt_close($fill_pantry_query);
    
    } catch (Exception $e) {
        handle_registration_error('fill_pantry_query', $e->getMessage(), $user_id, $my_field_id, $my_pantry_id);
        return False ;
    }
    
    // Fill the warehouse
    try {
        $fill_warehouse_query = mysqli_prepare($GLOBALS['db'],
            "INSERT INTO `warehouses`(`building_id`, `item_id`, `quantity`) "
                . "VALUES (?,".WOOD_ID.",".INIT_WOOD.")");
        mysqli_stmt_bind_param($fill_warehouse_query, "i", $my_warehouse_id);
        mysqli_stmt_execute($fill_warehouse_query);
        mysqli_stmt_close($fill_warehouse_query);
    
    } catch (Exception $e) {
        handle_registration_error('fill_warehouse_query', $e->getMessage(), $user_id, $my_field_id, $my_pantry_id, $my_warehouse_id);
        return False ;
    }
    
    // --------------------------------------
    // --------------------------------------
    // Create new workers
    
    for ( $i = 0; $i < INIT_WORKERS; $i++ )
    {
        try{
            create_insert_worker(FRENCH_NAMES, FRENCH_SURNAMES,
                $user_id, INIT_REGION_ID, $castle_id);
        } catch (Exception $e) {
            handle_registration_error('insert_worker_query', $e->getMessage(), $user_id, $my_field_id, $my_pantry_id, $my_warehouse_id);
            return False ;
        }
    }


    return $user_id;    # If everything went smoothly , this is the id of the new member
}


