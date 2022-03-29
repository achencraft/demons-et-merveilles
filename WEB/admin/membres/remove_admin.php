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
        	if(isset($_GET['id']))
        	{
        		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
        		if(get_magic_quotes_gpc())
        		{
        			$id = stripslashes($_GET['id']);
                    $id = htmlspecialchars($id);
        		}
        		else
        		{
        			$id = mysql_real_escape_string($_GET['id']);
                    $id = htmlspecialchars($id);
        		}

                //on vérifie que le nombre minimum d'un administrateur est respecté
                $result = mysql_query('select count(*) as total from users where admin=1');
                $nbr_admin=mysql_fetch_assoc($result);
                if($nbr_admin['total']>1){

                    //on vérifie qu'il ne supprime pas un super_admin
                    $dn2 = mysql_fetch_array(mysql_query('select username, super_admin from users where id='.$id));
                    if($dn2['super_admin']==0){

                        if(mysql_query('update users set admin=0 where id='.$id))
                        {
                            header("Location: index.php");
                        }
                        else
                        {
                            //Sinon on dit quil y a eu une erreur
                            echo 'Une erreur est survenue lors des modifications.';
                        }
                    } else {
                        echo "Vous ne pouvez pas supprimer ".$dn2['username']." des administrateur car il est super-administrateur.";
                    }
                } else {
                    echo "Il est nécessaire d'avoir au moins un administrateur !";
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
