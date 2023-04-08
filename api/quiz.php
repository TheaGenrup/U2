<?php ini_set("display_errors", 1);

require_once "help_functions.php";
allowCORS();

function checkIfCorrect($randomDogFromAlternatives, $dogName){
    if (str_contains($randomDogFromAlternatives["name"], $dogName)) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $originalArrayOfDogs = scandir('../images/');

    if (count($originalArrayOfDogs) == 0) {
        sendJSON(["message" => "No images available", 404]);
    }

    $newArrayOfDogs = array_map(function($originalDog){
        $newName = str_replace([ "_", ".jpg"], " ", $originalDog);
        return [
            "name" => trim($newName),
            "url" => $originalDog,
        ];
    }, $originalArrayOfDogs);

    array_splice($newArrayOfDogs, 0, 2);
    $encodedData = json_encode($newArrayOfDogs, JSON_PRETTY_PRINT);
    file_put_contents("dogs.json", $encodedData);

    $alternatives = [];
    $i = 0;
    while (count($alternatives) < 4) {

        $random = array_rand($newArrayOfDogs, 1);
        $newAlternative = [
            "name" => $newArrayOfDogs[$random]["name"],
            "url" => $newArrayOfDogs[$random]["url"],
        ];
        if (!in_array($newAlternative, $alternatives)) {
            $alternatives[] = $newAlternative;
        }

        $i++;
    }

    $randomDogFromAlternatives = $alternatives[array_rand($alternatives, 1)];

    $dogNames = [];
    foreach($alternatives as $dog) {
        $dogNames[] = [
            "correct" => checkIfCorrect($randomDogFromAlternatives, $dog["name"]),
            "name" => $dog["name"],
        ];
    }

    sendJSON([
        "image" => "images/" . $randomDogFromAlternatives["url"],
        "alternatives" => $dogNames,
    ]);
}
sendJSON(["message" => "You need to use the GET request method"], 405);

?>

