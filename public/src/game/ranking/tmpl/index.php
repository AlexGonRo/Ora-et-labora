<?php

$page_title = "Ranking";

$left_list_html = render_left_menu('ranking');

$content_html = render_content($fame_entries);

require_once '../masterPage.php';


function render_content($fame_entries){
    ob_start();
    ?>
        <table class="table table-striped">

            <thead>
                <tr>
                    <th scope="col" width="50%">Dinastía</td>
                    <th scope="col">Prestigio</td>
                    <th scope="col">Último ciclo</td>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($fame_entries as $fame_entry){
            ?>
                <tr>
                    <td><a href="../profile/profile.php?username=<?php echo $fame_entry['username'];?>"><?php echo $fame_entry['username']?></a></td>
                    <td><?php echo $fame_entry['fame']?></td>
                    <td><?php echo $fame_entry['last_update']?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    <?php

    return ob_get_clean();
}

