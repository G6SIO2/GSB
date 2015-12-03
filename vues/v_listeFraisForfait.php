<section>
    
    <?php setlocale(LC_TIME, 'fr_FR'); ?>
    <h2>Renseigner ma fiche de frais du mois <?php echo utf8_encode(strftime("%B %Y")); ?></h2>
    <?php $totalmontant = 0; ?>
    
    <h3>Saisie d'un nouveau frais forfaitisé</h3>

    <form method="POST" action="index.php?uc=gererFrais&action=validerCreationFraisForfait">

        <table class="table_forfait">

            <tr>
                <td>Type de frais</td>
                <td>
                    <select name="idfrais">
                        <?php foreach ($lesFraisForfait as $unFrais) { ?>

                            <option value="<?php echo $unFrais['idfrais']; ?>"><?php echo $unFrais['libelle']; ?></option>

                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Date de l'engagement de la dépense</td>
                <td>
                    <input type="date" name="date" placeholder="JJ/MM/AAAA">
                </td>
            </tr>

            <tr>
                <td>Description</td>
                <td>
                    <input type="text" name="description" maxlength="250">
                </td>
            </tr>

             <tr>
                <td>Quantité</td>
                <td>
                    <input type="number" name="quantite" maxlength="20" step="1" min="1" value="1">
                </td>
            </tr>

        </table>

        <br />

        <input type="submit" value="Valider" name="valider">

    </form>
    
    <h3>Eléments forfaitisés (synthèse du mois)</h3>
    
    <table class="table_forfait">

        <tr>
            <td></td>
            <?php foreach ($lesFraisForfait as $unFrais) { ?>

                    <td><?php echo $unFrais['libelle']; ?></td>

            <?php } ?>
        </tr>

        <tr>
            <td>Quantité totale</td>
            <?php foreach ($lesFraisForfait as $unFrais) { ?>

                    <td><?php echo $unFrais['quantite']; ?></td>

            <?php } ?>
        </tr>

        <tr>
            <td>Montant total</td>
            <?php foreach ($lesFraisForfait as $unFrais) { ?>

                    <td><?php echo $unFrais['montant']; ?></td>
                    <?php $totalmontant += $unFrais['montant']; ?>

            <?php } ?>
        </tr>

    </table>
    
    <h3>Total des frais engagés pour le mois : <i><?php echo $totalmontant; ?></i></h3>
    
    <h3>Eléments forfaitisés (détails du mois)</h3>
    
    <table class="table_forfait">

        <tr>
            <td>Date</td>
            <td>Type frais</td>
            <td>Description</td>
            <td>Quantité</td>
            <td></td>
        </tr>
        
        <?php 
        if(isset($lesFraisTemporaires))
        {
            foreach ($lesFraisTemporaires as $unFrais) { 
                ?>
        
                <tr>
                    <td><?php echo $unFrais['date']; ?></td>
                    <td><?php echo $unFrais['typefrais']; ?></td>
                    <td><?php echo $unFrais['description']; ?></td>
                    <td><?php echo $unFrais['quantite']; ?></td>
                    <td><a href="index.php?uc=gererFrais&action=supprimerFraisTemporaire&idFrais=<?php echo $unFrais['id'] ?>" 
                        onclick="return confirm('Voulez-vous vraiment supprimer ce frais ?');">Supprimer ce frais</a></td>
                </tr>

            <?php } 
        
        } ?>
        
    </table>

<!--
    <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
    <div class="corpsForm">

        <fieldset>
          <legend>Eléments forfaitisés
          </legend>

              <?php
                  foreach ($lesFraisForfait as $unFrais)
                  {
                      $idFrais = $unFrais['idfrais'];
                      $libelle = $unFrais['libelle'];
                      $quantite = $unFrais['quantite'];
              ?>
                  <p>
                      <label for="lesFrais[<?php echo $idFrais?>]"><?php echo $libelle ?></label>
                      <input type="text" id="lesFrais[<?php echo $idFrais?>]" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
                  </p>

              <?php
                  }
              ?>

        </fieldset>
    </div>
    <div class="piedForm">
    <p>
      <input id="ok" type="submit" value="Valider" size="20" />
      <input id="annuler" type="reset" value="Effacer" size="20" />
    </p> 
    </div>

    </form>

-->
    
</section>
  