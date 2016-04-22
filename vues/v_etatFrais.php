<section>

    <?php setlocale(LC_TIME, 'fr_FR'); ?>
    <h3>Fiche de frais du mois <?php $ladate = utf8_encode(strftime("%B %Y", strtotime($numMois."/01/".$numAnnee))); echo $ladate; ?> : </h3>
    
    <form action="controleurs/c_pdf.php" method="POST">
        
        <input name="ladate" type="text" style="visibility: hidden; display: none;" value="<?php echo $ladate ?>">
        <input name="nomprenom" type="text" style="visibility: hidden; display: none;" value="<?php echo $_SESSION['prenom']."  ".$_SESSION['nom'];  ?>">
        <input name="libetat" type="text" style="visibility: hidden; display: none;" value="<?php echo $libEtat ?>">
        <input name="datemodif" type="text" style="visibility: hidden; display: none;" value="<?php echo $dateModif ?>">
        <input name="montantvalide" type="text" style="visibility: hidden; display: none;" value="<?php echo $montantValide ?>">
        <input name="lemois" type="text" style="visibility: hidden; display: none;" value="<?php echo $leMois ?>">  
        
        <?php if($leMois != getMois(date('d/m/Y'))) { ?>
            <button type="submit" id="btn_pdf">PDF</button>
        <?php } ?>
    
    </form>
    
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
    </p>

    <table class="table" id="table_forfaitises" id="table_1">
        <caption>Eléments forfaitisés </caption>
        
        <tbody>
            
            <tr>
                <?php
                foreach ( $lesFraisForfait as $unFraisForfait ) 
                   {
                       $libelle = $unFraisForfait['libelle'];
                   ?>	
                   <th> <?php echo $libelle?></th>
                    <?php
                       }
                   ?>
            </tr>

            <tr>
                <?php
                foreach (  $lesFraisForfait as $unFraisForfait  ) 
                    {
                        $quantite = $unFraisForfait['quantite'];
                    ?>
                <td><?php echo $quantite ?> </td>
                <?php
                    }
                ?>
            </tr>
            
            <tr>
                <?php
                foreach (  $lesFraisForfait as $unFraisForfait  ) 
                    {
                        $montant = $unFraisForfait['montant'];
                    ?>
                <td><?php echo $montant ?> </td>
                <?php
                    }
                ?>
            </tr>
        
        <tbody>
        
    </table>
    
    <br />

    <table class="table" id="table_2">
        <caption>Descriptif des éléments hors forfait -<?php echo $nbJustificatifs ?> justificatifs reçus - </caption>
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        <?php      
            foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
                {
                    $date = $unFraisHorsForfait['date'];
                    $libelle = $unFraisHorsForfait['libelle'];
                    $montant = $unFraisHorsForfait['montant'];
                ?>
                <tr>
                    <td><?php echo $date ?></td>
                    <td><?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                </tr>
        <?php 
          }
        ?>
    </table>
    
</section>