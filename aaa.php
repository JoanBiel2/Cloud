<?php
header("Content-Type: application/json");

$response = array(
    "status" => "success",
    "message" => "Hola desde el Web Service en Azure"
);

echo json_encode($response);
?>
