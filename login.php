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
    <script src="loginvalidate.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <style>
        body {
            background-color: #343a40;
        }

        h1,
        label,
        a {
            color: white;
        }

        .btn {
            background-color: black;
            color: white;
        }

        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="container">
        <form method="POST" id="signup" class="mt-5">
            <h1 class="text-center">Login</h1>
            <div class="form-container">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                <div class="error"></div>
            </div>

            <div class="form-container">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <div class="error"></div>
            </div>

            <?php if ($is_invalid): ?>
                <div class="error">Username or password incorrect</div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Log in</button>
            <p class="mt-3">Don't have an account?</p>
            <a href="signup.html" style="color: white;">Sign up</a>
        </form>
    </div>

    <script src="loginvalidate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
