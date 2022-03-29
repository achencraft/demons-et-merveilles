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
            Liste des administrateurs:
            <table>
                <tr>
                	<th>Id</th>
                	<th>Nom d'utilisateur</th>
                	<th>Email</th>
                </tr>
            <?php
            //On recupere les identifiants, les pseudos et les emails des utilisateurs
            $req = mysql_query('select id, username, email, admin from users where admin="1" order by id');
            $compteur = 0;
            while($dnn = mysql_fetch_array($req))
            {
                $compteur++;
            ?>
            	<tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                	<td><?php echo $dnn['id']; ?></td>
                	<td><a href="profile.php?username=<?php echo $dnn['username']; ?>"><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                	<td    ><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="profile.php?username=<?php echo $dnn['username']; ?>">+ d'info</a></td>
                    <td><a href="remove_admin.php?id=<?php echo $dnn['id']; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/supprimer.png" title="Supprimer <?php echo $dnn['username']; ?> des administrateurs"></a></td>
                </tr>
            <?php
            }
            ?>
                <form method="post" action="add_admin.php">
                    <tr>
                        <td colspan="2">Ajouter un administrateur</td>
                        <td colspan="2">

                            <select name="new_admin_username">
                            <?php
                            //On recupere les identifiants, les pseudos et les emails des utilisateurs
                            $req = mysql_query('select username, admin from users where admin="0" order by LOWER(username)');
                            while($dnn = mysql_fetch_array($req))
                            {
                                ?><option><?php echo $dnn['username'];
                            }
                            ?>
                            </select>

                    </td>
                        <td><input style="width:15px;" type="image" src="<?php echo $imagefolder; ?>/icones/ajouter.png" alt="Submit Form" title="Ajouter votre sélection aux administrateurs" /></td>

                    </tr>
                </form>
            </table>



            Liste des utilisateurs:
            <table>
                <tr>
                	<th>Id</th>
                	<th>Nom d'utilisateur</th>
                	<th>Email</th>
                </tr>
            <?php
            //On recupere les identifiants, les pseudos et les emails des utilisateurs
            $req = mysql_query('select id, username, email, admin from users  order by id');
            $compteur = 0;
            while($dnn = mysql_fetch_array($req))
            {
                $compteur++;
            ?>
            	<tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                	<td><?php echo $dnn['id']; ?></td>
                	<td><a href="profile.php?username=<?php echo $dnn['username']; ?>"><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                	<td    ><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="profile.php?username=<?php echo $dnn['username']; ?>">+ d'info</a></td>
                </tr>
            <?php
            }
            ?>
            </table>
        </br>
            Pour des raisons de sécurité, la suppression d'utilisateur doit se faire directement dans la table "users" de la base de donnée.
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
