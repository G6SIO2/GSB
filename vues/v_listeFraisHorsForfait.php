<section>
    
    
    <?php setlocale(LC_TIME, 'fr_FR'); ?>
    <h2>Renseigner ma fiche de frais du mois <?php echo utf8_encode(strftime("%B %Y")); ?></h2>
    <?php $totalmontant = 0; ?>
    
    <h3>Saisie d'un nouveau frais hors forfait</h3>

    <form method="POST" action="index.php?uc=gererFrais&action=validerCreationFraisHorsForfait">

        <table class="table_forfait">

            <tr>
                <td>Date de l'engagement de la dépense</td>
                <td>
                    <input type="date" id="txtDateHF" name="dateFrais"/>
                </td>
            </tr>

            <tr>
                <td>Libelle</td>
                <td>
                   <input type="text" id="txtLibelleHF" name="libelle" size="70" maxlength="256" value="" />
                </td>
            </tr>

             <tr>
                <td>Montant</td>
                <td>
                      <input type="number" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" step="0.01" min="0.01"/>
                </td>
            </tr>

        </table>

        <br />

        <input id="ajouter" type="submit" value="Ajouter" size="20" />
            <input id="effacer" type="reset" value="Effacer" size="20" />

    </form><!--
    
    <form action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
        <div class="corpsForm">

            <fieldset>
                <legend>Nouvel élément hors forfait
                </legend>
                <p>
                    <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                    <input type="text" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  />
                </p>
                <p>
                    <label for="txtLibelleHF">Libellé</label>
                    <input type="text" id="txtLibelleHF" name="libelle" size="70" maxlength="256" value="" />
                </p>
                <p>
                    <label for="txtMontantHF">Montant : </label>
                    <input type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" />
                </p>
            </fieldset>
        </div>
        <div class="piedForm">
        <p>
            <input id="ajouter" type="submit" value="Ajouter" size="20" />
            <input id="effacer" type="reset" value="Effacer" size="20" />
        </p> 
        </div>

    </form>-->

    <table class="table_forfait">
        <caption>Descriptif des éléments hors forfait
        </caption>
        
        <tbody>
            
        <tr>
           <th class="date">Date</th>
                           <th class="libelle">Libellé</th>  
           <th class="montant">Montant</th>  
           <th class="action">&nbsp;</th>              
        </tr>

        <?php    
            foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
            {
                $libelle = $unFraisHorsForfait['libelle'];
                $date = $unFraisHorsForfait['date'];
                $montant=$unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id'];
        ?>		
                <tr>
                    <td> <?php echo $date ?></td>
                    <td><?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                    <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                        onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                 </tr>
            <?php		 

            }
        ?>
                 
        </tbody>

    </table>


</section>

