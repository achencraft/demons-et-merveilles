<?php
include('../../../config.php');
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
        <div class="menu"><?php include '../../../overall/menu.php' ?></div>
        <?php
        //On verifie si lutilisateur est connecte
        if(isset($_SESSION['username']))
        {
            $username = $_SESSION['username'];
            //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
            $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
            if($dn['admin']==1 and $dn['username']==$_SESSION['username']){


                ?>

                    <div class="menu_admin"><?php include '../../../overall/menu_admin.php' ?></div>
                    <div class="menu_admin menu_admin_games"><?php include '../../../overall/menu_admin_games.php' ?></div>
                    <div class="content">

            <h3>Parties non-publiées</h3>

            Liste des parties non-publiées:
            <table style="width:98%;">
                <tr>
                	<th>Id</th>
                    <th>Titre</th>
                    <th>MJ</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Durée</th>
                    <th>Lieu</th>
                    <th>Remplissage</th>
                </tr>
            <?php

            //on vérifie qu'il existe des tables
            $result = mysql_query('select count(*) as total from games g join histoires h on g.histoire_id = h.id where h.valide_par_admin = 1 and g.est_publie = 0');
            $nbr_admin=mysql_fetch_assoc($result);
            $compteur = 0;
            if($nbr_admin['total'] != 0){

                //On recupere les identifiants, les pseudos et les emails des utilisateurs
                $req = mysql_query("select g.id,h.titre,h.nom_mj,c.debut,c.fin,t.emplacement,g.nbr_joueur_courant,h.nbr_joueur_max from games g join histoires h on g.histoire_id = h.id join creneaux c on g.creneau_id = c.id join tables t on g.table_id = t.id where h.valide_par_admin = 1 and g.est_publie = 0");


                while($dnn = mysql_fetch_array($req))
                {
                    $compteur++;
                    $d1 = date('Y-m-d H:i:s',$dnn[debut]-3600);
                    $date1 = new DateTime("$d1");
                    $d2 = date('Y-m-d H:i:s',$dnn[fin]-3600);
                    $date2 = new DateTime("$d2");
                    $diff = date_diff($date1,$date2);

                ?>
                	<tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                    	<td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $dnn['id']; ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $dnn['titre']; ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $dnn['nom_mj']; ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $date1->format('d M H:i'); ?></a></td>
                    	<td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $date2->format('d M H:i'); ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $diff->format('%hh%I'); ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $dnn['emplacement']; ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>"><?php echo $dnn['nbr_joueur_courant']; ?>/<?php echo $dnn['nbr_joueur_max']; ?></a></td>
                        <td><a href="../game_info.php?game_id=<?php echo $dnn['id']; ?>">+ d'info</a></td>
                    </tr>
                <?php
                }
            } else {?>
                    <tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                    <td colspan="7">Il n'y a pas de parties non-publiées</td>
                </tr><?php
            }
            ?>

            </table>




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
        <div class="footer"><?php include '../../../overall/footer.php' ?></div>
	</body>
</html>
