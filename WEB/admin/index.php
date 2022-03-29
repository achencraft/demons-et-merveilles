<?php
include('../config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $stylefolder; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Démons && Merveilles</title>
    </head>
    <body>
        <div id="corps_de_page">
        <div class="header"></div>
        <div class="menu"><?php include '../overall/menu.php' ?></div>
<?php
//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){


        ?> <div class="menu_admin"><?php include '../overall/menu_admin.php' ?></div>


        <div class="content">
            <h3>Statistiques</h3><br><br>

            <?php
            $req = mysql_fetch_array(mysql_query('select count(*) as nbr_inscrit from users'));
            $nbr_inscrits = $req['nbr_inscrit'];

            $req = mysql_fetch_array(mysql_query('select count(*) as nbr_parties from games where est_supprime = 0'));
            $nbr_parties = $req['nbr_parties'];

            $req = mysql_fetch_array(mysql_query('select count(*) as nbr_parties from histoires where valide_par_user = 1 and valide_par_admin = 0'));
            $nbr_parties_non_valide = $req['nbr_parties'];

            $req = mysql_fetch_array(mysql_query('select count(*) as nbr_parties from games where est_publie = 1'));
            $nbr_parties_publiees = $req['nbr_parties'];

            $req = mysql_fetch_array(mysql_query('select count(*) as nbr_parties from games g join histoires h on g.histoire_id = h.id where est_publie =0 and valide_par_admin = 1'));
            $nbr_parties_non_publiees = $req['nbr_parties'];



             ?>

            Nombres de membres inscrits : <?php echo $nbr_inscrits; ?><br><br>

            Nombres de parties créées : <?php echo $nbr_parties; ?><br>
            Nombre de parties à valider : <?php echo $nbr_parties_non_valide; ?><br>
            Nombre de parties publiées : <?php  echo $nbr_parties_publiees;?><br>
            Nombre de parties non-publiées : <?php echo $nbr_parties_non_publiees; ?><br><br>

            Remplissage des parties :<br>
            <?php
            $req = mysql_query('select * from games g join histoires h on g.histoire_id = h.id where valide_par_admin = 1');

            while($dnn = mysql_fetch_array($req)){
            echo "<a href='games/game_info.php?game_id=".$dnn['id']."'>".$dnn['titre']."</a> - ".$dnn['nbr_joueur_courant']."/".$dnn['nbr_joueur_max']."<br>";
            }



             ?>

    </div>




        <?php

    } else {
        //message si l'utilisateur est connecté mais n'est pas admin
        ?>
        <div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre administrateur.<br />
        <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></div>
        <?php
    }
}
else
{
    //message si l'utilisateur n'est pas connecté
?>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute; et être administrateur.<br />
<a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/connexion.php">Se connecter</a></div>
<?php
}
?>
		</div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
