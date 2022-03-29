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
        <div class="content">
<?php

//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

        if($_SERVER['REQUEST_METHOD']=='GET'){
            //On verifie si le formulaire a ete envoye
        	if(isset($_GET['creneau_id']))
        	{
        		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
        		if(get_magic_quotes_gpc())
        		{
        			$id = stripslashes($_GET['creneau_id']);
                    $id = htmlspecialchars($id);
        		}
        		else
        		{
        			$id = mysql_real_escape_string($_GET['creneau_id']);
                    $id = htmlspecialchars($id);
        		}

                //on vérifie que le nombre minimum d'un administrateur est respecté


                        if(mysql_query('delete from creneaux WHERE id='.$id))
                        {
                            header("Location: index.php");
                        }
                        else
                        {
                            //Sinon on dit quil y a eu une erreur
                            echo 'Une erreur est survenue lors des modifications.';
                        }


                }

            }
        } else {
        echo "Vous n'etes pas administrateur";
        }

} else {
    echo "Vous n'etes pas connecté";
}
?>
</div>
</div>
<div class="footer"><?php include '../../overall/footer.php' ?></div>
</body>
</html>
