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


        if($_SERVER['REQUEST_METHOD']=='GET'){

            //On verifie si le formulaire a ete envoye
        	if(isset($_GET['log']) and isset($_GET['cle']))
            	{
                //On echappe les variables pour pouvoir les mettre dans des requetes SQL
                if(get_magic_quotes_gpc())
                {
                    $login = stripslashes($_GET['log']);
                    $cle = stripslashes($_GET['cle']);
                    $login = htmlspecialchars($login);
                    $cle = htmlspecialchars($cle);
                }
                else
                {
                    $login = mysql_real_escape_string($_GET['log']);
                    $cle = mysql_real_escape_string($_GET['cle']);
                    $login = htmlspecialchars($login);
                    $cle = htmlspecialchars($cle);
                }

                echo "Bonjour $login, <br>";

                //On recupere la clé et le booleen actif de la BDD
                $req = mysql_query('select valide,confirm_cle from users where username="'.$login.'"');
                $dn = mysql_fetch_array($req);

                if($dn['valide']==1){
                    echo "Votre compte est déjà actif ! <br>
                    <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a></br>
                    <a href='https://".$_SERVER['SERVER_NAME']."/membres/connexion.php'>Se connecter</a>";
                } else {
                    if($dn['confirm_cle'] == $cle){

                        if(mysql_query('update users set valide=1 where username="'.$login.'"'))
                        {
                            echo "Votre compte a bien été activé ! <br>
                            <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a></br>
                            <a href='https://".$_SERVER['SERVER_NAME']."/membres/connexion.php'>Se connecter</a>";
                        }
                        else
                        {
                            //Sinon on dit quil y a eu une erreur
                            echo "Une erreur est survenue lors des modifications. <br>
                            <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a></br>
                            <a href='https://".$_SERVER['SERVER_NAME']."/membres/connexion.php'>Se connecter</a>";
                        }
                    } else {
                        echo "Erreur ! Votre compte ne peut être activé... <br>
                        <a href='https://".$_SERVER['SERVER_NAME']."'>Retour à l'accueil</a></br>
                        <a href='https://".$_SERVER['SERVER_NAME']."/membres/connexion.php'>Se connecter</a>";
                    }
                }
            }

        }
         ?>







        </div>

                </div>
                <div class="footer"><?php include '../overall/footer.php' ?></div>
        	</body>
        </html>
