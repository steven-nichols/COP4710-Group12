<div id="sidebar">
<img src="<?php 
if(isset($picture))
    echo base_url()."pictures/users/".$picture;
else
    echo base_url()."pictures/users/"."default_user.jpg";
?>" width="175" /> <br>

<ul class="nav">
<li><?php echo anchor('login/logout', 'Log out'); ?></li>
<li><?php echo anchor('account', 'Accounts'); ?></li>
<li><?php echo anchor('history', 'History'); ?></li>
<li><?php echo anchor('shoppingCart', 'Shopping Cart'); ?></li>
<li><?php echo anchor('item', 'Items'); ?></li>
<li><?php echo anchor('transaction', 'Transactions'); ?></li>
<li><?php echo anchor('currentInventory', 'Inventory'); ?></li>
</ul>
</div>
