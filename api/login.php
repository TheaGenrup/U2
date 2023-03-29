<?php ini_set("display_errors", 1);


require_once "helper_functions.php";


$userDatabase = "users.json";

$users = json_decode(file_get_contents($userDatabase), true);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $inputData = json_decode(file_get_contents("php://input"), true);
    $username = $inputData["username"];
    $password = $inputData["password"];


    for($i=0; $i<count($users); $i++){
        $user = $users[$i];

        if ($username == $user["username"] and          $password == $user["password"]) {
            $points = $user["points"];

             $loggedInUser = [
                "username" => $username,
                "password" => $password,
                "points" => $points,
            ];

            sendJSON($loggedInUser);

        }

    }  

} 



?> 