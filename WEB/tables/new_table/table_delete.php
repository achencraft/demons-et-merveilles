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




//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];

        if($_SERVER['REQUEST_METHOD']=='GET'){




                if(isset($_GET['game_id'])){

                    $id = mysql_real_escape_string($_GET['game_id']);

                    $dn = mysql_fetch_array(mysql_query('select nom_mj from histoires where id='.$id));

                    if($username == $dn['nom_mj']){

    					if(mysql_query('update games set est_supprime = 1 where histoire_id='.$id))
    					{

                            header("Location: index.php");
    					}
    					else
    					{

    						echo  'Une erreur est survenue';
    					}
                    } else {

                        echo "Vous n'etes pas l'auteur de ce scénario !";
                    }
                }




        } else {
         echo "pas en requete GET";
        }



} else {
    echo "Vous n'etes pas connecté";
}



?>
		</div>
        <div class="footer"><?php include '../../overall/footer.php' ?></div>
	</body>
    </html>
