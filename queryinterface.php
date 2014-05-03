<?php
/*
Contributor:       Zeeshan Khan
Plugin Name:       Query Interface
Plugin URI:        http://www.queryinn.com/
Description:       A query interface, where you dont need to log in to your database explicitly like cpanel, but write & execute queries within wordpress admin panel.
Author:            Zeeshan Khan
Author URI:        http://www.queryinn.com/index.php/about/
Version:           1.1
*/

if(!function_exists('is_admin'))
{
	die();
}

if (is_admin())
{
/* Call the html code */
       add_action('admin_menu', 'queryinterface_admin_menu');

       function queryinterface_admin_menu()
       {
               add_options_page('Query Interface', 'Query Interface', 'administrator', 'query-interface', 'queryinterface_func');
       }
}
function view_fields(){
	global $wpdb;
	$table = $_GET["val"];
	// include("config.php");
	$sql = "SHOW FIELDS FROM ".$table;
	$rs = mysql_query($sql) or die(mysql_error());
	$fields = array();
	while($row = mysql_fetch_array($rs))
	{
		$fields[] = $row[0];
	}
?>
	<div class="td_head">Fields</div>
	<div>
		<select name="fields" id="fields" multiple="true" style='height: 150px;'>
			<?php foreach($fields as $fld) { ?>
				<option value="<?php echo $fld?>"><?php echo $fld?></option>
			<?php } ?>
		</select>
	</div>
<?php

exit;

}

add_action( 'wp_ajax_view_fields', 'view_fields' );
add_action( 'wp_ajax_nopriv_view_fields', 'view_fields' );

function queryinterface_func()
{
       include("qi.php");
}