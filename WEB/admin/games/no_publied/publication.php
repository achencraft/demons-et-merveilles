<?php
include('../../../config.php');


//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

        if($_SERVER['REQUEST_METHOD']=='GET'){
            //On verifie si le formulaire a ete envoye
        	if(isset($_GET['game_id']))
        	{
        		//On echappe les variables pour pouvoir les mettre dans des requetes SQL

                    $id = stripslashes($_GET['game_id']);
                    $id = htmlspecialchars($id);




                    //On modifie les informations
                    if(mysql_query('update games set est_publie=1 where id='.$id))
                    {
                            header('Location: index.php');
                    }
                    else
                    {
                        //Sinon on dit quil y a eu une erreur

                        echo 'Une erreur est survenue lors des modifications';
                    }

            }
        } else {
         echo "pas en requete GET";
        }

        } else {
        echo "Vous n'etes pas administrateur";
        }

} else {
    echo "Vous n'etes pas connecté";
}
?>
