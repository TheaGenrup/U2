<?php ini_set("display_errors", 1);


require_once "helper_functions.php";
allowCORS();


$method = $_SERVER["REQUEST_METHOD"];

$filename = "users.json";


$inputData = json_decode(file_get_contents("php://input"), true);



$userDatabase = json_decode(file_get_contents($filename), true);

if ($method == "PUT" or $method == "HEAD" or $method == "DELETE" or $method == "PATCH"){
      sendJSON(["message" => "Method Not Allowed (only GET and POST is allowed)"], 405);
}



// kolla om alla parametrar finns med
if ($method == "POST") {

/*     if ($username = null or $username == "" or $password == null or $password == "" or $pointsToIncrement == null or $pointsToIncrement == "") {
        sendJSON(["message" => "Please send username, password and points"], 400);
    } */
    $username = $inputData["username"];
$password = $inputData["password"];
$pointsToIncrement = $inputData["points"];

    for($i = 0; $i < count($userDatabase); $i++){

        
        if ($userDatabase[$i]["username"] == $username) {

            $currentPoints = $userDatabase[$i]["points"] += $pointsToIncrement;

            file_put_contents($filename, json_encode($userDatabase, JSON_PRETTY_PRINT));
            sendJSON(["points" => $currentPoints]);
        }
    }

    sendJSON(["error" => "Can't load points"], 400);

}


if ($method == "GET") {

    // Define the comparison function
    function cmp($a, $b) {
        if ($a["points"] == $b["points"]) {
            return 0;
        }
        return ($a["points"] > $b["points"]) ? -1 : 1;
    }

    // Sort the array using the comparison function
    usort($userDatabase, "cmp");

    // Shorten the sorted array
    $firstFive = array_slice($userDatabase, 0, 5);

    // Extract username and points
    $arrayToSend = [];
    foreach($firstFive as $user){
        $oneUser = [
            "username" => $user["username"],
            "points" => $user["points"],
        ];
        $arrayToSend[] = $oneUser;
    };

    // Send the sorted array
    sendJSON($arrayToSend);

}



/*     $userDatabase = "users.json";

    $users = json_decode(file_get_contents($userDatabase), true);
 */
/* 
    $newPoints = 0;
    if (isset($_POST["points"])) {

        $username = $_POST["username"];
        $password = $_POST["password"];
        $pointsToIncrement = $_POST["points"];

        foreach ($users as $user) {
            if ($user["username"] == $username or $user["password"] == $password) {
                var_dump($user);
                
                $user["points"] = $user["points"] += $pointsToIncrement;
                $newPoints = $user["points"] += $pointsToIncrement;
            }
        }

    }
    var_dump($users);

    file_put_contents($userDatabase, $users);
    sendJSON($newPoints);
 */

/* 
if ($method == "POST") {
        
    $username = $inputData["username"];
    $password = $inputData["password"];

    for($i = 0; $i < count($userDatabase); $i++){

        if ($userDatabase[$i]["username"] == $username) {
            $userDatabase[$i]["points"] = $userDatabase[$i]["points"] + $inputData["points"];
            $newpoints = 
            file_put_contents($filename, json_encode($userDatabase, JSON_PRETTY_PRINT));
            sendJSON(["points" => $userDatabase[$i]["points"]]);
        }
    }
}

if ($method == "GET") {

    $highestScores = [];
    foreach($userDatabase as $user){
        $usernameAndPassword = [
            "username" => $user["username"],
            "points" => $user["points"],
        ];
        $highestScores[] = $usernameAndPassword;
    };

    sort($highestScores);
    sendJSON($highestScores);
}
    
$error = ["error" => "Can't load points"];
sendJSON($error, 400);
}
    $error = ["error" => "Can't load points"];
    sendJSON($error, 400); */

?>