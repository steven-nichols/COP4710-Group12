<html>
<body>

<h1>Welcome, <?php echo $first_name; ?>!</h1>

<ul>
<li><?php echo anchor('login/logout', 'Log out'); ?></li>
<li><?php echo anchor('order', 'Place a transaction'); ?></li>
<li><?php echo anchor('account', 'Add/modify account'); ?></li>
</ul>

</body>
</html>
