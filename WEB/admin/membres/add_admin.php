<?php
include('../../config.php');


//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

        if($_SERVER['REQUEST_METHOD']=='POST'){
            //On verifie si le formulaire a ete envoye
        	if(isset($_POST['new_admin_username']))
        	{
        		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
        		if(get_magic_quotes_gpc())
        		{
        			$username = stripslashes($_POST['new_admin_username']);
                    $username = htmlspecialchars($username);
        		}
        		else
        		{
        			$username = mysql_real_escape_string($_POST['new_admin_username']);
                    $username = htmlspecialchars($username);
        		}


                if(mysql_query('update users set admin=1 where username="'.$username.'"'))
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
