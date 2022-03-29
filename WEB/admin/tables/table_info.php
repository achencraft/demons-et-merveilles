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
            if(isset($_GET['table_id']))
            {
            	$id = mysql_real_escape_string($_GET['table_id']);
            	//On verifie que lutilisateur existe
            	$dn = mysql_query('select id,nbr_place, emplacement from tables where id='.$id);
            	if(mysql_num_rows($dn)>0)
            	{
            		$dnn = mysql_fetch_array($dn);
            		//On affiche les donnees de lutilisateur
            ?>
            <table style="width:500px; background-color:#BCA9F5;">
            	<tr>
                <td colspan="2"><h1>Table <?php echo htmlentities($dnn['id'], ENT_QUOTES, 'UTF-8'); ?></h1></td>
                </tr>
                <tr><td>	Nombre de place: </td><td><?php echo htmlentities($dnn['nbr_place'], ENT_QUOTES, 'UTF-8'); ?> </td></tr>
                <tr><td>	Emplacement: </td><td><?php echo htmlentities($dnn['emplacement'], ENT_QUOTES, 'UTF-8'); ?> </td></tr>
            </table><br><br>


            Liste des parties de JDR programmées sur cette table :
            <table style="width:98%;">
                <tr>
                    <th >Id</th>
                    <th>Nom de l'histoire</th>
                    <th>MJ</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th >Durée</th>
                    <th>Remplissage</th>
                </tr>
            <?php
            $dn = mysql_query('select g.id,h.titre,h.nom_mj,c.debut,c.fin,g.nbr_joueur_courant,h.nbr_joueur_max,c.id from games g join histoires h on g.histoire_id = h.id join creneaux c on g.creneau_id = c.id where g.table_id='.$id);
            if(mysql_num_rows($dn)>0){
                $compteur = 0;
                while($dnn = mysql_fetch_array($dn))
                {
                    $compteur++;
                    $d1 = date('Y-m-d H:i:s',$dnn[3]-3600);
                    $date1 = new DateTime("$d1");
                    $d2 = date('Y-m-d H:i:s',$dnn[4]-3600);
                    $date2 = new DateTime("$d2");
                    $diff = date_diff($date1,$date2);

                ?>
                	<tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                    	<td><?php echo $dnn[0]; ?></td>
                    	<td><?php echo htmlentities($dnn[1], ENT_QUOTES, 'UTF-8'); ?></a></td>
                    	<td><?php echo htmlentities($dnn[2], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo $date1->format('d M H:i'); ?></td>
                        <td><?php echo $date2->format('d M H:i'); ?></td>
                        <td><?php echo $diff->format('%hh%I'); ?></td>
                        <td><?php echo $dnn[5]; ?>/<?php echo $dnn[6]; ?></td>
                        <td><a href="<?php echo $url;?>/admin/games/game_info.php?game_id=<?php echo $dnn[0]?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/jeu.png" title="Infos sur la partie de JDR"></a></td>
                        <td><a href="<?php echo $url;?>/admin/creneaux/creneau_info.php?creneau_id=<?php echo $dnn[7]?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/horloge.png" title="Infos sur le créneau horaire"></a></td>
                        <td><a href="<?php echo $url;?>/admin/membres/profile.php?username=<?php echo $dnn[2]?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/user.png" title="Infos sur le MJ"></a></td>
                        <td><a href="<?php echo $url;?>/admin/games/playerlist.php?games_id=<?php echo $dnn[0]?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/group.png" title="Infos sur les joueurs inscrits"></a></td>
                    </tr>
                <?php
                }



            } else {
             echo "<tr><td colspan='6'>Aucune partie n'est programmée pour cette table.</td></tr>";
            }
             ?>
            </table>
            <?php
            	}
            	else
            	{
            		echo 'Cette table n\'existe pas.';
            	}
            }
            else
            {
            	echo 'L\'identifiant de la table n\'est pas d&eacute;fini.';
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
