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
    //On vérifie que l'utilisateur est administrateur (champ 'admin' dans la table users : 1 = admin, 0 = non admin)
    $dn = mysql_fetch_array(mysql_query('select username, admin from users where username="'.$username.'"'));
    if($dn['admin']==1 and $dn['username']==$_SESSION['username']){

    if(isset($_GET['game_id'])){

        $id = mysql_real_escape_string($_GET['game_id']);
        $id = htmlspecialchars($id);

    	//On verifie si le formulaire a ete envoye
    	if(isset($_POST['desc_longue'], $_POST['desc_courte'], $_POST['new_table'], $_POST['new_creneau']))
    	{
    		//On enleve lechappement si get_magic_quotes_gpc est active
    		if(get_magic_quotes_gpc())
    		{
    			$_POST['desc_courte'] = stripslashes($_POST['desc_courte']);
    			$_POST['desc_longue'] = stripslashes($_POST['desc_longue']);
                $_POST['new_table'] = stripslashes($_POST['new_table']);
                $_POST['new_creneau'] = stripslashes($_POST['new_creneau']);
    		}

    					//On echape les variables pour pouvoir les mettre dans une requette SQL
    					$desc_courte = mysql_real_escape_string($_POST['desc_courte']);
    					$desc_longue = mysql_real_escape_string($_POST['desc_longue']);
                        $id_new_table = mysql_real_escape_string($_POST['new_table']);
                        $id_new_creneau = mysql_real_escape_string($_POST['new_creneau']);


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
    						if(mysql_query('update histoires set description_courte="'.$desc_courte.'", description_longue="'.$desc_longue.'",id_image='.$id_image.' where id='.$id))
    						{
                                if(mysql_query('update games set table_id='.$id_new_table.', creneau_id='.$id_new_creneau.' where histoire_id='.$id))
                                {
                                    //Si ca a fonctionne, on naffiche pas le formulaire
                                    $form = false;
                                    header('Location: game_info.php?game_id='.$id);

                                }
                                else
                                {
                                    //Sinon on dit quil y a eu une erreur
                                    $form = true;
                                    $message = 'Une erreur est survenue lors des modifications. 2';
                                }


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


    		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
    		if(isset($_POST['desc_courte'],$_POST['desc_longue']))
    		{
                $desc_courte = htmlentities($_POST['desc_courte'], ENT_QUOTES, 'UTF-8');
                $desc_longue = htmlentities($_POST['desc_longue'], ENT_QUOTES, 'UTF-8');
    		}
    		else
    		{
    			//Sinon, on affiche les donnes a partir de la base de donnee
    			$dnn = mysql_fetch_array(mysql_query('select h.description_courte,h.description_longue,g.creneau_id,g.table_id from histoires h join games g on g.histoire_id = h.id where g.id='.$id));
                $desc_courte = htmlentities($dnn['description_courte'], ENT_QUOTES, 'UTF-8');
                $desc_longue = htmlentities($dnn['description_longue'], ENT_QUOTES, 'UTF-8');
                $creneau_id = htmlentities($dnn['creneau_id'], ENT_QUOTES, 'UTF-8');
                $table_id = htmlentities($dnn['table_id'], ENT_QUOTES, 'UTF-8');
    		}
    		//On affiche le formulaire


    //On affiche un message sil y a lieu
    if(isset($message))
    {
        echo '<div class="message">'.$message.'</div>';
    }
    ?>
    <div class="menu_admin"><?php include '../../overall/menu_admin.php' ?></div>

    <div class="content">

        <form action="game_edit.php?game_id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
            Vous pouvez modifier les descriptions :<br /><br />
            <div class="center">
                <label for="desc_courte">Description Courte :</label><textarea name="desc_courte" cols="40" rows="5"><?php echo $desc_courte; ?></textarea><br /><br>
                <label for="desc_longue">Description Longue :</label><textarea name="desc_longue" cols="40" rows="12"><?php echo $desc_longue; ?></textarea><br /><br>



                <label for="desc_longue">Modifier le créneau horaire</label>
                        <select name="new_creneau" style="width:290px;">
                            <option>--
                        <?php
                        $req = mysql_query('select id,debut,fin from creneaux order by debut');
                        while($dnn2 = mysql_fetch_array($req))
                        {

                            $d1 = date('Y-m-d H:i:s',$dnn2[debut]-3600);
                            $date1 = new DateTime("$d1");
                            $d2 = date('Y-m-d H:i:s',$dnn2[fin]-3600);
                            $date2 = new DateTime("$d2");

                            if ($dnn2['id'] == $creneau_id){

                            ?><option value="<?php echo $dnn2['id']; ?>" selected="selected" ><?php echo $date1->format('d M H:i'); ?> - <?php echo $date2->format('d M H:i');

                            } else {

                            ?><option value="<?php echo $dnn2['id']; ?>"><?php echo $date1->format('d M H:i'); ?> - <?php echo $date2->format('d M H:i');
                            }
                        }
                        ?>
                    </select></br></br>

                    <label for="desc_longue">Modifier la table de jeu</label>
                            <select name="new_table" style="width:290px;">
                                <option>--
                            <?php
                            $req = mysql_query('select id,nbr_place,emplacement from tables order by emplacement');
                            while($dnn2 = mysql_fetch_array($req))
                            {

                                if ($dnn2['id'] == $table_id){
                                    ?><option value="<?php echo $dnn2['id']; ?>"  selected="selected"><?php echo $dnn2['emplacement'];?> - Table n°<?php echo $dnn2['id']; ?> - <?php echo $dnn2['nbr_place']; ?> places <?php
                                } else {
                                ?><option value="<?php echo $dnn2['id']; ?>"><?php echo $dnn2['emplacement'];?> - Table n°<?php echo $dnn2['id']; ?> - <?php echo $dnn2['nbr_place']; ?> places <?php
                                }
                            }
                            ?>
                        </select></br></br>

                    <label for="image">Modifier l'illustration</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> <!--taille max de l'image en octet = 1Mo-->
                    <input style="width:300px;" type="file" name="image" /><br /><br>
                        </br></br>



                <input type="submit" value="Envoyer" />
            </div>
        </form>
    </div>
    <?php
    	}
    }
    else{
        ?>
        <div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre administrateur.<br />
        <a href="connexion.php">Se connecter</a></div>
        <?php
    }
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
</html>
