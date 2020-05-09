<?php include("config_begin.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Easy Diamond</title>
    <meta charset="UTF-8" />
    <link href="medal_diamant.png" rel="shortcut icon" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" type="text/css" href="style_member.css" />
</head>

<?php include("menu.php"); ?>

<body>
    <?php if(! isset($_SESSION['id']))
    {
        while (ob_get_status()) {
            ob_end_clean();
        }

        // no redirect
        header("Location: /diamond.php");
    }
        ?>
    <div id="info_member">
        <div class="username">
            <a><?php echo ($_SESSION['username']); ?></a>
        </div>
        <div id="menu_member">
            <ul class="menu_member_cl">
                <li><a href="/profil.php" <?php if ($_SERVER['PHP_SELF'] == "/profil.php") {
                                                echo ("class='active'");
                                            } ?>>Profil</a></li><!--
                <li><a href="/member_diamond.php" <?php if ($_SERVER['PHP_SELF'] == "/member_diamond.php") {
                                                        echo ("class='active'");
                                                    } ?>>Diamond</a></li>-->
                <li><a href="/settings.php" <?php if ($_SERVER['PHP_SELF'] == "/settings.php") {
                                                echo ("class='active'");
                                            } ?>>Settings</a></li>
                <li><a href="/disconnection.php" >Log out</a></li>
            </ul>
        </div>
        <?php
        $req = $bdd->prepare('SELECT nb_recherche,nb_diamond,classement FROM user WHERE pseudo = ?');
        $req->execute(array($_SESSION['username']));
        $donnees = $req->fetch();
        ?>
