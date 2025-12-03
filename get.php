<?php

// insert config.php file
require_once "config.php";

header("Content-Type: application/json");

// function for response using json
function response($status, $message, $data = []) {
    $array = [
        "status" => $status,
        "message" => $message, 
        "data" => $data
    ];

    $json = json_encode($array);

    echo $json;

    exit;
}

$name = trim($_GET["name"] ?? "");
$age = trim($_GET["age"] ?? "");

$error = [];

// validate name
if ($name === "") {
    $error[] = "name is required";
} elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
    $error[] = "name should be alphabet";
}

// validate age
if ($age === "") {
    $error[] = "age is required";

} elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
    $error[] = "age must be number";
}

// response failed or success
if (!empty($error)) {
    response(false, "validation failed", $error);
} else {
    response(true, "data received successfully", [
            "name" => $name,
            "age" => $age,
        ]);
}
?>
