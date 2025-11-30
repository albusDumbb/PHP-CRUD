<?php

// Load database connection from config.php file
require_once "config.php";

header("Content-Type: application/json");

// Function for response
function response($status, $message, $data = []) {
    $arry = [
        "status" => $status,
        "message" => $message,
        "data" => $data
    ];

    $json = json_encode($arry);

    echo $json;

    exit;
}

// Get and sanitize data from user
$name = trim($_POST["name"] ?? "");
$age = trim($_POST["age"] ?? "");
$gender = trim($_POST["gender"] ?? "");

// Empty array to store error messages
$errors = [];

// Validdation of the data
if ($name === "") {
    $error[] = "name is required.";
} elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
    $error[] = "name must be alphabet letters only";
}
if ($age === "") {
    $error[] = "age is required.";
} elseif (!filter_var($age, FILTER_VALIDATE_INT)){
    $error[] = "age must be numbers";
}
if ($gender === "") {
    $error[] = "gender is required.";
} 

/* If the $errors is not empty, then throw an error response through
jsonResponse function */
if (!empty($errors)) {
    response(false, "Validation is invalid", $errors);
}

// Insert data to the database using prepared statement
$stmt = $conn->prepare("INSERT INTO users (name, age, gender) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $age, $gender); // sis means strings, integer, and strings

// Run SQL query
if ($stmt->execute()) {
    response(true, "Data added successfuly!", [
        "name" => $name,
        "age" => $age,
        "gender" => $gender
    ]);
} else {
    response(false, "Data failed to add.", $stmt->error);
}

?>
