<html>
<head>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
</head>
<body>
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">
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

<!-- Hidden post field to let the form validator on the modify page
know not to run validation immediately. //-->
<input type="hidden" name="redirect" value="true"/>

<input type="submit" value="Modify"/>
</p>
<?php echo form_close(); ?>
</div>

<?php include("footer.php"); ?>

</body>
</html>
