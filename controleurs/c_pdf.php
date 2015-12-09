<?php

    include_once '../html2pdf/html2pdf.class.php';
  
   ob_start();
   
    ?>
<style type="text/css">
    h4
    {
        text-align:center;
    }
    table, td
    {
        border: 2px outset gray;
    }
    .ElmtForfait
    {
        width: 19%; 
        color:blue;
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
        Etat de la fiche : <span>Fiche crée, saisie en cours depuis le XX/XX/XXX</span><br>
        Montant validée : X.XX
    </p>
    
    <br>
    <p style="text-align:left; font-weight:bold;">Eléments forfaitisés :</p>
    
    <table style="width: 100%; width:70%;">
        
        <tr>
            <td class="ElmtForfait" >Forfait Etape</td>
            <td class="ElmtForfait" >Frais Kilométrique</td>
            <td class="ElmtForfait" >Nuitée Hotel</td>
            <td class="ElmtForfait" >Repas Restaurant</td>            
        </tr>
        
        <tr>
            <td style="width: 19%;">XX</td>
            <td style="width: 19%;">XX</td>
            <td style="width: 19%;">XX</td>
            <td style="width: 19%;">XX</td>            
        </tr>
        
    </table>
    
    <br><br>
    <p style="text-align:left; font-weight:bold;">Descriptif des élements hors forfait :</p>
   
    <table style="width: 100%;">
        
        <tr>
            <td style="width: 15%; color:blue;">Date</td>
            <td style="width: 40%; color:blue;">Libellé</td>
            <td style="width: 15%; color:blue;">Montant</td>           
        </tr>
        
        <tr>
            <td style="width: 15%;">XX</td>
            <td style="width: 40%;">XX</td>
            <td style="width: 15%;">XX</td>            
        </tr>
        
    </table>
  
</page>
    <?php
    $contenu =  ob_get_contents();
    ob_end_clean();
    
    $pdf = new HTML2PDF('P', 'A4', 'fr', 'true', 'UTF-8');
    $pdf->writeHTML($contenu);
    
    $pdf->Output('fichefrais.pdf');

?>
