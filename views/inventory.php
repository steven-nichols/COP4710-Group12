<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Current Inventory</title>

</head>
<body>
<table summary="">
<tr>

<td>
<?php include("menu.php"); ?>
</td>

<td>

<?php echo form_open('currentInventory'); ?>

<br>
<br>

<table summary="" border="1" id="itemList">

<tr>

<td>Item#</td>
<td>Purchase Location</td>
<td>Real Cost</td>
<td>Point Cost</td>
<td>Description</td>
<td>Quantity</td>

</tr>

<tr id="item0">
<td id="itemNumber0">12345</td>
<td id="purchaseLocation0">Walmart Website</td>
<td id="realCost0">0.50</td>
<td id="cost0">2</td>
<td id="description0">Something cool</td>
<td id="quantity0">6</td>
</tr>

<?php
   $itemTotal = 0;
	 
	 foreach($listitems as $listitem):
	    echo '<tr>';
			
			echo '<td id="itemNumber' . itemTotal . '">' . $listitem->itemNumber . '</td>';
			echo '<td id="purchaseLocation' . itemTotal . '">' . $listitem->purchaseLocation . '</td>';
			echo '<td id="realCost' . itemTotal . '">' . $listitem->realCost . '</td>';
			echo '<td id="cost' . itemTotal . '">' . $listitem->pointCost . '</td>';
			echo '<td id="description' . itemTotal . '">' . $listitem->description . '</td>';
			echo '<td id="quantity' . itemTotal . '">' . $listitem->quantity . '</td>';
			
			echo '</tr>';
			
	    itemTotal++;
	 endforeach;
?>

</table><br>

</form>
</td>

</tr>
</table>
</body>
</html>
