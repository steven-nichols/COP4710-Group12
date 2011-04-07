<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Master Inventory</title>
</head>

<body>
<table summary="no table summary for now...">
<tr>

<td>
<img src="<?php echo $userImage?>" height="256" width="256" /> <br>
<?php
echo anchor('logout_view', 'Logout')<br>
echo anchor('', 'View/Modify Profile')<br>
echo anchor('', 'View History')<br>
echo anchor('shoppingCart', 'Shopping Cart')<br>
?>
</td>

<td>

<table cellpadding="6" cellspacing="1" style="width:100%" border="0">
<tr> 
	<th>Item Number:</th>
 	<th>Quantity:</th>
	<th>Description:</th>
	<th>Real Cost:</th>
 	<th>Point Cost:</th>
	<th>Quantity:</th>
	<th>Supplier:</th>
 	<th>Supplier URL:</th>
	<th>Item Type:</th>
 	<th>Availability:</th>
	<th>Real Cost:</th>
</tr>

<?php foreach $listItems->result() as $listItem
echo '</tr><tr>';
<td>echo $listItem->id;</td>
<td>echo $listItem->available;</td>
<td>echo $listItem->pointCost;</td>
<td>echo $listItem->realCost;</td>
endforeach; ?>

</tr>
</table>
</body>
</html>

