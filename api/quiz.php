<?php ini_set("display_errors", 1);


require_once "helper_functions.php";


$filename = '../images/';
$originalArrayOfDogs = scandir($filename);
$dogs_json = "dogs.json";

$NewArrayOfDogs = [];
foreach($originalArrayOfDogs as $dog){
    $dogsname = $dog;
    $newName = str_replace([ "_", ".jpg"], " ", $dogsname);
    $newdoggo = [
        "name" => trim($newName),
        "url" => $dog,
    ];
    $NewArrayOfDogs[] = $newdoggo;
}
$data = json_encode($NewArrayOfDogs, JSON_PRETTY_PRINT);
file_put_contents($dogs_json, $data);

array_splice($NewArrayOfDogs, 0, 2);

$alternatives = [];
    $i = 0;
    while (count($alternatives) < 4) {

        $random = array_rand($NewArrayOfDogs, 1);
        $new_dog = [
            "name" => $NewArrayOfDogs[$random]["name"],
            "url" => $NewArrayOfDogs[$random]["url"],
        ];
        if (!in_array($new_dog, $alternatives)) {
            $alternatives[] = $new_dog;
        }

        $i++;
    }

$imageofdog = $alternatives[array_rand($alternatives, 1)];


$dogname = [];
foreach($alternatives as $dog) {
    $dogname[] = [
        "correct" => check_answer( $imageofdog,$dog["name"]),
        "name" => $dog["name"],
    ];
}

$alt = [
  "image" => "images/" . $imageofdog["url"],
  "alternatives" => $dogname,
];


 function check_answer($imageofdog, $dog){
        if (str_contains($imageofdog["name"], $dog)) {
            return true;
        } else {
            return false;
        }
    }

sendJSON($alt);


?>

