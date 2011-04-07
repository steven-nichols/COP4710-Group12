<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Transaction Range</title>

</head>
<body>
<table summary="">
<tr>

<td>
<?php include("menu.php"); ?>
</td>

<td>

<?php echo form_open('transactionRange'); ?>

<br>
<br>

<table summary="" border="1" id="itemList">

<tr>
Start Date: <input id="startDate" type="text" size="15" maxlength="50" name="startDate" value="MM/DD/YYYY" / >
End Date: <input id="endDate" type="text" size="15" maxlength="50" name="endDate" value="MM/DD/YYYY" / >
<input type="submit" name="getHistory" value="Get History" />
</tr>

<tr>

<td>Item#</td>
<td>Point Cost</td>
<td>Quantity</td>
<td>Description</td>
<td>Real Cost</td>

</tr>

<tr id="item0">
<td id="itemNumber0">12345</td>
<td id="cost0">2</td>
<td id="quantity0">6</td>
<td id="description0">Something cool</td>
<td id="realCost0">0.50</td>
</tr>

<?php
   $itemTotal = 0;
	 
	 foreach($listitems as $listitem):
	    echo '<tr>';
			
			echo '<td id="itemNumber' . itemTotal . '">' . $listitem->itemNumber . '</td>';
			echo '<td id="cost' . itemTotal . '">' . $listitem->pointCost . '</td>';
			echo '<td id="quantity' . itemTotal . '">' . $listitem->quantity . '</td>';
			echo '<td id="description' . itemTotal . '">' . $listitem->description . '</td>';
			echo '<td id="realCost' . itemTotal . '">' . $listitem->realCost . '</td>';
			
			echo '</tr>';
			
	    itemTotal++;
	 endforeach;
?>

<tr>
<td>Total Unique Purchasers: <?php echo $uniquePurchasers; ?></td>
<td>Total Funny Money Spent: <?php echo $pointsSpent; ?></td>
<td>Real Money Spent: <?php echo $moneySpent; ?></td>
</tr>

</table><br>

</form>
</td>

</tr>
</table>
</body>
</html>
