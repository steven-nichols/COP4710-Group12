<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Transaction History</title>

<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
</head>
<body>
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">

<?php echo form_open('transactionHistory'); ?>

Child: 
<select>
<?php 
foreach($users as $user){
    echo '<option value="' . $user['userID'] .'">';
    echo $user['last_name'] . ', ' . $user['first_name'];
    echo '</option>';
}
?>
</select>

<input type="submit" name="getHistory" value="Get History" />

<br>
<br>


<?php 
$itemTotal = 0;
foreach($transactions as $transaction){
    $itemTotal = 0;

    echo 'Date: ' . $transaction->date . '<br>';
    echo 'Child: ' . $transaction->userID . '<br>';
    echo '<table summary="" border="1" id="itemList">';

    echo '<tr>';

    echo '<td>Item#</td>';
    echo '<td>Point Cost</td>';
    echo '<td>Quantity</td>';
    //echo '<td>Description</td>';

    echo '</tr>';

    foreach($transaction->items as $item){
        echo '<tr>';

        echo '<td id="itemNumber' . $itemTotal . '">' . $item->itemID . '</td>';
        //echo '<td id="purchaseLocation' . $itemTotal . '">' . $item->purchaseLocation . '</td>';
        //echo '<td id="realCost' . $itemTotal . '">' . $item->realCost . '</td>';
        echo '<td id="cost' . $itemTotal . '">' . $item->salePrice . '</td>';
        //echo '<td id="description' . $itemTotal . '">' . $item->description . '</td>';
        echo '<td id="quantity' . $itemTotal . '">' . $item->qty . '</td>';

        echo '</tr>';

        $itemTotal++;
    }

    echo '</table><br>';
    echo '<br>';
    echo '<hr>';
    echo '<br>';
}
?>

</form>

</div>
<?php include("footer.php"); ?>
</body>
</html>
