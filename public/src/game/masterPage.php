<?php
require_once '../../utils/php/other/render_left_menu.php';

# ------------------------------------
# Master page logic
#-------------------------------------

# Let's get all the info we need to create the master page
$user_info_query = mysqli_prepare($db,
    'SELECT role, fame, money FROM users WHERE id=?');
mysqli_stmt_bind_param($user_info_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($user_info_query, $role, $fame, $money);
mysqli_stmt_execute($user_info_query);
mysqli_stmt_fetch($user_info_query);
mysqli_stmt_close($user_info_query);

$char_info_query = mysqli_prepare($db,
    'SELECT a.name, a.location_id, b.name FROM characters AS a INNER JOIN regions AS b ON a.location_id=b.id WHERE belongs_to=? AND death IS NULL');
mysqli_stmt_bind_param($char_info_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($char_info_query, $char_name, $char_location_id, $char_location_name);
mysqli_stmt_execute($char_info_query);
mysqli_stmt_fetch($char_info_query);
mysqli_stmt_close($char_info_query);

//Count the number of new messages the user has
$new_messages_query = mysqli_prepare($db,
    'SELECT count(*) AS nb_new_pm FROM pm WHERE (user2=? and is_read=0)');
mysqli_stmt_bind_param($new_messages_query, "i", $_SESSION['user_id']);
mysqli_stmt_bind_result($new_messages_query, $nb_new_pm);
mysqli_stmt_execute($new_messages_query);
mysqli_stmt_fetch($new_messages_query);
mysqli_stmt_close($new_messages_query);

// Get ingame time
$ingame_time_query = mysqli_prepare($db,
    "SELECT value_char FROM variables WHERE name='time'");
mysqli_stmt_bind_result($ingame_time_query, $ingame_time);
mysqli_stmt_execute($ingame_time_query);
mysqli_stmt_fetch($ingame_time_query);
mysqli_stmt_close($ingame_time_query);

$ingame_time_str = str_replace("_", "-", $ingame_time)

?>
<!DOCTYPE html>
<html>
    
<head>
    <title><?php echo $page_title?></title>
    
    <!-- Favicon for the browser tabs. From https://realfavicongenerator.net/ -->
    <link rel="shortcut icon" href="../../../img/oet_favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="../../../img/oet_favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../../img/oet_favicon/favicon-16x16.png">
    <link rel="manifest" href="../../../img/oet_favicon/site.webmanifest">  <!--For android's menu-->
    <link rel="mask-icon" href="../../../img/oet_favicon/safari-pinned-tab.svg" color="#5bbad5"> <!--For safary-->
    <link rel="apple-touch-icon" sizes="60x60" href="../../../img/oet_favicon/apple-touch-icon.png"> <!--Apple phone-->
    <meta name="theme-color" content="#ffffff"> <!--For the iOS menu icon, I believe-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- --------- Load JQuery and Bootstrap -----------
    ---------------------------------------------------- -->
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <!-- jQuery local fallback -->
    <script>window.jQuery || document.write('<script src="../../jquery/jquery-3.3.1.js"><\/script>')</script>
    <!-- Bootstrap JS CDN -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap JS local fallback -->
    <script>if(typeof($.fn.modal) === 'undefined') {document.write('<script src="../../bootstrap-4.1.3/js/bootstrap.min.js"><\/script>')}</script>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Bootstrap CSS local fallback -->
    <div id="bootstrapCssTest" class="hidden"></div>
    <script>
      $(function() {
        if ($('#bootstrapCssTest').is(':visible')) {
          $("head").prepend('<link rel="stylesheet" href="../../boostrap-4.1.3/css/boostrap.min.css">');
        }
      });
    </script>
    <!-- ---------------------------------------------------
    ---------------------------------------------------- -->
    <!--LOCAL CSS style page -->
    <link rel="stylesheet" href="../../css/style.css">
    <!--My own js files-->
    <?php echo $my_js_scripts ?? ''; ?>
    
</head>

<body>

    <div id="header">
    
        <div id="game_logo_div" class="d-none d-md-block">  <!--This hides the title in the mobile version-->
            <img id="game_logo" class="img-fluid" src="../../../img/oel_logo/logo_half_size.png"  alt="Ora et Labora logo">
        </div>
    
        <!-- Navigation var -->
        <nav class="navbar navbar-expand-md my_navbar">
            <!-- Nav bar button for movile versions-->
            <button class="navbar-toggler navbar-toggler-left d-md-none" type="button" data-toggle="collapse" data-target="#my_collapsable_navbar">
            &#9776;
            </button>
            <!--Ora et Labora logo for mobile versions-->
            <a class="navbar-brand d-md-none">
                <img id="img_logo_in_navbar" src="../../../img/oel_logo/logo_sixth_size.png" class="img-fluid" alt="Ora et Labora logo">
            </a>

            <!-- Links -->
            <div id="my_collapsable_navbar" class="collapse navbar-collapse sidenav">
                
                <!-- For the mobile version, info about the user -->
                <div id="user_info_in_navbar">
                        <?php if ($role == '0') {
                            echo "<b> Señor: </b>".$char_name."<br>"; 
                        } else {
                            echo "<b> Abad: </b>".$char_name."<br>";
                        }
                        ?>
                        <!-- <td><center>Rango: TO DO</center></td> -->
                        <b>Ubicación: </b> <?php echo "<a href='".BASE_URL."src/game/map/region.php?id=$char_location_id'>$char_location_name</a>" ?><br>
                        <b>Prestigio: </b> <?php echo $fame ?><br>
                        <b>Oro: </b> <?php echo $money ?><br>
                        <b>Fecha: </b> <?php echo $ingame_time_str?> <br>
                </div>
                
                <ul class="navbar-nav my_navbar_list">
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../profile/index.php">Perfil</a>
                    <div class="d-md-none navbar_subopt">
                        <ul>
                            <?php echo render_left_menu('profile', $role, '../profile/'); ?>
                        </ul>
                    </div>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../castle/index.php">
                        <?php 
                        if ($role==0) {
                            echo "Mi castillo";
                        }
                        else {
                            echo "Mi abadía";
                        }
                        ?>
                    </a>
                    <div class="d-md-none navbar_subopt">
                        <ul>
                            <?php echo render_left_menu('castle', $role, '../castle/'); ?>
                        </ul>
                    </div>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../fief/index.php">Mi feudo</a>
                    <div class="d-md-none navbar_subopt">
                        <ul>
                            <?php echo render_left_menu('fief', $role, '../fief/'); ?>
                        </ul>
                    </div>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../map/index.php">Mapa</a>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../market/index.php">Mercado</a>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../diplo/index.php">Diplomacia</a>
                    <div class="d-md-none navbar_subopt">
                        <ul>
                            <?php echo render_left_menu('diplo', $role, '../diplo/'); ?>
                        </ul>
                    </div>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../ranking/index.php">Clasificación</a>
                    <div class="d-md-none navbar_subopt">
                        <ul>
                            <?php echo render_left_menu('ranking', $role, '../ranking/'); ?>
                        </ul>
                    </div>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="#">Foro</a>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../help/index.php">Ayuda</a>
                  </li>
                  <li class="nav-item my_navbar_list_item">
                    <a class="nav-link my_navbar_list_a" href="../../front/logout.php">Logout</a>
                  </li>
                </ul>
            </div>
        </nav> 
    
        <!-- General user information -->
        <div id="user_info">
            <table id="user_info_table">
                <tbody>
                    <tr>
                        <td><center><?php
                        if ($role == '0') {
                            echo "<b> Señor: </b>".$char_name; 
                        } else {
                            echo "<b> Abad: </b>".$char_name;
                        }
                        ?>
                        </center></td>
                        <!-- <td><center>Rango: TO DO</center></td> -->
                        <td><center><b>Ubicación: </b> <?php echo "<a href='".BASE_URL."src/game/map/region.php?id=$char_location_id'>$char_location_name</a>" ?></center></td>
                        <td><center><b>Prestigio: </b> <?php echo $fame ?></center></td>
                        <td><center><b>Oro: </b> <?php echo $money ?></center></td>
                        <td><center><b>Fecha: </b> <?php echo $ingame_time_str?></center></td>
                    </tr>
                </tbody>
            </table>
       </div>

        <!--Space for pop-->
        <div class="my_alerts">
            <?php echo $alerts_html ?? ''; ?>
        </div>
        
    </div>
    
    <!--General structure of the page-->
    <div class="container-fluid my_body">
        <div class="row">
            <div class="col-md-2 d-none d-md-block pr-md-1">
                <div class="left_body">
                    <div class="left_menu">
                        <ul class="left_list">
                            <?php echo $left_list_html ?? ''; ?>
                        </ul>
                    </div>    
                </div>
            </div>

            <div class="col-md-10 col-sm-12 col-xs-12 no_padding_tablet_phone">
                <div class="right_body">
                    <div class="page_title horizontal_separator pb-1 mb-3">
                        <h3> <b><?php echo $page_title; ?> </b></h3>
                    </div>
                    <div class="content">
                            <?php echo $content_html; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
