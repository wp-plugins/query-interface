<script type="text/javascript">				
			 
function embed_value(val)
{
	jQuery.ajax({
		type: 'GET',
		dataType: 'html',
		url: ajaxurl,
		data: {"action": "view_fields", "val" : val},
		success: function(data)
		{
			jQuery('#fields_div').html(data);
		}
	});
	return false;
}
<?php
$sql = "SHOW TABLES";
$rs = mysql_query($sql);
$tables = array();
while($row = mysql_fetch_array($rs))
{
	$tables[] = $row[0];
}
?>
</script>
<form name="qi" id="qi" method="post">
	<table align="center">
		<tr>
			<td align="center"><strong>Tables</strong></td>
			<td align="center"><strong>Query</strong></td>
		</tr>
		<tr>
			<td valign="top">
				<select name="tables" id="tables" multiple="true" ondblclick="embed_value(this.value)" style='height: 150px;'>
					<?php foreach($tables as $tbl)
					{
						$selected = "";
						if(isset($_POST["tables"]) && $_POST["tables"] == $tbl)
						{
							$selected = " selected = 'selected' ";
						}
					?>
						<option value="<?php echo $tbl?>" <?php echo $selected?>><?php echo $tbl?></option>
					<?php } ?>
				</select>
				<br>
				<div id="fields_div" width="100%"></div> 
			</td>
			<td>
				<div>
					<textarea style="width: 450px; height: 300px;" id="query" name="query"><?php echo $_POST["query"]?></textarea>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input name="submit" type="submit" value="Submit" /></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</form>
<?php
if($_POST)
{
	$sql = $_POST["query"];
	$rs = mysql_query($sql);
	$num_fields = mysql_num_fields($rs);
	for($i=0; $i<$num_fields; $i++)
		$fields[] = mysql_field_name($rs,$i);
	// $sql = $_POST["query"];
	// $rs = mysql_query($sql);
	if(mysql_error())
	{
		echo mysql_error();
	}
	else
	{
		?> <table align="center" border=1>
			<tr>
			<?php
			foreach($fields as $fld)
			{
				?>
					<td align="center"><strong><?php echo $fld?></strong></td>
				<?php
			}
			?> </tr> <?php
		$sql = $_POST["query"];
		$rs = mysql_query($sql) or die(mysql_error());
		$total_rows = mysql_num_rows($rs);
		while($row = mysql_fetch_array($rs))
		{
		?>
			<tr>
		<?php
			for($i=0; $i<$num_fields; $i++)
			{
				?>
					<td align="center"><?php echo $row[$i]?></td>
			<?php } ?>
			</tr>
	<?php
		}
	?>
		<tr>
			<td colspan="<?php echo $num_fields?>"><strong>Total rows: <strong><?php echo $total_rows?></td>
		</tr>
	<?php
	}
}
?>
</table>
