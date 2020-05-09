<?php include("member.php"); ?>
        <div id="profil_member">
            <div class="text_info_member">
                Number of diamond :
                <?php
                echo ($donnees['nb_diamond']);
                ?>
            </div>
            <div class="text_info_member">
                Number of recherche :
                <?php
                echo ($donnees['nb_recherche']);
                ?>
            </div>
            <div class="text_info_member fin_member">
                Classement :
                <?php
                echo ($donnees['classement']);
                ?>
            </div>
        </div>
    </div>
</body>

</html>