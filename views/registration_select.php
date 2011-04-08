<html>
<head>
</head>
<body>

<h1>Add/Modify Users</h1>

<?php echo form_open('account/add'); ?>
<p>You may add a new user to the database here</p>
<p><input type="submit" value="Add New"/></p>
<?php echo form_close(); ?>


<?php echo form_open('account/modify'); ?>
<p>To modify an existing user, select their name from the dropdown box below and click "modify".</p>
<p>
<select name="userid">
<?php foreach ($users as $user): ?>

<option value="<?php echo $user['userID']; ?>">
<?php echo $user['first_name']." ".$user['last_name']; ?>
</option>

<?php endforeach; ?>
</select>

<input type="submit" value="Modify"/>
</p>
<?php echo form_close(); ?>

</body>
</html>
