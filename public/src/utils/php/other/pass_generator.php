<?php

require_once BASE_PATH_PUBLIC.'src/private/vars/user_data_vars.php';
# From https://stackoverflow.com/questions/1846202/php-how-to-generate-a-random-unique-alphanumeric-string/13733588#13733588
function get_pass($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $codeAlphabet .= implode('',OTHER_CHARS_PASS); // Other characters allowed
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
}