<?php
/*
	virement.php
	ENTREE
		to: numero de carte destination
		montant: nombre reel positif
		token: jeton identification
	SORTIE
		error
*/
function virement($settings, $objets){
	$bdd = $objets['bdd'];	
	if(empty($objets['user_info']['uti_id']))return array("error"=>1, "error_msg"=>"Erreur d'identification");
	if(!is_numeric($settings['to']) || !is_numeric($settings['montant']) || $settings['montant']<0)return array("error"=>1, "error_msg"=>"Saisie incorrecte");

	$compte_credit = $bdd->query("SELECT id FROM membres WHERE numero=".$settings['to']);
        $i=0;
        foreach($compte_credit as $id){$i++;$id_credit=$id['id'];}
	if($i!=1)return array("error"=>1, "error_msg"=>"Compte introuvable !");

	$solde = $bdd->query("SELECT solde FROM membres WHERE id=".$objets['user_info']['uti_id'])->fetch()['solde'];
	$solde_credit = $bdd->query("SELECT solde FROM membres WHERE numero=".$settings['to'])->fetch()['solde'];
	if($solde-$settings['montant']<0)return array("error"=>1, "error_msg"=>"Solde insuffisant !");

	if($objets['user_info']['uti_id']==$id_credit)return array("error"=>1, "error_msg"=>"Vous ne pouvez pas envoyer a vous meme");

	$solde = $solde-$settings['montant'];
	$solde_credit+= $settings['montant'];
	$bdd->query("UPDATE membres SET solde = '$solde' WHERE id=".$objets['user_info']['uti_id']);
	$bdd->query("INSERT INTO logs_solde VALUES (NULL, '".$objets['user_info']['uti_id']."','".$objets['user_info']['uti_id']."','-".addslashes($settings['montant'])."', CURRENT_TIMESTAMP)");

        $bdd->query("UPDATE membres SET solde = '$solde_credit' WHERE id=".$id_credit);
        $bdd->query("INSERT INTO logs_solde VALUES (NULL, '".$objets['user_info']['uti_id']."','".$id_credit."','".addslashes($settings['montant'])."', CURRENT_TIMESTAMP)");




	return array("error"=>0);
}
?>
