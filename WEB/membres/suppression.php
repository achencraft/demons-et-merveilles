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
        <div class="menu"><?php include '../overall/menu.php'; ?></div>

                <div class="content">

<?php
$form = false;

//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{

    if($_SERVER['REQUEST_METHOD']=='GET'){      //Premier affichage de la page
        //On verifie si le formulaire a ete envoye
        if(isset($_GET['username'])){
            if(get_magic_quotes_gpc())
            {
                $username = stripslashes($_GET['username']);
                $username = htmlspecialchars($username);
            }
            else
            {
                $username = mysql_real_escape_string($_GET['username']);
                $username = htmlspecialchars($username);
            }

            if($username == $_SESSION['username']){ //on vérifie qu'il veut bien supprimer son compte, et pas celui d'un autre

                $form = true;

                $req = mysql_query('select confirm_cle from users where username="'.$username.'"');
                $dn = mysql_fetch_array($req);
                $confirm_cle = $dn['confirm_cle'];

            } else {
                echo "Vous ne pouvez pas supprimer le compte d'un autre utilisateur ! Vous vous prenez pour qui ?<br>
                Genre l'autre là, il croit pouvoir embeter les autres juste comme ça ? Nan mais allo quoi !
                <br> <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a>";
            }

        }

    }



    if($_SERVER['REQUEST_METHOD']=='POST'){      //Premier affichage de la page
	    //On verifie si le formulaire a ete envoye
        if(isset($_POST['password'], $_POST['confirmation'], $_POST['username'])){

            if(get_magic_quotes_gpc())
            {
                $username = stripslashes($_POST['username']);
                $username = htmlspecialchars($username);
                $confirm = stripslashes($_POST['confirmation']);
                $confirm = htmlspecialchars($confirm);
            }
            else
            {
                $username = mysql_real_escape_string($_POST['username']);
                $username = htmlspecialchars($username);
                $confirm = mysql_real_escape_string($_POST['confirmation']);
                $confirm = htmlspecialchars($confirm);
            }


            if($username == $_SESSION['username']){ //on vérifie qu'il veut bien supprimer son compte, et pas celui d'un autre

                $req = mysql_query('select id,username,password,confirm_cle from users where username="'.$username.'"');
                $dn = mysql_fetch_array($req);
                $psw = $_POST['password'];

                //on vérifie le mot de passe, si l'utilisateur existe, et sa clé de confirmation
                if(password_verify($psw, $dn['password']) and mysql_num_rows($req)>0 and $confirm==$dn['confirm_cle']){
                $form = false;
                $id = $dn['id'];

                $ok = 1;

                    //on le désinscrit des parties auquels il est inscrit

                    $req = mysql_query('select h.titre, g.id, i.debut, i.fin, t.emplacement from games g join histoires h on g.histoire_id = h.id join inscriptions i on i.game_id = g.id join users u on i.user_id = u.id join tables t on g.table_id = t.id where u.id = '.$id);

                        if(mysql_num_rows($req)>0){

                        while($dnn2 = mysql_fetch_array($req))
                        {
                                    
                                    if(mysql_query('delete from inscriptions where user_id ='.$id.' and game_id ='.$dnn2['id']))
                                    {

                                        $dnn3 = mysql_fetch_array(mysql_query('select nbr_joueur_courant from games where id='.$dnn2['id']));
                                        $nbr_joueur = $dnn3['nbr_joueur_courant'];

                                        if(mysql_query('update games set nbr_joueur_courant = '.($nbr_joueur-1).' where id='.$dnn2['id'])){


                                        } else {
                                            echo "erreur 2";
                                            $ok = 0;
                                        }

                                    }
                                    else
                                    {
                                        echo "erreur 1";
                                        $ok = 0;
                                    }

                        }

                    }





                    if($ok == 1){



                        if(mysql_query('delete from users WHERE id='.$id)){
                            //On le deconecte en supprimant simplement les sessions username et userid
                            unset($_SESSION['username'], $_SESSION['userid']);
                            echo "Compte supprimé !<br> <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a>";
                        } else {
                            echo "Une erreur est survenue, echec de la suppression ! C'est moche quand même :'( )'<br> <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a>";
                        }
                    }

                } else {
                    echo "Mauvais mot de passe ! Try again<br>  <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a>";


                }
            } else {
                echo "Vous ne pouvez pas supprimer le compte d'un autre utilisateur ! Vous vous prenez pour qui ?<br>
                Genre l'autre là, il croit pouvoir embeter les autres juste comme ça ? Nan mais allo quoi !
                <br> <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a>";
            }

        }

    }
}

?>

<?php
if($form){


<form action="suppression.php" method="post">
    Entrez votre mot de passe pour confirmer la suppression de votre compte:<br /><br>
    <div class="center">
        <label for="password" required>Mot de passe</label><input type="password" name="password" id="password" /><br /><br>
        <input type="hidden" name="confirmation" value="<?php echo $confirm_cle; ?> />
        <input type="hidden" name="username" value="<?php echo $username; ?>" />
        <input type="submit" style="width:300px;" value="Je confirme la suppression de mon compte" />
    </div>
</form>


}
 ?>

                </div>
        </div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
