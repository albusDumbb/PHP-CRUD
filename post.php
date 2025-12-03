<?php

require_once "config.php";

header("Content-Type: application/json");

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

$name = trim($_POST["name"] ?? "");
$age = trim($_POST["age"] ?? "");
$gender = trim($_POST["gender"] ?? "");

$error = [];

if ($name === "") {
    $error[] = "name is required";
} elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
    $error[] = "name should be alphabet";
}
if ($age === "") {
    $error[] = "age is required";

} elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
    $error[] = "age must be number";
}
if ($gender === "") {
    $error[] = "gender is required";
}

if (!empty($error)) {
    response(false, "validation failed", $error);
} else {
    $prepare = $connection->prepare("INSERT INTO users (name, age, gender) VALUES (?, ?, ?)");
    $prepare->bind_param("sis", $name, $age, $gender);

    if ($prepare->execute()) {
        response(true, "data added successfuly", [
            "name" => $name,
            "age" => $age,
            "gender" => $gender
        ]);
    } else {
        response(false, "data added unsuccessfuly", $prepare->error);
    }
}
?>
