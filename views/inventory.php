<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Current Inventory</title>

<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
</head>
<body>
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">
<h1>Inventory</h1>
<?php echo form_open('currentInventory'); ?>

<table summary="" border="1" id="itemList">

<tr>

<td>Item#</td>
<td>Purchase Location</td>
<td>Real Cost</td>
<td>Point Cost</td>
<td>Description</td>
<td>Quantity</td>


<?php
$itemTotal = 0;
$bg = "ltrow";

foreach($listitems as $listitem){
    //Alternates row color background via css
    if($itemTotal % 2 == 0)
		   $bg = "ltrow";
		else
		   $bg = "dkrow";
		
		echo '<tr id="' . $bg . '">';

    echo '<td id="itemNumber' . $itemTotal . '">' . $listitem->partno . '</td>';
    echo '<td id="purchaseLocation' . $itemTotal . '">' . $listitem->supplierurl . '</td>';
    echo '<td id="realCost' . $itemTotal . '">' . $listitem->realcost . '</td>';
    echo '<td id="cost' . $itemTotal . '">' . $listitem->pointcost . '</td>';
    echo '<td id="description' . $itemTotal . '">' . $listitem->description . '</td>';
    echo '<td id="quantity' . $itemTotal . '">' . $listitem->qty . '</td>';

    echo '</tr>';

    $itemTotal++;
}
?>

</table><br>

</form>
</div>
<?php include("footer.php"); ?>
</body>
</html>
