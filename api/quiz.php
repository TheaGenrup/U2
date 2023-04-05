<?php ini_set("display_errors", 1);


require_once "helper_functions.php";
allowCORS();

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $originalArrayOfDogs = scandir('../images/');

    if (count($originalArrayOfDogs) == 0) {
        sendJSON(["message" => "No images available", 404]);
    }
    $dogs_json = "dogs.json";

    $NewArrayOfDogs = [];
    foreach($originalArrayOfDogs as $dog){

        $newName = str_replace([ "_", ".jpg"], " ", $dog);
        $newDog = [
            "name" => trim($newName),
            "url" => $dog,
        ];
        $NewArrayOfDogs[] = $newDog;
    }

    array_splice($NewArrayOfDogs, 0, 2);
    $encodedData = json_encode($NewArrayOfDogs, JSON_PRETTY_PRINT);
    file_put_contents($dogs_json, $encodedData);

    $alternatives = [];
        $i = 0;
        while (count($alternatives) < 4) {

            $random = array_rand($NewArrayOfDogs, 1);
            $newAlternative = [
                "name" => $NewArrayOfDogs[$random]["name"],
                "url" => $NewArrayOfDogs[$random]["url"],
            ];
            if (!in_array($newAlternative, $alternatives)) {
                $alternatives[] = $newAlternative;
            }

            $i++;
        }

        
        function checkAnswer($randomDogFromAlternatives, $dogName){
            if (str_contains($randomDogFromAlternatives["name"], $dogName)) {
                return true;
            } else {
                return false;
            }
        }
        // få en random dog från alternatives
    $randomDogFromAlternatives = $alternatives[array_rand($alternatives, 1)];

    $dogNames = [];
    foreach($alternatives as $dog) {
        $dogNames[] = [
            "correct" => checkAnswer($randomDogFromAlternatives, $dog["name"]),
            "name" => $dog["name"],
        ];
    }

    $alternativesToSend = [
        "image" => "images/" . $randomDogFromAlternatives["url"],
        "alternatives" => $dogNames,
    ];



/*     if (!file_exists($alternativesToSend["image"])) {
        sendJSON(["message" => "You need to use the GET-request method"], 405);
    } */


    sendJSON($alternativesToSend);
}
sendJSON(["message" => "You need to use the GET-request method"], 405);

?>

