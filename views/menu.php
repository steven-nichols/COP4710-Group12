<img src="<?php 
if(isset($picture))
    echo $picture;
else
    echo "defaultuser.jpg";
?>" height="256" width="256" /> <br>

<?php
echo anchor('login/logout', 'Log out') . '<br>';
echo anchor('account', 'View/Modify Profile') . '<br>';
echo anchor('history', 'View History') . '<br>';
echo anchor('order', 'Shopping Cart') . '<br>';
echo anchor('mod_item', 'Add/Modify Item') . '<br>';
echo anchor('view_transaction', 'View Transaction History') . '<br>';
echo anchor('view_trans_date', 'View History of Transactions for a Date Range') . '<br>';
echo anchor('inventory', 'View Current Inventory') . '<br>';
?>