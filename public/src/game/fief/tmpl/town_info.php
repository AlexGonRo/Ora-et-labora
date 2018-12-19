<div class="content_block">
    <div class="row">
        <div class="col-md-5 center">
            <img src="https://via.placeholder.com/256" alt="Something should go here..."> 
        </div>
        <div class="col-md-7">
            
            <?php if($my_town) { ?>
                <b> Regidor: </b> <?php echo $owner_name; ?> <br>
            <?php } else { ?>
                <b> Regidor: </b> <a href="../profile/profile.php?username=<?php echo $owner_name; ?>"><?php echo $owner_name; ?> </a><br>
            <?php } ?>
            <b>Región:</b> <a href="../map/region.php?id=<?php echo $region_id; ?>"><?php echo $region_name;?> </a><br>
            <b>Ducado:</b> TO DO (Si procede) <br>
            <b>Reino:</b> <a href="../map/kingdom.php?id=<?php echo $kingdom_id; ?>"><?php echo $kingdom_name; ?> </a><br>
            <b>Población:</b> <?php echo $population; ?> <br>      
            <b>Fervor religioso:</b> <?php echo $zeal?> <br>
            <b>Seguridad:</b> <?php echo $security?> <br>
            <b>Impuestos:</b> <br>
            <div class="indent_block">
            Impuestos de la región: 
            <?php if ($local_tax > 100) { ?>
                <font id='local_font' color='red'><?php echo $local_tax; ?></font>
            <?php } else { ?>
                <font id='local_font'><?php echo $local_tax; ?></font>
            <?php } ?>%<br>
            
            Impuestos del ducado:
            <?php if ($local_tax + $duchy_tax > 100) { ?>
                    <font id='duchy_font' color='red'><?php echo $duchy_tax; ?></font>
            <?php } else { ?>
                    <font id='duchy_font'><?php echo $duchy_tax; ?></font>
            <?php } ?>%<br>
            
            Impuestos reales: 
            <?php if ($local_tax + $duchy_tax + $royal_tax > 100) { ?>
                <font id='royal_font' color='red'><?php echo $royal_tax; ?></font>
            <?php } else {?>
                <font id='royal_font'><?php echo $royal_tax; ?></font>
            <?php } ?>% <br>
                
            <?php if($my_town) { ?>
                <div class="row">
                    <label class="col-xl-7 col-form-label"><b> Cambiar los impuestos: </b></label>
                    <input class="col-xl-2 form-control" type="text" id="new_taxes" maxlength="3" size="3"><br>
                    <input class="col-xl-2 btn" type="submit" value="Cambiar" onclick="change_taxes(<?php echo $town_id; ?>)">
                </div>
            <?php } ?>

            </div>
        </div>
    </div>
</div>

<div class="content_block">
    <table class="table table-bordered table-hover table-striped">
        <tr>
          <th>Edificio</th>
          <th class="centered_td">Nivel</th>
          <?php if($my_town) { ?>
          <th class="centered_td">Siguiente nivel</th>
          <th class="centered_td">Ampliar</th>
          <?php } ?>
        </tr>
        <?php foreach ($town_buildings as $building) { ?>
            
            <tr>
            <!--Building name-->
            <td><?php echo $building['name']; ?></td>
            <!--Building level-->
            <?php if ($building['level']==0 && !$building['under_construction']){ ?>
                <td class="centered_td" id='lvl_cell_<?php echo $building['id']; ?>'> No construido </td>
            <?php } else if($building['level']==0){ ?>
                <td class="centered_td" id='lvl_cell_<?php echo $building['id']; ?>'> Construyendose </td>
            <?php } else { ?>
                <td class="centered_td" id='lvl_cell_<?php echo $building['id']; ?>'> <?php echo $building['level']; ?>
                <?php if (!$building['under_construction']){ ?>
                    (Ampliandose)
                <?php } ?>
                </td>
            <?php } ?>
                
            <?php if($my_town) { ?>
                <!--Building level up resources-->
                <td class="centered_td">
                <?php foreach ($building['lvlup_array'] as $name => $q){
                    echo ucfirst($name).": ".$q." ";
                } ?>
                </td>

                <!--Level up button-->
                <?php if ($building['can_lvlup']){ ?>
                    <td class="centered_td">
                        <button class="btn" id='upgrade_<?php echo $building['id']; ?>' type='button' onclick='lvlup_building(<?php echo $town_id.", ".$building['id']; ?>)'>Mejorar</button>
                    </td>
                <?php } else { ?>
                    <td class="centered_td">
                        <button class="btn"  id='upgrade_<?php echo $building['id']; ?>' type='button' value='".$building_id."' disabled>Mejorar</button>
                    </td>
                <?php } ?>
            <?php } ?>
            <tr>
        <?php } ?>

    </table>              

</div>

    