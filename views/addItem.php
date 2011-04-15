<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $title; ?></title>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url().'css/style.css'; ?>' />
</head>
<body>
<?php include("header.php"); ?>
<?php include("menu.php"); ?>

<div id="content">
<h1><?php echo $title; ?></h1>

<?php echo form_open(); ?>

<?php echo validation_errors(); ?>

<fieldset>
<legend>Item Details</legend>
<table>
<tr>
<td>Description:</td>
<td><input id="txtDescription" type="text" size="15" maxlength="50" name="description" value="<?php if(isset($item['description'])) echo $item['description']; ?>" /></td>
</tr>
<tr>
<td>Supplier:</td>
<td><input id="txtSupplier" type="text" size="15" maxlength="50" name="supplier" value="<?php if(isset($item['supplier'])) echo $item['supplier']; ?>" /></td>
</tr>
<tr>
<td>Supplier URL:</td>
<td><input id="txtSupplierURL" type="text" size="15" maxlength="50" name="supplierURL" value="<?php if(isset($item['supplierurl'])) echo $item['supplierurl']; ?>" /></td>
</tr>
<tr>
<td>Supplier Part No.:</td>
<td><input id="txtPartNo" type="text" size="15" maxlength="50" name="partNo" value="<?php if(isset($item['partno'])) echo $item['partno']; ?>" /></td>
</tr>
<tr>
<td>Item Type:</td>
<td>
<select name="itemType">
<?php
foreach($itemtypes as $itemtype){
    select_write_option($itemtype, $itemtype);
}
?>
</select>
</td>
</tr>
<tr>
<td>Min Quantity:</td>
<td><input id="txtMinQuantity" type="text" size="15" maxlength="50" name="minQuantity" value="<?php if(isset($item['minqty'])) echo $item['minqty']; ?>" /></td>
</tr>
<tr>
<td>Real Cost:</td>
<td><input id="txtRealCost" type="text" size="15" maxlength="50" name="realCost" value="<?php if(isset($item['realcost'])) echo $item['realcost']; ?>" /></td>
</tr>
<tr>
<td>Point Cost:</td>
<td><input id="txtPointCost" type="text" size="15" maxlength="50" name="pointCost" value="<?php if(isset($item['pointcost'])) echo $item['pointcost']; ?>" /></td>
</tr>
<tr>
<td>Quantity:</td>
<td><input id="txtQuantity" type="text" size="15" maxlength="50" name="quantity" value="<?php if(isset($item['qty'])) echo $item['qty']; ?>" /></td>
</tr>
<tr>
<td>Picture:</td>
<td><input id="txtPicture" type="text" size="15" maxlength="50" name="picture" value="<?php if(isset($item['picture'])) echo $item['picture']; ?>"/></td>
</tr>
<tr>
<td>Available:</td>
<td><input id="txtAvailable" type="checkbox" name="available" value="1" checked /></td>
</tr>
</table>
</fieldset>

<fieldset>
<legend>Comments</legend>
<table>
<tr>
<td>Modification Reason:</td>
<td>
<select name="modificationReason">
<?php
foreach($modtypes as $modtype){
    select_write_option($modtype, $modtype);
}
?>
</select>
</td>
</tr>
<tr>
<td>Modification Description:</td>
<td><input id="txtModifcationDescription" type="text" size="15" maxlength="50" name="modificationDescription" value="" /></td>
</td>
</tr>
</table>
</fieldset>

<br>
<table summary="">
<tr>

<td width="65%"></td>
<td><input type="submit" name="modify" value="Modify/Add" /></td>
</tr>
</table>

</form>

</div>

<?php include("footer.php"); ?>
</body>
</html>
