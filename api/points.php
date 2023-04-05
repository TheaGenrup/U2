<?php ini_set("display_errors", 1);


require_once "helper_functions.php";
allowCORS();


$method = $_SERVER["REQUEST_METHOD"];
$userDatabase = "users.json";
$inputData = json_decode(file_get_contents("php://input"), true);
$users = json_decode(file_get_contents($userDatabase), true);

$allowedMethods = ["POST", "GET"];
if (!in_array($method, $allowedMethods)) {
    sendJSON(["message" => "Only POST and GET are allowed", 405]);
}

if ($method == "POST") {

    $username = $inputData["username"];
    $password = $inputData["password"];
    $pointsToIncrement = $inputData["points"];

    for($i = 0; $i < count($users); $i++){

        if ($users[$i]["username"] == $username) {

            $currentPoints = $users[$i]["points"] += $pointsToIncrement;

            file_put_contents($userDatabase, json_encode($users, JSON_PRETTY_PRINT));
            sendJSON(["points" => $currentPoints]);
        }
    }

    // if the user isn't found, send error
    sendJSON(["message" => "User not Found"], 404);

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
    usort($users, "cmp");

    // Shorten the sorted array
    $firstFive = array_slice($users, 0, 5);

    // Extract username and points
/*     $arrayToSend = [];
    foreach($firstFive as $user){
        $oneUser = [
            "username" => $user["username"],
            "points" => $user["points"],
        ];
        $arrayToSend[] = $oneUser;
    }; */


    $arrayToSend = array_map(function($user){
        return [
            "username" => $user["username"],
            "points" => $user["points"]
        ];
    }, $firstFive);

    // Send the sorted array
    sendJSON($arrayToSend);

}

/*
    
    fetch("api/points.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        username: "JDLA",
                        password: user.password,
                        points: 1,
                    }),
                }).then(r => r.json()) */

?>