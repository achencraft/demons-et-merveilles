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
                    <div class="menu_admin menu_admin_games"><?php include '../../overall/menu_admin_games.php' ?></div>
                    <div class="content">
            <?php

            if(isset($_GET['game_id']))
            {
            	$id = mysql_real_escape_string($_GET['game_id']);

                $req = mysql_query('select valide_par_admin from histoires where id='.$id);
                $res = mysql_fetch_array($req);

                if($res['valide_par_admin'] == 0){
                    $dn = mysql_query('select h.titre, h.nom_mj, h.niveau_mj, h.nbr_joueur_min, h.nbr_joueur_max, h.duree, h.jour, h.heure, h.description_courte, h.valide_par_admin,g.nbr_joueur_courant, g.est_publie, g.est_supprime, g.table_id, h.description_longue, h.id,h.id_image  from games g join histoires h on g.histoire_id = h.id  where g.id = '.$id);
                } else {
                    $dn = mysql_query('select h.titre, h.nom_mj, h.niveau_mj, h.nbr_joueur_min, h.nbr_joueur_max, h.duree, h.jour, h.heure, h.description_courte, h.valide_par_admin, g.nbr_joueur_courant, g.est_publie, g.est_supprime, g.table_id, h.description_longue, h.id,h.id_image, t.nbr_place, t.emplacement, c.debut, c.fin  from games g join histoires h on g.histoire_id = h.id join tables t on g.table_id = t.id join creneaux c on g.creneau_id = c.id where g.id = '.$id);
                }



            	if(mysql_num_rows($dn)>0)
            	{


                    /*    ILLUSTRATION
                     $dnn[0] h.titre
                     $dnn[1] h.nom_mj
                     $dnn[2] h.niveau_mj
                     $dnn[3] h.nbr_joueur_min
                     $dnn[4] h.nbr_joueur_max
                     $dnn[5] h.duree
                     $dnn[6] h.jour
                     $dnn[7] h.heure
                     $dnn[8] h.description_courte
                     $dnn[9] h.valide_par_admin
                     $dnn[10] g.nbr_joueur_courant
                     $dnn[11] g.est_publie
                     $dnn[12] g.est_supprime
                     $dnn[13] g.table_id
                     $dnn[14] h.description_longue
                    $dnn[15] h.id
                    $dnn[16] h.id_image
                    $dnn[17] t.nbr_place
                    $dnn[18] t.emplacement
                    $dnn[19] c.debut
                    $dnn[20] c.fin
                    */

                    /*    ILLUSTRATION
                     $dnn[0] h.titre
                     $dnn[1] h.nom_mj
                     $dnn[2] h.niveau_mj
                     $dnn[3] h.nbr_joueur_min
                     $dnn[4] h.nbr_joueur_max
                     $dnn[5] h.duree
                     $dnn[6] h.jour
                     $dnn[7] h.heure
                     $dnn[8] h.description_courte
                     $dnn[9] h.valide_par_admin
                     $dnn[10] g.nbr_joueur_courant
                     $dnn[11] g.est_publie
                     $dnn[12] g.est_supprime
                     $dnn[13] g.table_id
                     $dnn[14] h.description_longue
                    $dnn[15] h.id
                    $dnn[16] h.id_image
                    */

            		$dnn = mysql_fetch_array($dn);
            		//On affiche les donnees de la partie
                    ?>
                    <center>
                    <h4>Partie de JDR n°<?php echo $id;?></h4><br>
                    <h3><?php echo $dnn[0];?></h3>
                    </center>


                    <?php if ($dnn[9] == 0  && $dnn[12] == 0) { ?>
                        <div class="alerte">Cette partie n'a pas été validée par un administrateur.<br />
                        Attribuez lui une table de jeu et un créneau horaire, puis validez la !</div>
                    <?php } ?>

                    <?php if ($dnn[11] == 0 && $dnn[9] == 1  && $dnn[12] == 0) { ?>
                        <div class="alerte">Cette partie n'est pas publiée.<br />
                        Aucun joueur ne peut donc s'y inscrire</div>
                    <?php } ?>

                    <?php if ($dnn[11] == 1 && $dnn[9] == 1 && $dnn[12] == 0) { ?>
                        <div class="cool">Cette partie est publiée.<br />
                        Les inscriptions sont ouvertes ...</div>
                    <?php } ?>

                    <?php if ($dnn[12] == 1) { ?>
                        <div class="alerte">Cette partie a été supprimée par l'utilisateur<br />
                        Elle est conservée uniquement pour l'archivage</div>
                    <?php } ?>

                    <table style="width:98%;" >
                        <tr><td width="40%">Nom du MJ</td><td><?php echo $dnn[1];?></td></tr>
                        <tr><td width="40%">Niveau du MJ</td><td><?php echo $dnn[2];?></td></tr>
                    </table>

                    <table style="width:98%;" >
                        <tr><td >Description courte </td>
                            <td width="20px"><a href="game_edit.php?game_id=<?php echo $dnn[15]; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/editer.png" title="Editer la description"></a></td>
                            <td width="60%"><?php echo $dnn[8];?></td></tr>
                    </table>

                    <table style="width:98%;" >
                        <tr><td >Description longue</td>
                            <td width="20px"><a href="game_edit.php?game_id=<?php echo $dnn[15]; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/editer.png" title="Editer la description"></a></td>
                            <td width="60%"><?php echo $dnn[14];?></td></tr>
                    </table>

                    <br>

                    <table style="width:98%;" >
                        <tr><td width="40%">Nombre de joueurs minimum</td><td><b><?php echo $dnn[3];?></b> joueurs</td></tr>
                        <tr><td width="40%">Nombre de joueurs maximum</td><td><b><?php echo $dnn[4];?></b> joueurs</td></tr>
                        <?php if ($dnn[9] == 1) {?>
                        <tr>
                            <td width="40%">Table de jeu attribuée</td><td>n°<?php echo $dnn[13];?> - <?php echo $dnn[18];?></td><td width="20px" style="float:right;"><a href="game_edit.php?game_id=<?php echo $dnn[15]; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/editer.png" title="Editer la table attribuée"></a></td></tr>
                        <tr><td width="40%">Nombre de places de la table</td><td><b><?php echo $dnn[17];?></b> places</td></tr>
                        <tr><td width="40%">Remplissage</td><td><b><?php echo $dnn[10];?></b> / <?php echo $dnn[4];?> </td></tr>
                    <?php } else { ?>

                        <form method="post" action="to_valid/validation.php">
                            <tr style="background-color:#DA6A6B;">
                                <td>Choisir une table de jeu</td>
                                <td colspan="2">

                                    <select name="new_table">
                                        <option>--
                                    <?php

                                    $req = mysql_query('select id,nbr_place,emplacement from tables order by emplacement');
                                    while($dnn2 = mysql_fetch_array($req))
                                    {
                                        ?><option value="<?php echo $dnn2['id']; ?>"><?php echo $dnn2['emplacement'];?> - Table n°<?php echo $dnn2['id']; ?> - <?php echo $dnn2['nbr_place']; ?> places <?php
                                    }
                                    ?>
                                    </select>

                            </td>
                            </tr>


                    <?php } ?>
                    </table>


                    <br>




                    <table style="width:98%;" >
                        <tr><td width="40%">Jour et heure demandés</td><td><?php echo $dnn[6];?> - <?php echo $dnn[7];?></td></tr>
                        <tr><td width="40%">Durée envisagée</td><td><?php echo $dnn[5];?></td></tr>
                        <?php if ($dnn[9] == 1) {

                            $d1 = date('Y-m-d H:i:s',$dnn[19]-3600);
                            $date1 = new DateTime("$d1");
                            $d2 = date('Y-m-d H:i:s',$dnn[20]-3600);
                            $date2 = new DateTime("$d2");
                            $diff = date_diff($date1,$date2);
                            ?>

                        <tr><td width="40%">Jour et heure de début attribués</td><td><?php echo $date1->format('d M H:i');?></td><td width="20px" style="float:right;"><a href="game_edit.php?game_id=<?php echo $dnn[15]; ?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/editer.png" title="Editer le créneau attribué"></a></td</tr>
                        <tr><td width="40%">Jour et heure de fin attribués</td><td><?php echo $date2->format('d M H:i');?></td></tr>
                        <tr><td width="40%">Durée totale attribuée</td><td><?php echo $diff->format('%hh%I');?></td></tr>
                    <?php } else { ?>


                            <tr style="background-color:#DA6A6B;">
                                <td>Choisir un créneau horaire</td>
                                <td colspan="2">

                                    <select name="new_creneau">
                                        <option>--
                                    <?php
                                    //On recupere les identifiants, les pseudos et les emails des utilisateurs
                                    $req = mysql_query('select id,debut,fin from creneaux order by debut');
                                    while($dnn2 = mysql_fetch_array($req))
                                    {

                                        $d1 = date('Y-m-d H:i:s',$dnn2[debut]-3600);
                                        $date1 = new DateTime("$d1");
                                        $d2 = date('Y-m-d H:i:s',$dnn2[fin]-3600);
                                        $date2 = new DateTime("$d2");

                                        ?><option value="<?php echo $dnn2['id']; ?>"><?php echo $date1->format('d M H:i'); ?> - <?php echo $date2->format('d M H:i');
                                    }
                                    ?>
                                    </select>

                            </td>
                            </tr>


                    <?php } ?>
                    </table>

                    <center>

                        <?php
                        if($dnn[16] == -1){
                            echo "Aucune illustration n'a été renseignée.";
                        } else {

                            $file_profil = "../../images/illustrations-games/photo_game_".$dnn[16];

                            if(file_exists ( $file_profil.".png" )) $file_profil = $file_profil.".png" ;
                            if(file_exists ( $file_profil.".jpg" )) $file_profil = $file_profil.".jpg" ;
                            if(file_exists ( $file_profil.".jpeg")) $file_profil = $file_profil.".jpeg";
                            if(file_exists ( $file_profil.".gif" )) $file_profil = $file_profil.".gif" ;



                            echo "<img height='100' width='200' src='".$file_profil."'>";
                        }
                        ?>

                    </center>

                    <?php if ($dnn[11] == 0 && $dnn[9] == 1) { ?>
                        <div class="alerte"><a href="no_publied/publication.php?game_id=<?php echo $id;?>"><input style="width:300px;" type="button" value="Publier cette partie et permettre les inscriptions"></a>
                        <br>Cette action rendra cette partie visible aux joueurs, qui pourront alors s'y inscrire.</div>
                    <?php } ?>

                    <?php if ($dnn[11] == 1 && $dnn[9] == 1) { ?>
                        <div class="danger"><a href="publied/depublication.php?game_id=<?php echo $id;?>"><input style="width:300px;" type="button" value="Retirer cette partie et bloquer les inscriptions"></a><br>
                        <b>Danger !</b> Cette action ne va pas désinscrire les membres déjà inscrits, mais les joueurs ne pourront plus s'y inscrire.</div>
                    <?php } ?>

                <?php if( $dnn[12] == 0){ ?>


        <?php if ($dnn[9] == 1) {?>
        </div><div class="content">
            Liste des membres inscrits à cette partie:
            <table style="width:98%;">
                <tr>
                    <th>Id</th>
                    <th>Pseudo</th>
                    <th>Mail</th>
                    <th>Téléphone</th>
                </tr>
            <?php
            $dn = mysql_query('select u.id,u.username,u.email,u.telephone from users u join inscriptions i on i.user_id = u.id where i.game_id ='.$id);
            if(mysql_num_rows($dn)>0){
                $compteur = 0;
                while($dnn = mysql_fetch_array($dn))
                {
                    $compteur++;
                ?>
                	<tr style="background-color:<?php if($compteur%2 == 0) {echo '#D8D8D8';} else { echo '#BCA9F5';} ?>;">
                    	<td><?php echo $dnn[0]; ?></td>
                    	<td><?php echo htmlentities($dnn[1], ENT_QUOTES, 'UTF-8'); ?></a></td>
                    	<td><?php echo htmlentities($dnn[2], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlentities($dnn[3], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><a href="<?php echo $url;?>/admin/membres/profile.php?username=<?php echo $dnn[1]?>"><img height="15px" src="<?php echo $imagefolder; ?>/icones/user.png" title="Infos sur le joueur"></a></td>
                    </tr>
                <?php
                }



            } else {
             echo "<tr><td colspan='6'>Pas de joueurs inscrits.</td></tr>";
            }
             ?>
            </table>
            <?php
        } else {
            ?>
            <input type="hidden" name="game_id" value="<?php echo $id;?>">
            <center><input style="width:300px;" type="submit"  alt="Submit Form" value="Valider la partie avec les informations renseignées" /></center>
            </form>
            <?php
        }
    }
            }
            	else
            	{



            		echo 'Ce créneau n\'existe pas';
            	}
            }
            else
            {
            	echo 'L\'identifiant du créneau n\'est pas d&eacute;fini.';
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
