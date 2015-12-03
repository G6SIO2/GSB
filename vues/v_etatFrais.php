<section>

    <?php setlocale(LC_TIME, 'fr_FR'); ?>
    <h3>Fiche de frais du mois <?php echo utf8_encode(strftime("%B %Y", strtotime($numMois."/01/".$numAnnee))); ?> : </h3>
    
    <p>
        Etat : <?php echo $libEtat?> depuis le <?php echo $dateModif?> <br> Montant validé : <?php echo $montantValide?>
    </p>

    <table class="table">
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

    <table class="table">
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
 













