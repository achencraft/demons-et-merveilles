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
//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
	//On verifie si le formulaire a ete envoye
	if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['tel'], $_POST['naissance']))
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
					$dn = mysql_fetch_array(mysql_query('select count(*) as nb from users where username="'.$username.'"'));
					//On verifie si le pseudo a ete modifie pour un autre et que celui-ci n'est pas deja utilise
					if($dn['nb']==0 or $_POST['username']==$_SESSION['username'])
					{

						//on chiffre le mdp
						$password = password_hash($password,PASSWORD_BCRYPT,['cost' => 11]);


						//On modifie les informations de lutilisateur avec les nouvelles
						if(mysql_query('update users set username="'.$username.'", password="'.$password.'", email="'.$email.'", telephone="'.$tel.'", date_naissance="'.strtotime($naissance).'" where id="'.mysql_real_escape_string($_SESSION['userid']).'"'))
						{
							//Si ca a fonctionne, on naffiche pas le formulaire
							$form = false;
							//On supprime les sessions username et userid au cas ou il aurait modifie son pseudo
							unset($_SESSION['username'], $_SESSION['userid']);
?>
<div class="message">Vos informations ont bien &eacute;t&eacute; modifif&eacute;e. Vous devez vous reconnecter.<br />
<a href="connexion.php">Se connecter</a></div>
<?php
						}
						else
						{
							//Sinon on dit quil y a eu une erreur
							$form = true;
							$message = 'Une erreur est survenue lors des modifications.';
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
				$message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
			}
		}
		else
		{
			//Sinon, on dit que les mots de passes ne sont pas identiques
			$form = true;
			$message = 'Les mot de passe que vous avez entr&eacute; ne sont pas identiques.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{


		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
		if(isset($_POST['username'],$_POST['password'],$_POST['email'],$_POST['tel'],$_POST['naissance']))
		{
			$username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
			if($_POST['password']==$_POST['passverif'])
			{
				$password = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
			}
			else
			{
				$password = '';
			}
			$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
            $tel = htmlentities($_POST['tel'], ENT_QUOTES, 'UTF-8');
            $naissance = htmlentities($_POST['naissance'], ENT_QUOTES, 'UTF-8');
		}
		else
		{
			//Sinon, on affiche les donnes a partir de la base de donnee
			$dnn = mysql_fetch_array(mysql_query('select username,password,email,telephone,date_naissance from users where username="'.$_SESSION['username'].'"'));
			$username = htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8');
			$password = htmlentities($dnn['password'], ENT_QUOTES, 'UTF-8');
			$email = htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8');
            $tel = htmlentities($dnn['telephone'], ENT_QUOTES, 'UTF-8');
            $naissance = date('Y-m-d',$dnn['date_naissance']);
		}
		//On affiche le formulaire


//On affiche un message sil y a lieu
if(isset($message))
{
    echo '<div class="message">'.$message.'</div>';
}
?>
<div class="content">

    <form action="edit_infos.php" method="post">
        Vous pouvez modifier vos informations:<br /><br />
        <div class="center">
            <label for="username">Nom d'utilisateur</label><input type="text" name="username" id="username" value="<?php echo $username; ?>" /><br />
            <label for="password">Mot de passe<span class="small"> (6 caract&egrave;res min.)</span></label><input type="password" name="password" id="password" value="<?php echo $password; ?>" /><br />
            <label for="passverif">Mot de passe<span class="small"> (v&eacute;rification)</span></label><input type="password" name="passverif" id="passverif" value="<?php echo $password; ?>" /><br />
            <label for="email">Email</label><input type="text" name="email" id="email" value="<?php echo $email; ?>" /><br />
            <label for="tel">Téléphone</label><input type="text" name="tel" value="<?php echo $tel; ?>" maxlength="10" /><br />
            <label for="birthday">Date de naissance</label><input type="date" name="naissance" value="<?php echo $naissance; ?>" /><br /><br />
            <input type="submit" value="Envoyer" />
        </div>
    </form>

<br><br>

    <hr><br>
    Liste de vos inscriptions aux parties de JDR : <br><br>

    <?php


    $req = mysql_query('select h.titre, g.id, i.debut, i.fin, t.emplacement from games g join histoires h on g.histoire_id = h.id join inscriptions i on i.game_id = g.id join users u on i.user_id = u.id join tables t on g.table_id = t.id where u.username = "'.$_SESSION['username'].'"');

        if(mysql_num_rows($req)>0){

        while($dnn = mysql_fetch_array($req))
        {
            $d1 = date('Y-m-d H:i:s',$dnn['debut']-3600);
            $date1 = new DateTime("$d1");
            $d2 = date('Y-m-d H:i:s',$dnn['fin']-3600);
            $date2 = new DateTime("$d2");
            $diff = date_diff($date1,$date2);


            echo "<a href='../tables/table_info.php?game_id=".$dnn['id']."'>".$dnn['titre']."</a>";
            echo "  --  ";
            echo $date1->format('d F  H:i');
            echo "  --   ";
            echo $dnn['emplacement'];
            echo "<br>";

        }

    } else {
        echo "Aucune inscription.";
    }





     ?>
     <br>

    <hr>
    <span style="color:red;">Vous pouvez supprimer votre compte en cliquant <a href="suppression.php?username=<?php echo $_SESSION['username']; ?>">ici</a>.<br> Cette action est irréversible et vous perdrez vos inscriptions aux JDR.</span>
</div>
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
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
