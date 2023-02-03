<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template facture</title>
	<style type="text/css">
		.border {
			border-style: solid;
			border-width: 1px;
		}
	</style>
</head>
<body>
    <table cellspacing="0" style="border-style: solid; border-width: 1px">
        <tr>
            <td colspan="9" align="center">Facture d'eau</td>
        </tr>
        <tr>
            <td colspan="9" align="left">Tel: <?=$admin['result']['phone']?></td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <td class="border">Dernier Index <br> relevé le :</td>
            <td class="border" align="center"><?=date("d.m.y",strtotime($invoice['result']['dateReleveNewIndex']))?></td>
        </tr>
        <tr>
            <td colspan="9" align="center">Déposé le :</td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <td class="border">Date limite <br> de paiement :</td>
            <td class="border" align="center"><?=date("m.d.y",strtotime($invoice['result']['dataLimitePaid']))?></td>
        </tr>
        <tr>
            <td colspan="9" align="center">Mois: <?=date("F Y")?> <br> Destinataire: <?=$client['result']['name']?> <br> Localisation: 
                @for ($i = 0; $i < count($client['result']['description']); $i++)
                    <?=$client['result']['description'][$i]?>
                @endfor
            </td>
        </tr>
        <tr>
            <td rowspan="2" align="center" class="border">N° <br> Compteur </td>
            <td colspan="2" align="center" class="border">Index</td>
            <td rowspan="2" align="center" class="border">Consommation <br> M3 </td>
            <td rowspan="2" align="center" class="border">Prix <br> Unitaire </td>
            <td rowspan="2" align="center" class="border">Montant <br> Consommation </td>
            <td rowspan="2" align="center" class="border">Frais <br> Entretein </td>
            <td rowspan="2" align="center" class="border">Impayes </td>
            <td rowspan="2" align="center" class="border">Montant <br> A Payer </td>
        </tr>
        <tr>
            <td align="center" class="border">Nouvel</td>
            <td align="center" class="border">Ancien</td>
        </tr>
        <tr>
            <td align="center" class="border"><?=$invoice['result']['idCompteur']?></td>
            <td align="center" class="border"><?=$invoice['result']['newIndex']?></td>
            <td align="center" class="border"><?=$invoice['result']['oldIndex']?></td>
            <td align="center" class="border"><?=$invoice['result']['consommation']?></td>
            <td align="center" class="border"><?=$invoice['result']['prixUnitaire']?></td>
            <td align="center" class="border"><?php echo ($invoice['result']['montantConsommation']-$invoice['result']['fraisEntretien'])?></td>
            <td align="center" class="border"><?=$invoice['result']['fraisEntretien']?></td>
            <td align="center" class="border"><?=$invoice['result']['montantImpaye']?></td>
            <td align="center" class="border"><?=$invoice['result']['montantConsommation']?></td>
        </tr>
        <tr>
            <td height="8"></td>
        </tr>
        <tr>
            <td class="border" align="center">Montant <br> Versé</td>
            <td class="border" align="center">Nom et  <br> Signature caissier</td>
            <td class="border" align="center">Date paiement</td>
            <td align="center" colspan="6">Mode paiement: Cash ou Orange Money (avec frais de retrait)</td>
        </tr>
        <tr>
            <td class="border" height="30"><?=$invoice['result']['montantVerse']?></td>
            <td class="border"><?=$admin['result']['name']?></td>
            <td class="border"></td>
            <td align="center" colspan="6"></td>
        </tr>
    </table>
</body>
</html>