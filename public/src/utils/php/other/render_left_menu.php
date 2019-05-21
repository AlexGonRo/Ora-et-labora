<?php

function render_left_menu($type, $role='', $pre_path=''){
    # For some menus we need to know the role of the user
    if($role=='' && ($type=='castle' || $type=='fief' || $type=='diplo')){
        $user_info_query = mysqli_prepare($GLOBALS['db'],
            'SELECT role FROM users WHERE id=?');
        mysqli_stmt_bind_param($user_info_query, "i", $_SESSION['user_id']);
        mysqli_stmt_bind_result($user_info_query, $role);
        mysqli_stmt_execute($user_info_query);
        mysqli_stmt_fetch($user_info_query);
        mysqli_stmt_close($user_info_query);
    }
    ob_start();
    if ($type == 'castle'){
        $buildings = check_for_buildings();
        ?>
        <li><a href="<?php echo $pre_path ?>index.php">Inicio</a></li>
        <li><a href="<?php echo $pre_path ?>workers.php"><?php if ($role) {echo "Monjes"; } else {echo "Trabajadores"; } ?></a></li>
        <li><a href="<?php echo $pre_path ?>buildings.php">Edificios</a></li>
        <li><a href="<?php echo $pre_path ?>store.php">Almacenes</a></li>
        <li><a href="<?php echo $pre_path ?>produce.php">Fabricación</a></li>
        
        
        <li><a <?php if(!$buildings['garden']) echo "class='btn-link disabled'";?> 
                href="<?php echo $pre_path ?>garden.php">Huerta</a></li>
        
        <li><a <?php if(!$buildings['garden']) echo "class='btn-link disabled'";?> 
                href="<?php echo $pre_path ?>animals.php">Animales</a></li>
        
        
        <!-- <li><a href="<?php echo $pre_path ?>treasures.php">Tesoros y biblioteca</a></li> -->
        <?php
    } else if ($type == 'diplo'){?>
            <li><a href="<?php echo $pre_path ?>index.php">Bandeja de entrada</a></li>
            <li><a href="<?php echo $pre_path ?>sent_pm.php">Bandeja de salida</a></li>
            <li><a href="#">Bandos</a></li>
            <li><a href="#">Acuerdos y tratados</a></li>
            <li><a href="#">Contratos feudales</a></li>
            <li><a href="#"> <?php if ($role) {echo "Orden religiosa"; } else {echo "Gremio"; } ?> </a></li>
        <?php 
    } else if ($type == 'fief'){
        ?>
        <li><a href="<?php echo $pre_path ?>index.php">Inicio</a></li>
        <li><a class='btn-link disabled' href="<?php echo $pre_path ?>vasals.php"><?php if ($role) {echo "Mis subordinados"; } else {echo "Mis vasallos"; } ?></a></li>
        <li><a href="<?php echo $pre_path ?>land.php">Tierras</a></li>
        <li><a href="<?php echo $pre_path ?>towns.php">Pueblos y villas</a></li>
        <?php
    } else if ($type == 'help'){
        ?>
        
        <?php
    } else if ($type == 'map'){
        ?>
        <li><a href="<?php echo $pre_path ?>index.php">Mapa</a></li>

        <?php
    } else if ($type == 'market'){
        ?>
        <li><a href="<?php echo $pre_path ?>index.php">Inicio</a></li>
        <li><a href="<?php echo $pre_path ?>market.php">Mapa</a></li>
        <li><a href="<?php echo $pre_path ?>trade_route.php">Ruta comercial</a></li>
        
        <?php
    } else if ($type == 'profile'){
        ?>
        <li><a href="<?php echo $pre_path ?>index.php">Inicio</a></li>
        <li><a href="<?php echo $pre_path ?>profile.php">Perfil y dinastía</a></li>
        <li><a href="<?php echo $pre_path ?>conf.php">Configuración</a></li>
        <?php
    } else if ($type == 'ranking'){
        ?>
        <li><a href="<?php echo $pre_path ?>index.php">Inicio</a></li>
        <?php
    } else {
        ?>
        
        <?php
    }
    
    return ob_get_clean();
}


function check_for_buildings(){
    
    require_once "../../private/vars/building_vars.php";
    
    $buildings = array();
    $buildings['garden'] = False;
    $buildings['stable'] = False;
    
    // Does the user have this building?
    $buildings_query = mysqli_prepare($GLOBALS['db'],
        'SELECT building_id '
            . 'FROM buildings '
            . 'WHERE owner_id=?');
    mysqli_stmt_bind_param($buildings_query, "i", $_SESSION['user_id']);
    mysqli_stmt_bind_result($buildings_query, $building_id);
    mysqli_stmt_execute($buildings_query);
    while(mysqli_stmt_fetch($buildings_query)){
        
        // Check for gardens
        if ($building_id == GARDEN_ID){
            $buildings['garden'] = True;
            continue;
        }
        
        // Check for stable
        if ($building_id == STABLE_ID){
            $buildings['stable'] = True;
            continue;
        }
        
        // Check for ...
        
        
    }
    mysqli_stmt_close($buildings_query);
    
    return $buildings;
}