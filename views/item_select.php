<html>
<head>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
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
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">
<h1>Add/Modify Items</h1>


<?php echo form_open('item/add'); ?>
<p>You may add a new item to the database here</p>
<p><input type="submit" value="Add New"/></p>
<?php echo form_close(); ?>


<?php echo form_open('item/modify'); ?>
<p>To modify an existing item, click on any of the items listed below.</p>

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
echo '<td><center><a href="'.site_url('item/modify/'.$listitem->itemID).'"><img src="';
echo $img_path.$listitem->picture;
echo '" height="128" width="128" onClick="modifyItem(' . $curItem . ')"/></a><br>' . $listitem->qty . '</center></td>';
$colNum++;

echo'<script language="JavaScript" type="text/javascript">';

echo 'itemID[' . $curItem . '] = ' . $listitem->itemID . ";";
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
</table>

</div>

<?php include("footer.php"); ?>
</body>
</html>
