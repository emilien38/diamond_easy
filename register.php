<?php include("config_begin.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Easy Diamond</title>
    <meta charset="UTF-8" />
    <link href="medal_diamant.png" rel="shortcut icon" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<?php include("menu.php"); ?>

<body>

    <?php

    $username_register = "";
    $email_register = "";
    $password_register = "";
    $password2_register = "";
    $validation_register = "";
    $default_registration = "";

    if (isset($_POST['validation_register'])) {
        $validation_register  = $_POST['validation_register'];

        if (isset($_POST['username_register'])) {
            $username_register  = $_POST['username_register'];
        }
        if (isset($_POST['email_register'])) {
            $email_register  = $_POST['email_register'];
        }
        if (isset($_POST['password_register'])) {
            $password_register  = $_POST['password_register'];
        }
        if (isset($_POST['password2_register'])) {
            $password2_register  = $_POST['password2_register'];
        }

        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email_register)) {
            if (strlen($password_register) > 3) {
                if ($password_register == $password2_register) {

                    $req = $bdd->prepare("SELECT COUNT(*) FROM user WHERE pseudo = ?");
                    $req->execute(array($username_register));
                    if (!($req->fetchColumn()) && (strlen($username_register) > 3)) {
                        $req = $bdd->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
                        $req->execute(array($email_register));
                        if (!($req->fetchColumn())) {
                            $password_hache = password_hash($password_register, PASSWORD_DEFAULT);
                            $req_send_profil = $bdd->prepare("INSERT INTO user(pseudo, pass, email, date_inscription) VALUE(:pseudo, :pass, :email, NOW())");
                            $req_send_profil->execute(array(
                                'pseudo' => $username_register,
                                'pass' => $password_hache,
                                'email' => $email_register,
                            ));

                            $req = $bdd->prepare("SELECT id,pseudo,pass,email,classement FROM user WHERE pseudo = ?");
                            $req->execute(array($username_register));
                            $resultat = $req->fetch();


                            $_SESSION['id'] = $resultat['id'];
                            $_SESSION['psw'] = $resultat['pass'];
                            $_SESSION['username'] = $resultat['pseudo'];
                            $_SESSION['email'] = $resultat['email'];
                            $_SESSION['classement'] = $resultat['classement'];

                            while (ob_get_status()) {
                                ob_end_clean();
                            }

                            // no redirect
                            header("Location: /profil.php");
                        } else {
                            $default_registration = "email";
                        }
                    } else {
                        $default_registration = "user";
                    }
                } else {
                    $default_registration = "psw_not_egal";
                }
            } else {
                $default_registration = "psw_length";
            }
        } else {
            $default_registration = "email_format";
        }
    }



    ?>
    <div id="Big_Register_box">

        <div id="Information_box">

            <div class="title_reg">
                <a><strong>Registration</strong></a>
            </div>

            <div class="info_reg">
                <a> To be able to make more precise simulations, access to the classification, indicate which diamond you had.
                    <br>
                    You have to register
                </a>
            </div>

        </div>

        <div id="Register_box">
            <form action="register.php" method="POST">
                <div id="Register_box_info">

                    <div class="pseudo_reg">
                        Username :
                        <input type="text" name="username_register" value=<?php echo($username_register);?>>
                    </div>
                    <?php
                    if ($default_registration == "user") { ?>
                        <div class="error">
                            Username already exist
                        </div>
                    <?php
                    }
                    ?>

                    <div class="email_reg">
                        Email :
                        <input type="text" name="email_register" value=<?php echo($email_register);?>>
                    </div>
                    <?php
                    if ($default_registration == "email") { ?>
                        <div class="error">
                            Email already exist
                        </div>
                    <?php
                    }
                    else if ($default_registration == "email_format") { ?>
                        <div class="error">
                            Email is invalid
                        </div>
                    <?php
                    }
                    ?>

                    <div class="password_reg">
                        Password :
                        <input type="password" name="password_register">
                    </div>

                    <div class="password_reg">
                        Confirm Password :
                        <input type="password" name="password2_register">
                    </div>

                    <?php
                    if ($default_registration == "psw_not_egal") { ?>
                        <div class="error">
                            No match
                        </div>
                    <?php
                    }
                    else if ($default_registration == "psw_length") { ?>
                        <div class="error">
                            Invalid password
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <input type="submit" class="bp_submit" name="validation_register" value="SUBMIT">
            </form>
        </div>


    </div>



</body>

</html>