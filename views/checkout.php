<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Checkout</title>
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
<table summary="">
<tr>

<td>
<img src="defaultuser.jpg" height="256" width="256" /> <br>
<a href="mainPage.htm">Logout</a><br>
<a href="mainPage.htm">View/Modify Profile</a><br>
<a href="mainPage.htm">View History</a><br>
<a href="mainPage.htm">Shopping Cart</a><br>
</td>

<td>

<?php echo form_open('checkout'); ?>

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

<tr id="item0">
<td id="itemNumber0">12345</td>
<td id="quantity0">6</td>
<td id="cost0">2</td>
<td id="description0">Something cool</td>
</tr>

<?php
   $itemTotal = 0;
	 
	 foreach($listitems as $listitem):
	    echo '<tr>';
			
			echo '<td id="itemNumber' . itemTotal . '"></td>';
			echo '<td id="quantity' . itemTotal . '"></td>';
			echo '<td id="cost' . itemTotal . '"></td>';
			echo '<td id="description' . itemTotal . '"></td>';
			
			echo '</tr>';
			
	    itemTotal++;
	 endforeach;
	 
	 echo '<script type=”text/javascript”>itemCount = ' . itemTotal . ';</script>';
?>

</table><br>
<table summary="">
<tr>
<td id="totalCost">Total Cost: 0</td>
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
<td><input type="submit" value="Confirm" /> / <input type="submit" value="Cancel" /></td>
</tr>
<br>

</table>

</form>
</td>

</tr>
</table>
</body>
</html>
