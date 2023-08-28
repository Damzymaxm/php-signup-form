<?php

if  (empty($_POST["name"])) {
    die("name is required") ;
}


if ( ! filter_var($_POST["email"] , FILTER_VALIDATE_EMAIL)) {
    die("valid email is required");
}

if (strlen($_POST["password"])<8) {
    die("password must be atleast 8 chatracters");
}

if (! preg_match("/[a-z]/i",$_POST["password"])) {
die("pasword must contain a letter");
}

if (! preg_match("/[0-9]/", $_POST["password"])) {
    die("password must contain atleast one number");
}

if (!isset($_POST["password_confirmation"])) {
    die("Please confirm your password");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords do not match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

require __DIR__ . "/database.php";

$sql = "INSERT INTO USER(name, email, password_hash)
        VALUES (?, ?, ?)";

       $stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die ("sql error:" . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);


$stmt->execute();
echo "signup successful";

