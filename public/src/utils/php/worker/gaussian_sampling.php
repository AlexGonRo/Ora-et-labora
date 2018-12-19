<?php

function purebell($min,$max, $center, $std_deviation) {
  $rand1 = (float)mt_rand()/(float)mt_getrandmax();
  $rand2 = (float)mt_rand()/(float)mt_getrandmax();
  $gaussian_number = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
  $mean = $center;
  $random_number = ($gaussian_number * $std_deviation) + $mean;
  $random_number = round($random_number);
  if($random_number < $min || $random_number > $max) {
    $random_number = purebell($min, $max, $center, $std_deviation);
  }
  return $random_number;
}
