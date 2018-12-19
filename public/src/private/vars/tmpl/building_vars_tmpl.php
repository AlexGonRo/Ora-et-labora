<?php /*
require_once "item_vars.php";


define('EXISTENCE_BUILDING_SPACE', );   # Space that a building consumes just for being there (doesn't take into account levels)

define('CLAUSTRO_ID', );
define('PATIO_ID', );
define('KITCHEN_ID', );
define('PANTRY_ID', );
define('WAREHOUSE_ID', );
define('DORMITORY_ID', );


define('MAIN_BUILDING_IDS', array(PATIO_ID, CLAUSTRO_ID));
define('CORE_BUILDINGS', array(PATIO_ID, CLAUSTRO_ID, KITCHEN_ID, PANTRY_ID, 
    WAREHOUSE_ID, DORMITORY_ID));   # Buildings that cannot be demolished completely

define('MAIN_BUILDING_SPACE', array(,,,,));

define('DORMITORY_SPACE', array(,,,,));

define('PERC_DEMOLISH', );   # Percentage of resources we get back when demolishing a building

define('LVL_BONUS_BUILDINGS', array(, , , ,));


# Building materials. Format: (gold,construction_time, [(material_id, quantity),...])

define('CLAUSTRO_BUILDING_MAT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));
define('CLAUSTRO_MANT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));


define('PATIO_BUILDING_MAT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));         
define('PATIO_MANT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));


define('KITCHEN_BUILDING_MAT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));
define('KITCHEN_MANT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));


define('PANTRY_BUILDING_MAT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));
define('PANTRY_MANT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));


define('WAREHOUSE_BUILDING_MAT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));
define('WAREHOUSE_MANT', array(
    array(),    # Level 0
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 1
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 2
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 3
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)), # Level 4
    array(100,10, array(WOOD_ID, 100), array(STONE_ID, 100)) # Level 5
));


define('BUILDING_BUILDING_MAT_ARRAY', array(CLAUSTRO_BUILDING_MAT,
    PATIO_BUILDING_MAT,
    KITCHEN_BUILDING_MAT,
    PANTRY_BUILDING_MAT,
    WAREHOUSE_BUILDING_MAT));
define('BUILDING_MANT_ARRAY', array(CLAUSTRO_MANT,
    PATIO_MANT,
    KITCHEN_MANT,
    PANTRY_MANT,
    WAREHOUSE_MANT));
