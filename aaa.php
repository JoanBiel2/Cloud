<?php
header("Content-Type: application/json");

$response = array(
    "status" => "success",
    "message" => "B"
);

echo json_encode($response);
?>
