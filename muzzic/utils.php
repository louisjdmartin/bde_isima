<?php

$liste_jours = array("Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim");
$liste_joursLong = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
$liste_mois = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout",
                    "Septembre", "Octobre", "Novembre", "Decembre");

$cryptokey = "DF/01";

function getJourFromSemaineAnnee ( $semaine, $annee )
{
  $premJour = new DateTime();
  $premJour->setISOdate($annee, $semaine);
  
  $premJourTS = $premJour->format('U');
}

function mysql_table_exists($table , $db) 
{
	$requete = 'SHOW TABLES FROM '.$db.' LIKE \''.$table.'\'';
	$exec = mysql_query($requete);
	return mysql_num_rows($exec);
}

function verifConfig (  )
{
    if(!file_exists("config.php") || file_exists("install.php") ) 
    {
        die("Vous devez d'abord effectuer l'installation du calendrier ".
            "<a href=\"install.php\">ici</a> puis supprimer le fichier install.php");
    }

    require("config.php");

    if( !mysql_connect($bddhost, $bddlogin, $bddpass) )
    {
      die('Impossible de se connecter a la base de donn&eacute;es ( identifiants faux ? )');
    }
    mysql_select_db($bddname) or die('Impossible de s&eacute;lectionner la base de donn&eacute;es');

    if (!mysql_table_exists("reservations" , $bddname) && !mysql_table_exists("groupes" , $bddname))
        die("les tables ne sont pas cr&eacute;es ou ont &eacute;t&eacute; supprim&eacute;es");

}

function deCrypte($message, $key)
{
    $key_length = strlen($key);

    $encoded_data = base64_decode($message);

    $result = '';

    $length = strlen($encoded_data);
    for ($i = 0; $i < $length; $i++) {
        $tmp = $encoded_data[$i];

        for ($j = 0; $j < $key_length; $j++) {
            $tmp = chr(ord($tmp) ^ ord($key[$j]));
        }

        $result .= $tmp;
    }

    return $result;
}

function Crypte($message, $key)
{
    $key_length = strlen($key);

    $encoded_data = '';

    $length = strlen($message);
    for ($i = 0; $i < $length; $i++) {
        $tmp = $message[$i];

        for ($j = 0; $j < $key_length; $j++) {
            $tmp = chr(ord($tmp) ^ ord($key[$j]));
        }

        $encoded_data .= $tmp;
    }

    $result = base64_encode($encoded_data);

    return $result;
}
?>