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
        <div class="menu"><?php include '../overall/menu.php' ?></div>
<?php
//On verifie que le formulaire a ete envoye
if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['tel'], $_POST['naissance']) and $_POST['username']!='')
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['username'] = stripslashes($_POST['username']);
		$_POST['password'] = stripslashes($_POST['password']);
		$_POST['passverif'] = stripslashes($_POST['passverif']);
		$_POST['email'] = stripslashes($_POST['email']);
        $_POST['tel'] = stripslashes($_POST['tel']);
        $_POST['naissance'] = stripslashes($_POST['naissance']);
	}
	//On verifie si le mot de passe et celui de la verification sont identiques
	if($_POST['password']==$_POST['passverif'])
	{
		//On verifie si le mot de passe a 6 caracteres ou plus
		if(strlen($_POST['password'])>=6)
		{
			//On verifie si lemail est valide
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$username = mysql_real_escape_string($_POST['username']);
				$password = mysql_real_escape_string($_POST['password']);
				$email = mysql_real_escape_string($_POST['email']);
                $tel = mysql_real_escape_string($_POST['tel']);
                $naissance = mysql_real_escape_string($_POST['naissance']);
				//On verifie sil ny a pas deja un utilisateur inscrit avec le pseudo choisis
				$dn = mysql_num_rows(mysql_query('select id from users where username="'.$username.'"'));
				if($dn==0)
				{
					//On recupere le nombre dutilisateurs pour donner un identifiant a lutilisateur actuel
                    $dn2 = mysql_fetch_array(mysql_query('select MAX(id) as maximum from users'));
                    $id = $dn2['maximum']+1;
					//On crypte le mot de passe
					$password = password_hash($password,PASSWORD_BCRYPT,['cost' => 11]);

                    //clé pour le mail de confirmation
                    $cle = md5(microtime(TRUE)*100000);

					//On enregistre les informations dans la base de donnee
					if(mysql_query('insert into users(id, username, password, email, telephone, date_naissance, signup_date, confirm_cle, valide) values ('.$id.', "'.$username.'", "'.$password.'", "'.$email.'", "'.$tel.'", "'.strtotime($naissance).'",  "'.time().'", "'.$cle.'",1)'))
					{
						//Si ca a fonctionne, on naffiche pas le formulaire
						$form = false;
                        //On redirige vers l'envoi du mail
                        //header("Location: send_email.php?log=$username");  LES MAILS PARTENT EN SPAM
                        ?>
                        <div class="content">
                            Votre compte a été créé !<br>
                            <a href="https://<?php echo $_SERVER['SERVER_NAME']?>">Retour à l'accueil</a></br>
                            <a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/connexion.php">Se connecter</a></div>
                        </div>
                        <?php

					}
					else
					{
						//Sinon on dit quil y a eu une erreur
						$form = true;
						$message = 'Une erreur est survenue lors de l\'inscription.';
					}
				}
				else
				{
					//Sinon, on dit que le pseudo voulu est deja pris
					$form = true;
					$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
				}
			}
			else
			{
				//Sinon, on dit que lemail nest pas valide
				$form = true;
				$message = 'L\'email que vous avez entr&eacute; n\'est pas valide.';
			}
		}
		else
		{
			//Sinon, on dit que le mot de passe nest pas assez long
			$form = true;
			$message = 'Le mot de passe que vous avez entr&eacute; contient moins de 6 caract&egrave;res.';
		}
	}
	else
	{
		//Sinon, on dit que les mots de passes ne sont pas identiques
		$form = true;
		$message = 'Les mots de passe que vous avez entr&eacute; ne sont pas identiques.';
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
    <form action="sign_up.php" method="post">
        Veuillez remplir ce formulaire pour vous inscrire:<br />
        Tous les champs sont obligatoires.<br><br>
        <div class="center">
            <label for="username" required>Nom d'utilisateur</label><input type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="password" required>Mot de passe<span class="small"> (6 caract&egrave;res min.)</span></label><input type="password" name="password" /><br />
            <label for="passverif" required>Mot de passe<span class="small"> (v&eacute;rification)</span></label><input type="password" name="passverif" /><br />
            <label for="email" required>Email</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="tel" required>Téléphone</label><input type="tel" name="tel" value="<?php if(isset($_POST['tel'])){echo htmlentities($_POST['tel'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="birthday" required>Date de naissance<span class="small"> (jj/mm/aaaa)</span></label><input type="date" name="naissance" value="<?php if(isset($_POST['naissance'])){echo htmlentities($_POST['naissance'], ENT_QUOTES, 'UTF-8');} ?>" /><br /><br>
            <input type="submit" value="S'inscrire" />
		</div>
    </form>
</div>
<?php
}
?>
		</div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
