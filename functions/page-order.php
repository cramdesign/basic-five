<?php
/*
Plugin Name: My Page Order
Description: Based on My Page Order plugin version 3.3.2 http://wordpress.org/plugins/my-page-order/
*/

function mypageorder_menu() {    
	add_pages_page('Sort Pages', 'Sort Pages', 'edit_pages', 'mypageorder', 'mypageorder');
}

function mypageorder_js_libs() {
	if ( isset($_GET['page']) && $_GET['page'] == "mypageorder" ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
	}
}

add_action('admin_menu', 'mypageorder_menu');
add_action('admin_print_scripts', 'mypageorder_js_libs');



function mypageorder() {

global $wpdb;
$parentID = 0;

if (isset($_POST['btnSubPages'])) { 
	$parentID = $_POST['pages'];
}
elseif (isset($_POST['hdnParentID'])) { 
	$parentID = $_POST['hdnParentID'];
}

if (isset($_POST['btnReturnParent'])) { 
	$parentsParent = $wpdb->get_row( $wpdb->prepare("SELECT post_parent FROM $wpdb->posts WHERE ID = %d ", $_POST['hdnParentID'] ), ARRAY_N);
	$parentID = $parentsParent[0];
}

$success = "";
if (isset($_POST['btnOrderPages'])) { 
	$success = mypageorder_updateOrder();
}

$subPageStr = mypageorder_getSubPages($parentID);
?>

<div class='wrap'>
<form name="frmMyPageOrder" method="post" action="">

	<h2>Sort Pages</h2>
	
	<?php echo $success; ?>
	
	<p>Choose a page from the drop down to order its subpages or order the pages on this level by dragging and dropping them into the desired order.</p>
	
	<?php if($subPageStr != "") : ?>
	
		<h3>Sort Subpages</h3>
		<select id="pages" name="pages"><?php echo $subPageStr; ?></select>
		<input type="submit" name="btnSubPages" class="button" id="btnSubPages" value="<?php _e('View Subpages', 'mypageorder') ?>" />
	
	<?php endif; ?>

	<h3>Current Pages - <?php echo get_the_title( $parentID ); ?></h3>
	
	<ul id="page_list">
		<?php $results = mypageorder_pageQuery($parentID); ?>
		<?php foreach($results as $row) : ?><li id="id_<?php echo $row->ID; ?>" class="menu-item">
        	<div class="item">
				<div class="thumb"><?php echo get_the_post_thumbnail( $row->ID, array(35,35) ); ?></div>
				<div class="title"><?php echo __($row->post_title); ?></div>
        	</div>
		</li><?php endforeach; ?>
	</ul>

	<input type="submit" name="btnOrderPages" id="btnOrderPages" class="button-primary" value="Save Page Order" onclick="javascript:orderPages(); return true;" />
	<?php echo mypageorder_getParentLink($parentID); ?>
	<strong id="updateText"></strong>
	<input type="hidden" id="hdnMyPageOrder" name="hdnMyPageOrder" />
	<input type="hidden" id="hdnParentID" name="hdnParentID" value="<?php echo $parentID; ?>" />
	
</form>
</div>

<style type="text/css">

#page_list {
	overflow-x: hidden;
	border: 1px solid #bbb; 
	margin: 1em 0;
	padding: 1em;
	list-style: none;
	background-color: #fff;
}

#page_list .menu-item {
	box-sizing:border-box;
	-moz-box-sizing:border-box;
	-webkit-box-sizing:border-box;

	padding: 1em;
	margin: 0;
	width: 180px;
	display: inline-block;
	vertical-align: top;
	text-align: center;
}

#page_list .menu-item .item {
	cursor: move;
	border: 1px solid #ccc;
	background: #fafafa;
	overflow: hidden;
}

#page_list .sortable-placeholder{ 
	box-sizing:border-box;
	-moz-box-sizing:border-box;
	-webkit-box-sizing:border-box;

	display: inline-block;
	width: 180px;
	padding: 1em 0;
	margin: 0;
}

#page_list .menu-item.ui-sortable-helper .item {
	box-shadow: 0 0 1em rgba(0,0,0,0.2);
}

#page_list .thumb {
	border-bottom: 1px solid #ccc;
	width: 100%;
	padding-top: 100%;
	overflow: hidden;
	position: relative;
	background: #ddd;
}

#page_list .thumb img {
	width: 100%;
	height: auto;
	position: absolute;
	top: 0;
	left: 0;
}

#page_list .title {
	padding: 1em;
}

</style>

<script type="text/javascript">
// <![CDATA[

	function mypageorderaddloadevent(){
		jQuery("#page_list").sortable({ 
			placeholder: "sortable-placeholder", 
			forcePlaceholderSize: true,
			revert: false,
			tolerance: "pointer" 
		});
	};

	addLoadEvent(mypageorderaddloadevent);
	
	function orderPages() {
		jQuery("#updateText").html("Updating Page Order...");
		jQuery("#hdnMyPageOrder").val(jQuery("#page_list").sortable("toArray"));
	}

// ]]>
</script>
<?php
}

//Switch page target depending on version
function mypageorder_getTarget() {
	global $wp_version;
	if (version_compare($wp_version, "2.999", ">"))
		return "edit.php?post_type=page&page=mypageorder";
	else
		return "edit-pages.php?page=mypageorder";
}

function mypageorder_updateOrder()
{
	if (isset($_POST['hdnMyPageOrder']) && $_POST['hdnMyPageOrder'] != "") { 
		global $wpdb;

		$hdnMyPageOrder = $_POST['hdnMyPageOrder'];
		$IDs = explode(",", $hdnMyPageOrder);
		$result = count($IDs);

		for($i = 0; $i < $result; $i++)
		{
			$str = str_replace("id_", "", $IDs[$i]);
			$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET menu_order = %d WHERE id = %d ", $i, $str));
		}

		return '<div id="message" class="updated fade"><p>Page order updated successfully.</p></div>';
		
	} else {
	
		return '<div id="message" class="updated fade"><p>An error occured, order has not been saved.</p></div>';
		
	}
}

function mypageorder_getSubPages($parentID)
{
	global $wpdb;
	
	$subPageStr = "";
	$results = mypageorder_pageQuery($parentID);
	foreach($results as $row)
	{
		$postCount=$wpdb->get_row($wpdb->prepare("SELECT count(*) as postsCount FROM $wpdb->posts WHERE post_parent = %d and post_type = 'page' AND post_status != 'trash' AND post_status != 'auto-draft' ", $row->ID) , ARRAY_N);
		if($postCount[0] > 0)
	    	$subPageStr = $subPageStr."<option value='$row->ID'>".__($row->post_title)."</option>";
	}
	return $subPageStr;
}

function mypageorder_pageQuery($parentID)
{
	global $wpdb;
	return $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_parent = %d and post_type = 'page' AND post_status != 'trash' AND post_status != 'auto-draft' ORDER BY menu_order ASC", $parentID) );
}

function mypageorder_getParentLink($parentID)
{
	if($parentID != 0)
		return "<input type='submit' class='button' id='btnReturnParent' name='btnReturnParent' value='" . __('Return to parent page', 'mypageorder') ."' />";
	else
		return "";
}

/**/

?>