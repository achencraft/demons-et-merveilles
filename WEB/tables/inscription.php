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

        $req = mysql_fetch_array(mysql_query('select g.nbr_joueur_courant,h.nbr_joueur_max from games g join histoires h on h.id=g.histoire_id where g.id='.$id));
        $nbr_joueur = $req['nbr_joueur_courant'];
        $nbr_joueur_restant = $req['nbr_joueur_max']-$req['nbr_joueur_courant'];

        $req = mysql_fetch_array(mysql_query('select c.debut,c.fin from games g join creneaux c on g.creneau_id=c.id where g.id='.$id));
        $debut_courant = $req['debut'];
        $fin_courant = $req['fin'];

        $req = mysql_query('select * from inscriptions where user_id = '.$user_id.' and game_id='.$id);
        if(mysql_num_rows($req)>0)
        {
            ?>
            <div class="message">
                Vous êtes déjà inscrit à cette partie !<br>
                <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></br>
            </div>
            <?php
        }
        else
        {
            //verification de partie complète
            if($nbr_joueur_restant <= 0 ){
                ?>
                <div class="message">
                    Cette partie est complète !<br>
                    <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></br>
                </div>
                <?php
            } else
            {


            //vérification si conflit horaire
            $req = mysql_query('select * from inscriptions where user_id='.$user_id);
            $conflit = 0;

            if(mysql_num_rows($req)>0){

                while($dnn = mysql_fetch_array($req))
                {

                    if( ($debut_courant<=$dnn['debut'] && $fin_courant>=$dnn['fin']) ||
                        ($debut_courant>$dnn['debut'] && $debut_courant<$dnn['fin']) ||
                        ($fin_courant>$dnn['debut'] && $fin_courant<$dnn['fin'])
                    ){
                        $conflit = 1;
                        ?>
                        <div class="message">
                        Vous ne pouvez pas vous inscrire !<br>
                        Il y a un conflit horaire avec d'autres inscriptions !


                        </div>
                        <?php

                    }
                }
            }




            if($conflit == 0){


                //On enregistre les informations dans la base de donnee
                if(mysql_query('insert into inscriptions (user_id,game_id,debut,fin) values ('.$user_id.', '.$id.', '.$debut_courant.', '.$fin_courant.')'))
                {

                    if(mysql_query('update games set nbr_joueur_courant = '.($nbr_joueur+1).' where id='.$id)){

                        ?>
                        <div class="message">
                            Vous avez bien été inscrit à cette partie !<br>
                            <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></br>
                        </div>
                        <?php


                    } else {
                        ?>
                        <div class="message">
                        Une erreur est survenue lors de l\'inscription 2.
                        </div>
                        <?php
                    }

                }
                else
                {
                    ?>
                    <div class="message">
                    Une erreur est survenue lors de l\'inscription 1.
                    </div>
                    <?php

                }

            }






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
