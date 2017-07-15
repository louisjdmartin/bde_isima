<?php 
include("inc/bdd.php");
include("inc/head.php");
?>
<form action="absence.php" method="POST">
  Absent: <select name='m_id_absent'>
  <?php
  $membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");
foreach($membres as $m){
  echo "<option value='".$m['m_id']."'>".$m['m_nom']."</option>";
}
  ?>
</select>
remplacé par
<select name='m_id_remplace'><option value='NULL'>Personne</option>                                                  
  <?php  
  $membres = $bdd->query("SELECT * FROM membres ORDER BY m_nom");                                                     
foreach($membres as $m){                                                              
  echo "<option value='".$m['m_id']."'>".$m['m_nom']."</option>";                   
}                                                                                  
  ?>     
  </select>
<select name='c_id'>
  <?php
  $cs = $bdd->query('SELECT * FROM creneaux ORDER BY c_jour, c_deb');
$last_day = -1;
foreach($cs as $c)
  {
     if($last_day != $c['c_jour']){
       if($last_day != 0)echo "</optgroup>";
       $last_day=$c['c_jour'];
       echo "<optgroup label='".$jours[$c['c_jour']]."'>";
	
    }
	  echo "<option value='".$c['c_id']."'>".$c['c_deb']." &rarr; ".$c['c_fin']."</option>";
  }

  ?>
<optgroup></select>
<input type='submit' value='Envoyer' />
</form>