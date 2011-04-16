<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Checkout</title>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
<script language="JavaScript" type="text/javascript">
var total = 0;
var itemCount = 1;

//Iterates through all items in the invoice list and updates the running total appropriately
function updateTotal()
{
   var i = 0;
	 total = 0;
	 
	 for(i = 0; i < itemCount; i++)
	 {
			total += (parseInt(document.getElementById('cost' + i).innerHTML) * parseInt(document.getElementById('quantity' + i).innerHTML));
	 }
   document.getElementById('totalCost').innerHTML = "Total Cost: " + total;
}


//Checks the money entered in the Money Box and subtracts the total
//Updates Change Due
function updateChange()
{
   updateTotal();
	 var money = document.getElementById('txtMoney').value;
	 var changeDue = money - total;
   document.getElementById('changeText').innerHTML = "Change Due: " + changeDue;
}

</script>

</head>
<body>
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">
<?php echo form_open('order/process'); ?>

Buyer: <?php echo "user for transaction";?>

<br>
<br>

<table summary="" border="1" id="itemList">

<tr>

<td>Item#</td>
<td>Quantity</td>
<td>Cost</td>
<td>Description</td>

</tr>

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

    echo '<td id="itemNumber' . $itemTotal . '">' . $listitem['itemid'] . '</td>';
    echo '<td id="quantity' . $itemTotal . '">' . $listitem['qty'] . '</td>';
    echo '<td id="cost' . $itemTotal . '">' . $listitem['pointCost'] . '</td>';
    echo '<td id="description' . $itemTotal . '">' . $listitem['description'] . '</td>';

    echo '<input type="hidden" name="itemNumber' . $itemTotal . '" value="' . $listitem['itemid'] . '" />';
    echo '<input type="hidden" name="quantity' . $itemTotal . '" value="' . $listitem['qty'] . '" />';
    echo '<input type="hidden" name="cost' . $itemTotal . '" value="' . $listitem['pointCost'] . '" />';

    echo '</tr>';

    $itemTotal++;
}

echo '<input type="hidden" name="userID" value="'. $userID .'"/>';
echo '<input type="hidden" name="itemTotal" value="'. $itemTotal .'"/>';
echo '<input type="hidden" name="totalCost" value="'. $totalcost .'"/>';
echo '<script type="text/javascript">itemCount = ' . $itemTotal . ';</script>';
?>

</table><br>
<table summary="">
<tr>
<td id="totalCost">Total Cost: <?php echo $totalcost; ?></td>
</tr>
<br>

<tr>
<td>Money Given: <input id="txtMoney" type="text" size="15" maxlength="50" name="money" value="" onKeyUp="updateChange();" onChange="updateChange();" onBlur="updateChange();" onFocus="updateChange();"></td>
</tr>
<br>

<tr>
<td id="changeText">Change Due: 0</td>
</tr>
<br>

<tr>
<td><input type="submit" name="confirm" value="Confirm" /> / <input type="submit" name="cancel" value="Cancel" /></td>
</tr>
<br>

</table>

</form>
</div>

<?php include("footer.php"); ?>
</body>
</html>
