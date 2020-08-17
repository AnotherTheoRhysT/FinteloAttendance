<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    html,
    body {
    height: 100%;
    }

    body {
    padding: 100px 0px;
    background-color: #f5f5f5;
    }
    .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
    }
    .form-signin .checkbox {
    font-weight: 400;
    }
    .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
    }
    .form-signin .form-control:focus {
    z-index: 2;
    }
    .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    }
    .invalid-input{
        display: block;
    width: 100%;
    margin-top: .25rem;
    font-size: 80%;
    color: #dc3545;

    }
    </style>
</head>
<?php
session_start();

var_dump(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true, $_SESSION);
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

include './config/config.php';

$usrOrEmail = $psw = $usrOrEmailErr = $pswErr = "";
$remember = 0;

// Check submit
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $remember = !isset($_POST['remember-me']) ? 0 : 1 ;
    
    // Username error check
    if(empty(trim($_POST['email-or-username']))) {
        $usrOrEmailErr = "Username or Email address can't be empty";   
    } else {
        $usrOrEmail = trim($_POST['email-or-username']);
    }

    // Password error check
    if(empty(trim($_POST['psw']))) {
        $pswErr = "Password can't be empty";
    } else {
        $psw = trim($_POST['psw']);
    }

    // Credential validation
    if(empty($usrOrEmailErr) && empty($pswErr)) {
        // Prepare statement
        $sql = "SELECT `id`, `email`, `username`, `password` FROM `user` WHERE `username` IN (?) OR `email` IN (?)";
        
        if($stmt = $mysqli->prepare($sql)) {
            // Bind user or email parameters to prepared statement
            $stmt->bind_param('ss', $paramUsrOrEmail, $paramUsrOrEmail);
            $paramUsrOrEmail = $usrOrEmail;
            
            // Execute attempt
            if($stmt->execute()) {
                $stmt->store_result();

                // Check if user or email matches any record
                if($stmt->num_rows() == 1) {
                    // Binds data from columns to the ff vars
                    $stmt->bind_result($id, $email, $usr, $hashed_psw);
                    
                    // Fetches the binded results to corresponding vars
                    if($stmt->fetch()) {
                        if(password_verify($psw, $hashed_psw)) {
                            session_start();

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $usr;

                            echo "Success"; 
                            var_dump(header('Location: index.php'));
                        } else {
                            $pswErr = "Invalid Password";
                        }
                    }
                } else {
                    $usrOrEmailErr = "Username or Email not found";
                }
            } else {
                $serverErr = "{$stmt->errno}: {$stmt->error}";
            }

            $stmt->close();
        }
    }
    $mysqli->close();
}

?>
<body class="text-center">
    <section>
        <form class="form-signin" method="POST">
            <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

            <div class="form-group">
                <?php if(!empty($serverErr)):?>
                    <div class="alert alert-danger">
                        <pre><?php echo $serverErr; ?></pre>
                    </div>
                <?php endif; ?>

                <label for="inputEmail" class="sr-only">Email address or Username</label>
                <input type="text" name="email-or-username" id="inputEmail" class="form-control" placeholder="Username or Email address" required autofocus 
                    <?php
                    echo empty($usrOrEmail) ? "" : "value='{$usrOrEmail}'" ;
                    echo !empty($usrOrEmailErr) ? "class='is-invalid'" : "class='is-valid'";
                    ?> >
                <?php
                echo (empty($usrOrEmailErr)) ? "" : 
                    "<div class='invalid-input'>{$usrOrEmailErr}</div>";
                ?>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="psw" id="inputPassword" class="form-control" placeholder="Password" required
                    <?php
                    echo empty($psw) ? "" : "value='{$psw}'" ;
                    echo !empty($pswErr) ? "class='is-invalid'" : "class='is-valid'";
                    ?> >
                <?php
                echo (empty($pswErr)) ? "" : 
                    "<div class='invalid-input'>{$pswErr}</div>";
                ?>
                
            </div>

            <div class="checkbox mb-3">
                <input type="checkbox" name="remember-me" value="remember-me" 
                    <?php
                    echo !isset($_POST['remember-me']) ? "" : "checked" ;
                    ?>
                    > Remember me
            </div>

            <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Sign In">

            <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        </form>
    </section>
</body>
</html>
