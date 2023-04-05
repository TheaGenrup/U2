<?php ini_set("display_errors", 1);


require_once "helper_functions.php";




if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userDatabase = "users.json";
    $users = json_decode(file_get_contents($userDatabase), true);

    $inputData = json_decode(file_get_contents("php://input"), true);
    $username = $inputData["username"];
    $password = $inputData["password"];

    if ($username == "" or $password == "") {
        sendJSON(["message" => "Bad Request (empty values)"], 400);
        exit();
    }  

    for($i=0; $i<count($users); $i++){
        $user = $users[$i];

        if ($username == $user["username"] and $password == $user["password"]) {
            $points = $user["points"];
            $loggedInUser = [
                "username" => $username,
                "password" => $password,
                "points" => $points,
            ];

            sendJSON($loggedInUser);
        } 

            
    }  
    sendJSON(["message" => "Not Found"], 404);
} 
sendJSON(["message" => "You need to use the POST-request method"], 405);


?> 