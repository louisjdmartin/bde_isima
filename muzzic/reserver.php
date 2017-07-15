<!doctype html>
<html>
<head>
<title>Réservation de la salle de muZZic</title>

<link rel="stylesheet" type="text/css" href="design.css" />
<script type="text/javascript" src="jQuerry.js"></script>
<script>
function checkB(id)
{
  document.getElementsByName(id)[0].checked = !document.getElementsByName(id)[0].checked;
}
</script>
</head>
<body>
<div id="body">
<?php 
require("config.php");
require("utils.php");
  
if ( $_POST["mode"]!="Go" )
{
  $annee = ( $_GET["annee"]!="" ? $_GET["annee"] : date("Y") );
  $semaine = ($_GET["semaine"]!="" ? $_GET["semaine"] : date("W") );

  ?>
  <h1>R&eacute;servez la salle de muZZic</h1>
  <!--todo: faire un fichier separe pour les requetes sql-->
  <form method="post">
  <input type="hidden" name="mode" value="Go"/>
  <input type="hidden" name="semaine" value="<?php echo $semaine; ?>"/>
  <input type="hidden" name="annee" value="<?php echo $annee; ?>"/>
  <div id="TabSem">
  <table border="1" class="overElemnt">
    <tr>
      <td class="cliquable" onclick="window.location.replace(
        '<?php echo "?semaine=".($semaine-1)."&amp;annee=".$annee; ?>')">&lt;</td>
        
      <td colspan="4" align="center"><?php echo $annee; ?> 
      : Semaine <?php echo $semaine; ?></td>
      <td class="cliquable" onclick="window.location.replace(
        '<?php echo "?semaine=".($semaine+1)."&amp;annee=".$annee; ?>')">&gt;</td>
    </tr>
    
  <tr><td>&nbsp;</td>

  <?php
    $premJour = new DateTime();
    $premJour->setISOdate($annee, $semaine);
    
    $premJourTS = $premJour->format('U');

    $nouvDate = $premJour;
    
    for ($i=0; $i<5; $i++)
    {
      echo "<td>".$liste_joursLong[$i]."<br/>".date('d/m', $premJourTS)."</td>";
      
      $premJourTS += 86400;
    }
  ?>

  </tr>
  <?php

    if(!mysql_connect($bddhost, $bddlogin, $bddpass))
    {
      die('Impossible de se connecter : ' . mysql_error());
    }
    mysql_select_db($bddname) or die('Impossible de sélectionner la base de données');

    for ($j=19; $j<=24; $j++)
    {
      echo "<tr><td>".$j."h</td>";
      
      for ($i=0; $i<5; $i++)
      {
        $resultat = mysql_query("select * from reservations where semaine=". $semaine ." and jour=". $i ." and heure = ". $j );
        $row = mysql_fetch_assoc( $resultat );
      
        $occupe = ( $row!=NULL );
      
        echo "<td ". ($occupe ? "" : "onclick=\"checkB('".$i."X".$j."')\"" ).
        "><input type=\"checkbox\" name=\"".$i."X".$j."\" ".($occupe ? "disabled=\"disabled\"" :
        "onclick=\"checkB('".$i."X".$j."')\"")." /></td>";
      }
      echo "</tr>";
    }

  ?>
  </table>
  </div>
  <table border="1" id="WE" class="overElemnt">
  <tr><td>&nbsp;</td>

  <?php
    for ($i=8; $i<=24; $i++)
    {
      echo "<td>".$i."h</td>";
    }
  ?>

  </tr>

  <?php

  for ($i=5; $i<7; $i++)
  {
    
    echo "<tr><td>".$liste_joursLong[$i]."<br/>".date('d/m', $premJourTS)."</td>";
    for ($j=8; $j<=24; $j++)
    {
      $resultat = mysql_query("select * from reservations where semaine="
      . $semaine ." and jour=". $i ." and heure = ". $j );
      $row = mysql_fetch_assoc( $resultat );
    
      $occupe = ( $row!=NULL );
    
      echo "<td ". ($occupe ? "" : "onclick=\"checkB('".$i."X".$j."')\"" ).
        "><input type=\"checkbox\" name=\"".$i."X".$j."\" ".($occupe ? "disabled=\"disabled\"" :
        "onclick=\"checkB('".$i."X".$j."')\"")." /></td>";
    }
    $premJourTS += 86400;
    echo "</tr>";
  }
  ?>
  </table>

  <table id="detailJour" border="0" class="overElemnt">
  <tr>
    <th colspan="3">Infos sur le groupe</th>
  </tr>

  <tr>
    <td colspan="3"><hr/></td>
  </tr>
  
  <tr><td>Nom du Groupe</td><td><input type="text" name="nom"></td></tr>
  <tr><td>Nom du R&eacute;f&eacute;rent</td><td><input type="text" name="ref"></td></tr>
  <tr><td>Email du R&eacute;f&eacute;rent</td><td colspan="3"><input type="text" name="email"></td></tr>
  <tr><td>Divers ( parlez un peu de votre groupe )</td><td colspan="3"><textarea style="resize:vertical" name="divers" rows="8" cols="94"></textarea></td></tr>
  
  <tr><td></td><td><input type="submit" value="Reserver la salle"></td><td><input type="reset" value="Recommencer"></td></tr>
  </table>
  <br/><br/>

  <?php 
}
else
{
  if(!mysql_connect($bddhost, $bddlogin, $bddpass))
  {
    die('Impossible de se connecter : ' . mysql_error());
  }
  mysql_select_db($bddname) or die('Impossible de sélectionner la base de données');
  
  $annee = mysql_real_escape_string($_POST["annee"]);
  $semaine = mysql_real_escape_string($_POST["semaine"]);
  
  mysql_query("INSERT INTO groupes VALUES (DEFAULT, '" 
            .mysql_real_escape_string($_POST["nom"])."', '"
            .base64_encode(mysql_real_escape_string($_POST["email"]))."', '"
            .mysql_real_escape_string($_POST["ref"])."', '"
            .nl2br(htmlentities(mysql_real_escape_string($_POST["divers"])))."')");        
  
  // on va chercher le groupe que l'on vient de creer  
  $resultat = mysql_query("SELECT id FROM groupes WHERE nom='" 
            .mysql_real_escape_string($_POST["nom"])."' and referent='"
            .mysql_real_escape_string($_POST["ref"])."' and contact='"
            .base64_encode(mysql_real_escape_string($_POST["email"]))."' and divers='"
            .htmlentities(mysql_real_escape_string($_POST["divers"]))."'");
  
  $row = mysql_fetch_assoc( $resultat );
  
  if ( !$row ) die("echec lors de l'insertion du groupe");
  
  for ($i=0; $i<=6; $i++)
  {
    for ($j=8; $j<=24; $j++)
    {
      if ( $i<5 && $j<19 ) continue;
      
      $presen = mysql_query("SELECT count(*) from reservations where annee=$annee and semaine=$semaine and jour=$i and heure=$j");
      $presence = mysql_fetch_row( $presen );
      $presence = $presence[0];
      
      // ici une requete d'insertion
      if ( $presence==0 && $_POST[$i."X".$j]=="on" ) mysql_query("INSERT INTO reservations VALUES (DEFAULT, ".$annee.", ".$semaine.", ".$i.", ".$j.", ".$row["id"].")");
      else if ($presence!=0 && $_POST[$i."X".$j]=="on") die("un des cr&eacute;neau demand&eacute sont deja pris...");
    }
  }

 ?>
 <h1>R&eacute;servation enregistr&eacute;e</h1>
 La r&eacute;servation pour le groupe "<?php echo htmlspecialchars(stripslashes($_POST["nom"])); ?>" a &eacute;t&eacute; enregistr&eacute;e
 <a href="index.php">retour au calendrier</a>
</div>
</form>
<?php } include("menu.php"); ?>
</body>
</html>
<!-- Script cree par David191212 ( David BEUVOT ) -->