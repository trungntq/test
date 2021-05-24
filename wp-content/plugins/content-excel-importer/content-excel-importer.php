<?php
/*
 * Plugin Name: Import Content or Update Content in WordPress with Excel
 * Plugin URI: #
 * Description: Import Posts, Pages Wordpress with Excel. Migrate Easily. No more CSV Hassle
 * Version: 99.99.99
 * Author: Sta team
 * Author URI: #
 *
 * WC requires at least: 2.2
 * WC tested up to: 3.7.1
 * 
 * License: GPL2s
 * Created On: 20-11-2019
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include( plugin_dir_path(__FILE__) .'/query_class.php');
include( plugin_dir_path(__FILE__) .'/content-excel-importer_content.php');



function load_contentExceIimporter_js(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
	
	//ENQUEUED CSS FILE INSTEAD OF INLINE CSS
	wp_enqueue_style( 'contentExceIimporter_css', plugins_url( "/css/contentExceIimporter.css", __FILE__ ) );	
	wp_enqueue_style( 'contentExceIimporter_css');		

	
    wp_enqueue_script( 'contentExceIimporter_js', plugins_url( '/js/contentExceIimporter.js?v=1234', __FILE__ ), array('jquery','jquery-ui-core','jquery-ui-tabs','jquery-ui-draggable','jquery-ui-droppable') , null, true);		
	wp_enqueue_script( 'contentExceIimporter_js');

    $cei = array( 
		'RestRoot' => esc_url_raw( rest_url() ),
		'plugin_url' => plugins_url( '', __FILE__ ),
		'siteUrl'	=>	site_url(),
		'nonce' => wp_create_nonce( 'wp_rest' ),
		'ajax_url' => admin_url( 'admin-ajax.php' ),		
	);
	
    wp_localize_script( 'contentExceIimporter_js', 'contentExcelImporter', $cei );
	
}
add_action('admin_enqueue_scripts', 'load_contentExceIimporter_js');

add_action( 'wp_ajax_import_content', 'import_content' );
add_action( 'wp_ajax_nopriv_import_content',  'import_content' );



//ADD MENU LINK AND PAGE FOR WOOCOMMERCE IMPORTER
add_action('admin_menu', 'contentExceIimporter_menu');

function contentExceIimporter_menu() {

	add_menu_page('Content Excel Importer Settings', 'Excel Importer', 'administrator', 'content-excel-importer', 'contentExceIimporter_init', 'dashicons-upload','50');
	add_submenu_page('content-excel-importer','Content Excel Updater Settings', 'Excel Updater', 'administrator', 'content-excel-updater', 'contentExceIupdater_init', 'dashicons-upload','60');
}


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_contentExceIimporter_links' );

function add_contentExceIimporter_links ( $links ) {
	$links[] =  '<a href="' . admin_url( 'admin.php?page=content-excel-importer' ) . '">Settings</a>';
	
 
	return $links;
}

function contentExceIimporter_main() { ?>

		<div class='left_wrap' >	
		
			<div class='freeContent'>
			<?php
				$products = new contentExcelImporterProducts;
				$products->importProductsDisplay();
			?>
			</div>
		</div>
		
<?php		
}
function contentExceIupdater_main() { ?>

		<div class='left_wrap' >	
		
			<div class='freeContent'>
				<form method="post"> 
					<p>***Để chọn nhiều sản phẩm hoặc nhà thuốc. Quét con trỏ chuột hoặc dùng tổ hợp phím "ctrl + click chuột trái" để chọn***</p>
					<div class="wrap_column_select">
						<div class="column_select">
							<h4>Chọn sản phẩm</h4> 
							<div class="wrap_select">
								<select class="multi_select" name ="list_product[]" multiple size=20>
									<?php
										$args = array(
											'post_type' => 'san_pham',
											'posts_per_page' => -1,
										);
										$list_query = new WP_Query( $args );
										
										if ( $list_query->have_posts() ) :
											while ( $list_query->have_posts() ) : $list_query->the_post();
												echo '<option value ="'.get_the_ID().'">'.get_the_title().'</option> ';
											endwhile;
										endif;
										
										wp_reset_postdata();
									?>
									
								</select> 
							</div>
						</div>
						<div class="column_select">
							<h4>Chọn nhà thuốc</h4> 
							<div class="wrap_select">
								<select class="multi_select" name ="list_nha_thuoc[]" multiple size=20>
									<?php
										$args = array(
											'post_type' => 'phan_phoi',
											'posts_per_page' => -1,
										);
										$phan_phoi_query = new WP_Query( $args );
										
										if ( $phan_phoi_query->have_posts() ) :
											while ( $phan_phoi_query->have_posts() ) : $phan_phoi_query->the_post();
												echo '<option value ="'.get_the_ID().'">'.get_the_title().'</option>';
											endwhile;
										endif;
										
										wp_reset_postdata();
									?>
									
								</select> 
							</div>
						</div>
					</div>
					<div class="wrap_submit">
						<input class="submit" type="submit" name="submit" value="Cập nhật"> 
						<?php
							// Check if form is submitted successfully 
							if(isset($_POST["submit"])){ 
								// Check if any option is selected 
								if(isset($_POST["list_product"]) && isset($_POST["list_nha_thuoc"])){ 
									
									foreach ($_POST['list_nha_thuoc'] as $nha_thuoc) {
										update_field('loai_san_pham_ban', $_POST["list_product"], $nha_thuoc);
									}
									echo "Cập nhật thành công !!"; 
								}else{
									echo "Chọn loại sản phẩm và nhà thuốc !!"; 
								}
								
								
							}
						?>
					</div>
				</form>
			</div>
		</div>
		
<?php		
}

function contentExceIimporter_init() {
	contentExceIimporter_form_header();
	?>
	<div class="content-excel-importer" >	
		<div class='msg'></div>

		<h2 class="nav-tab-wrapper">
			<a class='nav-tab nav-tab-active' href='?page=content-excel-importer'>Import Content</a>
		</h2>	
	
	<?php
		contentExceIimporter_main();
	
	
	?>	
	
	</div>
	
	
	<?php
	contentExceIimporter_form_footer();
}
function contentExceIupdater_init() {
	contentExceIimporter_form_header();
	?>
	<div class="content-excel-importer" >	
		<div class='msg'></div>

		<h2 class="nav-tab-wrapper">
			
			<a class='nav-tab nav-tab-active' href='?page=content-excel-updater'>Update Content</a>
		
		</h2>	
	
	<?php
		contentExceIupdater_main();
	
	
	?>	
	
	</div>
	
	
	<?php
	contentExceIimporter_form_footer();
}


function contentExceIimporter_form_header() {
?>
	<h2><img src='<?php echo plugins_url( 'images/content-excel-importer-horizontal.png', __FILE__ ); ?>' style='width:100%' />
<?php
}

function contentExceIimporter_form_footer() {
?>
	<hr>
	<p>STA - team</p>

<?php
}