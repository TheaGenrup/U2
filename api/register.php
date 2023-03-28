<?php ini_set("display_errors", 1);

require_once("helper_functions.php");
allowCORS();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userDatabase = "users.json";
    $users = [];

    if (!file_exists($userDatabase)) {
        file_put_contents($userDatabase, $users);
    } else {
      $users = json_decode(file_get_contents($userDatabase), true);
    }

    $newUser = json_decode(file_get_contents("php://input"), true);

    $username = $newUser["username"];
    $password = $newUser["password"];

    foreach ($users as $user ) {
        if ($user["username"] == $username) {
            sendJSON(["message" => "Conflict (the username is already taken)"], 409);
        }
    }

      if ($username == "" or $password == "") {
              sendJSON(["message" => "Please enter username and password"], 400);
              exit();
      }

      $users[] = [
        // "id" => getNewId($users),
        "username" => $username,
        "password" => $password,
        "points" => 0
      ];

      $encodedData = json_encode($users, JSON_PRETTY_PRINT);
      file_put_contents($userDatabase, $encodedData);
      sendJSON([
        "username" => $username,
        "message" => "The user $username was added successfully"
      ]);

    }
?>