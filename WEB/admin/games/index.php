<?php
include('../../config.php');
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
        <div class="menu"><?php include '../../overall/menu.php' ?></div>
        <?php
        //On verifie si lutilisateur est connecte
        if(isset($_SESSION['username']))
        {
            $username = $_SESSION['username'];
            //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
            $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
            if($dn['admin']==1 and $dn['username']==$_SESSION['username']){


                ?>

                    <div class="menu_admin"><?php include '../../overall/menu_admin.php' ?></div>
                    <div class="menu_admin menu_admin_games"><?php include '../../overall/menu_admin_games.php' ?></div>
                    <div class="content">


            <h3>Indications</h3>
            Vous voyez ici la liste des histoires créées par les joueurs eux-mêmes.<br><br>
            Avant d'être publiées au public, chaque histoire doit être validée par un administrateur, qui va lui assigner une table de jeu, ainsi qu'un créneau horaire.<br><br>
            Il est important de selectionner des tables et des horaires pour lesquelles le nombre de place restant est supérieur ou égal au nombre de place max. de l'histoire.<br><br>
            Lorsqu'une partie est publiée, le public peut s'y inscrire.<br>

            Il vous est possible de publier ou dé-publier une partie n'importe quand.<br><br>

            Les histoires peuvent être supprimées par le MJ, si celui-ci souhaite se résigner. Dans ce cas, une alerte mail sera envoyée aux administrateurs.
            <br><br><br>



    




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
        <div class="footer"><?php include '../../overall/footer.php' ?></div>
	</body>
</html>
