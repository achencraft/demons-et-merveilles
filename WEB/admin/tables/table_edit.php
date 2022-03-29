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

    if(isset($_GET['table_id'])){

        $id = mysql_real_escape_string($_GET['table_id']);
        $id = htmlspecialchars($id);

    	//On verifie si le formulaire a ete envoye
    	if(isset($_POST['nbr_place'], $_POST['emplacement']))
    	{
    		//On enleve lechappement si get_magic_quotes_gpc est active
    		if(get_magic_quotes_gpc())
    		{
    			$_POST['nbr_place'] = stripslashes($_POST['nbr_place']);
    			$_POST['emplacement'] = stripslashes($_POST['emplacement']);
    		}

    					//On echape les variables pour pouvoir les mettre dans une requette SQL
    					$nbr_place = mysql_real_escape_string($_POST['nbr_place']);
    					$emplacement = mysql_real_escape_string($_POST['emplacement']);


    						//On modifie les informations de lutilisateur avec les nouvelles
    						if(mysql_query('update tables set nbr_place="'.$nbr_place.'", emplacement="'.$emplacement.'"where id="'.$id.'"'))
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



    	}
    	else
    	{
    		$form = true;
    	}

    	if($form)
    	{


    		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
    		if(isset($_POST['nbr_place'],$_POST['emplacement']))
    		{
                $nbr_place = htmlentities($_POST['nbr_place'], ENT_QUOTES, 'UTF-8');
                $emplacement = htmlentities($_POST['emplacement'], ENT_QUOTES, 'UTF-8');
    		}
    		else
    		{
    			//Sinon, on affiche les donnes a partir de la base de donnee
    			$dnn = mysql_fetch_array(mysql_query('select nbr_place,emplacement from tables where id="'.$id.'"'));
                $nbr_place = htmlentities($dnn['nbr_place'], ENT_QUOTES, 'UTF-8');
                $emplacement = htmlentities($dnn['emplacement'], ENT_QUOTES, 'UTF-8');
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

        <form action="table_edit.php?table_id=<?php echo $id;?>" method="post">
            Vous pouvez modifier les informations de la table <?php echo $id;?>:<br /><br />
            <div class="center">
                <label for="nbr_place">Nombre de place :</label><input type="text" name="nbr_place" value="<?php echo $nbr_place; ?>" /><br />
                <label for="emplacement">Emplacement :</label><input type="text" name="emplacement" value="<?php echo $emplacement; ?>" /><br /><br>
                <input type="submit" value="Envoyer" />
            </div>
        </form>
    </div>
    <?php
    	}
    }
    else{
        ?>
        <div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre administrateur.<br />
        <a href="connexion.php">Se connecter</a></div>
        <?php
    }
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
