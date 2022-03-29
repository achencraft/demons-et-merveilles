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
<?php
//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

    if(isset($_GET['creneau_id'])){

        $id = mysql_real_escape_string($_GET['creneau_id']);
        $id = htmlspecialchars($id);

    	//On verifie si le formulaire a ete envoye
    	if(isset($_POST['debut'], $_POST['fin']))
    	{

    					//On echape les variables pour pouvoir les mettre dans une requette SQL
    					$debut = mysql_real_escape_string($_POST['debut']);
    					$fin = mysql_real_escape_string($_POST['fin']);




                        $date1 = date_create("$debut");
                        //echo date_format($date1,'d M Y H:i');

                        $date2 = date_create("$fin");
                        //echo date_format($date2,'d M Y H:i');

                        $timestamp1 = date_timestamp_get($date1) + 3600;
                        $timestamp2 = date_timestamp_get($date2) + 3600;

                        if($timestamp2 >= $timestamp1){ //on vérifie que heure de fin arrive APRES heure de début

                            if(($timestamp1 > -2147483647) and ($timestamp1 < 2147483647) and ($timestamp2 > -2147483647) and ($timestamp2 < 2147483647)){

                                if(($timestamp2 - $timestamp1) <= 86340){ //on vérifie que la durée du créneau est inférieure à 23h59


                                    //On modifie les informations de lutilisateur avec les nouvelles
            						if(mysql_query('update creneaux set debut='.$timestamp1.', fin='.$timestamp2.' where id='.$id))
            						{
            							//Si ca a fonctionne, on naffiche pas le formulaire
            							$form = false;
                                        header('Location: index.php');

            						}
            						else
            						{
            							//Sinon on dit quil y a eu une erreur
            							$form = true;
            							$message = 'Une erreur est survenue lors des modifications.';
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
    	else
    	{
    		$form = true;
    	}

    	if($form)
    	{


    		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
    		if(isset($_POST['debut'],$_POST['fin']))
    		{
                $debut = htmlentities($_POST['debut'], ENT_QUOTES, 'UTF-8');
                $fin = htmlentities($_POST['fin'], ENT_QUOTES, 'UTF-8');
    		}
    		else
    		{
    			//Sinon, on affiche les donnes a partir de la base de donnee
    			$dnn = mysql_fetch_array(mysql_query('select debut,fin from creneaux where id="'.$id.'"'));
                $debut = $dnn['debut'] - 3600;
                $fin = $dnn['fin'] - 3600;
            }
    		//On affiche le formulaire


        //On affiche un message sil y a lieu
        if(isset($message))
        {
            echo '<div class="message">'.$message.'</div>';
        }
        ?>
        <div class="menu_admin"><?php include '../../overall/menu_admin.php' ?></div>

        <div class="content">

            <form action="creneau_edit.php?creneau_id=<?php echo $id;?>" method="post">
                Vous pouvez modifier les informations du créneau <?php echo $id;?>:<br /><br />
                <div class="center">
                    <label for="debut">Date et heure de début :</label><input type="datetime-local" name="debut"  value="<?php echo date('Y-m-d\TH:i',$debut); ?>" style="width:200px;"/><br />
                    <label for="fin">Date et heure de fin :</label><input type="datetime-local" name="fin" value="<?php echo date('Y-m-d\TH:i',$fin); ?>" style="width:200px;" /><br /><br>
                    <input type="submit" value="Envoyer" />
                </div>
            </form>
        </div>
        <?php
    	}
    }
    }
    else{
        ?>
        <div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre administrateur.<br />
        <a href="connexion.php">Se connecter</a></div>
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
        <div class="footer"><?php include '../../overall/footer.php' ?></div>
	</body>
</html>
