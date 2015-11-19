<section>
    
    <?php setlocale(LC_TIME, 'fr_FR'); ?>
    <h2>Renseigner ma fiche de frais du mois <?php echo strftime("%B %Y"); ?></h2>
    
    <h3>Saisie d'un nouveau frais forfaitisé:</h3>

<form method="POST" action="index.php?uc=gererFrais&action=validerCreationFraisForfait">

    <table class="table_forfait">

        <tr>
                    <td>Type de frais:</td>
                <td>
                        <input  type="text" name="dateFrais" maxlength="45">
                </td>
        </tr>

        <tr>
                    <td>Date de l'engagement de la dépense:</td>
                <td>
                        <input  type="text" name="dateEngag"  maxlength="100">
                </td>
        </tr>

        <tr>
                    <td>Description:</td>
                <td>
                    <input  type="text" name="description" maxlength="250">
                </td>
        </tr>

         <tr>
                    <td>Quantité:</td>
                <td>
                    <input  type="text" name="quantite" maxlength="20">
                </td>
        </tr>

    </table>
    
    <br />
    
    <input type="submit" value="Valider" name="valider">

</form>

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
  