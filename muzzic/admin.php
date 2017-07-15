<?php session_start(); 
if ( $_GET['mode'] == "q" )
{
  // deconnexion de l'admin
  session_unset ();
  session_destroy ();
  header ('location: admin.php');
}
?>
<!doctype html>
<html>
<head>
<title>
Administration 
</title>
<link rel="stylesheet" type="text/css" href="design.css" />
<?php
require("config.php");
require("utils.php");
?>
<script>
function deleteReserv(id)
{
   if (confirm("Voulez-vous vraiment supprimer cette reservation ?"))
   {
     $.get("go.php?mode=res&id="+id, function(data)
     {
       window.location.assign("admin.php");
     });
   }
 }
 
function deleteGroup(id, nom)
{
   if (confirm("Voulez-vous vraiment supprimer le groupe '"+nom+"'\nainsi que toutes ses reservations ?"))
   {
     $.get("go.php?mode=Grp&id="+id, function(data)
     {
       window.location.assign("admin.php");
     });
   }
 }

function changeData(usr, pass)
{
   if (confirm("Voulez-vous vraiment changer les infos d'administrateur ?"))
   {
     $.get("go.php?mode=chG&login="+usr+"&pass="+pass, function(data)
     {
       window.location.assign("admin.php?mode=q");
     });
   }
 }

function quit()
{
  window.location.assign("admin.php?mode=q");
}
</script>
</head>
<body>
<div id="admin">

    <h1>Administration du calendrier MuZZic</h1>

      <?php

      if ( isset($_POST['user']) && isset($_POST['pass']) || isset($_SESSION['login']) && isset($_SESSION['pwd']) )
      {
        
        if ( $_POST['user'] == $adminLogin
        &&   Crypte($_POST['pass'], $cryptokey) == $adminPass
        ||
        $_SESSION['login'] == $adminLogin
        && $_SESSION['pwd'] == $adminPass)
        
        {
        if ( !isset($_SESSION['login']) && !isset($_SESSION['pwd']) )
        {
          	$_SESSION['login'] = $_POST['user'];
            $_SESSION['pwd'] = Crypte($_POST['pass'], $cryptokey);
        }
        ?><table summary="" border="1" class="liste center overElemnt">
          <tbody><?php
        
        if(!mysql_connect($bddhost, $bddlogin, $bddpass))
        {
          die('Impossible de se connecter : ' . mysql_error());
        }
        mysql_select_db($bddname) or die('Impossible de sélectionner la base de données');
        ?>
          
            <tr>
              <td colspan="5"><h3>Liste des groupes</h3></td>
            </tr>

            <tr>
              <th>Groupe</th>
              <th>Referent</th>
              <th>contact</th>
              <th colspan="1">Divers</th>
              <td><input type="submit" value="Deconnexion" onclick="quit()"></td>
            </tr>
            
            <?php
            
            $resultat = mysql_query("select count(id) nbr from groupes" );
            $row = mysql_fetch_row($resultat);
            $nbGroupes = $row[0];
            
            $resultat = mysql_query("select * from groupes" );
            
            for ($i=0; $i<$nbGroupes; $i++)
            {
              $row = mysql_fetch_assoc($resultat);
            ?>
            <tr class="surbrill">
              <td><?php echo stripslashes($row["nom"]); ?></td>
              <td><?php echo stripslashes($row["referent"]); ?></td>
              <td><?php echo base64_decode($row["contact"]); ?></td>
              <td><?php echo nl2br(stripslashes($row["divers"])); ?></td>
              <td><input type="submit" value="Supprimer" onclick="deleteGroup(<?php echo $row["id"]; ?>,
                  '<?php echo stripslashes($row["nom"]); ?>' )"></td>
            </tr>
            <?php
            }
            
            ?>
            </tbody>
            </table>
            
            <table summary="" border="1" class="liste center overElemnt">
          <tbody>
            <tr>
              <td colspan="6"><h3>Liste des reservations</h3></td>
            </tr>
            
            <tr>
              <th>Groupe</th>
              <th>Jour</th>
              <th>heure</th>
              <th>Semaine</th>
              <th>Ann&eacute;e</th>        
              <th></th>
            </tr>
            
            <?php
            
            $resultat = mysql_query("select count(*) nbr from reservations" );
            $row = mysql_fetch_row($resultat);
            $nbReserv = $row[0];

            $resultat = mysql_query("select * from reservations R, groupes G where R.groupe = G.id
                                     order by semaine asc, jour asc,heure asc" );
                                     
            for ($i=0; $i<$nbReserv; $i++)
            {
              $row = mysql_fetch_assoc($resultat);
            ?>
            <tr class="surbrill">
              <td><?php echo stripslashes($row["nom"]); ?></td>
              <td><?php echo $liste_joursLong[$row["jour"]]; ?></td>
              <td><?php echo $row["heure"]; ?>h</td>
              <td><?php echo $row["semaine"]; ?></td>
              <td><?php echo $row["annee"]; ?></td>
              <td><input type="submit" value="Supprimer" onclick="deleteReserv(<?php echo $row["id_reservation"]; ?>)"></td>
            </tr>
            <?php
            }
            
            ?>
            
          </tbody>
          </table>

<table summary="" border="1" class="liste center overElemnt">
          <tbody><?php
        
        if(!mysql_connect($bddhost, $bddlogin, $bddpass))
        {
          die('Impossible de se connecter : ' . mysql_error());
        }
        mysql_select_db($bddname) or die('Impossible de sélectionner la base de données');
        ?>
          
            <tr>
              <td colspan="2"><h3>Changement des donn&eacute;es de connexion</h3></td>
            </tr>

            <tr>
              <td>Login</td>
              <td><input type="text" name="newUser" value="<?php echo $adminLogin; ?>"></td>
            </tr>
            <tr>
              <td>Mot de passe</td>
              <td><input type="password" name="newPass" value=""></td>
            </tr>
            <tr>
              <td colspan="2"><input type="submit" value="Changer les informations" 
                       onclick="changeData(document.getElementsByName('newUser')[0].value, document.getElementsByName('newPass')[0].value)"></td>
            </tr>

            </tbody>
            </table>
          <?php
        }
        else
        {
          // il faudra penser a enlever ca
          session_unset ();
          session_destroy ();
          file_put_contents("debug", print_r($GLOBALS, true));
        ?><table summary="" border="0" class="center overElemnt">
          <tbody>
          
      <tr>
        <th colspan="2">Login incorrect</th>
      </tr>
    
      <tr>
        <td class="title">Erreur:</td>
        <td>Les informations de login sont incorrectes</td>
      </tr>

      <tr>
        <th colspan="2"><a href="admin.php">R&eacute;essayer</a></th>
      </tr>
    
    <?php
  }
}
else
{
  ?>
  <table summary="" border="0" class="center overElemnt">
  <tbody>
  <form method="post" action="">
      <tr>
        <th colspan="2">Acc&egrave;s administration</th>
      </tr>
    
      <tr>
        <td class="title"><label for="loginuser">Utilisateur</label></td>
        <td><input name="user" id="loginuser" autocomplete="off" type="text" /></td>
      </tr>
      
      <tr>
        <td class="title"><label for="loginpwd">Mot de passe</label></td>
        <td><input name="pass" id="loginpwd" autocomplete="off" type="password" /></td>
      </tr>
      
      <tr>
        <td></td>
        <td><input type="submit" value="Connexion" /></td>
      </tr>
  </form>
  <?php
}
?>
</tbody>
</table>
<?php include("menu.php"); ?>
</div>
<script type="text/javascript" src="jQuerry.js"></script>
</body>
</html>
<!-- Script cree par David191212 ( David BEUVOT ) -->