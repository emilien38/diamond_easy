<?php

$username = "";
$password = "";
$psw_problem = "0";

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    $psw_problem='1';


    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, pass,email,classement FROM user WHERE pseudo = :pseudo');
    $req->execute(array(
        'pseudo' => $username
    ));
    $resultat = $req->fetch();



    if (!$resultat) {
        echo '<script type="text/javascript">',
            'affiche_connexion();',
            '</script>';

    } else {
        // Comparaison du pass envoyé via le formulaire avec la base
        $isPasswordCorrect = password_verify($password, $resultat['pass']);
        if ($isPasswordCorrect) {
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['psw'] = $resultat['pass'];
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $resultat['email'];
            $_SESSION['classement'] = $resultat['classement'];
            $psw_problem ='0';
        } else {
            echo '<script type="text/javascript">',
                'affiche_connexion();',
                '</script>';

        }
    }
}
?>




<header bgcolor=black>


    <div id="menu_top">
        <a href="/index.php" class="diamond_menu_image"><img class="diamond_menu_image" src="medal_diamant.png"></a>
        <div id="menu_top_choix">
            <ul class=menu_top>
                <li><a href="/index.php" <?php if ($_SERVER['PHP_SELF'] == "/index.php") {
                                                echo ("class='active'");
                                            } ?>>Home</a></li>
                <li><a href="/simulation.php" <?php if ($_SERVER['PHP_SELF'] == "/simulation.php") {
                                                    echo ("class='active'");
                                                } ?>>Simulation</a></li>
                <li><a href="/diamond.php" <?php if ($_SERVER['PHP_SELF'] == "/diamond.php") {
                                                echo (" class='active'");
                                            } ?>>Track List</a></li>
                <?php
                if (isset($_SESSION['id']) && isset($_SESSION['username'])) { ?>
                    <li style="float:right" class="dropdown">
                        <a href="/profil.php" <?php if (($_SERVER['PHP_SELF'] == "/profil.php") || ($_SERVER['PHP_SELF'] == "/settings.php") || ($_SERVER['PHP_SELF'] == "/member_diamond.php")) {
                                                    echo (" class='active'");
                                                } ?>><?php echo ($_SESSION['username']); ?></a>

                    </li>
                <?php } else { ?>
                    <li style="float:right"><a href="/register.php" <?php if ($_SERVER['PHP_SELF'] == "/register.php") {
                                                                        echo (" class='active'");
                                                                    } ?>>Register</a></li>
                    <li style="float:right"><button onclick="affiche_connexion()">Login</button></li>

                <?php }
                ?>

            </ul>
        </div>
    </div>


    <div id="id01" class="modal">

        <form class="modal-content animate" action="/diamond.php" method="post">

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" class="log_pop" placeholder="Enter Username" name="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" class="log_pop" placeholder="Enter Password" name="password" required>

                <div id="psw_incorrect_id" class="psw_incorrect">
                    Username or Password incorect
                </div>

                <button type="submit" class="bouton_co">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <a href="#" class="psw">Forgot password ?</a>
            </div>
        </form>
    </div>


    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            if (event.target == modal_lvl) {
                modal_lvl.style.display = "none";

            }
        }

        function affiche_connexion() {
            var modal = document.getElementById('id01');
            modal.style.display = "block";

            var psw_problem = <?php echo json_encode($psw_problem); ?>;

            if (psw_problem == '1') {
                document.getElementById("psw_incorrect_id").style.visibility = "visible";
            }
        }
    </script>


    <?php
    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }



        if (!$resultat) {
            echo '<script type="text/javascript">',
                'affiche_connexion();',
                '</script>';
        } else {
            // Comparaison du pass envoyé via le formulaire avec la base
            $isPasswordCorrect = password_verify($password, $resultat['pass']);
            if ($isPasswordCorrect) {
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['psw'] = $resultat['pass'];
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $resultat['email'];
                $_SESSION['classement'] = $resultat['classement'];
            } else {
                echo '<script type="text/javascript">',
                    'affiche_connexion();',
                    '</script>';
            }
        }
    } ?>




</header>