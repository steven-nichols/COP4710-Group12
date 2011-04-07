<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Transaction History</title>

</head>
<body>
<table summary="">
<tr>

<td>
<?php include("menu.php"); ?>
</td>

<td>

<?php echo form_open('transactionHistory'); ?>

Child: 
<select>
<?php 
	 foreach($users as $user):
	    echo '<option value="' . $user->lname . $user->fname . '">';
			echo $user->lname . ', ' . $user->fname;
			echo '</option>';
	 endforeach;
?>
</select>

<input type="submit" name="getHistory" value="Get History" />

<br>
<br>


<?php 
	 $itemTotal = 0;
	 foreach($transactions as $transaction):
	    itemTotal = 0;
			
	    echo 'Date: ' . $transaction->date . '<br>';
			echo '<table summary="" border="1" id="itemList">';
			
			echo '<tr>';
			
			echo '<td>Item#</td>';
			echo '<td>Point Cost</td>';
			echo '<td>Quantity</td>';
			echo '<td>Description</td>';
			
			echo '</tr>';
			
	    foreach($transaction->items as $item):
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
			
			echo '</table><br>';
			echo '<br>';
			echo '<hr>';
			echo '<br>';
	 endforeach;
?>

</form>
</td>

</tr>
</table>
</body>
</html>
