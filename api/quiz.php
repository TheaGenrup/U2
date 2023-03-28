<?php ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
/* $dir = scandir("//.images");
var_dump($dir);

// print_r($dir);

$alternatives = [];
$imagesCount = count($dir);

for ($i=0; $i < 4; $i++) { 
    
    $randomDog = rand(2, count($dir));
    $alternativesOfDogs[] = $dir[$randomDog];
    var_dump($alternativesOfDogs);
} */


$filename = '../images';
$dir = scandir($filename);
var_dump($dir[$randomDog]);

$alternativesOfDogs = [];

for ($i=0; $i < 4 ; $i++) { 
    $randomDog = rand(2, count($dir));
    $alternativesOfDogs[] = $dir[$randomDog];

}

print_r($alternativesOfDogs);

}


?>