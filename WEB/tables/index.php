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




$req = mysql_query('select h.titre,h.nom_mj,h.nbr_joueur_max, h.duree, h.description_courte,h.id_image, g.histoire_id, g.nbr_joueur_courant, c.debut, c.fin from games g join histoires h on g.histoire_id = h.id join creneaux c on c.id = g.creneau_id where g.est_publie = 1');

if(mysql_num_rows($req)>0){

    while($dnn = mysql_fetch_array($req))
    {

        $d1 = date('Y-m-d H:i:s',$dnn['debut']-3600);
        $date1 = new DateTime("$d1");
        $d2 = date('Y-m-d H:i:s',$dnn['fin']-3600);
        $date2 = new DateTime("$d2");
        $diff = date_diff($date1,$date2);


    ?>

    <div class="table_view">

        <div class="table_view_image">
            <?php
            if($dnn['id_image'] == -1){
                echo "<img height='100' width='200' src='../images/illustrations-games/no_image.bmp'>";
            } else {

                $file_profil = "../images/illustrations-games/photo_game_".$dnn['id_image'];

                if(file_exists ( $file_profil.".png" )) $file_profil = $file_profil.".png" ;
                if(file_exists ( $file_profil.".jpg" )) $file_profil = $file_profil.".jpg" ;
                if(file_exists ( $file_profil.".jpeg")) $file_profil = $file_profil.".jpeg";
                if(file_exists ( $file_profil.".gif" )) $file_profil = $file_profil.".gif" ;



                echo "<img height='100' width='200' src='".$file_profil."'>";
            }
            ?>
        </div>

        <div class="table_view_infos">
            <span class="table_view_titre"><?php echo $dnn['titre']; ?></span><br>
            <?php echo $dnn['description_courte']; ?><br>
            <hr>

            <div class="table_view_info_left">
                Maître du jeu : <?php echo $dnn['nom_mj'] ?><br>
                Places disponibles :  <?php echo($dnn['nbr_joueur_max']-$dnn['nbr_joueur_courant']); echo " places"; ?>
            </div>
            <div class="table_view_info_right">
                Heure : <?php echo $date1->format('d M H:i'); ?><br>
                Durée : <?php echo $diff->format('%hh%I'); ?>
            </div>
            <div class="table_view_info_subscribe">
                <a href="table_info.php?game_id=<?php echo $dnn['histoire_id']; ?>">
                <span>+ d'infos</span>
                </a>
            </div>
        </div>


    </div>


<?php
}

} else {
        ?>
    <div class="table_view">
        <center>Il n'y a aucune partie disponible.</center>
    </div>
        <?php
}






?>
		</div>
        <div class="footer"><?php include '../overall/footer.php' ?></div>
	</body>
</html>
