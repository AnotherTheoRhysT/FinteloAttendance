<?php

function console_log($data) {
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

include './config/config.php';

$email = $username = $psw = $pswConfirm = "";
$emailErr = $usernameErr = $pswErr = $pswConfirmErr = $serverErr = "";
$isAdmin = 0;
$serverErr = [];
// IMPROVE SECURITY AND SANITIZATION OF THIS USER INPUT, DAMN IT!!!

// Processing of data when POST form is submitted
if($_SERVER['REQUEST_METHOD'] === "POST") {
    // Check if new user will be admin
    $isAdmin = (!empty($_POST['is_admin'])) && ($_POST['is_admin'] === '1') ? 1 : 0 ;

    // Validate email
    if(empty(trim($_POST['email']))) {
        //NOTE: IMPROVE EMAIL VALIDATION TO ENFORCE AN EXISTING EMAIL
        $emailErr = "Please enter email";
    } else {
        // Prepare SQL statement
        $sql = "SELECT id FROM user WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $paramEmail);

            // Set parameter
            $paramEmail = trim($_POST['email']);

            // Attempt to execute prepared statement
            if($stmt->execute()) {
                // Store result
                $stmt->store_result();

                if($stmt->num_rows() === 1) {
                    $emailErr = "Email already registered. Use another email.";
                } else {
                    $email = trim($_POST['email']);
                }
            } else { 
                array_push($serverErr, $stmt->error);
            }

            // Close statement;
            $stmt->close();
        }
    }

    // Validate username
    if(empty(trim($_POST['username']))) {
        $usernameErr = "Please enter a username.";
    } else {
        // Prepare SQL statement
        $sql = "SELECT id FROM user WHERE username = ?";

        if($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $paramUsername);

            // Set parameter
            $paramUsername = trim($_POST['username']);

            // Attempt to exectute the prepared statement
            if($stmt->execute()) {
                // Store result
                $stmt->store_result();

                if($stmt->num_rows == 1) {
                    $usernameErr = "This username is already taken. Choose another username.";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                array_push($serverErr, $stmt->error);
            }

            // Close statement
            $stmt->close();
        }
    }

    // psw-confirm = $pswConfirm
    // Validate password
    if(empty(trim($_POST['psw']))) {
        $pswErr = "Please enter a password";
    } elseif(strlen(trim($_POST['psw'])) < 8 ) {
        $pswErr = "Password must be at least 8 characters";
    } else {
        $psw = trim($_POST['psw']);
    }

    // Validate confirm password
    if(empty(trim($_POST['psw-confirm']))) {
        $pswConfirmErr = "Please reenter password";
    } else {
        $pswConfirm = trim($_POST['psw-confirm']);
        if(empty($pswErr) && ($psw !== $pswConfirm)) {
            $pswConfirmErr = "Password did not match.";
        }
    }

    if(empty($emailErr) && empty($usernameErr) && empty($pswErr) && empty($pswConfirmErr)) {
        // Prepare insert statement
        $sql = "INSERT INTO user (`email`, `username`, `password`, `is_admin`) VALUES (?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as params
            $stmt->bind_param("sssi", $paramEmail, $paramUsername, $paramPsw, $paramAdmin);
            
            // Set parameters
            $paramEmail = $email;
            $paramUsername = $username;
            $paramPsw = password_hash($psw, PASSWORD_ARGON2ID, ['cost' => 10]);
            $paramAdmin = $isAdmin;

            // Attempt to execute prepared statement
            if($stmt->execute()) {
                // Redirect / Reset to register page
                header($_SERVER['PHP_SELF']);
            } else {
                array_push($serverErr, $stmt->error);
            }

            // Close statement
            $stmt->close();
        }
        
    }
    // Close connection
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://getbootstrap.com/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Signin Template for Bootstrap</title>
    
    <!-- Bootstrap core CSS -->
    <style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
    padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
    }

    .registerbtn:hover {
    opacity:1;
    }

    /* Add a blue text color to links */
    a {
    color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
    background-color: #f1f1f1;
    text-align: center;
    }

    .invalid-input{
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
    }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head> 

<body class="text-center">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="container">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>

            <div class="form-group">
                <?php if(!empty($serverErr)):?>
                    <div class="alert alert-danger">
                        <pre><?php print_r($serverErr); ?></pre>
                    </div>
                <?php endif; ?>
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required 
                    <?php 
                    echo (!empty($email)) ? "value='{$email}'": "" ;
                    echo (empty($emailErr)) ? "class='is-valid'" : "class='is-invalid'";
                    ?> >
                <?php
                echo (empty($emailErr)) ? "" : 
                    "<div class='invalid-input'>{$emailErr}</div>";
                ?>
            </div>
            
            <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required 
                    <?php 
                    echo (!empty($username)) ? "value='{$username}'": "" ;
                    echo (empty($usernameErr)) ? "class='is-valid'" : "class='is-invalid'";
                    ?> >
                <?php
                echo (empty($usernameErr)) ? "" : 
                    "<div class='invalid-input'>{$usernameErr}</div>";
                ?>
            </div>
            
            <div class="form-group">
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required 
                <?php 
                    echo (!empty($psw)) ? "value='{$psw}'": "" ;
                    echo (empty($pswErr)) ? "class='is-valid'" : "class='is-invalid'";
                    ?> >
                <?php
                echo (empty($pswErr)) ? "" : 
                    "<div class='invalid-input'>{$pswErr}</div>";
                ?>
            </div>

            <div class="form-group">
                <label for="psw-confirm"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-confirm" id="psw-repeat" required 
                <?php 
                    echo (!empty($pswConfirm)) ? "value='{$pswConfirm}'": "" ;
                    echo (empty($pswConfirmErr)) ? "class='is-valid'" : "class='is-invalid'";
                    ?> >
                <?php
                echo (empty($pswConfirmErr)) ? "" : 
                    "<div class='invalid-input'>{$pswConfirmErr}</div>";
                ?>
            </div>

            <label for="vehicle1">Admin</label><br>
            <input type="checkbox" name="is_admin" value="1">
            
            <hr>

            <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
            <input type="submit" class="registerbtn" name="submit" value="Register">
        </div>

        <div class="container signin">
            <p>Already have an account? <a href="#">Sign in</a>.</p>
        </div>
    </form>
</body>
</html>
