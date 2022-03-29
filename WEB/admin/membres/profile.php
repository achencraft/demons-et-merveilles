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


                ?>

                    <div class="menu_admin"><?php include '../../overall/menu_admin.php' ?></div>
                    <div class="content">
            <?php
            //On verifie que lidentifiant de lutilisateur est defini
            if(isset($_GET['username']))
            {
            	$id = mysql_real_escape_string($_GET['username']);
            	//On verifie que lutilisateur existe
            	$dn = mysql_query('select username, email, telephone, date_naissance, admin, signup_date from users where username="'.$id.'"');
            	if(mysql_num_rows($dn)>0)
            	{
            		$dnn = mysql_fetch_array($dn);
            		//On affiche les donnees de lutilisateur
            ?>
            <table style="width:500px; background-color:#BCA9F5;">
            	<tr>
                <td colspan="2"><h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1></td>
                </tr>
                <tr><td>	Email: </td><td><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?> </td></tr>
                <tr><td>	Téléphone: </td><td><?php echo htmlentities($dnn['telephone'], ENT_QUOTES, 'UTF-8'); ?> </td></tr>
                <tr><td>	Date de naissance: </td><td><?php echo date('d/m/Y',$dnn['date_naissance']); ?> </td></tr>
                <tr><td>    Date d'inscription: </td><td> <?php echo date('d/m/Y',$dnn['signup_date']); ?> </td></tr>
                <tr><td>    Administrateur ? </td><td> <?php if($dnn['admin'] == 1) {echo "oui";} else {echo "non";}; ?> </td></tr>
            </table>
            <?php
            	}
            	else
            	{
            		echo 'Cet utilisateur n\'existe pas.';
            	}
            }
            else
            {
            	echo 'L\'identifiant de l\'utilisateur n\'est pas d&eacute;fini.';
            }
            ?>
            		</div>
        <?php

    } else {
        //message si l'utilisateur est connecté mais n'est pas admin
        ?>
        <div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre administrateur.<br />
        <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></div>
        <?php
    }
}
else
{
    //message si l'utilisateur n'est pas connecté
?>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute; et être administrateur.<br />
<a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/connexion.php">Se connecter</a></div>
<?php
}
?>

		</div>
        <div class="footer"><?php include '../../overall/footer.php' ?></div>
	</body>
</html>
