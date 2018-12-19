<?php 

$page_title = "Producción";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($kitchen_text_receipes, $my_kitchen_id, 
        $kit_prod_items, $open_kitchen);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/add_delete_prod.js"></script>
    <?php
    return ob_get_clean();
}


function render_content($kitchen_text_receipes, $my_kitchen_id, 
        $kit_prod_items, $open_kitchen){ 
    ob_start();
    ?>
        <div class="tab">
            <button id="cocina_button" class="tablinks active" onclick="openTab(event, 'Cocina')">Cocina</button>
            <button id="TODO_button" class="tablinks" onclick="openTab(event, 'TO_DO')">TO DO</button>
            <script>
                $(document).ready(function(){
                    document.getElementById('Cocina').style.display = "block";
                    document.getElementById('Cocina').class += " active";
                });
            </script>
        </div>
        
        <!--Kitchen tab-->
        <div id="Cocina" class="tabcontent">
            <div class="content_block center">
                
                <b> Producto: </b>
                    <!-- Create the dropdown list -->
                    <select class="form-control" id='dropdown_kitchen' name='item'>
                    <?php foreach ($kitchen_text_receipes as $item=>$recipe){ ?>
                        <option value='<?php echo $item; ?>'><?php echo $recipe; ?></option>
                    <?php } ?>
                    </select> 
                <br>
                
                <div class="row mt-2">
                    <label class="col-xl-4 col-form-label center"><b> Cantidad: </b></label>
                    <input class="col-xl-3 form-control mr-0 mr-xl-2 mb-2 mb-xl-0" id="quantity_kitchen" name="quantity"><br>
                    <input class="col-xl-2 btn" id="<?php echo $my_kitchen_id; ?>" onclick="add_prod(<?php echo $my_kitchen_id;?>, 'quantity_kitchen', 'dropdown_kitchen')" type="submit" value="Fabricar">
                </div>
                
            </div>
            <!-- Kitchen production table -->
            <div class="mt-4">
                <table id="<?php echo $my_kitchen_id."_table";?>" class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                    <th class="centered_td" scope="col">Objeto</td>
                    <th class="centered_td" scope="col">Cantidad</td>
                    </tr>
                    </thead>
                <?php if(empty($kit_prod_items)) {?>
                    <tr>
                    <td colspan="2" align="center">¡No hay cola de producción para este edificio!</td>
                    </tr>
                <?php } else {
                    foreach($kit_prod_items as $prod_id => $item_info) {?>
                            <tr id='<?php echo "row_$prod_id"; ?>'>
                            <td> <?php echo $item_info[0] ?> </td>
                            <td class="right_td"> <?php echo $item_info[1] ?> </td>
                            <td class="centered_td">  <button id='<?php echo $prod_id; ?>' onclick='delete_prod(<?php echo $prod_id; ?>)'>Eliminar</button>  </td>
                            <tr>
                    <?php } ?>
                <?php } ?>
                </table>

            </div>
        </div>
        
        <!--Any other tab-->
        <div id="TO_DO" class="tabcontent">
            <?php
            // create_prod_table($table_name, $building_id);
            ?>
        </div>
        

        
        <!--In case we have some GET information-->
        <?php if($open_kitchen){ ?>
            <script>
                $(document).ready(function(){
                    document.getElementById('cocina_button').click();
                });
            </script>
        <?php
        } ?>
        
    <?php
    return ob_get_clean();
}
        



