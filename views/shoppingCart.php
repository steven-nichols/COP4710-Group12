<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Shopping Cart</title>
<script language="JavaScript" type="text/javascript">
var itemCount = 0;
var total = 0;

//Adds an item to the invoice list
//Takes in itemNum, cost, and description
//The quantity for the items to be added are decided via prompt dialog box
function addItem(itemNum, cost, descrp)
{
   var quantity = prompt('How many are being purchased?', '1');
   var tempStr = "<tr id=\"item" + itemCount + "\">";
	 tempStr += "<td id=\"itemNumber" + itemCount + "\">" + itemNum + "</td>";
	 tempStr += "<td id=\"quantity" + itemCount + "\">" + quantity + "</td>";
	 tempStr += "<td id=\"cost" + itemCount + "\">" + cost + "</td>"
	 tempStr += "<td id=\"description" + itemCount + "\">" + descrp + "</td>"
	 tempStr += "</tr>"
	 
   document.getElementById("itemList").innerHTML += tempStr;
	 
	 itemCount++;
	 
	 updateTotal();
}

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

<?php echo form_open('shoppingCart'); ?>

Select Buyer:
<select>

<?php foreach($users as $user): ?>
<?php echo '<option value="' . $user->lname . $user->fname . '">'; ?>
<?php echo $user->lname . ', ' $user->fname; ?>
<?php echo '</option>'; ?>
<?php endforeach; ?>

</select>

<br>
<br>

<table summary="" border="1" id="itemList">
<tr>

<?php

$colNum = 0;

foreach($listitems as $listitem):

if(colNum == 4)
{
   echo '</tr><tr>';
	 colNum = 0;
}

//The onClick is what adds items to the invoice list
//The format is addItem(itemNumber, cost, description) the quantity is obtained via prompt
echo '<td><center><img src="' . $listitem->image . '" height="128" width="128" onClick="addItem(1, 2, \'really cool\')"/><br>' . $listitem->quantity . '</center></td>';
colNum++;

endforeach;

?>

<!---- These need to be removed after real images are being queried // -->
<td><center><img src="defaultitem.jpg" height="128" width="128" onClick="addItem(1, 2, 'really cool')" /><br>2</center></td>
<td><center><img src="defaultitem.jpg" height="128" width="128" onClick="addItem(2, 2, 'really cool')" /><br>1</center></td>
<td><center><img src="defaultitem.jpg" height="128" width="128" onClick="addItem(3, 2, 'really cool')" /><br>4</center></td>
<td><center><img src="defaultitem.jpg" height="128" width="128" onClick="addItem(4, 2, 'really cool')" /><br>1</center></td>

</tr>

<tr>

<td>Item#</td>
<td>Quantity</td>
<td>Cost</td>
<td>Description</td>

</tr>

</table><br>
<table summary="">
<tr>

<td id="totalCost">Total Cost: 0</td>

<td width="65%"></td>
<td><input type="submit" value="Checkout" /></td>
</tr>
</table>

</form>
</td>

</tr>
</table>
</body>
</html>
