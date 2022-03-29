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


$image_max_size = 1000000; //1 Mo
$image_max_width = 1000;
$image_max_height = 1000;
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );



//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];


    if(isset($_GET['game_id'])){


        $id = mysql_real_escape_string($_GET['game_id']);
        $id = htmlspecialchars($id);
        $dn = mysql_fetch_array(mysql_query('select nom_mj from histoires where id='.$id));

        if($username == $dn['nom_mj']){



        	//On verifie si le formulaire a ete envoye
        	if(isset($_POST['titre'],$_POST['desc_longue'], $_POST['desc_courte'], $_POST['minimum'], $_POST['maximum'], $_POST['duree'],$_POST['jour'], $_POST['heure'],$_POST['niveau']))
        	{
        		//On enleve lechappement si get_magic_quotes_gpc est active
        		if(get_magic_quotes_gpc())
        		{
                    $_POST['titre'] = stripslashes($_POST['titre']);
        			$_POST['desc_courte'] = stripslashes($_POST['desc_courte']);
        			$_POST['desc_longue'] = stripslashes($_POST['desc_longue']);
                    $_POST['minimum'] = stripslashes($_POST['minimum']);
                    $_POST['maximum'] = stripslashes($_POST['maximum']);
                    $_POST['duree'] = stripslashes($_POST['duree']);
                    $_POST['jour'] = stripslashes($_POST['jour']);
                    $_POST['heure'] = stripslashes($_POST['heure']);
                    $_POST['niveau'] = stripslashes($_POST['niveau']);
        		}

        					//On echape les variables pour pouvoir les mettre dans une requette SQL
                            $titre = mysql_real_escape_string($_POST['titre']);
        					$desc_courte = mysql_real_escape_string($_POST['desc_courte']);
        					$desc_longue = mysql_real_escape_string($_POST['desc_longue']);
                            $minimum = mysql_real_escape_string($_POST['minimum']);
                            $maximum = mysql_real_escape_string($_POST['maximum']);
                            $duree = mysql_real_escape_string($_POST['duree']);
                            $jour = mysql_real_escape_string($_POST['jour']);
                            $heure = mysql_real_escape_string($_POST['heure']);
                            $niveau = mysql_real_escape_string($_POST['niveau']);


                            $image_ok = 1;

                            $dn2 = mysql_fetch_array(mysql_query('select id_image from histoires where id='.$id));
                            $id_image = $dn2['id_image'];

                            if(!empty($_FILES['image']['name'])){

                                $dn2 = mysql_fetch_array(mysql_query('select MAX(id_image) as maximum from histoires'));
                                $id_image = $dn2['maximum']+1;


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
                                    $nom = "../../images/illustrations-games/photo_game_".$id_image.".".$extension_upload;
                                    $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$nom);
                                    if (!$resultat){
                                        echo "déplacement fichier echoué";
                                        $image_ok = 0;
                                    } else {
                                        echo "deplacement ok";
                                    }
                                }
                            }


                            if($image_ok == 1){

        						//On modifie les informations de lutilisateur avec les nouvelles
        						if(mysql_query('update histoires set titre="'.$titre.'", description_courte="'.$desc_courte.'", description_longue="'.$desc_longue.'",id_image='.$id_image.',nbr_joueur_min='.$minimum.',nbr_joueur_max='.$maximum.',duree="'.$duree.'",jour="'.$jour.'",heure="'.$heure.'",niveau_mj="'.$niveau.'" where id='.$id))
        						{

                                        $form = false;
                                        header('Location: index.php?game_id='.$id);




        						}
        						else
        						{
        							//Sinon on dit quil y a eu une erreur
        							$form = true;
        							$message = 'Une erreur est survenue lors des modifications. 1';

        						}
                        }



        	}
        	else
        	{
        		$form = true;
        	}

        	if($form)
        	{


                    //Sinon, on affiche les donnes a partir de la base de donnee
        			$dnn = mysql_fetch_array(mysql_query('select h.titre,h.description_courte,h.description_longue,h.id_image,h.nbr_joueur_min,h.nbr_joueur_max,h.duree,h.jour,h.heure,h.niveau_mj from histoires h join games g on g.histoire_id = h.id where g.id='.$id));
                    $desc_courte = htmlentities($dnn['description_courte'], ENT_QUOTES, 'UTF-8');
                    $desc_longue = htmlentities($dnn['description_longue'], ENT_QUOTES, 'UTF-8');
                    $creneau_id = htmlentities($dnn['creneau_id'], ENT_QUOTES, 'UTF-8');
                    $table_id = htmlentities($dnn['table_id'], ENT_QUOTES, 'UTF-8');

        		//On affiche le formulaire


        //On affiche un message sil y a lieu
        if(isset($message))
        {
            echo '<div class="message">'.$message.'</div>';
        }
        ?>
        <div class="menu_admin"><?php include '../../overall/menu_admin.php' ?></div>

        <div class="content">
            Vous pouvez modifier les informations :
            <form action="table_edit.php?game_id=<?php echo $id; ?>" method="post"  enctype="multipart/form-data" name="new_table">
                <br /><br />
                <div class="center">
                    <fieldset>
                        <legend>A propos de votre histoire :</legend>
                            <br>
                            <label for="titre">Titre de votre histoire</label><input  style="width:300px;" type="text" name="titre" value="<?php echo $dnn['titre']; ?>" required /><br /><br />
                            <label for="desc_courte">Description Courte :</label><textarea name="desc_courte" cols="40" rows="5" required><?php echo $desc_courte; ?></textarea><br /><br>
                            <label for="desc_longue">Description Longue :</label><textarea name="desc_longue" cols="40" rows="12" required><?php echo $desc_longue; ?></textarea><br /><br>
                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!--taille max de l'image en octet = 1Mo-->
                            <label for="desc_longue">Illustration :</label><input style="width:300px;" type="file" name="image" /><br /><br>

                            <center>

                                <?php
                                if($dnn['id_image'] == -1){
                                    echo "Aucune illustration n'a été renseignée.";
                                } else {

                                    $file_profil = "../../images/illustrations-games/photo_game_".$dnn['id_image'];

                                    if(file_exists ( $file_profil.".png" )) $file_profil = $file_profil.".png" ;
                                    if(file_exists ( $file_profil.".jpg" )) $file_profil = $file_profil.".jpg" ;
                                    if(file_exists ( $file_profil.".jpeg")) $file_profil = $file_profil.".jpeg";
                                    if(file_exists ( $file_profil.".gif" )) $file_profil = $file_profil.".gif" ;



                                    echo "<img height='100' width='200' src='".$file_profil."'>";
                                }
                                ?>

                            </center>

                    </fieldset><br>
                    <fieldset>
                        <legend>Informations techniques :</legend>
                            <br>





                            <label for="minimum">Nombre de joueurs minimum</label><input type="number" max="9" min="0" name="minimum" value="<?php echo $dnn['nbr_joueur_min']; ?>" required /><br /><br />
                            <label for="maximum">Nombre de joueurs maximum</label><input min="0" max="9" type="number" name="maximum" value="<?php echo $dnn['nbr_joueur_max']; ?>" required /><br /><br />
                            <label for="duree">Durée Approximative</label><input type="text" name="duree" value="<?php echo $dnn['duree']; ?>" maxlength="10" required /><br /><br />

                            <label for="jour">Jour souhaité</label><select name="jour" size="1" onChange="updatehoraires(this.selectedIndex)" required>
                                <option selected>
                                    <?php
                                        $req = mysql_query("select * from configuration where jour=1 and valide=1");
                                        while($dnn2 = mysql_fetch_array($req)){



                                            if($dnn2['valeur'] == $dnn['jour']){
                                                ?>
                                                <option value="<?php echo $dnn2['valeur'];?>"  selected><?php echo $dnn2['valeur'];?>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?php echo $dnn2['valeur'];?>"><?php echo $dnn2['valeur'];?>
                                                <?php
                                            }


                                        }
                                     ?>
                            </select></br><br />

                            <?php $old_heure = $dnn['heure']; ?>

                            <label for="heure">Heure souhaitée</label><select name="heure" size="1" required>

                            </select></br><br />

                            <label for="niveau">Votre niveau de MJ</label><select name="niveau" size="1" required>
                                <option selected>

                                <?php if($dnn['niveau_mj'] = "novice") {echo "<option value='novice' selected>Novice"; } else {echo "<option value='novice'>Novice"; }
                                 if($dnn['niveau_mj'] = "novice") {echo "<option value='debutant' selected>Débutant"; } else {echo "<option value='debutant' >Débutant"; }
                                 if($dnn['niveau_mj'] = "novice") {echo "<option value='expert' selected>Experimenté"; } else {echo "<option value='expert'>Experimenté";} ?>

                            </select></br><br />
                        </fieldset><br>
                            <input type="submit" name="save" value="Sauvegarder" />
                </div>
            </form>

        </div>
        <?php
        	}
        }

    } else {
        ?>
        <div class="message">Ne modifie pas la partie d'un autre, vilain !<br />
        </div>
        <?php
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
                    if(cities[selecteddaygroup][i].split("|")[0] == "<?php echo $old_heure;?>"){
                        heurelist.options[heurelist.options.length]=new Option(cities[selecteddaygroup][i].split("|")[0], cities[selecteddaygroup][i].split("|")[1],true,true)
                    } else {
                        heurelist.options[heurelist.options.length]=new Option(cities[selecteddaygroup][i].split("|")[0], cities[selecteddaygroup][i].split("|")[1])
                    }


            }
        }

        </script>


</html>
