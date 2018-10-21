<?php
/*
	get_solde_isibouffe.php

	ENTREE
		token : token d'identification
					
	SORTIE:
		Retourne le solde
		Si non authentifié ou carte non associé, retourne erreur
	AUTORISATION:
		zz bde
*/



$autorise = array("zz", "bde");
function get_solde_isibouffe($settings, $objets){
	$bdd = $objets['bdd'];
	

	
	$search = $bdd->query("SELECT id_isibouffe FROM isibouffe_link WHERE id_bde=".$objets['user_info']['uti_id']);
	while($result = $search->fetch()){
		$solde=$bdd->query("SELECT solde FROM isibouffe_zz WHERE id=".$result['id_isibouffe'])->fetch()['solde'];
		return array("error"=>0, "solde"=>$solde);
	}
	return array("error" => 1, "msg" => "Vous n'avez pas encore associé votre carte isibouffe à votre compte BDE, avant de faire l'association vous devez avoir créé votre carte isibouffe en ayant fait au moins une recharge auprès du trésorier. Une fois la recharge faite vous pouvez associer votre compte isibouffe");
}
?>
