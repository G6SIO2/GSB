<?php
/**
 * Retourne les visiteurs
 
 * @param $pdo
 * @return Array Un tableau de visiteurs
*/
function getLesVisiteurs($pdo)
{
		$req = "select * from Visiteur";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
/**
 * Retourne les fiches de frais
 
 * @param $pdo
 * @return Array Un tableau des fiches de frais
*/
function getLesFichesFrais($pdo)
{
		$req = "select * from FicheFrais";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
/**
 * Retourne les id des frais de forfait dans l'ordre croissant
 
 * @param $pdo
 * @return Array Un tableau des id des frais de forfait dans l'ordre croissant
*/
function getLesIdFraisForfait($pdo)
{
		$req = "select FraisForfait.id as id from FraisForfait order by FraisForfait.id";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
/* gestion des erreurs*/
/**
 * Renvoie le dernier mois sous la forme 'AAAAMM' des fiches de frais créées pour un visiteur
 
 * @param $pdo
 * @param $idVisiteur
 * @return Mixed Le dernier mois sous la forme 'AAAAMM'
*/
function getDernierMois($pdo, $idVisiteur)
{
		$req = "select max(mois) as dernierMois from FicheFrais where idVisiteur = '$idVisiteur'";
		$res = $pdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['dernierMois'];

}
/**
 * Renvoie le mois suivant le mois passé en paramètre sous la forme 'AAAAMM'
 
 * @param $mois
 * @return Mixed Le mois suivant le mois passé en paramètre sous la forme 'AAAAMM'
*/
function getMoisSuivant($mois){
		$numAnnee =substr( $mois,0,4);
		$numMois =substr( $mois,4,2);
		if($numMois=="12"){
			$numMois = "01"; 
			$numAnnee++;
		}
		else{
			$numMois++;

		}
		if(strlen($numMois)==1)
			$numMois="0".$numMois;
		return $numAnnee.$numMois;
}
/**
 * Renvoie le mois précédent le mois passé en paramètre sous la forme 'AAAAMM'
 
 * @param $mois
 * @return Mixed Le mois précédent le mois passé en paramètre sous la forme 'AAAAMM'
*/
function getMoisPrecedent($mois){
		$numAnnee =substr( $mois,0,4);
		$numMois =substr( $mois,4,2);
		if($numMois=="01"){
			$numMois = "12"; 
			$numAnnee--;
		}
		else{
			$numMois--;
		}
		if(strlen($numMois)==1)
			$numMois="0".$numMois;
		return $numAnnee.$numMois;
}
/**
 * Génère pour chaque visiteur une fiche de frais du mois actuel, du mois précédent et du mois suivant 
 * avec un état différent en fonction du mois
 
 * @param type $pdo
 */
function creationFichesFrais($pdo)
{
	$lesVisiteurs = getLesVisiteurs($pdo);
	$moisActuel = getMois(date("d/m/Y"));
	$moisDebut = "201001";
	$moisFin = getMoisPrecedent($moisActuel);
	foreach($lesVisiteurs as $unVisiteur)
	{
		$moisCourant = $moisFin;
		$idVisiteur = $unVisiteur['id'];
		$n = 1;
		while($moisCourant >= $moisDebut)
		{
			if($n == 1)
			{
				$etat = "CR";
				$moisModif = $moisCourant;
			}
			else
			{
				if($n == 2)
				{
					$etat = "VA";
					$moisModif = getMoisSuivant($moisCourant);
				}
				else
				{
					$etat = "RB";
					$moisModif = getMoisSuivant(getMoisSuivant($moisCourant));
				}
			}
			$numAnnee =substr( $moisModif,0,4);
			$numMois =substr( $moisModif,4,2);
			$dateModif = $numAnnee."-".$numMois."-".rand(1,8);
			$nbJustificatifs = rand(0,12);
			$req = "insert into FicheFrais(idVisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
			values ('$idVisiteur','$moisCourant',$nbJustificatifs,0,'$dateModif','$etat');";
			$pdo->exec($req);
			$moisCourant = getMoisPrecedent($moisCourant);
			$n++;
		}
	}
}
/**
 * Génère aléatoirement des lignes de frais de forfait pour chaque fiche de frais. 
 * La quantité du frais dépend de l'id :
 * - S'il commence par la lettre K, la quantité sera entre 300 et 1000
 * - Sinon, la quantité sera entre 2 et 20
 
 * @param type $pdo
 */
function creationFraisForfait($pdo)
{
	$lesFichesFrais= getLesFichesFrais($pdo);
	$lesIdFraisForfait = getLesIdFraisForfait($pdo);
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idVisiteur = $uneFicheFrais['idVisiteur'];
		$mois =  $uneFicheFrais['mois'];
		foreach($lesIdFraisForfait as $unIdFraisForfait)
		{
			$idFraisForfait = $unIdFraisForfait['id'];
			if(substr($idFraisForfait,0,1)=="K")
			{
				$quantite =rand(300,1000);
			}
			else
			{
				$quantite =rand(2,20);
			}
			$req = "insert into LigneFraisForfait(idVisiteur,mois,idFraisForfait,quantite)
			values('$idVisiteur','$mois','$idFraisForfait',$quantite);";
			$pdo->exec($req);	
		}
	}

}
/**
 * Retourne un tableau de frais hors forfait qui peuvent être utilisés pour être insérés en base de données
 
 * @return Array Un tableau de frais hors forfait
 */
function getDesFraisHorsForfait()
{
	$tab = array(
				1 => array(
				      "lib" => "repas avec praticien",
					  "min" => 30,
					  "max" => 50 ),
				2 => array(
				      "lib" => "achat de matériel de papèterie",
					  "min" => 10,
					  "max" => 50 ),
				3 => array(
				      "lib" => "taxi",
					  "min" => 20,
					  "max" => 80 ),
				4 => array(
				      "lib" => "achat d'espace publicitaire",
					  "min" => 20,
					  "max" => 150 ),
				5 => array(
				      "lib" => "location salle conférence",
					  "min" => 120,
					  "max" => 650 ),
				6 => array(
				      "lib" => "Voyage SNCF",
					  "min" => 30,
					  "max" => 150 ),
				7 => array(
					  "lib" => "traiteur, alimentation, boisson",
					  "min" => 25,
					  "max" => 450 ),
				8 => array(
					  "lib" => "rémunération intervenant/spécialiste",
					  "min" => 250,
					  "max" => 1200 ),
				9 => array(
					  "lib" => "location équipement vidéo/sonore",
					  "min" => 100,
					  "max" => 850 ),
				10 => array(
					  "lib" => "location véhicule",
					  "min" => 25,
					  "max" => 450 ),
				11 => array(
					  "lib" => "frais vestimentaire/représentation",
					  "min" => 25,
					  "max" => 450 ) 
		);
	return $tab;
}
/**
 * Permet de réatribuer un mot de passe composé de 5 caractères (lettres minuscules et chiffres) généré aléatoirement
 * pour chaque visiteur
 
 * @param type $pdo
 */
function updateMdpVisiteur($pdo)
{
	$req = "select * from Visiteur";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		$lettres ="azertyuiopqsdfghjkmwxcvbn123456789";
		foreach($lesLignes as $unVisiteur)
		{
			$mdp = "";
			$id = $unVisiteur['id'];
			for($i =1;$i<=5;$i++)
			{
				$uneLettrehasard = substr( $lettres,rand(33,1),1);
				$mdp = $mdp.$uneLettrehasard;
			}
			
			$req = "update Visiteur set mdp ='$mdp' where Visiteur.id ='$id' ";
			$pdo->exec($req);
		}
}
/**
 * Génère des lignes de frais hors forfait aléatoirement pour chaque fiche de frais et à partir d'une liste de
 * frais hors forfait prédéfinie.
 
 * @param type $pdo
 */
function creationFraisHorsForfait($pdo)
{
	$desFrais = getDesFraisHorsForfait();
	$lesFichesFrais= getLesFichesFrais($pdo);
	
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idVisiteur = $uneFicheFrais['idVisiteur'];
		$mois =  $uneFicheFrais['mois'];
		$nbFrais = rand(0,5);
		for($i=0;$i<=$nbFrais;$i++)
		{
			$hasardNumfrais = rand(1,count($desFrais)); 
			$frais = $desFrais[$hasardNumfrais];
			$lib = $frais['lib'];
			$min= $frais['min'];
			$max = $frais['max'];
			$hasardMontant = rand($min,$max);
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$hasardJour = rand(1,28);
			if(strlen($hasardJour)==1)
			{
				$hasardJour="0".$hasardJour;
			}
			$hasardMois = $numAnnee."-".$numMois."-".$hasardJour;
			$req = "insert into LigneFraisHorsForfait(idVisiteur,mois,libelle,date,montant)
			values('$idVisiteur','$mois','$lib','$hasardMois',$hasardMontant);";
			$pdo->exec($req);
		}
	}
}
/**
 * Retourne une chaîne de caractères correspondant à une année et un mois sous la forme "AAAAMM" créée à partir de la date passée en paramètre.
 * Le jour, le mois et l'année sont décomposés grâce au slash.
 
 * @param $date
 * @return Mixed Une chaîne de caractères correspondant à une année et un mois sous la forme "AAAAMM"
*/
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}
/**
 * Met à jour le montant validé de chaque fiche de frais en additionnant leurs totaux de frais de forfait et de frais hors forfait
 
 * @param type $pdo
 */
function majFicheFrais($pdo)
{
	
	$lesFichesFrais= getLesFichesFrais($pdo);
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idVisiteur = $uneFicheFrais['idVisiteur'];
		$mois =  $uneFicheFrais['mois'];
		$dernierMois = getDernierMois($pdo, $idVisiteur);
		$req = "select sum(montant) as cumul from LigneFraisHorsForfait where LigneFraisHorsForfait.idVisiteur = '$idVisiteur' 
				and LigneFraisHorsForfait.mois = '$mois' ";
		$res = $pdo->query($req);
		$ligne = $res->fetch();
		$cumulMontantHorsForfait = $ligne['cumul'];
		$req = "select sum(LigneFraisForfait.quantite * FraisForfait.montant) as cumul from LigneFraisForfait, FraisForfait where
		LigneFraisForfait.idFraisForfait = FraisForfait.id   and   LigneFraisForfait.idVisiteur = '$idVisiteur' 
				and LigneFraisForfait.mois = '$mois' ";
		$res = $pdo->query($req);
		$ligne = $res->fetch();
		$cumulMontantForfait = $ligne['cumul'];
		$montantEngage = $cumulMontantHorsForfait + $cumulMontantForfait;
		$etat = $uneFicheFrais['idEtat'];
		if($etat == "CR" )
			$montantValide = 0;
		else
			$montantValide = $montantEngage*rand(80,100)/100;
		$req = "update FicheFrais set montantValide =$montantValide where
		idVisiteur = '$idVisiteur' and mois='$mois'";
		$pdo->exec($req);
		
	}
}
/** 
 * Fonctions pour l'application GSB
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 */
 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($id, $nom, $prenom, $role){
	$_SESSION['idVisiteur']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
	$_SESSION['role']= $role;
}
/**
 * Détruit la session active
 */
function deconnecter(){
	session_destroy();
}
/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais aaaa-mm-jj
 
 * @param $madate au format  jj/mm/aaaa
 * @return la date au format anglais aaaa-mm-jj
*/
function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}
/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format français jj/mm/aaaa 
 
 * @param $madate au format  aaaa-mm-jj
 * @return la date au format format français jj/mm/aaaa
*/
function dateAnglaisVersFrancais($maDate){
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}

/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}
/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false; 
		}
	}
	return $ok;
}
/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 
 * @param $dateTestee 
 * @return vrai ou faux
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}
/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa 
 
 * @param $date 
 * @return vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}
/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 
 
 * @param $lesFrais 
 * @return vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}
/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais et le montant 
 
 * des message d'erreurs sont ajoutés au tableau des erreurs
 
 * @param $dateFrais 
 * @param $libelle 
 * @param $montant
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!estDatevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}
/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	} 
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}
?>




