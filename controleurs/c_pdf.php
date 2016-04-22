<?php
    include_once '../html2pdf/html2pdf.class.php';
    
    require_once("../include/fct.inc.php");
    require_once ("../include/class.pdogsb.inc.php");
    
    session_start();
    $pdo = PdoGsb::getPdoGsb();
    
    $idVisiteur = $_SESSION['idVisiteur'];
    $leMois = $_POST['lemois'];
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur,$leMois);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
    
    ob_end_clean();
    ob_start();
   
    ?>
<style type="text/css">
    h4
    {
        text-align:center;
    }
    table
    {
        border: 1px solid grey;
    }
    td
    {
        border-bottom: 1px solid #EEE;
    }
    .ElmtForfait
    {
        width: 25%; 
    }
    
    .BlocH4
    {
        text-decoration:underline;
        width: 100%;
    }
    span
    {
        text-align: center;
    }
</style>

<page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
    
    <div class="BlocH4">
        <h4>Fiche de frais de <?php echo $_POST['ladate']; ?></h4>
    </div>
    
    <p style="margin-top: 50px; text-align:right;">
        Employé concerné : <?php echo $_POST['nomprenom'];  ?> <br>
        Etat de la fiche : <span><?php echo $_POST['libetat'];  ?> depuis le <?php echo $_POST['datemodif'];  ?></span><br>
        Montant validée : <?php echo $_POST['montantvalide'];  ?> €
    </p>
    
    <br>
    <p style="text-align:left; font-weight:bold;">Eléments forfaitisés :</p>
    
    <table style="width: 100%;">
        
        <tr>
            <?php
                foreach ( $lesFraisForfait as $unFraisForfait ) 
                {
                   $libelle = $unFraisForfait['libelle'];
                ?>	
                    <td class="ElmtForfait"><?php echo $libelle?></td>
            <?php
                }
            ?>
        </tr>
        
        <tr>
            <?php
                foreach ( $lesFraisForfait as $unFraisForfait ) 
                {
                    $quantite = $unFraisForfait['quantite'];
                ?>	
                    <td class="ElmtForfait"><?php echo $quantite; ?></td>
            <?php
                }
            ?>
        </tr>
        
        <tr>
            <?php
                foreach ( $lesFraisForfait as $unFraisForfait ) 
                {
                    $montant = $unFraisForfait['montant'];
                ?>	
                    <td class="ElmtForfait"><?php echo $montant; ?> €</td>
            <?php
                }
            ?>
        </tr>
        
    </table>
    
    <br><br>
    <p style="text-align:left; font-weight:bold;">Descriptif des élements hors forfait :</p>
   
    <table style="width: 100%;">
        
        <tr>
            <td style="width: 30%;">Date</td>
            <td style="width: 40%;">Libellé</td>
            <td style="width: 30%;">Montant</td>           
        </tr>
        
        <tr>
            <?php      
            foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
                {
                    $date = $unFraisHorsForfait['date'];
                    $libelle = $unFraisHorsForfait['libelle'];
                    $montant = $unFraisHorsForfait['montant'];
                ?>
                <tr>
                    <td style="width: 30%;"><?php echo $date ?></td>
                    <td style="width: 40%;"><?php echo $libelle ?></td>
                    <td style="width: 30%;"><?php echo $montant ?> €</td>
                </tr>
        <?php 
          }
        ?>     
        </tr>
        
    </table>
  
</page>
<?php

    $contenu =  ob_get_contents();
    
    $pdf = new HTML2PDF('P', 'A4', 'fr', 'true', 'UTF-8');
    $pdf->writeHTML($contenu);
    
    ob_end_clean();
    $pdf->Output('fichefrais.pdf');

?>
