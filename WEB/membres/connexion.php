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
<?php
//Si lutilisateur est connecte, on le deconecte
if(isset($_SESSION['username']))
{

	//On le deconecte en supprimant simplement les sessions username et userid
	unset($_SESSION['username'], $_SESSION['userid']);
    header('Location: ../index.php');
}
else
{

	$ousername = '';
	//On verifie si le formulaire a ete envoye
	if(isset($_POST['username'], $_POST['password']))
	{

		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
		if(get_magic_quotes_gpc())
		{
			$ousername = stripslashes($_POST['username']);
			$username = mysql_real_escape_string(stripslashes($_POST['username']));
			$password = stripslashes($_POST['password']);
		}
		else
		{
			$username = mysql_real_escape_string($_POST['username']);
			$password = $_POST['password'];
		}
		//On recupere le mot de passe de lutilisateur
		$req = mysql_query('select password,id,valide from users where username="'.$username.'"');
		$dn = mysql_fetch_array($req);
		//On le compare a celui quil a entre et on verifie si le membre existe
		if(password_verify($password, $dn['password']) and mysql_num_rows($req)>0)
		{
            //si son compte est activé
            if($dn['valide'] == 1){

                //Si le mot de passe est bon, on ne vas pas afficher le formulaire
    			$form = false;
    			//On enregistre son pseudo dans la session username et son identifiant dans la session userid
    			$_SESSION['username'] = $_POST['username'];
    			$_SESSION['userid'] = $dn['id'];
                header("Location: $url_home");
            } else {
                //Sinon, on indique que le compte n'est pas activé
                $form = true;
                $message = "Votre compte n'est pas activé, vérifiez vos emails. <br> <a href='https://".$_SERVER['SERVER_NAME']."/membres/send_email.php?log=$username'>Renvoyer le mail d'activation</a>";
            }
		}
		else
		{
			//Sinon, on indique que la combinaison nest pas bonne
			$form = true;
			$message = 'La combinaison que vous avez entr&eacute; n\'est pas bonne.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
	//On affiche un message sil y a lieu
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
	//On affiche le formulaire
?>
<div class="content">
    <form action="connexion.php" method="post">
        Veuillez entrer vos identifiants pour vous connecter:<br /><br>
        <div class="center">
            <label for="username">Nom d'utilisateur</label><input type="text" name="username" id="username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8'); ?>" /><br />
            <label for="password">Mot de passe</label><input type="password" name="password" id="password" /><br /><br>
            <input type="submit" value="Connexion" />
		</div>
    </form>
</div>
<?php
	}
}
?>
        </div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
