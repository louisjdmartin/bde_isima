Je vous avais prévenu, ce site ne peut plus fonctionner sur le nouveau serveur car ce dernier utilise PHP7. Si vous avez besoin de reserver un créneau, contactez directement un membre muZZic.
<br /><br />
Si quelqu'un souhaite récuperer le script pour le mettre à jour (ou pour un autre raison) contactez le BDE: bdeisima(at)gmail.com
<?php die(); ?>
<!doctype html>
<html>
<head>
<title>Occupation Salle muZZic</title>
<?php
require("utils.php");

verifConfig();

require("config.php");


if ( $_GET["mode"]!="inline" || $_GET["semaine"]=="" || $_GET["annee"]=="" )
{

  $annee = ( $_GET["annee"]!="" ? $_GET["annee"] : date("Y") );

  $semaine = ($_GET["semaine"]!="" ? $_GET["semaine"] : date("W") );

  ?>
  <link rel="stylesheet" type="text/css" href="design.css"/>

  <script type="text/javascript" src="jQuerry.js"></script>
  </head>
  <body>
  <div id="body">
  <h1>Planning d'occupation de la salle de muZZic</h1>
  <!--todo: faire un fichier separe pour les requetes sql-->
  <div id="TabSem">
  <table border="1" class="overElemnt">
  <tr>
    <td class="cliquable" onclick="window.location.replace(
      '<?php echo "?semaine=".($semaine-1)."&amp;annee=".$annee; ?>')">&lt;</td>
      
    <td colspan="4" align="center">Semaine <?php echo $semaine; ?></td>
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
    mysql_select_db($bddname) or die('Impossible de s&eacute;lectionner la base de donn&eacute;es');

    for ($j=19; $j<=24; $j++)
    {
      echo "<tr><td>".$j."h</td>";
      
      for ($i=0; $i<5; $i++)
      {
        $resultat = mysql_query("select * from reservations where semaine=". 
                    mysql_real_escape_string($semaine) ." and jour=". $i ." and heure = ". $j );
        $row = mysql_fetch_assoc( $resultat );
      
        $occupe = ( $row!=NULL );
      
        echo "<td ". ($occupe?
                      "class=\"occupe\" title=\"Creneau pris par un groupe\" onclick=\"loadDate("
                  . $annee . ", " .$semaine. ", " .$i.", ".$j . ");\""
                  :"class=\"libre\" title=\"Creneau libre\" ")
        ."></td>\n";
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
      /* Verifier si le jour est occupe ou non */
        $resultat = mysql_query("select * from reservations where semaine=". 
        mysql_real_escape_string($semaine) ." and jour=".
                                $i ." and heure = ". $j );
        $row = mysql_fetch_assoc( $resultat );
      
        $occupe = ( $row!=NULL );
   
        echo "<td ". ($occupe?
                      "class=\"occupe\" title=\"Creneau pris par un groupe\" onclick=\"loadDate("
                  . $annee . ", " .$semaine. ", " .$i.", ".$j . ");\""
                  :"class=\"libre\" title=\"Creneau libre\" ")
        ."></td>\n";
    }
    echo "</tr>";
    $premJourTS += 86400;
  }
  ?>
  </table>
  <br/>
  Cr&eacute;neaux en rouge => Cr&eacute;neaux occup&eacute;s<br/>
  Pour supprimer un cr&eacute;neau, adressez vous &agrave; un membre de muZZic
  <div id="detailJour" class="overElemnt" style="visibility:hidden"></div>
    <br/><br/>
  </div>
  <?php include("menu.php"); 
}
else
{
  /* ***************************************** Mode detail ************************************** */

  $semaine = $_GET["semaine"];
  $jour = $_GET["jour"];
  $heure = $_GET["heure"];
  $annee = $_GET["annee"];
  
  /* Une bonne grosse requete SQL Ici !!! */
  if(!mysql_connect($bddhost, $bddlogin, $bddpass))
  {
    die('Impossible de se connecter : ' . mysql_error());
  }
  mysql_select_db($bddname) or die('Impossible de s&eacute;lectionner la base de donn&eacute;es');

  /* quel est le groupe qui a reserve ce creneau */
  $requete = 'SELECT groupe FROM reservations WHERE'.
                       ' annee=' .  mysql_real_escape_string( $annee ).
                   ' and semaine='. mysql_real_escape_string( $semaine ).
                   ' and jour='.    mysql_real_escape_string( $jour ).
                   ' and heure='.   mysql_real_escape_string( $heure );              

  $resultat = mysql_query($requete);

  $groupe = mysql_fetch_row( $resultat );
  $groupe = $groupe[0];
  
  /* info sur ce groupe */
  $requete = 'SELECT * FROM groupes WHERE id=' . mysql_real_escape_string( $groupe );
  
  $resultat = mysql_query($requete);
  
  $row = null;
  if ($resultat) $row = mysql_fetch_assoc( $resultat );

  /* Formattage de la date */
  $aff_Jour = new DateTime();
  $aff_Jour->setISOdate($annee, $semaine, ($jour+1)%8 );
  
  $stamp = mktime($heure, 0, 0, $aff_Jour->format('n'), $aff_Jour->format('d'), $aff_Jour->format('Y'));
  
  $Njour = ( ( date("w", $stamp)-1 + 7 )%7 ) %7;
  
  $jourM =  date("d", $stamp);
  
  $mois = (date("m", $stamp)-1)%12;
  
  ?>
  <table border="1" style="width:100%;">
  <tr>  
    <th colspan="3"><?php echo $liste_joursLong[$Njour]." ".$jourM." ".$liste_mois[$mois]." ".$annee.
    " &agrave; ". $heure ."h"; ?></th>
  </tr>
  
  <tr><td>Nom du Groupe</td><td><?php echo stripslashes($row['nom']); ?></td></tr>
  <tr><td>R&eacute;f&eacute;rent</td><td><?php echo stripslashes($row['referent']); ?></td></tr>
  <tr><td>Contact</td><td colspan="3"><img src="email.php?token=<?php echo $row['contact']; ?>"/></td></tr>
  <tr><td>Divers</td><td colspan="3"><?php echo nl2br(stripslashes($row['divers'])); ?></td></tr>
  </table>
  <!-- debug, a retirer -->
  <!-- <?php print_r($GLOBALS); ?> -->
  <?php
} ?>
<script>
function loadDate(year, week, day, hour)
{
  //alert("on est le "+day+month+year);
  $.get("", {mode: "inline", annee: year, semaine: week, jour: day, heure:hour}, function(data){
    $('#detailJour').html(data);
    $('#detailJour').css('visibility', 'visible');
  });
}
</script>
</body>
</html>
<!-- Script cree par David191212 ( David BEUVOT ) -->
