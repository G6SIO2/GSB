<?php
include("vues/v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee =substr( $mois,0,4);
$numMois =substr( $mois,4,2);
$action = $_REQUEST['action'];

switch($action){
	case 'saisirFraisForfait':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){

                    $pdo->creeNouvellesLignesFraisForfait($idVisiteur,$description);
                    $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
                    include("vues/v_listeFraisForfait.php");
                    $pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur,$mois);
                $lesFraisTemporaires = $pdo->getLesFraisTemporaires($idVisiteur, $mois);
                include("vues/v_listeFraisForfait.php");
                
		break;
	}
        case 'saisirFraisHorsForfait':{
		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
		}
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
                include("vues/v_listeFraisHorsForfait.php");
                
		break;
	}
	case 'validerMajFraisForfait':{
		$lesFrais = $_REQUEST['lesFrais'];
		if(lesQteFraisValides($lesFrais)){
	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
	  break;
	}
        case 'validerCreationFraisForfait':{
		$idFrais = $_REQUEST['idfrais'];
		$date = $_REQUEST['date'];
		$description = $_REQUEST['description'];
		$quantite = $_REQUEST['quantite'];
		valideInfosFraisForfait($idFrais, $date, $description, $quantite);
		if (nbErreurs() != 0 ){
                    include("vues/v_erreurs.php");
		}
		else{
                    $pdo->creeNouveauFraisTemporaire($idVisiteur, $mois, $idFrais, $date, $description, $quantite);
                    $pdo->modifierLigneFraisForfait($idVisiteur, $mois, $idFrais, $quantite);
		}
		break;
	}
	case 'validerCreationFraisHorsForfait':{
		$dateFrais = $_REQUEST['dateFrais'];
		$libelle = $_REQUEST['libelle'];
		$montant = $_REQUEST['montant'];
		valideInfosFrais($dateFrais,$libelle,$montant);
		if (nbErreurs() != 0 ){
                    include("vues/v_erreurs.php");
		}
		else{
                    $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
		}
		break;
	}
	case 'supprimerFrais':{
		$idFrais = $_REQUEST['idFrais'];
                $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}
?>