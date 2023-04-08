<?php ini_set("display_errors", 1);

require_once "help_functions.php";
allowCORS();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$inputData = json_decode(file_get_contents("php://input"), true);
$users = json_decode(file_get_contents("users.json"), true);

$allowedMethods = ["POST", "GET"];

if (!in_array($requestMethod, $allowedMethods)) {
    sendJSON(["message" => "Only POST and GET are allowed", 405]);
}

if ($requestMethod == "POST") {

    $username = $inputData["username"];
    $password = $inputData["password"];
    $pointsToIncrement = $inputData["points"];

    for ($i = 0; $i < count($users); $i++){

        if ($users[$i]["username"] == $username) {

            $currentPoints = $users[$i]["points"] += $pointsToIncrement;

            file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
            sendJSON(["points" => $currentPoints]);
        }
    }
    sendJSON(["message" => "User not Found"], 404);
}

if ($requestMethod == "GET") {

    function sortByPoints($a, $b) {
        if ($a["points"] == $b["points"]) {
            return 0;
        }
        return ($a["points"] > $b["points"]) ? -1 : 1;
    }

    usort($users, "sortByPoints");

    $firstFive = array_slice($users, 0, 5);

    $arrayToSend = array_map(function($user){
        return [
            "username" => $user["username"],
            "points" => $user["points"]
        ];
    }, $firstFive);

    sendJSON($arrayToSend);
}

?>