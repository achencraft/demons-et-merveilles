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
        	if(isset($_POST['nbr_place'], $_POST['emplacement']))
        	{

        		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
        		if(get_magic_quotes_gpc())
        		{
        			$nbr_place = stripslashes($_POST['nbr_place']);
                    $nbr_place = htmlspecialchars($nbr_place);
                    $nbr_place = (int)$nbr_place;
                    $emplacement = stripslashes($_POST['emplacement']);
                    $emplacement = htmlspecialchars($emplacement);
        		}
        		else
        		{
        			$nbr_place = mysql_real_escape_string($_POST['nbr_place']);
                    $nbr_place = htmlspecialchars($nbr_place);
                    $nbr_place = (int)$nbr_place;
                    $emplacement = mysql_real_escape_string($_POST['emplacement']);
                    $emplacement = htmlspecialchars($emplacement);
        		}


                //On recupere le nombre dutilisateurs pour donner un identifiant a lutilisateur actuel
                $dn2 = mysql_fetch_array(mysql_query('select MAX(id) as maximum from tables'));
                $id = $dn2['maximum']+1;

                echo $id;
                //On enregistre les informations dans la base de donnee
                if(mysql_query('insert into tables(id, nbr_place, emplacement) values ('.$id.', "'.$nbr_place.'", "'.$emplacement.'")'))
                {
                    //On redirige
                    header("Location: index.php");


                }
                else
                {
                    //Sinon on dit quil y a eu une erreur
                    echo 'Une erreur est survenue lors de l\'inscription.';
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
