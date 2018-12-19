        <?php /*

if (!defined('ENVIRONMENT')){    # If this variable is not defined, we assume none of them are
    //define('ENVIRONMENT', 'PRODUCTION');
    //define('ENVIRONMENT', 'TESTING');
    define('ENVIRONMENT', 'DEVELOPMENT');

    switch (ENVIRONMENT) {
        case 'PRODUCTION':
            define('BASE_URL', '');
            define('BASE_PATH_PRIVATE', '');
            define('BASE_PATH_PUBLIC', '');
            define('COOKIE_BASE_PATH', '');
            break;
        case 'TESTING':
            define('BASE_URL', '');
            define('BASE_PATH_PRIVATE', '');
            define('BASE_PATH_PUBLIC', '');
            define('COOKIE_BASE_PATH', '');
            break;
        case 'DEVELOPMENT':
            define('BASE_URL', '');
            define('BASE_PATH_PRIVATE', '');
            define('BASE_PATH_PUBLIC', '');
            define('COOKIE_BASE_PATH', '');
            break;
    }


}