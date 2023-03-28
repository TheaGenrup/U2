<?php ini_set("display_errors", 1);
/* 
require_once("helper_functions.php");
allowCORS();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userDatabase = "users.json";
    $data = [];

    if (!file_exists($userDatabase)) {
        file_put_contents($userDatabase, $data);
    } else {
      $data = json_decode(file_get_contents($userDatabase), true);
    }
    $newUser = json_decode(file_get_contents("php://input"), true);

    $username = $newUser["username"];
    $password = $newUser["password"];

    foreach ($data as $user ) {
        if ($user["username"] == $username and $user["password"] == $password) {
            $message = ["message" => "Conflict (the username is already taken)"];
            sendJSON($message, 409);
        }
    }

      if ($username == "" or $password == "") {
              sendJSON(["error" => "Missing Inputs"], 400);
              exit();
      }

      $data[] = [
        "id" => getNewId($data)1,
        "username" => $username,
        "password" => $password,
      ];

      $encodedData = json_encode($data, JSON_PRETTY_PRINT);
      file_put_contents($userDatabase, $encodedData);
      sendJSON($data);

    }
 */

ini_set("display_errors", 1);

require_once "helper_functions.php";


$userDatabase = "users.json";

$users = json_decode(file_get_contents($userDatabase), true);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $inputData = json_decode(file_get_contents("php://input"), true);
    $username = $inputData["username"];
    $password = $inputData["password"];


    foreach($users as $user){

        if ($user["username"] == $username && $user["password"] == $password) {

            $points = $user["points"];

            $loggedInUser = [
                "username" => $username,
                "password" => $password,
                "points" => $points
            ];

            sendJSON($loggedInUser);
        }

    }

}



?> 