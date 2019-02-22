<?php


function update_town_pop($db, $death_rate, $birth_rate, $small_town_limit, 
        $small_town_bonus, $has_player_bonus, $min_pop){
    
    $town_query = mysqli_prepare($db,
        'SELECT a.id, a.population, b.id '
            . 'FROM towns AS a LEFT JOIN castles_monasteries as B ON a.id=b.town_id');
    mysqli_stmt_bind_result($town_query, $town_id, $pop, $near_castle);
    mysqli_stmt_execute($town_query);
    mysqli_stmt_store_result($town_query);
    
    while (mysqli_stmt_fetch($town_query)){
        if(is_null($near_castle)){
            $new_pop = round($pop + ($pop*$birth_rate) - ($pop*$death_rate),2);      # Town has not nearby player
        } else if($pop < $small_town_limit){
            $new_pop = round($pop + ($pop * $birth_rate) + ($pop*$has_player_bonus) + ($pop*$small_town_bonus) - ($pop * $death_rate),2);  # Town has nearby player and it's small
        } else {
            $new_pop = round($pop + ($pop * $birth_rate) + ($pop*$has_player_bonus) - ($pop * $death_rate),2);  # Town has nearby player but the town is already big
        }
        
        if ($new_pop < $min_pop){
            $new_pop = $min_pop;
        }
        
        $upd_building_lvlup_query = mysqli_prepare($db,
                "UPDATE towns SET population = ? WHERE id=?");
        mysqli_stmt_bind_param($upd_building_lvlup_query, 'di', $new_pop, $town_id);
        mysqli_stmt_execute($upd_building_lvlup_query);
        mysqli_stmt_close($upd_building_lvlup_query);

        
    }
    mysqli_stmt_close($town_query);
    
}
