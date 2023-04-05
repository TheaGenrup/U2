<?php ini_set("display_errors", 1);

require_once("helper_functions.php");
allowCORS();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $inputData = json_decode(file_get_contents("php://input"), true);
  $username = $inputData["username"];
  $password = $inputData["password"];
  
    if ($username == "" or $password == "") {
          sendJSON(["message" => "Bad Request (empty values)"], 400);
          exit();
    }

    $userDatabase = "users.json";
    $users = [];

    if (!file_exists($userDatabase)) {
        file_put_contents($userDatabase, $users);
    } else {
      $users = json_decode(file_get_contents($userDatabase), true);
    }

    if (!$users == null or !$users == []) {
      
      foreach ($users as $user ) {
          if ($user["username"] == $username) {
              sendJSON(["message" => "Conflict (the username is already taken)"], 409);
          }
      }
    }

      $newUser = [
        "username" => $username,
        "password" => $password,
        "points" => 0
      ];

      $users[] = $newUser;

      $encodedData = json_encode($users, JSON_PRETTY_PRINT);
      file_put_contents($userDatabase, $encodedData);

      sendJSON($newUser);

}
    sendJSON(["message" => "You need to use the POST-request method"], 405);
?>