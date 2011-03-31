<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
</head>
<body>
<center>

<?php echo form_open('login'); ?>

First Name: <input type="text" size="15" maxlength="50" name="firstname" value=""> <br>
Password: <input type="password" size="15" maxlength="50" name="password" value=""> <br>
<?php echo validation_errors(); ?>
<input type="submit" value="Login" />

</form>

</center>
</body>
</html>
