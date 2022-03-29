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

    ?>
    <div class="content">

        Vous avez l'âme d'un maître de jeu ? Proposez ici votre idée de scénario.<br>
        Si les organisateurs la valide, vous pourrez alors animer une table de jeu et faire vivre votre histoire à des joueurs.<br><br>

        <?php
        $result = mysql_query('select count(*) as total from histoires h join games g on g.histoire_id = h.id where h.nom_mj = "'.$_SESSION['username'].'" and g.est_supprime = 0');
        $nbr_game=mysql_fetch_assoc($result);
        if($nbr_game['total'] == 0){
            ?>



        Il ne vous est possible de proposer qu'une seule histoire.<br>
        De plus, il ne vous est possible de choisir qu'un seul créneau horaire.<br>
        Choisissez en une où vous êtes certain d'être présent pour animer votre scénario !<br>
        <br>

        ** Créneaux disponibles **<br>
        Samedi 6 Avril - de 9h30 à 16h00<br>
        Samedi 6 Avril - de 16h30 à 23h00<br>
        Dimanche 7 Avril - de 00h00 à 08h00<br>
        Dimanche 7 Avril - de 9h30 à 16h00<br>
        <br>

        ** Durée de la partie **<br>
        La durée approximative de votre partie doit pouvoir correspondre avec les créneaux ci-dessus<br>







            <form action="save_new_table.php" method="post"  enctype="multipart/form-data" name="new_table">
                <br /><br />
                <div class="center">
                    <fieldset>
                        <legend>A propos de votre histoire :</legend>
                            <br>
                            <label for="titre">Titre de votre histoire</label><input  style="width:300px;" type="text" name="titre" value="<?php echo $username; ?>" required /><br /><br />
                            <label for="desc_courte">Description Courte :</label><textarea name="desc_courte" cols="40" rows="5" required><?php echo $desc_courte; ?></textarea><br /><br>
                            <label for="desc_longue">Description Longue :</label><textarea name="desc_longue" cols="40" rows="12" required><?php echo $desc_longue; ?></textarea><br /><br>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!--taille max de l'image en octet = 1Mo-->
                            <label for="desc_longue">Illustration :</label><input style="width:300px;" type="file" name="image" /><br /><br>

                    </fieldset><br>
                    <fieldset>
                        <legend>Informations techniques :</legend>
                            <br>





                            <label for="minimum">Nombre de joueurs minimum</label><input type="number" max="9" min="0" name="minimum" value="<?php echo $password; ?>" required /><br /><br />
                            <label for="maximum">Nombre de joueurs maximum</label><input min="0" max="9" type="number" name="maximum" value="<?php echo $email; ?>" required /><br /><br />
                            <label for="duree">Durée Approximative</label><input type="text" name="duree" value="<?php echo $tel; ?>" maxlength="10" required /><br /><br />

                            <label for="jour">Jour souhaité</label><select name="jour" size="1" onChange="updatehoraires(this.selectedIndex)" required>
                                <option selected>
                                    <?php
                                        $req = mysql_query("select * from configuration where jour=1 and valide=1");
                                        while($dnn = mysql_fetch_array($req)){
                                            ?>
                                                <option value="<?php echo $dnn['valeur'];?>"><?php echo $dnn['valeur'];?>
                                            <?php
                                        }
                                     ?>
                            </select></br><br />

                            <label for="heure">Heure souhaitée</label><select name="heure" size="1" required>

                            </select></br><br />

                            <label for="niveau">Votre niveau de MJ</label><select name="niveau" size="1" required>
                                <option selected>
                                <option value="novice">Novice
                                <option value="debutant">Débutant
                                <option value="expert">Experimenté
                            </select></br><br />
                        </fieldset><br>
                            <input type="submit" name="save" value="Sauvegarder" />
                </div>
            </form>

            <?php
        } else {

            $username = $_SESSION['username'];

            $req = mysql_query('select h.id,h.valide_par_admin from histoires h join games g on g.histoire_id = h.id where h.nom_mj="'.$username.'" and g.est_supprime = 0');
            $res = mysql_fetch_array($req);

            if($res['valide_par_admin'] == 0){
                $dn = mysql_query('select h.titre, h.nom_mj, h.niveau_mj, h.nbr_joueur_min, h.nbr_joueur_max, h.duree, h.jour, h.heure, h.description_courte, h.valide_par_admin,  h.valide_par_user, g.nbr_joueur_courant, g.est_publie, g.est_supprime, g.table_id, h.description_longue, h.id,h.id_image  from games g join histoires h on g.histoire_id = h.id  where g.id = '.$res['id']);
            } else {
                $dn = mysql_query('select h.titre, h.nom_mj, h.niveau_mj, h.nbr_joueur_min, h.nbr_joueur_max, h.duree, h.jour, h.heure, h.description_courte, h.valide_par_admin,  h.valide_par_user, g.nbr_joueur_courant, g.est_publie, g.est_supprime, g.table_id, h.description_longue, h.id,h.id_image, t.nbr_place, t.emplacement, c.debut, c.fin  from games g join histoires h on g.histoire_id = h.id join tables t on g.table_id = t.id join creneaux c on g.creneau_id = c.id where g.id = '.$res['id']);
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
                     $dnn[10] h.valide_par_user
                     $dnn[11] g.nbr_joueur_courant
                     $dnn[12] g.est_publie
                     $dnn[13] g.est_supprime
                     $dnn[14] g.table_id
                     $dnn[15] h.description_longue
                    $dnn[16] h.id
                    $dnn[17] h.id_image
                    $dnn[18] t.nbr_place
                    $dnn[19] t.emplacement
                    $dnn[20] c.debut
                    $dnn[21] c.fin

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
                     $dnn[10] h.valide_par_user
                     $dnn[11] g.nbr_joueur_courant
                     $dnn[12] g.est_publie
                     $dnn[13] g.est_supprime
                     $dnn[14] g.table_id
                     $dnn[15] h.description_longue
                    $dnn[16] h.id
                    $dnn[17] h.id_image
                    */

                $dnn = mysql_fetch_array($dn);
                //On affiche les donnees de la partie
                ?>

                <?php if ($dnn[10] == 0) { ?>
                    <div class="alerte">Vous n'avez pas encore valider cette partie.<br />
                    Elle n'a donc pas encore été soumise aux administrateurs !<br/>
                    Vérifiez vos informations, puis validez la.</div>
                <?php } ?>

                <?php if ($dnn[10] == 1 && $dnn[9] == 0) { ?>
                    <div class="danger">Vous avez validé cette partie.<br />
                    Elle est en attente d'approbation par les administrateurs !</div>
                <?php } ?>

                <?php if ($dnn[10] == 1  && $dnn[9] == 1) { ?>
                    <div class="cool">Votre partie a été approuvée par les administrateurs.<br />
                    Elle pourra être disponible à l'inscription !</div>
                <?php } ?>

                <br>
                <center><h3><?php echo $dnn[0];?></h3></center><br>

                <table style="width:98%;" >
                    <tr><td width="40%">Nom du MJ</td><td><?php echo $dnn[1];?></td></tr>
                    <tr><td width="40%">Niveau du MJ</td><td><?php echo $dnn[2];?></td></tr>
                </table>

                <table style="width:98%;" >
                    <tr><td >Description courte </td>
                        <td width="60%"><?php echo $dnn[8];?></td></tr>
                </table>

                <table style="width:98%;" >
                    <tr><td >Description longue</td>
                        <td width="60%"><?php echo $dnn[15  ];?></td></tr>
                </table>

                <br>

                <table style="width:98%;" >
                    <tr><td width="40%">Nombre de joueurs minimum</td><td><b><?php echo $dnn[3];?></b> joueurs</td></tr>
                    <tr><td width="40%">Nombre de joueurs maximum</td><td><b><?php echo $dnn[4];?></b> joueurs</td></tr>
                    <?php if ($dnn[9] == 1) {?>
                    <tr>
                        <td width="40%">Table de jeu attribuée</td><td>n°<?php echo $dnn[14];?> - <?php echo $dnn[19];?></td></tr>
                    <tr><td width="40%">Nombre de places de la table</td><td><b><?php echo $dnn[18];?></b> places</td></tr>
                    <tr><td width="40%">Remplissage</td><td><b><?php echo $dnn[11];?></b> / <?php echo $dnn[4];?> </td></tr>
                <?php }  ?>

                </table>

                <br>




                <table style="width:98%;" >
                    <tr><td width="40%">Jour et heure demandés</td><td><?php echo $dnn[6];?> - <?php echo $dnn[7];?></td></tr>
                    <tr><td width="40%">Durée envisagée</td><td><?php echo $dnn[5];?></td></tr>
                    <?php if ($dnn[9] == 1) {

                        $d1 = date('Y-m-d H:i:s',$dnn[20]-3600);
                        $date1 = new DateTime("$d1");
                        $d2 = date('Y-m-d H:i:s',$dnn[21]-3600);
                        $date2 = new DateTime("$d2");
                        $diff = date_diff($date1,$date2);
                        ?>

                    <tr><td width="40%">Jour et heure de début attribués</td><td><?php echo $date1->format('d M H:i');?></td></tr>
                    <tr><td width="40%">Jour et heure de fin attribués</td><td><?php echo $date2->format('d M H:i');?></td></tr>
                    <tr><td width="40%">Durée totale attribuée</td><td><?php echo $diff->format('%hh%I');?></td></tr>
                <?php } ?>

            </table><br>


            <center>

                <?php
                if($dnn[17] == -1){
                    echo "Aucune illustration n'a été renseignée.";
                } else {

                    $file_profil = "../../images/illustrations-games/photo_game_".$dnn[17];

                    if(file_exists ( $file_profil.".png" )) $file_profil = $file_profil.".png" ;
                    if(file_exists ( $file_profil.".jpg" )) $file_profil = $file_profil.".jpg" ;
                    if(file_exists ( $file_profil.".jpeg")) $file_profil = $file_profil.".jpeg";
                    if(file_exists ( $file_profil.".gif" )) $file_profil = $file_profil.".gif" ;



                    echo "<img height='100' width='200' src='".$file_profil."'>";
                }
                ?>

            </center>


                <?php
                $id = $dnn[16];
                if ($dnn[10] == 0) { ?>
                    <div class="danger"><a href="send_new_table.php?game_id=<?php echo $id;?>"><input style="width:300px;" type="button" value="Valider le scénario"></a>
                    <br>Cette action va soumettre votre scénario aux administrateurs.
                    <br>** Attention ** <br>Vous ne pourrez plus modifier les informations renseignées.</div>
                <?php } ?>
                <br>
                <?php if ($dnn[10] == 0) { ?>
                    <div class="danger">
                        <a href="table_edit.php?game_id=<?php echo $id;?>"><input style="width:300px;" type="button" value="Editer ce scénario"></a>
                        <a href="table_delete.php?game_id=<?php echo $id;?>"><input style="width:300px;" type="button" value="Supprimer ce scénario"></a>
                        <br>
                    </div>
                <?php } ?>

                <?php if ($dnn[10] == 1) { ?>
                    <div class="danger">
                    Vous ne pouvez plus ni éditer, ni supprimer votre scénario.<br>
                    Si vous souhaitez prendre contact avec les administrateurs afin de modifier vos informations, cliquez <a href="../../contact.php">ici</a>.
                </div>
                <?php }
            }
        }




        ?>


    </div>
    <?php


}
else
{
?>

<div class="content">

Dans le but de proposer des histoires toujours plus hors du commun, nous vous proposons d'animer directement vos parties de jeu de rôle !<br><br>

Si vous avez déjà animé un JDR, ou que vous avez envie de vous y mettre, devenez Maitre du jeu et proposez nous un scénario.<br><br>

S'il est accepté, d'autres joueurs pourront alors s'y inscrire et vivre l'aventure que vous leur avez préparé !



</div>

<div class="message">Pour pouvoir proposer un jeu de rôle, vous devez &ecirc;tre connect&eacute;.<br />
<a href="https://<?php echo $_SERVER['SERVER_NAME']?>/membres/connexion.php">Se connecter</a></div>
<?php
}
?>
		</div>
        <div class="footer"><?php include '../../overall/footer.php' ?></div>
	</body>


    <script type="text/javascript">

    var jourlist=document.new_table.jour
    var heurelist=document.new_table.heure

    var cities=new Array()
    cities[0]=""

    <?php
        $req = mysql_query("select * from configuration where jour=1 and valide=1");
        $compteur = 1;
        while($dnn = mysql_fetch_array($req)){
                echo "cities[".$compteur.']=[" -- |-1"  ';
                $req2 = mysql_query("select * from configuration where heure=1 and valide=1 and jour_associe='".$dnn['valeur']."'");
                    while($dnn2 = mysql_fetch_array($req2)){
                        echo ' ,"'.$dnn2['valeur'].'|'.$dnn2['valeur'].'"';
                    }
                echo "]\n";

        $compteur++;
        }
     ?>






    function updatehoraires(selecteddaygroup){
        heurelist.options.length=0
        if (selecteddaygroup>0){
            for (i=0; i<cities[selecteddaygroup].length; i++)
                heurelist.options[heurelist.options.length]=new Option(cities[selecteddaygroup][i].split("|")[0], cities[selecteddaygroup][i].split("|")[1])
        }
    }

    </script>


</html>
