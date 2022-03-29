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


            <form method="post" action="set_config.php">
                <fieldset>
                    <legend>Sélectionner les jours à proposer aux MJ</legend>

                        <?php
                        $req = mysql_query("select * from configuration where jour=1");


                        while($dnn = mysql_fetch_array($req))
                        {
                            ?>
                            <div>
                              <input style="width:50px;" type="checkbox" name="jour[]" value="<?php echo $dnn['id']?>" <?php if($dnn['valide'] == 1){echo "checked";}?>>

                              <?php echo $dnn['valeur'];?>
                            </div>
                            <?php

                        }
                        ?>


                </fieldset>

                <?php
                        $req2 = mysql_query("select * from configuration where jour=1 and valide=1");
                        while($dnn2 = mysql_fetch_array($req2)){

                            ?>
                            <br>
                            <fieldset>
                                <legend>Sélectionnez les heures à proposer le <?php echo $dnn2['valeur']; ?></legend>
                                    <table>
                                        <tr>
                                            <td>
                                            <?php $req3 = mysql_query("select * from configuration where heure=1 and jour_associe='".$dnn2['valeur']."'");
                                            $compteur = 0;
                                            while($dnn3 = mysql_fetch_array($req3)){

                                                if($compteur == 12){
                                                    echo "</td><td>";
                                                    $compteur = 0;
                                                }

                                                    ?>
                                                <div>
                                                  <input style="width:50px;" type="checkbox" name="heure[]" value="<?php echo $dnn3['id']?>" <?php if($dnn3['valide'] == 1){echo "checked";}?>>

                                                  <?php echo $dnn3['valeur'];?>
                                                </div>

                                                <?php
                                                $compteur = $compteur+1;

                                            } ?>
                                            </td>
                                        </tr>
                                    </table>
                            </fieldset>
                            <?php



                        }

                ?>
                <br>
                <input type="submit" value="Envoyer" />
                <br> Attention ! La validation de cette page prend quelques secondes ! <br>Soyez patient merci
            </form>








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
