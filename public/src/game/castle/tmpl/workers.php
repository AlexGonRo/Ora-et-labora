<?php

if($role){
    $page_title = "Monjes";
} else {
    $page_title = "Trabajadores";
}

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($workers, $travel_workers, $available_tasks, $occupied, $total_space, $role);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/hire_worker.js"></script>
    <?php
    return ob_get_clean();
}

function render_content($workers, $travel_workers, $available_tasks, $occupied, $total_space, $role){ 
    ob_start();
    ?>
        <div class="content_block">
            <div class="float-right mb-3 slightly_bigger_text">
                <b> Espacio ocupado: </b> <?php echo "$occupied/$total_space" ?> <br />
            </div>

            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                <th>Trabajador</td>
                <th class="centered_td" scope="col">Edad</td>
                <th class="centered_td" scope="col">Fuerza</td>
                <th class="centered_td" scope="col">Destreza</td>
                <th class="centered_td" scope="col">Carisma</td>
                <th scope="col">Tarea</td>
                <th class="centered_td" scope="col">Nueva tarea</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($workers as $worker) { ?>
                    <tr>
                    <td> <?php echo $worker['name']; ?> </td>
                    <td class="centered_td"> <?php echo $worker['age']; ?> </td>
                    <td class="centered_td"> <?php echo $worker['str_stars']; ?></td>
                    <td class="centered_td"> <?php echo $worker['dex_stars']; ?> </td>
                    <td class="centered_td"> <?php echo $worker['char_stars']; ?> </td>
                    <td id='<?php echo $worker['id']."_task"; ?>'> <?php echo ucfirst($worker['task']); ?> </td>

                    <td class="centered_td"> <select id="<?php echo $worker['id']; ?>" name='task'>
                    <?php foreach ($available_tasks as $a_task){ ?>
                        <option value='<?php echo $a_task ?>'><?php echo ucfirst($a_task); ?></option>
                    <?php } ?>
                    </select> </td>

                    </tr>
                    <!--Listener in case the user selects a different value-->
                    <script>
                    $(document).ready(function() {  
                        $('#<?php echo $worker['id'] ?>').on('change', function(){
                            new_job = $(this).find("option:selected").attr('value');
                             $.ajax({
                                type: 'POST',
                                url: 'php/ajax/change_job.php',
                                data: {
                                    'worker_id':<?php echo $worker['id'] ?>,
                                    'new_job':new_job
                                },
                                success: function(data) {
                                    document.getElementById("<?php echo $worker['id'] ?>_task").innerHTML = new_job.charAt(0).toUpperCase() + new_job.slice(1);                 

                                    var alert_div = $(".my_alerts").eq(0);
                                    alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                                        <p>Trabajo actualizado.</p>\n\
                                      </div>");
                                }     
                              });
                        });
                     });
                    </script>
                <?php } ?>
                </tbody>
            </table>      
        </div>
        
        
        <?php if(!empty($travel_workers)){ ?>
            <div class="content_block">
                <?php if($role){ ?>
                    <h2 class='mb-3'>Monjes fuera de nuestra abadía:</h2>
                <?php } else { ?>
                    <h2 class='mb-3'>Trabajadores fuera de nuestro castillo:</h2>
                <?php } ?>



                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                    <th>Trabajador</td>
                    <th class="centered_td" scope="col">Edad</td>
                    <th class="centered_td" scope="col">Fuerza</td>
                    <th class="centered_td" scope="col">Destreza</td>
                    <th class="centered_td" scope="col">Carisma</td>
                    <th scope="col">Tarea</td>
                    <th class="centered_td" scope="col">Nueva tarea</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($travel_workers as $worker) { ?>
                        <tr>
                        <td> <?php echo $worker['name']; ?> </td>
                        <td class="centered_td"> <?php echo $worker['age']; ?> </td>
                        <td class="centered_td"> <?php echo $worker['str_stars']; ?></td>
                        <td class="centered_td"> <?php echo $worker['dex_stars']; ?> </td>
                        <td class="centered_td"> <?php echo $worker['char_stars']; ?> </td>
                        <td id='<?php echo $worker['id']."_task"; ?>'> <?php echo ucfirst($worker['task']); ?> </td>

                        <td class="centered_td"> <select id="<?php echo $worker['id']; ?>" name='task'>
                        <?php foreach ($available_tasks as $a_task){ ?>
                            <option value='<?php echo $a_task ?>'><?php echo ucfirst($a_task); ?></option>
                        <?php } ?>
                        </select> </td>

                        </tr>
                        <!--Listener in case the user selects a different value-->
                        <script>
                        $(document).ready(function() {  
                            $('#<?php echo $worker['id'] ?>').on('change', function(){
                                new_job = $(this).find("option:selected").attr('value');
                                 $.ajax({
                                    type: 'POST',
                                    url: 'php/ajax/change_job.php',
                                    data: {
                                        'worker_id':<?php echo $worker['id'] ?>,
                                        'new_job':new_job
                                    },
                                    success: function(data) {
                                        document.getElementById("<?php echo $worker['id'] ?>_task").innerHTML = new_job.charAt(0).toUpperCase() + new_job.slice(1);                 

                                        var alert_div = $(".my_alerts").eq(0);
                                        alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                                            <p>Trabajo actualizado.</p>\n\
                                          </div>");
                                    }     
                                  });
                            });
                         });
                        </script>
                    <?php } ?>
                    </tbody>
                </table>    

            </div>
        <?php } ?>
        
        <div class="content_block center">
            <p class="mb">Buscar un nuevo trabajador/monje: </p> 
            <?php
            if($occupied-$total_space < 0){ ?>
                <button class="btn" id='button_hire' type='button' onclick='hire_worker()'>Contratar</button>
            <?php } else {?>
                <button class="btn" id='button_hire' type='button' disabled>Contratar</button>
            <?php } ?>
        </div>

<?php
    return ob_get_clean();
}
       