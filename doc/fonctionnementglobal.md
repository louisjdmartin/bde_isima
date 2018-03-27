
# Fonctionnement global du site

Le site du BDE est découpé en 3 grandes parties: Accès visiteurs, Accès membres, API

# API
Tout accès à la base de donnée se fait par l'api, chaque fonctions utilise le même prototype
> function nomdelafonction($settings, $objets){}

$settings contient les variables passées en GET ou POST, par exemple $settings = array("token" => "abcdef", "article" => 4);
$objets contient:

`$objets['bdd']` => Objet PDO vers la base de données

`$objets['user_info']` => Array contenant les infos de l'utilisateur authenfié, chaque élément vaut NULL sinon.



   

    $objets['user_info'] = array(
                            "autorisations" => array("nomdroit" => "nomdroit"),  //Actuellement: zz, bde, club
     		        "uti_id" => NULL,  // Id du compte != numéro de carte !!!!
     			"carte" => NULL,  // Numéro de carte
     			"nom" => NULL,
     			"prenom" => NULL,
     			"surnom" => NULL,
     			"expiration" => NULL, // Timestamp indiquant l'heure ou la session expire
     			"cotisation" => NULL // Année de la dernière cotisation
        );
  
## Accès à l'api
L'accès en JS se fait via `/api/ajax/nomdelafonction` et retourne un JSON

L'accès en PHP se fait via `api("nomdelafonction", $parametres)` où $paramètres est un tableau similaire à ce que peux renvoyer $_POST et retourne un array

## Ajouter un module dans l'api
* Créer un fichier /api/api/nomdelafonction.php
* Ajouter un commentaire un début de fichier, celui-ci permet de construire la doc (prendre exemple sur les autres fichiers)
* Mettre le code source dans une fonction `function nomdelafonction($settings, $objets){}`
* Le fichier /api/fonctions.php est importé sans rien écrire !
* Le module est accessible !
* Vérifiez toujours les droits avec $objets['user_info']['autorisations']['nomdudroit']
* Toujours retourner un array, même si c'est juste array("error" => 0")

# Espace membre
Menu dans header.php

La variable $page dans index.php contient toutes les url possible et le titre à afficher pour le navigateur

Par exemple l'entrée carte est associé à l'url /espace_ZZ/carte et au fichier /espace_ZZ/pages/carte.php

## Ajouter un module dans l'espace membre
* Créer la/les page(s) qui affichera le module dans le dossier /espace_ZZ/pages/nomdelapage.php
* Ajouter la page à la variable $page d'index.php
* Sans avoir écrit une seule ligne de code les fichiers /api/api.php et /api/fonctions.php sont importés
* Coté client les fichiers dans /espace_ZZ/assets/js et /espace_ZZ/assets/css sont importés
* Pour les accès à la base de données, ajouter les modules necessaires dans l'API
* Le module est accessible via espace_ZZ/nomdelapage
* Si il y a besoin de passer des paramètres on peux soit modifier l'url rewriting via le .htacess soit utiliser les URL sous la forme /espace_ZZ/?page=nomdelapage&p1=valeur1&p2=valeur2
