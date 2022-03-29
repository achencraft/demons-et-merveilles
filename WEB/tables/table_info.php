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


if(isset($_GET['game_id']))
{
    $id = mysql_real_escape_string($_GET['game_id']);

    $dn = mysql_query('select h.titre,h.nom_mj,h.nbr_joueur_max, h.duree, h.description_courte,h.description_longue, h.id_image, g.histoire_id, g.nbr_joueur_courant, c.debut, c.fin, t.emplacement from games g join histoires h on g.histoire_id = h.id join creneaux c on c.id = g.creneau_id join tables t on g.table_id = t.id where g.est_publie = 1 and g.est_supprime = 0 and g.id='.$id);
    if(mysql_num_rows($dn)>0)
    {
        $dnn = mysql_fetch_array($dn);

        $d1 = date('Y-m-d H:i:s',$dnn['debut']-3600);
        $date1 = new DateTime("$d1");
        $d2 = date('Y-m-d H:i:s',$dnn['fin']-3600);
        $date2 = new DateTime("$d2");
        $diff = date_diff($date1,$date2);



        ?>
        <div class="table_info">


            <center><h3><?php echo $dnn['titre']; ?></h3><br>

            <?php
            if($dnn['id_image'] > -1){

                $file_profil = "../images/illustrations-games/photo_game_".$dnn['id_image'];

                if(file_exists ( $file_profil.".png" )) $file_profil = $file_profil.".png" ;
                if(file_exists ( $file_profil.".jpg" )) $file_profil = $file_profil.".jpg" ;
                if(file_exists ( $file_profil.".jpeg")) $file_profil = $file_profil.".jpeg";
                if(file_exists ( $file_profil.".gif" )) $file_profil = $file_profil.".gif" ;



                echo "<img height='100' width='200' src='".$file_profil."'>";
            }
            ?>
            <br>
            <?php echo $dnn['description_longue']; ?><br><br>

            organisé par <?php echo $dnn['nom_mj']; ?><br><br>



            <div class="table_recap">
                <img height="15px" src="../images/icones/group.png">
                <span class="table_view_titre"> <?php echo($dnn['nbr_joueur_max']-$dnn['nbr_joueur_courant']); ?></span> places disponibles
                <br><br>

                <img height="15px" src="../images/icones/horloge.png">
                <?php echo $date1->format('d F  H:i'); ?>
                <br><br>

                <img height="15px" src="../images/icones/sablier.png">
                <?php echo $diff->format('%hh%I'); ?>
                <br><br>

                <img height="15px" src="../images/icones/lieu.png">
                <?php echo $dnn['emplacement']; ?>
                <br>
            </div>
            <br><br>


            <?php
            //On verifie si lutilisateur est connecte
            if(isset($_SESSION['username']))
            {
                $req = mysql_fetch_array(mysql_query('select id from users where username="'.$_SESSION['username'].'"'));
                $user_id = $req['id'];

                $req = mysql_query('select * from inscriptions where user_id = '.$user_id.' and game_id='.$id);
                if(mysql_num_rows($req)>0)
                {
                    ?>
                    <div class="subscribe">
                        <a href="desinscription.php?game_id=<?php echo $dnn['histoire_id']; ?>">
                        <span>Se désinscrire de cette partie</span>
                        </a>
                    </div>
                    <?php
                } else {

                    if($dnn['nbr_joueur_max']-$dnn['nbr_joueur_courant'] > 0 ){
                        ?>
                        <div class="subscribe">
                            <a href="inscription.php?game_id=<?php echo $dnn['histoire_id']; ?>">
                            <span>S'inscrire à cette partie</span>
                            </a>
                        </div>
                        <?php
                    } else {
                        ?>
                        Cette partie est complète.
                        <?php
                    }
                }

            } else {

                echo "Vous devez être connecté pour vous inscrire à cette partie.";

            }

             ?>



        </center>



        </div>
        <?php




    } else {
        echo "identifiant de jeu incorrect";
    }
} else {
    echo "identifiant de jeu incorrect";
}





?>
		</div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
