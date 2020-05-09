<?php include("config_begin.php"); ?>
<!doctype html>
<html>

<head>
    <title>Easy Diamond</title>
    <meta charset="UTF-8">
    <link href="medal_diamant.png" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <?php





    ////////////////////////////////////////////////////////////////////////////

    //init variable recu par methode post
    // permet de ne pas faire buguer la page au lancement
    $Track_Name = '';
    $Level = 'ALL';
    $Difficult = 'ALL';
    $League = 'ALL';
    $Type = 'ALL';
    $Bike = 'ALL';
    $option_member = 'NOT Passed';
    $id_track = "";

    //si Track_Name detecté dans le post,on recupere la valeur
    if (isset($_POST['Track_Name'])) {
        $Track_Name  = $_POST['Track_Name'];
    }

    if (isset($_POST['Level'])) {
        $Level  = $_POST['Level'];
    }

    if (isset($_POST['Difficult'])) {
        $Difficult  = $_POST['Difficult'];
    }

    if (isset($_POST['League'])) {
        $League  = $_POST['League'];
    }

    if (isset($_POST['Type'])) {
        $Type  = $_POST['Type'];
    }

    if (isset($_POST['Bike'])) {
        $Bike  = $_POST['Bike'];
    }

    if (isset($_POST['option_member'])) {
        $option_member = $_POST['option_member'];
    }

    include("menu.php");

    //////////////////////////////////////////////// enregistre nouvelle connexion //////////////
    $req = $bdd->prepare('SELECT nb_visite FROM visite');
    $req->execute();

    $donnees = $req->fetch();
    $nb_visiteur = $donnees['nb_visite'] + 1;
    $req->closeCursor();

    $req = $bdd->prepare('UPDATE visite SET nb_visite = ? WHERE id = ?');
    $req->execute(array($nb_visiteur, 1));

    $req->closeCursor();
    ///////////////////////////////////////////////////////////////
    if (isset($_SESSION['username'])) {
        $req = $bdd->prepare('SELECT nb_recherche FROM user WHERE pseudo = ?');
        $req->execute(array($_SESSION['username']));

        $donnees = $req->fetch();
        $nb_recherche = $donnees['nb_recherche'] + 1;
        $req->closeCursor();

        $req = $bdd->prepare('UPDATE user SET nb_recherche = ? WHERE pseudo = ?');
        $req->execute(array($nb_recherche, $_SESSION['username']));

        $req->closeCursor();
    }


    if (isset($_SESSION['id'])) {
        $req = $bdd->prepare('SELECT liste_diamond, diamond, change_lvl FROM user WHERE id = :id');
        $req->execute(array(
            'id' => $_SESSION['id']
        ));
        $resultat = $req->fetch();
        $diamond = $resultat['diamond'];
        $list_diamond = $resultat['liste_diamond'];
        $change_lvl_var = $resultat['change_lvl'];
    ?>
        <script>
            var diamond = "";

            diamond = <?php echo json_encode($diamond); ?>;

            var diamond_list = "";
            diamond_list = <?php echo json_encode($list_diamond); ?>;

            var change_lvl_var = "";
            var id_change_lvl = "";
            change_lvl_var = <?php echo json_encode($change_lvl_var); ?>;
        </script>
    <?php
    }

    ?>


</head>



<?php


/*
$nb_modifs = $bdd->exec('UPDATE diamond SET Type = \'Skill Game\' WHERE Type = \'Skill\'');
echo $nb_modifs . ' entrées ont été modifiées !';
*/
?>

<body>




    <form id="post_track_info" action="/diamond.php" method="POST">

        <div id="cherche_parameter_box">

            <div class="cherche track">
                Track Name :
                <input id="Track_Name_id" type="text" name="Track_Name" value=<?php echo ($Track_Name); ?>>
            </div>

            <div class="cherche">
                Difficulty :
                <select name="Difficult">
                    <option value="ALL">All</option>
                    <option <?php if ($Difficult == 'Easy') {
                                echo ("selected='Easy'");
                            } ?>value='Easy'>Easy</option>
                    <option <?php if ($Difficult == 'Medium') {
                                echo ("selected='Medium'");
                            } ?>value='Medium'>Medium</option>
                    <option <?php if ($Difficult == 'Hard') {
                                echo ("selected='Hard'");
                            } ?>value='Hard'>Hard</option>
                    <option <?php if ($Difficult == 'Extreme') {
                                echo ("selected='Extreme'");
                            } ?>value='Extreme'>Extreme</option>
                    <option <?php if ($Difficult == 'Ninja') {
                                echo ("selected='Ninja'");
                            } ?>value='Ninja'>Ninja</option>
                </select>
                <br>
            </div>

            <div class="cherche">
                Type :
                <select name="Type">
                    <option value="ALL">All</option>
                    <option <?php if ($Type == 'Trials Track') {
                                echo ("selected='Trials Track'");
                            } ?>value='Trials Track'>Trials Track</option>
                    <option <?php if ($Type == 'Skill Game') {
                                echo ("selected='Skill Game'");
                            } ?>value='Skill Game'>Skill Game</option>
                    <option <?php if ($Type == 'Stadium') {
                                echo ("selected='Stadium'");
                            } ?>value='Stadium'>Stadium</option>
                    <option <?php if ($Type == 'Ninja') {
                                echo ("selected='Ninja'");
                            } ?>value='Ninja'>Ninja</option>
                </select>
                <br>
            </div>

            <div class="cherche league">
                League :
                <select name="League">
                    <option value="ALL">All</option>
                    <option <?php $League_choix = "'Skill Game'";
                            if ($League == 'Skill Game') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Skill Game</option>
                    <option <?php $League_choix = "'Schoolyard Brawl'";
                            if ($League == 'Schoolyard Brawl') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Schoolyard Brawl</option>
                    <option <?php $League_choix = "'Stable Swede'";
                            if ($League == 'Stable Swede') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Stable Swede</option>
                    <option <?php $League_choix = "'Siberian Learnings'";
                            if ($League == 'Siberian Learnings') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Siberian Learnings</option>
                    <option <?php $League_choix = "'Bali Forever'";
                            if ($League == 'Bali Forever') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Bali Forever</option>
                    <option <?php $League_choix = "'Highland Fling'";
                            if ($League == 'Highland Fling') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Highland Fling</option>
                    <option <?php $League_choix = "'Montreal Mayhem'";
                            if ($League == 'Montreal Mayhem') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Montreal Mayhem</option>
                    <option <?php $League_choix = "'Monster Mash'";
                            if ($League == 'Monster Mash') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Monster Mash</option>
                    <option <?php $League_choix = "'Bull Session'";
                            if ($League == 'Bull Session') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Bull Session</option>
                    <option <?php $League_choix = "'Trials Trophy'";
                            if ($League == 'Trials Trophy') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Trials Trophy</option>
                    <option <?php $League_choix = "'RACE'";
                            if ($League == 'RACE') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>RACE</option>
                    <option <?php $League_choix = "'Movie Night'";
                            if ($League == 'Movie Night') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Movie Night</option>
                    <option <?php $League_choix = "'Texas Turmoil'";
                            if ($League == 'Texas Turmoil') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Texas Turmoil</option>
                    <option <?php $League_choix = "'Incan Times'";
                            if ($League == 'Incan Times') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Incan Times</option>
                    <option <?php $League_choix = "'South African Sensation'";
                            if ($League == 'South African Sensation') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>South African Sensation</option>
                    <option <?php $League_choix = "'The Pacific Gem'";
                            if ($League == 'The Pacific Gem') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>The Pacific Gem</option>
                    <option <?php $League_choix = "'Ninja'";
                            if ($League == 'Ninja') {
                                echo ("selected=");
                                echo ($League_choix);
                            } else {
                                echo ("value=");
                                echo ($League_choix);
                            } ?>>Ninja</option>
                </select>
                <br>
            </div>

            <div class="cherche level">
                Level :
                <select name="Level">
                    <option value='ALL'>All</option>
                    <option <?php if ($Level == '0') {
                                echo ("selected='0'");
                            } ?>value='0'>0</option>
                    <option <?php if ($Level == '1') {
                                echo ("selected='1'");
                            } ?>value='1'>1</option>
                    <option <?php if ($Level == '2') {
                                echo ("selected='2'");
                            } ?>value='2'>2</option>
                    <option <?php if ($Level == '3') {
                                echo ("selected='3'");
                            } ?>value='3'>3</option>
                    <option <?php if ($Level == '4') {
                                echo ("selected='4'");
                            } ?>value='4'>4</option>
                    <option <?php if ($Level == '5') {
                                echo ("selected='5'");
                            } ?>value='5'>5</option>
                    <option <?php if ($Level == '6') {
                                echo ("selected='6'");
                            } ?>value='6'>6</option>
                    <option <?php if ($Level == '7') {
                                echo ("selected='7'");
                            } ?>value='7'>7</option>
                    <option <?php if ($Level == '8') {
                                echo ("selected='8'");
                            } ?>value='8'>8</option>
                    <option <?php if ($Level == '9') {
                                echo ("selected='9'");
                            } ?>value='9'>9</option>
                    <option <?php if ($Level == '10') {
                                echo ("selected='10'");
                            } ?>value='10'>10</option>
                </select>
            </div>


            <div class="cherche">
                Bike :
                <select name="Bike">
                    <option value="ALL">All</option>
                    <option <?php if ($Bike == 'Rhino') {
                                echo ("selected ");
                            } ?>value="Rhino">Rhino</option>
                    <option <?php if ($Bike == 'Mantis') {
                                echo ("selected ");
                            } ?>value="Mantis">Mantis</option>
                    <option <?php if ($Bike == 'Helium') {
                                echo ("selected ");
                            } ?>value="Helium">Helium</option>
                    <option <?php if ($Bike == 'Shopping Cart') {
                                echo ("selected ");
                            } ?>value="Shopping Cart">Shopping Cart</option>
                    <option <?php if ($Bike == 'Alpaca') {
                                echo ("selected ");
                            } ?>value="Alpaca">Alpaca</option>
                    <option <?php if ($Bike == 'Turtle') {
                                echo ("selected ");
                            } ?>value="Turtle">Turtle</option>
                    <option <?php if ($Bike == 'Crawler') {
                                echo ("selected ");
                            } ?>value="Crawler">Crawler</option>
                    <option <?php if ($Bike == 'Scarab') {
                                echo ("selected ");
                            } ?>value="Scarab">Scarab</option>
                    <option <?php if ($Bike == 'King Crab') {
                                echo ("selected ");
                            } ?>value="King Crab">King Crab</option>
                </select>
                <br>
            </div>

            <div class="cherche_bouton">
                <input type="submit" class="bp_shearch" name="Bouton" value="Search">
                <input type="reset" class="bp_reset" value="Reset" onclick="window.location.href='diamond.php'" />

                <?php
                if (isset($_SESSION['id'])) { ?>
                    <div id="member_cherche_option">

                        <div class="cherche option_member">
                            Option :
                            <select name="option_member" class="option_member_select">
                                <option value="ALL">All</option>
                                <option <?php if ($option_member == 'List') {
                                            echo ("selected ");
                                        } ?>value="List">List</option>
                                <option <?php if ($option_member == 'Past') {
                                            echo ("selected ");
                                        } ?>value="Past">Past</option>
                                <option <?php if ($option_member == 'NOT Passed') {
                                            echo ("selected ");
                                        } ?>value="NOT Passed">NOT Passed</option>

                            </select>
                        </div>

                    </div>
                <?php }
                ?>
            </div>
        </div>
    </form>


    <?php


    //init conditions pour cherhcer dans la base de donnée
    $conditions = [];
    $parameters = [];

    if ($Track_Name != '') {
        $conditions[] = ' Track_Name LIKE ? ';
        $parameters[] = $Track_Name . '%';
    }

    if ($Level != 'ALL') {
        $conditions[] = ' Level = ? ';
        $parameters[] = $Level;
    }

    if ($Difficult != 'ALL') {
        $conditions[] = ' Difficult = ? ';
        $parameters[] = $Difficult;
    }

    if ($League != 'ALL') {
        $conditions[] = ' League = ? ';
        $parameters[] = $League;
    }

    if ($Type != 'ALL') {
        $conditions[] = ' Type = ? ';
        $parameters[] = $Type;
    }

    if ($Bike != 'ALL') {
        $conditions[] = ' ( Bike = ? OR Bike2 = ? )';
        $parameters[] = $Bike;
        $parameters[] = $Bike;
    }



    $sql_request = "SELECT * FROM diamond ";
    $sql_request_nb = "SELECT COUNT(*) FROM diamond ";

    if ($conditions) {
        $sql_request .= "WHERE" . implode("AND", $conditions) . " ORDER BY nb_diamond DESC";
        $sql_request_nb .= "WHERE" . implode("AND", $conditions) . " ORDER BY nb_diamond DESC";
    } else {
        $sql_request .= " ORDER BY nb_diamond DESC";
    }

    $req_nb = $bdd->prepare($sql_request_nb);
    $req_nb->execute($parameters);
    $nb_result = $req_nb->fetchColumn();

    ?>

    <div id="result_box">

        <div id="nb_track_found">
            Tracks Found : <a id="nb_track_found_text"><?php /* echo ($nb_result);*/ ?></a>
        </div>


        <div id="result_info_box">
            <div class="video_info">
                <a>Video</a>
            </div>

            <div class="name_info">
                <a>Name</a>
            </div>

            <div class="difficult_info">
                <a>Difficulty</a>
            </div>

            <div class="type_info">
                <a>Type / League</a>
            </div>

            <div class="level_info">
                <a>Level</a>
            </div>

            <div class="ratio_info">
                <a>Ratio</a>
            </div>

            <div class="bike_info">
                <a>Bike</a>
            </div>
            <?php
            if (isset($_SESSION['id'])) { ?>
                <div class="option_info">
                    <a>Option</a>
                </div>
            <?php
            } ?>
        </div>

        <?php

        $req = $bdd->prepare($sql_request);
        $req->execute($parameters);



        echo '<ul>';
        $couleur_tableau = 0;
        $id_track = 0;
        while ($donnees = $req->fetch()) {

            if ((!isset($_SESSION['id'])) || ($option_member == 'ALL') || ($option_member == 'Past' && $diamond[$donnees['id']] == '1') || ($option_member == 'NOT Passed' && $diamond[$donnees['id']] != '1') || ($option_member == 'List' && $list_diamond[$donnees['id']] == '1')) {
                $couleur_tableau++;
                $id_track++;

                if (($couleur_tableau % 2) == 1) {
                    $id_track_found = "track_found1";
                } else {
                    $id_track_found = "track_found2";
                }

                $lien_video = "https://youtu.be/" . $donnees["Video"];
                $lien_image_video = "http://img.youtube.com/vi/" . $donnees["Video"] . "/mqdefault.jpg"
        ?>
                <div id=<?php echo $id_track_found; ?>>
                    <p>

                        <?php
                        
                        if ($lien_video != "https://youtu.be/") { ?>

                            <div class="miniature_info_result_box">
                                <a href=<?php echo $lien_video; ?>><img class="miniature_info_result" src=<?php echo $lien_image_video; ?>> </a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="miniature_info_result_box"></div>
                        <?php
                        }
                        ?>

                        <div class="name_info">
                            <a><strong><?php echo $donnees['Track_Name']; ?></strong></a>
                        </div>

                        <div class="difficult_info">
                            <a><?php echo $donnees['Difficult']; ?></a>
                        </div>

                        <div class="type_info">
                            <a><?php echo $donnees['Type'];
                                if ($donnees['Type'] != $donnees['League']) { ?> <br> <?php echo $donnees['League'];
                                                                                    } ?></a>
                        </div>

                        <div class="level_info">
                            <a id=<?php echo ("'level_info");
                                    echo ($donnees['id']);
                                    echo ("'"); ?>><?php echo $donnees['Level']; ?></a>
                        </div>

                        <div class="nb_invisible">
                            <a id=<?php echo ("'nb_level_vote");
                                    echo ($donnees['id']);
                                    echo ("'"); ?>><?php echo $donnees['level_nb_vote']; ?></a>
                            <a id=<?php echo ("'level_total");
                                    echo ($donnees['id']);
                                    echo ("'"); ?>><?php echo $donnees['level_total']; ?></a>
                        </div>


                        <div class="ratio_info">
                            <a><?php echo $donnees['nb_diamond']; ?> / <?php echo $donnees['nb_player']; ?>

                                <?php if ($donnees['nb_player']) { ?><br><?php echo (round($donnees['nb_diamond'] / $donnees['nb_player'] * 100, 2)); ?> %<?php } ?>
                            </a>
                        </div>

                        <div class="bike_info">
                            <a><?php echo $donnees['Bike'];
                                if ($donnees["bike2" != '']) { ?> <br> <?php echo $donnees['Bike2'];
                                                                    } ?></a>
                        </div>

                        <?php
                        if (isset($_SESSION['id'])) { ?>
                            <div id="action_button_track">

                                <button class=<?php echo ("'action_button_track ");
                                                if ($diamond[$donnees['id']] != '1') {
                                                    if ($list_diamond[$donnees['id']] == '1') {
                                                        echo ("ok' ");
                                                        echo ("title='Remove from your list'");
                                                    } else {
                                                        echo ("no_ok' ");
                                                        echo ("title='Add to your list'");
                                                    }
                                                } else {
                                                    echo ("no_ok' ");
                                                    echo ("title='Already passed'");
                                                } ?> id=<?php echo ("'list");
                                                        echo ($donnees['id']);
                                                        echo ("'"); ?> onclick=<?php echo ("add_diamond_list(");
                                                                                echo ($donnees['id']);
                                                                                echo (")"); ?>>+

                                </button>

                                <button class=<?php echo ("'action_button_track ");
                                                if ($diamond[$donnees['id']] == '1') {
                                                    echo ("ok' ");
                                                    echo ("title='Remove from past'");
                                                } else {
                                                    echo ("no_ok' ");
                                                    echo ("title='Indicated as past'");
                                                } ?> id=<?php echo ("'past");
                                                        echo ($donnees['id']);
                                                        echo ("'"); ?> onclick=<?php echo ("add_diamond_past(");
                                                                                echo ($donnees['id']);
                                                                                echo (")"); ?>>✓
                                </button>


                                <button class=<?php echo ("'action_button_track ");
                                                if ($change_lvl_var[$donnees['id']] == '1') {
                                                    echo ("ok_lvl' ");
                                                } else {
                                                    echo ("no_ok' ");
                                                } ?> <?php if ($change_lvl_var[$donnees['id']] != '1') {
                                                            echo ("title='Change Level'");
                                                        } else {
                                                            echo ("title='Already changed'");
                                                        } ?>id=<?php echo ("'lvl");
                                                                echo ($donnees['id']);
                                                                echo ("'"); ?> onclick=<?php echo ("change_lvl(");
                                                                                    echo ($donnees['id']);
                                                                                    echo (")"); ?>>!
                                </button>

                            </div>
                        <?php
                        } ?>

                        <script>
                            var tab_nb_level_vote = <?php json_encode($tab_nb_lvl_vote); ?>
                        </script>

                    </p>

                </div>


        <?php
            }
        }

        echo '</ul>';

        $req->closeCursor();

        ?>

        <script>
            change_nb_track_found();

            function change_nb_track_found() {
                
                var nb_track_found = <?php echo (json_encode($id_track)); ?>;

                document.getElementById("nb_track_found_text").innerHTML = nb_track_found;
            }
        </script>




    </div>

    <div id="Modal_change_level" class="modal">
        <div class="modal-content_lvl">
            <div class="title_change_lvl">
                <a class="title_lvl_change"><strong> Change the difficulty level to get this diamond.</strong></a><br>
                The level goes from 0 (power bike, the easiest) <br>to 10 (a difficult diamond)
            </div>
            <div class="send_lvl">
                Level :
                <div class="input_lvl">

                    <select id="select_new_level" name="change_lvl">
                        <option value='0'>0</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                        <option value='6'>6</option>
                        <option value='7'>7</option>
                        <option value='8'>8</option>
                        <option value='9'>9</option>
                        <option value='10'>10</option>
                    </select>
                </div>
                <button class="bp_send" onclick=change_lvl_data()>Send</button>
            </div>
        </div>

    </div>

    <script>
        String.prototype.replaceAt = function(index, replacement) {
            return this.slice(0, index) + replacement + this.slice(index + 1);
        }

        function add_diamond_past(id) {


            if (diamond.charAt(id) != '1') {

                diamond = diamond.replaceAt(id, '1');

                document.getElementById('past' + id).style.background = "rgb(93, 204, 78)";
                document.getElementById('past' + id).title = "Remove from past";

                diamond_list = diamond_list.replaceAt(id, '0');
                document.getElementById('list' + id).title = "Already passed";
                document.getElementById('list' + id).style.background = "rgb(255, 255, 255)";

            } else {
                diamond = diamond.replaceAt(id, '0');
                document.getElementById('past' + id).title = " Indicated as past";
                document.getElementById('past' + id).style.background = "rgb(255, 255, 255)";
            }


            $.ajax({
                type: 'POST',
                url: '/response.php',
                data: {
                    action: 'past',
                    id: id
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        function add_diamond_list(id) {

            if (diamond.charAt(id) != '1') {

                if (diamond_list.charAt(id) != '1') {

                    diamond_list = diamond_list.replaceAt(id, '1');
                    document.getElementById('list' + id).title = "Remove from your list";
                    document.getElementById('list' + id).style.background = "rgb(93, 204, 78)";
                } else {
                    diamond_list = diamond_list.replaceAt(id, '0');
                    document.getElementById('list' + id).title = "Add to your list";
                    document.getElementById('list' + id).style.background = "rgb(255, 255, 255)";
                }


                $.ajax({
                    type: 'POST',
                    url: '/response.php',
                    data: {
                        action: 'list',
                        id: id
                    },
                    success: function(data) {
                        $('#result').html(data);
                    }
                });
            }
        }


        // Get the modal
        var modal_lvl = document.getElementById("Modal_change_level");


        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];


        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal_lvl.style.display = "none";
        }


        function change_lvl(id) {

            if (change_lvl_var.charAt(id) != '1') {

                id_change_lvl = id;

                // When the user clicks the button, open the modal 
                modal_lvl.style.display = "block";
            }
        }

        function change_lvl_data() {

            change_lvl_var = change_lvl_var.replaceAt(id_change_lvl, '1');

            document.getElementById('lvl' + id_change_lvl).style.background = "rgb(247, 161, 2)";

            var new_level = document.getElementById("select_new_level").selectedIndex;

            $.ajax({
                type: 'POST',
                url: '/response.php',
                data: {
                    action: 'lvl',
                    id: id_change_lvl,
                    lvl: new_level
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });

            modal_lvl.style.display = "none";
            document.getElementById("level_info" + id_change_lvl).innerHTML = (parseInt(document.getElementById("level_total" + id_change_lvl).innerHTML, 10) + parseInt(new_level, 10)) / (parseInt(document.getElementById("nb_level_vote" + id_change_lvl).innerHTML, 10) + 1);

        }
    </script>


</body>

</html>