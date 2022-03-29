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
        <div class="menu_admin"><?php include '../../overall/menu_admin.php' ?></div>
        <div class="content">
        <?php

//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

        if($_SERVER['REQUEST_METHOD']=='POST'){
            //On verifie si le formulaire a ete envoye
        	if(isset($_POST['debut'], $_POST['fin']))
        	{


                    $debut_tmp = $_POST['debut'];
                    $fin_tmp = $_POST['fin'];



                    $date1 = date_create("$debut_tmp");
                    //echo date_format($date1,'d M Y H:i');

                    $date2 = date_create("$fin_tmp");
                    //echo date_format($date2,'d M Y H:i');

                    $timestamp1 = date_timestamp_get($date1) + 3600;
                    $timestamp2 = date_timestamp_get($date2) + 3600;

                    if($timestamp2 >= $timestamp1){ //on vérifie que heure de fin arrive APRES heure de début

                        if(($timestamp1 > -2147483647) and ($timestamp1 < 2147483647) and ($timestamp2 > -2147483647) and ($timestamp2 < 2147483647)){

                            if(($timestamp2 - $timestamp1) <= 86340){ //on vérifie que la durée du créneau est inférieure à 23h59

                                //On recupere le nombre dutilisateurs pour donner un identifiant a lutilisateur actuel
                                $dn2 = mysql_fetch_array(mysql_query('select MAX(id) as maximum from creneaux'));
                                $id = $dn2['maximum']+1;

                                //On enregistre les informations dans la base de donnee
                                if(mysql_query('insert into creneaux(id, debut, fin) values ('.$id.', '.$timestamp1.', '.$timestamp2.')'))
                                {
                                    //On redirige
                                    header("Location: index.php");


                                }
                                else
                                {
                                    //Sinon on dit quil y a eu une erreur
                                    echo 'Une erreur est survenue lors de l\'inscription.';
                                }

                            }else{
                                echo "la durée de ce créneau est supérieure à 23h59. Tu t'imagines jouer combien de temps là !?! Va dormir ";
                            }
                        }else{
                            echo "Une ou plusieures dates sont trop éloignées du présent ... Le voyage dans le temps, c'est pas pour bientôt ! Calme toi ...<br>
                                Connais tu le TimeStamp UNIX ?<br>
                                Il s'agit de la représentation utilisée pour ce site, des dates en binaire. Aujourd'hui, on ne peut représenter que des dates allant, à la louche, de 1901 à 2038.<br>
                                Le jour où les pc représenteront ça sur 64bits, alors je laisserai passer les dates loufoques que tu as renseigné dans le formulaire...<br>

                                En attendant, bonne journée !";
                        }

                    } else {
                        echo "Votre heure de fin se passe avant votre heure de début. On me la fait pas à moi...";
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
