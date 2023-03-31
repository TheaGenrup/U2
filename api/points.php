<?php ini_set("display_errors", 1);


require_once "helper_functions.php";
allowCORS();


$method = $_SERVER["REQUEST_METHOD"];
$userDatabase = "users.json";
$inputData = json_decode(file_get_contents("php://input"), true);
$users = json_decode(file_get_contents($userDatabase), true);

if ($method == "PUT" or $method == "HEAD" or $method == "DELETE" or $method == "PATCH"){
      sendJSON(["message" => "Method Not Allowed (only GET and POST is allowed)"], 405);
}

if ($method == "POST") {

    $username = $inputData["username"];
    $password = $inputData["password"];
    $pointsToIncrement = $inputData["points"];

/*     if ($username = null or $username == "" or $password == null or $password == "" or $pointsToIncrement == null or $pointsToIncrement == "") {
        var_dump($username);
        sendJSON(["message" => "Please send username, password and points"], 400);
    } */

    for($i = 0; $i < count($users); $i++){

        if ($users[$i]["username"] == $username) {

            $currentPoints = $users[$i]["points"] += $pointsToIncrement;

            file_put_contents($userDatabase, json_encode($users, JSON_PRETTY_PRINT));
            sendJSON(["points" => $currentPoints]);
        }
    }

    // if the user isn't found, send error
    sendJSON(["message" => "Not Found"], 404);

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



/*     $users = "users.json";

    $users = json_decode(file_get_contents($users), true);
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

    file_put_contents($users, $users);
    sendJSON($newPoints);
 */

/* 
if ($method == "POST") {
        
    $username = $inputData["username"];
    $password = $inputData["password"];

    for($i = 0; $i < count($users); $i++){

        if ($users[$i]["username"] == $username) {
            $users[$i]["points"] = $users[$i]["points"] + $inputData["points"];
            $newpoints = 
            file_put_contents($userDatabase, json_encode($users, JSON_PRETTY_PRINT));
            sendJSON(["points" => $users[$i]["points"]]);
        }
    }
}

if ($method == "GET") {

    $highestScores = [];
    foreach($users as $user){
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
    sendJSON($error, 400); 
    
    
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