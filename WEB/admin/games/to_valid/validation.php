<?php
include('../../../config.php');


//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

        if($_SERVER['REQUEST_METHOD']=='POST'){
            //On verifie si le formulaire a ete envoye
        	if(isset($_POST['new_creneau'], $_POST['new_table'], $_POST['game_id']))
        	{
        		//On echappe les variables pour pouvoir les mettre dans des requetes SQL

        			$new_table_id = stripslashes($_POST['new_table']);
                    $new_table_id = htmlspecialchars($new_table_id);
                    $new_creneau_id = stripslashes($_POST['new_creneau']);
                    $new_creneau_id = htmlspecialchars($new_creneau_id);
                    $id = stripslashes($_POST['game_id']);
                    $id = htmlspecialchars($id);




                    //On modifie les informations
                    if(mysql_query('update histoires set valide_par_admin=1 where id='.$id))
                    {

                        if(mysql_query('update games set table_id='.$new_table_id.', creneau_id='.$new_creneau_id.' where histoire_id='.$id))
                        {
                            //Si ca a fonctionne, on naffiche pas le formulaire

                            header('Location: index.php');

                        }
                        else
                        {
                            //Sinon on dit quil y a eu une erreur

                            echo 'Une erreur est survenue lors des modifications (2).';
                        }

                    }
                    else
                    {
                        //Sinon on dit quil y a eu une erreur

                        echo 'Une erreur est survenue lors des modifications (1).';
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
