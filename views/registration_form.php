<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
<script language="JavaScript" src="<?php echo base_url(); ?>javascript/CalendarPopup.js"></script>
    <script language="JavaScript" id="js1">
        var cal = new CalendarPopup();
    </script>
</head>
<body>

<table summary="">
<tr>

<td>
<?php include("menu.php"); ?>
</td>

<td>
<h1>Register</h1>

<?php echo form_open(''); ?>

<!-- Not sure if this will be needed or not //-->
<input type="hidden" name="userid" value="<?php if(isset($userID)) echo $userID; ?>">

<table class="input-form">
    <tr>
        <th class="required">First Name</th>
        <td><input type="text" size="15" maxlength="50" name="first_name" 
        value="<?php 
if(isset($userID))
    echo $first_name;
else
    echo set_value('first_name');
?>"></td>
    </tr>
    <?php echo form_error('first_name'); ?>

    <tr>
        <th>Last Name</th>
        <td><input type="text" size="15" maxlength="50" name="last_name" 
            value="<?php 
if(isset($userID))
    echo $last_name;
else
    echo set_value('last_name');
?>"></td>
    </tr>

    <tr>
        <th>Picture (optional)</th>
        <td><input type="text" size="15" maxlength="50" name="picture" 
        value="<?php 
if(isset($userID))
    echo $picture;
else
    echo set_value('picture');
?>"></td>
    </tr>

    <tr>
        <th class="required">Birth date</th>
        <td>
            <input id="date1" type="text" size="11" maxlength="100" 
                name="birthdate" value="<?php 
if(isset($_POST['birthdate'])){
    echo set_value('birthdate');
}
elseif(isset($userID)){
    echo $birthdate;
}
else {
    echo "mm/dd/yyyy";
} ?>">
            <a href="#" onClick="cal.select(document.forms[0].date1,'anchor1','MM/dd/yyyy'); return false;" title="cal.select(document.forms[0].date1,'anchor1','MM/dd/yyyy'); return false;" name="anchor1" id="anchor1">select</a>
        </td>
    </tr>



    <?php echo form_error('valid_date'); ?>

    <tr>
        <th class="required">Password</th>
        <td><input type="password" size="15" maxlength="50" name="password" 
            value="<?php echo set_value('password'); ?>"></td>
    </tr>
    <?php echo form_error('password'); ?>

    <tr>
        <th class="required">Confirm Password</th>
        <td><input type="password" size="15" maxlength="50" name="pass_conf" 
            value="<?php echo set_value('pass_conf'); ?>"></td>
    </tr>
    <?php echo form_error('pass_conf'); ?>

    <tr>
        <th>User type</th>
        <td><select name="user_type">
<?php 
function write_option($value, $label, $default){
    echo '<option value="'.$value.'"';
    if(($default == $value) || (set_value('type') == $value))
        echo ' selected="yes"';
    echo '>'.$label."</option>\n";
}
?>
            <?php write_option('child', 'Child', $type); ?>
            <?php write_option('teen', 'Teen', $type); ?>
            <?php write_option('adult', 'Adult', $type); ?>
            <?php write_option('trusted', 'Trusted', $type); ?>
            </select>
</td>
    </tr>

    <tr>
        <th>Active</th>
        <td><input type="checkbox" size="15" maxlength="50" name="active" 
        value="true" <?php 
if( (!isset($userID)) || (isset($userID) && $active) )
    echo "checked";
?>></td>
    </tr>

</table>
<p>* Required</p>
<input type="submit" value="Submit" />

</form>
</td>
</table>
</body>
</html>
