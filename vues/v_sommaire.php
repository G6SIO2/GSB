    <!-- Division pour le sommaire -->
    <div id="menuGauche">
    <div id="infosUtil">
         
    </div>  
        <ul id="menuList">
			<li >
                                <b><?php echo $_SESSION['role']; ?></b>
                                <br /> <br />
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom'];  ?>
			</li>
           <li class="smenu">
               <a href="index.php?uc=gererFrais&action=saisirFraisForfait" title="Saisie fiche de frais : forfaitisés">Saisie fiche de frais : forfaitisés</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=gererFrais&action=saisirFraisHorsForfait" title="Saisie fiche de frais : hors forfait">Saisie fiche de frais : hors forfait</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
 	   <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
         </ul>
        
    </div>
    