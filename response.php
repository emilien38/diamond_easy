
<?php
include("config_begin.php");
/////////////////////////////////////////Test/////////////////////////////////
$id_piste = "";
$action = "";
if (isset($_POST['id'])) {
    $id_piste  = $_POST['id'];
    $action = $_POST['action'];
}

if ($action == "past") {
    $req = $bdd->prepare('SELECT nb_diamond, diamond, liste_diamond, nb_liste_diamond FROM user WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']
    ));
    $resultat = $req->fetch();

    $diamond = $resultat['diamond'];
    $list_diamond = $resultat['liste_diamond'];

    if ($diamond[$id_piste] != '1') {
        $nb_diamond = $resultat['nb_diamond'] + 1;
        $diamond[$id_piste] = '1';

        if($list_diamond[$id_piste] == '1')
        {
            $list_diamond[$id_piste] = '0';
            $nb_list_diamond = $resultat['nb_liste_diamond'] -1;
        }
     
    } else {
        $nb_diamond = $resultat['nb_diamond'] - 1;

        $diamond[$id_piste] = '0';
        $nb_list_diamond = $resultat['nb_liste_diamond'];
    }

    $req_send = $bdd->prepare("UPDATE user SET  nb_diamond = :nb_diamond , diamond = :diamond , nb_liste_diamond = :nb_liste_diamond , liste_diamond = :liste_diamond WHERE id = :id");
    $req_send->execute(array(
        'nb_diamond' => $nb_diamond,
        'diamond' => $diamond,
        'nb_liste_diamond' => $nb_list_diamond,
        'liste_diamond' => $list_diamond,
        'id' => $_SESSION['id']
    ));
}
else if($action =="list")
{
    $req = $bdd->prepare('SELECT liste_diamond, nb_liste_diamond FROM user WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']
    ));
    $resultat = $req->fetch();
    $list_diamond = $resultat['liste_diamond'];
    if ($list_diamond[$id_piste] != '1') {
        $nb_list_diamond = $resultat['nb_liste_diamond'] + 1;

        $list_diamond[$id_piste] = '1';
    } else {
        $nb_list_diamond = $resultat['nb_liste_diamond'] - 1;

        $list_diamond[$id_piste] = '0';
    }

    $req_send = $bdd->prepare("UPDATE user SET  nb_liste_diamond = :nb_liste_diamond , liste_diamond = :liste_diamond WHERE id = :id");
    $req_send->execute(array(
        'nb_liste_diamond' => $nb_list_diamond,
        'liste_diamond' => $list_diamond,
        'id' => $_SESSION['id']
    ));
}
else if($action =="lvl")
{
    $new_lvl = $_POST['lvl'];

    $req = $bdd->prepare('SELECT change_lvl FROM user WHERE id = :id');
    $req->execute(array(
        'id' => $_SESSION['id']
    ));
    $resultat = $req->fetch();

    $change_lvl = $resultat['change_lvl'];
    $change_lvl[$id_piste] = '1';
 
    $req_send = $bdd->prepare("UPDATE user SET  change_lvl = :change_lvl WHERE id = :id");
    $req_send->execute(array(
        'change_lvl' => $change_lvl,
        'id' => $_SESSION['id']
    ));




    $req = $bdd->prepare('SELECT level_total , level_nb_vote  FROM diamond WHERE id = :id');
    $req->execute(array(
        'id' => $id_piste
    ));
    $resultat = $req->fetch();

    $level_total = $resultat['level_total'] + $new_lvl;
    $level_nb_vote = $resultat['level_nb_vote'] +1;

    $level = round($level_total / $level_nb_vote);
 
    $req_send = $bdd->prepare("UPDATE diamond SET  Level = :Level, level_total = :level_total, level_nb_vote = :level_nb_vote WHERE id = :id");
    $req_send->execute(array(
        'Level' => $level,
        'level_total' => $level_total,
        'level_nb_vote' => $level_nb_vote,
        'id' => $id_piste
    ));






}

?>