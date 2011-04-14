<img src="<?php 
if(isset($picture))
    echo $picture;
else
    echo "http://www.makefive.com/media/images/placeholder/default_user.jpg";
?>" height="256" width="256" /> <br>

<?php
echo anchor('login/logout', 'Log out') . '<br>';
echo anchor('account', 'View/Modify Profile') . '<br>';
echo anchor('history', 'View History') . '<br>';
echo anchor('shoppingCart', 'Shopping Cart') . '<br>';
echo anchor('item/add', 'Add/Modify Item') . '<br>';
echo anchor('transaction', 'View Transaction History') . '<br>';
echo anchor('transaction/date', 'View History of Transactions for a Date Range') . '<br>';
echo anchor('currentInventory', 'View Current Inventory') . '<br>'; 
?>
