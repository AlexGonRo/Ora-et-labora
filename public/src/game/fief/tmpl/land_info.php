<div class="content_block">
    <div class="row">
        <div class="col-md-5 center">
            <img src="https://via.placeholder.com/256" alt="Something should go here..."> 
        </div>
        <div class="col-md-7">
            
            <?php if($my_resource) { ?>
                <b>Propietario:</b> <?php echo $owner_name; ?> <br>
            <?php } else { ?>
                <b>Propietario: </b> <a href="../profile/profile.php?username=<?php echo $owner_name; ?>"><?php echo $owner_name; ?> </a><br>
            <?php } ?>
            
            <b>Región:</b> <a href="../map/region.php?id=<?php echo $region_id; ?>"><?php echo $region_name;?> </a><br>

            <b>Reino:</b> <a href="../map/kingdom.php?id=<?php echo $kingdom_id; ?>"><?php echo $kingdom_name; ?> </a><br>

            <b>Aldeanos empleados: </b> 
                <?php if(is_null($manual_limit)){ ?>
                    <?php echo $current_cap."/".$max_cap; ?><span id='limit_info'></info><br>
                <?php } else { ?>
                    <?php echo $current_cap."/".$max_cap; ?>
                    <?php if($my_resource){ ?>
                        <span id='limit_info'> (Límite puesto en <?php echo $manual_limit; ?> personas)</span><br>
                    <?php } 
                } ?>

            <?php if($my_resource) { ?>
            <div class="indent_block">        
                    <div class="row">
                        <label class="col-xl-7 col-form-label"><b> Establecer nuevo límite de empleo: </b></label>
                            <input class="col-xl-2 form-control" type="text" id="new_limit" maxlength="5">
                            <input class="col-xl-2 btn" type="submit" value="Cambiar" onclick="change_limit(<?php echo $resource_id;?>)">
                    </div>
            </div>
            <?php } ?>
                    

            <b>Población empleada desde:</b> <br>
            <div class="indent_block">
                <?php foreach ($workers_from as $workers_info){ ?>
                    <a href="towns.php?id=<?php echo $workers_info['town_id']; ?>">&#10014; <?php echo $workers_info['town_name']; ?></a> 
                    <?php if($my_resource) { ?>
                        (<?php echo $workers_info['pop']; ?> trabajadores)<br>
                    <?php } 
                } ?>
            </div>


            <b>Impuestos:</b> <br>
            <div class="indent_block">
                Impuestos del ducado:  <?php echo $duchy_tax; ?>% <br>
                Impuestos reales: <?php echo $royal_tax; ?>% <br>
            </div>
            <b> Nivel:</b> <?php echo $level; ?> <br>
            
            <?php if($my_resource) { ?>
                <b> Siguiente nivel:</b>  

                <?php if ($under_construction){ ?>
                    Mejorando...
                <?php } else { 
                    foreach ($lvlup_array as $id => $q){ 
                        echo ucfirst($names[$id]).": ".$q." ";
                    }
                    if (has_resources($user_id, $lvlup_array) && !$under_construction){ ?>
                        <input class="btn" type='submit' value='Mejorar' id='lvlup_button' onclick='lvlup_resource(<?php echo $resource_id; ?>)'>
                    <?php } else { ?>
                        <td><button class="btn" type='button' disabled>Mejorar</button></td>
                    <?php }
                } 
            } ?>

        </div>
    </div>

</div>

<?php 
if ($resource_type==FIELD_RES_ID){ ?>
    
    <div class="content_block">
        <b> Actualmente produciendo: </b>

        <?php if ($field_resource=='cattle_raising'){ ?>
            <span id='field_production_text'>Ganado</span> =>

        <?php } else if($field_resource=='grain'){ ?>
            <span id='field_production_text'>Grano</span> =>

        <?php } else if($field_resource=='grapevine'){ ?>
            <span id='field_production_text'>Uva</span> =>

        <?php } ?>
            
                
        <?php if ($month >= $start && $month <= $end && $ready){ ?>
            <span id='production_time_info'>¡Estamos produciendo hasta <span id='month'><?php echo MONTH_NAMES_ES[$end]; ?></span>!(Quedan <span id='turns_left'><?php echo $turns_left; ?></span> ciclos)</span><br>
        <?php } else { ?>
            <span id='production_time_info'>La producción comenzará en <span id='month'><?php echo MONTH_NAMES_ES[$start-1]; ?></span>(Quedan <span id='turns_left'><?php echo $turns_left; ?></span> ciclos)</span><br>                
        <?php } ?>


        <?php if($my_resource) { ?>
        <div class="indent_block">    
            <div class="col-lg-9" >
                <div class="row">
                    <label class="col-lg-4 col-form-label"><b> Cambiar producción a: </b></label>
                    <select class="form-control col-lg-4 mr-2" name="production" id="field_production">
                        <option value="1">Ganado</option>
                        <option value="2">Grano</option>
                        <option value="3">Vino</option>
                    </select>
                    <input class="btn col-lg-2" type="submit" onclick="change_production(<?php echo $resource_id;?>)" value="Cambiar">
                </div>
            </div>
        </div>
        <?php } ?>
    
    </div>
            
    <?php
}

