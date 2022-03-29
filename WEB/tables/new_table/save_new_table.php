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
        <div class="content">
<?php


$image_max_size = 1000000; //1 Mo
$image_max_width = 1000;
$image_max_height = 1000;
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );





//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];

        if($_SERVER['REQUEST_METHOD']=='POST'){




                if(isset($_POST['save'],$_POST['titre'],$_POST['desc_courte'],$_POST['desc_longue'],$_POST['minimum'],$_POST['maximum'],$_POST['duree'],$_POST['jour'],$_POST['heure'],$_POST['niveau'])){

                    $titre = mysql_real_escape_string($_POST['titre']);
                    $desc_courte = mysql_real_escape_string($_POST['desc_courte']);
                    $desc_longue = mysql_real_escape_string($_POST['desc_longue']);
                    $minimum = mysql_real_escape_string($_POST['minimum']);
                    $maximum = mysql_real_escape_string($_POST['maximum']);
                    $duree = mysql_real_escape_string($_POST['duree']);
                    $jour = mysql_real_escape_string($_POST['jour']);
                    $heure = mysql_real_escape_string($_POST['heure']);
                    $niveau = mysql_real_escape_string($_POST['niveau']);

                    $dn2 = mysql_fetch_array(mysql_query('select MAX(id) as maximum from games'));
                    $id = $dn2['maximum']+1;

                    $image_ok = 1;
                    $id_image = -1;

                    if(!empty($_FILES['image']['name'])){

                        $id_image = $id;

                        if($_FILES['image']['error'] == 2){
                            echo "Le fichier est trop gros ! Taille Maximale : 1Mo";
                            $image_ok = 0;
                        }

                        //taille physique
                        if ($_FILES['image']['size'] > $image_max_size) {
                            echo "Le fichier est trop gros ! Taille Maximale : 1Mo";
                            $image_ok = 0;
                        }

                        //format du fichier
                        $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
                        if (!in_array($extension_upload,$extensions_valides) ){
                            echo "Extension incorrecte : Les extensions autorisées sont 'jpg' , 'jpeg' , 'gif' , 'png'";
                            $image_ok = 0;
                        }

                        //taille de l'image
                        $image_sizes = getimagesize($_FILES['image']['tmp_name']);
                        if ($image_sizes[0] > $image_max_width OR $image_sizes[1] > $image_max_height){

                            echo "Image trop grande : Dimensions maximales ".$image_max_width."x".$image_max_height."px";
                            $image_ok = 0;
                        }


                        if($image_ok == 1){
                            $nom = "../../images/illustrations-games/photo_game_".$id.".".$extension_upload;
                            $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
                            if (!$resultat){
                                echo "déplacement fichier echoué";
                                $image_ok = 0;
                            }
                        }
                    }


                    if($image_ok == 1){

                        //On enregistre les informations dans la base de donnee
    					if(mysql_query('insert into histoires(id,titre,nom_mj,niveau_mj,nbr_joueur_min,nbr_joueur_max,duree,jour,heure,description_courte,description_longue,id_image,valide_par_admin,valide_par_user)
                        values ('.$id.', "'.$titre.'", "'.$_SESSION['username'].'", "'.$niveau.'", "'.$minimum.'", "'.$maximum.'",  "'.$duree.'", "'.$jour.'", "'.$heure.'", "'.$desc_courte.'", "'.$desc_longue.'","'.$id_image.'", 0, 0)'))
    					{
                            //echo 'insert into games (id, histoire_id,est_publie,est_supprime) values ('.$id.', '.$id.',0,0)';
                            if(mysql_query('insert into games (id, histoire_id,est_publie,est_supprime) values ('.$id.', '.$id.',0,0)')){

                                header("Location: index.php");

                            } else {

                                echo 'Une erreur est survenue 2';
                            }


    					}
    					else
    					{

    						echo  'Une erreur est survenue 1';
    					}

                }








                }
















        } else {
         echo "pas en requete POST";
        }



} else {
    echo "Vous n'etes pas connecté";
}



?>
		</div>
        <div class="footer"><?php include '../../overall/footer.php' ?></div>
	</body>
    </html>
