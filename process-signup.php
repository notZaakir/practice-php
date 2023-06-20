<?php 


//ini_set('display_errors', 1); 
//ini_set('log_errors',1); error_reporting(E_ALL);
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


if (empty($_POST["first_name"])){
    die("Name is required");
}

if (empty($_POST["last_name"])){
    die("Last name is required");
}

IF ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8){
    die("Password must be at least 8 characters");
}
if ( ! preg_match("/[a-z]/i", $_POST["password"])){
    die("Password must contain at least one letter");
}


if ($_POST["password"] !== $_POST["password_confirmation"]){
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (first_name, last_name, email, password_hash)
        VALUES (?,?,?,?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)){
    die("SQL error:" . $mysqli->error);
}

$stmt->bind_param("ssss", $_POST["first_name"], $_POST["last_name"], $_POST["email"], $password_hash);

if ($stmt->execute()){

    header("Location: signup-success.html");
    exit;

} else{
    if($mysqli->errno === 1062){
        die("There is already an account associated with that email");
    }
    die($mysqli->error . " " . $mysqli->errno);

}





