<?php include("member.php");

$new_username = "";
$new_email = "";
$new_password = "";
$old_password = "";
$new_classement = "";
$validation_new = "";
$default_registration = "";

if (isset($_POST['validation_new'])) {
    $validation_new  = $_POST['validation_new'];

    if (isset($_POST['new_username'])) {
        $new_username  = $_POST['new_username'];
    }
    if (isset($_POST['new_email'])) {
        $new_email  = $_POST['new_email'];
    }
    if (isset($_POST['new_password'])) {
        $new_password  = $_POST['new_password'];
    }
    if (isset($_POST['old_password'])) {
        $old_password  = $_POST['old_password'];
    }
    if (isset($_POST['new_classement'])) {
        $new_classement  = $_POST['new_classement'];
    }

    $req = $bdd->prepare('SELECT * FROM user WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']
    ));
    $resultat = $req->fetch();

    if (password_verify($old_password, $resultat['pass'])) {
        if ((preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $new_email)) || ($new_email == "")) {
            if ((strlen($new_password) > 3) || ($new_password == "")) {

                $req = $bdd->prepare("SELECT COUNT(*) FROM user WHERE pseudo = ?");
                $req->execute(array($new_username));
                if ((!($req->fetchColumn()) && (strlen($new_username) > 3)) || ($new_username == "")) {
                    $req = $bdd->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
                    $req->execute(array($new_email));
                    if (!($req->fetchColumn()) || ($new_email == "")) {
                        if ($new_username == "") {
                            $new_username = $resultat['pseudo'];
                        }
                        if ($new_email == "") {
                            $new_email = $resultat["email"];
                        }
                        if ($new_classement == "") {
                            $new_classement = $resultat['classement'];
                        }
                        if ($new_password == "") {
                            $password_hache = $resultat['pass'];

                        } else {
                            $password_hache = password_hash($new_password, PASSWORD_DEFAULT);
                        }
                        

                        $req_send_profil = $bdd->prepare("UPDATE user SET pseudo = :pseudo , pass = :pass , email = :email , classement = :classement WHERE id = :id");
                        $req_send_profil->execute(array(
                            'pseudo' => $new_username,
                            'pass' => $password_hache,
                            'email' => $new_email,
                            'classement' => $new_classement,
                            'id' => $resultat['id']
                        ));

                        $req = $bdd->prepare("SELECT id, pass,pseudo,email,classement FROM user WHERE id = ?");
                        $req->execute(array($_SESSION['id']));
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
                        header("Location: /settings.php");
                    } else {
                        $default_registration = "email";
                    }
                } else {
                    $default_registration = "user";
                }
            } else {

                $default_registration = "psw_length";
            }
        } else {
            $default_registration = "email_format";
        }
    } else {
        $default_registration = "psw_not_egal";
    }
}

?>
<form action="/settings.php" method="POST">
    <div id="Big_Register_box">

        <div id="Information_box">

            <div class="title_reg">
                <a><strong>Change personal information</strong></a>
            </div>

            <div class="info_reg">
                Classement :
                <input type="text" name="new_classement" placeholder=<?php echo ($_SESSION['classement']); ?>>
            </div>

        </div>

        <div id="Register_box">

            <div id="Register_box_info">

                <div class="pseudo_reg">
                    Username :
                    <input type="text" name="new_username" placeholder=<?php echo ($_SESSION['username']); ?>>
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
                    <input type="text" name='new_email' placeholder=<?php echo ($_SESSION['email']); ?>>
                </div>
                <?php
                if ($default_registration == "email") { ?>
                    <div class="error">
                        Email already exist
                    </div>
                <?php
                } else if ($default_registration == "email_format") { ?>
                    <div class="error">
                        Email is invalid
                    </div>
                <?php
                }
                ?>

                <div class="password_reg">
                    New Password :
                    <input type="password" name="new_password">
                </div>

                <div class="password_reg">
                    Old Password :
                    <input type="password" name="old_password">
                </div>
                <?php
                if ($default_registration == "psw_not_egal") { ?>
                    <div class="error">
                        No match
                    </div>
                <?php
                } else if ($default_registration == "psw_length") { ?>
                    <div class="error">
                        Invalid password
                    </div>
                <?php
                }
                ?>
            </div>

            <input type="submit" class="bp_submit" name="validation_new" value="SUBMIT">

        </div>


    </div>
</form>



</div>
</body>

</html>