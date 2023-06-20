<?php

 $is_invalid = false;
 if ($_SERVER["REQUEST_METHOD"] === "POST"){

    $mysqli = require __DIR__. "/database.php";

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", 
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user){

        if (password_verify($_POST["password"], $user["password_hash"])){


            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        }

    }
    $is_invalid = true;
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login</title> 
</head>
<body>
    

    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>

    <form method = "POST" id = signup>
    <h1>Login</h1>
    <div class="input-control">
        <label for = "email" >Email</label>
        <input type="email" name="email" id="email"
                            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
    </div>
        
     <div class="input-control">
        <label for = "password" >Password</label>
        <input type="password" name="password" id="password">
     </div>
        <button>Log in</button>
        <p>Dont have an account? </p>
        <a href="signup.html">Sign up</a> 


    </form>
</body>
</html>