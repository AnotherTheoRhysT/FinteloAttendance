<?php

include './config/config.php';

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}


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
        $sql = "SELECT `id`, `email`, `username`, `password`, `is_admin` FROM `user` WHERE `username` IN (?) OR `email` IN (?)";
        
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
                    $stmt->bind_result($id, $email, $usr, $hashed_psw, $isAdmin);
                    
                    // Fetches the binded results to corresponding vars
                    if($stmt->fetch()) {
                        if(password_verify($psw, $hashed_psw)) {
                            session_start();

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $usr;
                            $_SESSION['isAdmin'] = $isAdmin == 1 ? true : false;

                            header('Location: index.php');
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <!--js library rani -->
    <div id="particles-js"></div>

    <div class="login-div">
        <div class="logo"></div>
        <div class="title">Fintelo Attendance</div>
        <div class="sub-title">Welcome</div>
        <div class="fields">
     
            <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validate()">  
            
                <!-- Shows server error message if there is -->
                <?php if(!empty($serverErr)):?>
                    <div class="alert alert-danger">
                        <pre><?php echo $serverErr; ?></pre>
                    </div>
                <?php endif; ?>

                <div id="username">
                    <!--taas jud kayng link sa svg--->
                    <svg class="svg-icon" viewBox="0 0 20 20">
                    <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path>
                    </svg>
                    <input type="text" name="email-or-username" id="uname" class="form-control" placeholder="Username or Email address" required autofocus 
                        <?php
                        echo empty($usrOrEmail) ? "" : "value='{$usrOrEmail}'" ;
                        echo !empty($usrOrEmailErr) ? "class='is-invalid'" : "class='is-valid'";
                        ?> >
                    <?php
                    echo (empty($usrOrEmailErr)) ? "" : 
                        "<div class='invalid-input'>{$usrOrEmailErr}</div>";
                    ?>
                </div>

                <div id="password">
                    <!--taas jud kayng link sa svg--->
                    <svg class="svg-icon" viewBox="0 0 20 20">
                    <path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path>
                    </svg>
                    <input type="password" name="psw" id="pass" class="form-control" placeholder="Password" required
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

                <input class="signin-button" type="submit" name="submit" value="Sign In">

                <div class="link">
                    <a href="#">Forgot password?</a> or <a href="/register.php">Sign up</a>
                </div>
            </form>
        </div>
    </div>

    <script src="scripts/main.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', 'scripts/particles.json'); 
        
    </script>
</body>
</html>
