<?php ini_set("display_errors", 1);

function sendJSON ($data, $statusCode = 200) {
		header("Content-Type: application/json");
		http_response_code($statusCode);
    $json = json_encode($data);
		echo $json;
		exit(); //Exit kan ses som en return för hela dokumentet
}

function allowCORS() {
  if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Origin: *");
    exit();
  } else {
    header("Access-Control-Allow-Origin: *");
  }
}

?>