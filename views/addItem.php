<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Shopping Cart</title>
<script language="JavaScript" type="text/javascript">

var itemCount = 0;
var total = 0;

var descriptions = new Array();
var suppliers = new Array();
var supplierURLs = new Array();
var itemTypes = new Array();
var availables = new Array();
var minQtys = new Array();
var realCosts = new Array();
var pointCosts = new Array();
var qtys = new Array();
var modificationReasons = new Array();
var modificationDescriptions = new Array();

//Populates all the text boxes with the data corresponding to the item number
function addItem(itemNum)
{
	 document.getElementById('txtDescription').value = descriptions[itemNum];
	 document.getElementById('txtSupplier').value = suppliers[itemNum];
	 document.getElementById('txtSupplierURL').value = supplierURLs[itemNum];
	 document.getElementById('txtItemType').value = itemTypes[itemNum];
	 document.getElementById('txtAvailable').value = availables[itemNum];
	 document.getElementById('txtMinQuantity').value = minQtys[itemNum];
	 document.getElementById('txtRealCost').value = realCosts[itemNum];
	 document.getElementById('txtPointCost').value = pointCosts[itemNum];
	 document.getElementById('txtQuantity').value = qtys[itemNum];
	 document.getElementById('txtModificationReason').value = modificationReasons[itemNum];
	 document.getElementById('txtModificationDescription').value = modificationDescriptions[itemNum];
}
</script>

</head>
<body>
<table summary="">
<tr>

<td>
<?php include("menu.php"); ?>
</td>

<td>

<?php echo form_open('addItem'); ?>

<br>
<br>

<table summary="" border="1" id="itemList">
<tr>

<?php

$colNum = 0;
$curItem = 0;


foreach($listitems as $listitem){

if($colNum == 4)
{
   echo '</tr><tr>';
	 $colNum = 0;
}

//The onClick is what adds items to the invoice list
//The format is addItem(itemNumber, cost, description) the quantity is obtained via prompt
echo '<td><center><img src="';
if(file_exists($img_path.$listitem->picture))
    echo $img_path.$listitem->picture;
else 
    echo $img_path."default_image.gif";

echo '" height="128" width="128" onClick="modifyItem(' . $curItem . ')"/><br>' . $listitem->qty . '</center></td>';
$colNum++;

echo'<script language="JavaScript" type="text/javascript">';

echo 'descriptions[' . $curItem . '] = ' . $listitem->description . ";";
echo 'suppliers[' . $curItem . '] = ' . $listitem->supplier . ";";
echo 'supplierURLs[' . $curItem . '] = ' . $listitem->supplierurl . ";";
echo 'itemTypes[' . $curItem . '] = ' . $listitem->type . ";";
echo 'availables[' . $curItem . '] = ' . $listitem->available . ";";
echo 'minQtys[' . $curItem . '] = ' . $listitem->minqty . ";";
echo 'realCosts[' . $curItem . '] = ' . $listitem->realcost . ";";
echo 'pointCosts[' . $curItem . '] = ' . $listitem->pointcost . ";";
echo 'qtys[' . $curItem . '] = ' . $listitem->qty . ";";
#echo 'modificationReasons[' . $curItem . '] = ' . $listitem->modificationReason . ";";
#echo 'modificationDescriptions[' . $curItem . '] = ' . $listitem->modificationDescriptions . ";";

echo '</script>';
$curItem++;

}

?>

</tr>

<tr>
<td>
<input type="hidden" name="itemID"/>
Description: <input id="txtDescription" type="text" size="15" maxlength="50" name="description" value="" /><br>
Supplier: <input id="txtSupplier" type="text" size="15" maxlength="50" name="supplier" value="" /><br>
Supplier URL: <input id="txtSupplierURL" type="text" size="15" maxlength="50" name="supplierURL" value="" /><br>
Item Type: <input id="txtItemType" type="text" size="15" maxlength="50" name="itemType" value="" /><br>
Min Quantity: <input id="txtMinQuantity" type="text" size="15" maxlength="50" name="minQuantity" value="" /><br>
Real Cost: <input id="txtRealCost" type="text" size="15" maxlength="50" name="realCost" value="" /><br>
Point Cost: <input id="txtPointCost" type="text" size="15" maxlength="50" name="pointCost" value="" /><br>
Quantity: <input id="txtQuantity" type="text" size="15" maxlength="50" name="quantity" value="" /><br>
Available: <input id="txtAvailable" type="checkbox" name="available" value="1" checked /><br>
Modification Reason: <input id="txtModificationReason" type="text" size="15" maxlength="50" name="modificationReason" value="" /><br>
Modification Description: <input id="txtModifcationDescription" type="text" size="15" maxlength="50" name="modificationDescription" value="" /><br>
</td>
</tr>

</table><br>
<table summary="">
<tr>

<td width="65%"></td>
<td><input type="submit" name="modify" value="Modify/Add" /></td>
</tr>
</table>

</form>
</td>

</tr>
</table>
</body>
</html>
