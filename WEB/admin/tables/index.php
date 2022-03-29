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
            Liste des tables disponibles:
            <table>
                <tr>
                	<th>Id</th>
                	<th>Nombre de place</th>
                	<th>Emplacement</th>
                </tr>
            <?php

            //on vérifie qu'il existe des tables
            $result = mysql_query('select count(*) as total from tables');
            $nbr_admin=mysql_fetch_assoc($result);
            $compteur = 0;
            if($nbr_admin['total'] != 0){

                //On recupere les identifiants, les pseudos et les emails des utilisateurs
                $req = mysql_query('select id, nbr_place, emplacement from tables order by id');

                while($dnn = mysql_fetch_array($req))
                {
                    $compteur++;
                ?>
                	<tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                    	<td><a href="table_info.php?table_id=<?php echo $dnn['id']; ?>"><?php echo $dnn['id']; ?></a></td>
                    	<td><a href="table_info.php?table_id=<?php echo $dnn['id']; ?>"><?php echo htmlentities($dnn['nbr_place'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                    	<td><a href="table_info.php?table_id=<?php echo $dnn['id']; ?>"><?php echo htmlentities($dnn['emplacement'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                        <td><a href="table_info.php?table_id=<?php echo $dnn['id']; ?>">+ d'info</a></td>
                        <td><a href="table_edit.php?table_id=<?php echo $dnn['id']; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/editer.png" title="Editer la table <?php echo $dnn['id']; ?> "></a></td>
                        <td><a href="remove_table.php?table_id=<?php echo $dnn['id']; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/supprimer.png" title="Supprimer la table <?php echo $dnn['id']; ?> "></a></td>
                    </tr>
                <?php
                }
            } else {?>
                    <tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                    <td colspan="3"> Il n'y a pas de table</td>
                </tr><?php
            }
            ?>

            </table>
            <br><br>
            <form method="post" action="add_table.php">
                <table>
                    <tr><td colspan="2" style="text-align:center;">Ajouter une table</td></tr>
                    <tr>
                        <td>Nombre de place :</td>
                        <td><input type="text" name="nbr_place" value="" required></td>
                    </tr>
                    <tr>
                        <td>Emplacement :</td>
                        <td><input type="text" name="emplacement" value="" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center;"><input type="submit" value="Créer une nouvelle table"  /></td>
                    </tr>
                </table>
            </form>

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
