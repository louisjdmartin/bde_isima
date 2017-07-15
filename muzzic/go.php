<?php
session_start();

require("config.php");
require("utils.php");

if (  $_SESSION['login'] == $adminLogin && $_SESSION['pwd'] == $adminPass )
{
  if ($_GET['mode'] == 'Grp')
  {
      if(!mysql_connect($bddhost, $bddlogin, $bddpass))
      {
        die('Impossible de se connecter : ' . mysql_error());
      }
      mysql_select_db($bddname) or die('Impossible de sélectionner la base de données');
      
      mysql_query("Delete from groupes where id=".$_GET['id']);
      mysql_query("Delete from reservations where groupe=".$_GET['id']);
      
      echo "Ok grp";
  }
  else if ($_GET['mode'] == 'res')
  {
      if(!mysql_connect($bddhost, $bddlogin, $bddpass))
      {
        die('Impossible de se connecter : ' . mysql_error());
      }
      mysql_select_db($bddname) or die('Impossible de sélectionner la base de données');
      
      mysql_query("Delete from reservations where id_reservation=".$_GET['id']);
      echo "Ok res";
  }
  else if ($_GET['mode'] == 'chG')
  {
    $str = "<?php\n\$bddhost = \"".$bddhost."\";\n\$bddlogin = \"".$bddlogin.
    "\";\n\$bddpass = \"".$bddpass."\";\n\$bddname = \"".$bddname."\";"
    ."\n\n\$adminLogin = \"".$_GET['login']."\";\n\$adminPass = \"".Crypte($_GET['pass'], $cryptokey)."\";\n?>";

    file_put_contents("config.php", $str);
  }
  else die("Rien a faire");
}
else
{
  die("Oupsss, alors comme ca, on a essaye d'entrer manuellement dans la matrice ???");
}
?>