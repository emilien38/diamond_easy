<?php include("member.php"); ?>
<div id="diamond_big_box">

    <div id="diamond_list">
        <a> List : </a>

        <div id="result_info_box">
            <div class="video_info_member">
                <a>Video</a>
            </div>

            <div class="name_info_member">
                <a>Name</a>
            </div>

            <div class="difficult_info_member">
                <a>Difficulty</a>
            </div>

            <div class="type_info_member">
                <a>Type / League</a>
            </div>

            <div class="level_info_member">
                <a>Level</a>
            </div>

            <div class="ratio_info_member">
                <a>Ratio</a>
            </div>

            <div class="bike_info_member">
                <a>Bike</a>
            </div>
            
        </div>

        <?php

        $req = $bdd->prepare("SELECT * FROM diamond");
        $req->execute();


        echo '<ul>';
        $couleur_tableau = 0;
        while ($donnees = $req->fetch()) {
            $couleur_tableau++;

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

                        <div class="miniature_info_result_box_member">
                            <a href=<?php echo $lien_video; ?>><img class="miniature_info_result_member" src=<?php echo $lien_image_video; ?>> </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="miniature_info_result_box_member"></div>
                    <?php
                    }
                    ?>

                    <div class="name_info_member">
                        <a><strong><?php echo $donnees['Track_Name']; ?></strong></a>
                    </div>

                    <div class="difficult_info_member">
                        <a><?php echo $donnees['Difficult']; ?></a>
                    </div>

                    <div class="type_info_member">
                        <a><?php echo $donnees['Type'];
                            if ($donnees['Type'] != $donnees['League']) { ?> <br> <?php echo $donnees['League'];
                                                                                } ?></a>
                    </div>

                    <div class="level_info_member">
                        <a id=<?php echo ("'level_info");
                                echo ($donnees['id']);
                                echo ("'"); ?>><?php echo $donnees['Level']; ?></a>
                    </div>

                    <div class="nb_invisible_member">
                        <a id=<?php echo ("'nb_level_vote");
                                echo ($donnees['id']);
                                echo ("'"); ?>><?php echo $donnees['level_nb_vote']; ?></a>
                        <a id=<?php echo ("'level_total");
                                echo ($donnees['id']);
                                echo ("'"); ?>><?php echo $donnees['level_total']; ?></a>
                    </div>


                    <div class="ratio_info_member">
                        <a><?php echo $donnees['nb_diamond']; ?> / <?php echo $donnees['nb_player']; ?>

                            <?php if ($donnees['nb_player']) { ?><br><?php echo (round($donnees['nb_diamond'] / $donnees['nb_player'] * 100, 2)); ?> %<?php } ?>
                        </a>
                    </div>

                    <div class="bike_info_member">
                        <a><?php echo $donnees['Bike'];
                            if ($donnees["bike2" != '']) { ?> <br> <?php echo $donnees['Bike2'];
                                                                } ?></a>
                    </div>

                </p>

            </div>


        <?php

        }
        echo '</ul>';

        $req->closeCursor();

        ?>


    </div>

    <div id="diamond_past">

    </div>
</div>
</div>
</body>

</html>