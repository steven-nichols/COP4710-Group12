<div id="sidebar">
<img class="profpic" src="<?php 
if(isset($picture))
    echo base_url()."pictures/users/".$picture;
else
    echo base_url()."pictures/users/"."default_user.jpg";
?>" width="175" />

<ul class="nav">
<li><?php echo anchor('login/logout', 'Log out'); ?></li>
<li><?php echo anchor('order', 'Shopping Cart'); ?></li>
<li><?php echo anchor('account', 'Accounts'); ?></li>
<li><?php echo anchor('item', 'Items'); ?></li>
<li><?php echo anchor('transaction', 'Transactions'); ?></li>
<li><?php echo anchor('inventory', 'Inventory'); ?></li>
<!--<li><?php echo anchor('history', 'History'); ?>-->
</li>
</ul>
</div>
