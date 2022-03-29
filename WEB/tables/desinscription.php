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


    if(isset($_GET['game_id']))
    {
        $id = mysql_real_escape_string($_GET['game_id']);

        $req = mysql_fetch_array(mysql_query('select id from users where username="'.$_SESSION['username'].'"'));
        $user_id = $req['id'];

        $req = mysql_fetch_array(mysql_query('select nbr_joueur_courant from games where id='.$id));
        $nbr_joueur = $req['nbr_joueur_courant'];



        $req = mysql_query('select * from inscriptions where user_id = '.$user_id.' and game_id='.$id);
        if(mysql_num_rows($req)==0)
        {
            ?>
            <div class="message">
                Vous n'êtes pas inscrit à cette partie !<br>
                <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></br>
            </div>
            <?php
        }
        else
        {



            //On enregistre les informations dans la base de donnee
            if(mysql_query('delete from inscriptions where user_id ='.$user_id.' and game_id='.$id))
            {

                if(mysql_query('update games set nbr_joueur_courant = '.($nbr_joueur-1).' where id='.$id)){

                    ?>
                    <div class="message">
                        Vous avez bien été désinscrit de cette partie !<br>
                        <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></br>
                    </div>
                    <?php


                } else {
                    ?>
                    <div class="message">
                    Une erreur est survenue lors de la désinscription 2.
                    </div>
                    <?php
                }

            }
            else
            {
                ?>
                <div class="message">
                Une erreur est survenue lors de la désinscription 1.
                </div>
                <?php

            }

        }






    } else {
        ?>
        <div class="message">pas en get</div>
        <?php

    }


}
else
{
?>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute;.<br />
<a href="connexion.php">Se connecter</a></div>
<?php
}
?>
		</div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
