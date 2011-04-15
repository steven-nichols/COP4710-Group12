<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Shopping Cart</title>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
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
	 tempStr += "<td id=\"cost" + itemCount + "\">" + cost + "</td>";
	 tempStr += "<td id=\"description" + itemCount + "\">" + descrp + "</td>";
	 
	 //This is an update to allow the data to be accessed by the PHP
	 //Hidden fields are generated with the appropriate data
	 tempStr += "<input type=\"hidden\" name=\"HitemNumber" + itemCount + "\" value=\"" + itemNum + "\"></input>";
	 tempStr += "<input type=\"hidden\" name=\"Hquantity" + itemCount + "\" value=\"" + quantity + "\"></input>";
	 tempStr += "<input type=\"hidden\" name=\"Hcost" + itemCount + "\" value=\"" + cost + "\"></input>";
	 tempStr += "<input type=\"hidden\" name=\"Hdescription" + itemCount + "\" value=\"" + descrp + "\"></input>";
	 tempStr += "</tr>";
	 
   document.getElementById("itemList").innerHTML += tempStr;
	 
	 itemCount++;
	 document.getElementById("itemsTotal").value = itemCount;
	 
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
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">

<?php echo form_open('order/checkout'); ?>

<input type="hidden" name="itemsTotal" id="itemsTotal" value="0"></input>

Select Buyer:
<select name="userID">

<?php
foreach($users as $user){ 
    echo '<option value="' . $user['userID'] . '">';
    echo $user['last_name'] . ', ' . $user['first_name'];
    echo '</option>'; 
}
?>

</select>

<br>
<br>

<table summary="" border="1" id="itemList">
<tr>

<?php

$colNum = 0;

foreach($listitems as $listitem){

    if($colNum == 4)
    {
        echo '</tr><tr>';
        $colNum = 0;
    }

    //The onClick is what adds items to the invoice list
    //The format is addItem(itemNumber, cost, description) the quantity is obtained via prompt
    echo '<td><center><img src="' . base_url().'pictures/items/'.$listitem->picture;
    echo '" height="128" width="128" onClick="addItem(';
    echo $listitem->itemID.', '. $listitem->pointcost .', ';
    echo '\''. $listitem->description .'\')"/><br>' . $listitem->qty . '</center></td>';
    $colNum++;

}
?>
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
<td><input type="submit" name="checkout" value="Checkout" /></td>
</tr>
</table>
</form>
</div>

<?php include("footer.php"); ?>
</body>
</html>
