<?php ini_set("dispaly_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

require_once "helper_functions.php";
allowCORS();

$userDatabase = "users.json";

$data = json_decode(file_get_contents($userDatabase), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["points"])) {

        $points = $_POST["points"];
        $data["points"] += $points;

    }

    file_put_contents($userDatabase, $data);
    sendJSON($data);
}
$error = ["error" => "Can't load points"];
sendJSON($error, 400);

}
?>