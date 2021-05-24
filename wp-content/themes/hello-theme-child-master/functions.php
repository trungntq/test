<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style('sta_modalPopup_css',get_stylesheet_directory_uri() . '/css/magnific-popup.css',array(),'1.0.0');
	wp_enqueue_style('hello-elementor-child-style',get_stylesheet_directory_uri() . '/style.css',['hello-elementor-theme-style',],'1.0.0');
	wp_enqueue_style('sta_responsive_css',get_stylesheet_directory_uri() . '/css/responsive.css',array(),'1.0.0');
	
	wp_enqueue_script('pagination-js',get_stylesheet_directory_uri().'/js/pagination.js',array(),'1.0.0',true);
	wp_enqueue_script('sta_popup_js',get_stylesheet_directory_uri().'/js/jquery.magnific-popup.min.js',array(),'1.0.0',true);
	wp_enqueue_script('sta_js',get_stylesheet_directory_uri().'/js/custom.js',array(),'1.0.0',true);
	wp_localize_script('sta_js', 'livespo', array('ajaxurl' => admin_url('admin-ajax.php'),));

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts' );

add_image_size( '397x281', 397, 281, true );
add_image_size( '412x245', 412, 245, true );


function sta_product_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Sản Phẩm Sidebar', '' ),
            'id' => 'sta-product-sidebar',
            'description' => __( 'Sản Phẩm Sidebar', '' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'sta_product_sidebar' );

function sta_blog_sidebar() {
    register_sidebar(
        array (
            'name' => __( 'Blog Sidebar', '' ),
            'id' => 'sta-blog-sidebar',
            'description' => __( 'Blog Sidebar', '' ),
            'before_widget' => '<div class="widget-content">',
            'after_widget' => "</div>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'sta_blog_sidebar' );

function shortcode_staff($content){
	ob_start();
	
	extract( shortcode_atts( array(
		'taxonomy_name'=> '',
	) , $content) );
	$args = array(
		'post_type' => 'co_cau_to_chuc',
		'order' => 'ASC',
		'tax_query'=> array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'danh_muc_co_cau_to_chuc',
				'field' => 'slug',
				'terms' => explode( "," , $taxonomy_name),
				'include_children' => true,
				'operator' => 'IN'
			),
		),
	);
	
	$content_first ='';
	$content_second ='';
	$content_third ='';
	
	$the_query = new WP_Query( $args );
	// The Loop
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
		
			$phan_lop = get_field('phan_lop_nhan_vien');
			
			if($phan_lop == 1){
				$url_img = get_the_post_thumbnail_url(get_the_ID(),'full');
				$content_first .= '<div class="leaders-item">
					<div class="li-thumb">
						<a class="sta_popup" href="#ModalView-'.get_the_ID().'" data-id="'.get_the_ID().'">
							<span class="li-thumb-inner"><img src="'.$url_img.'" alt="'.get_the_title().'"></span>
						</a>
					</div>
					<div class="li-content">
						<div class="li-row"><a class="li-title sta_popup" href="#ModalView-'.get_the_ID().'" data-id="'.get_the_ID().'">'.get_the_title().'</a></div>
						<div class="li-row"><div class="li-desc">'.get_field("chuc_vu").'</div></div>
					</div>
					<div class="modal fade wrapp-popup mfp-hide" id="ModalView-'.get_the_ID().'" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<a class="close" data-dismiss="modal" aria-label="Close"></a>
								</div><!-- modal-header -->
								<div class="modal-body">
									<div class="modal-view leaders-view">
										<div class="row">
											<div class="col-md-6">
												<div class="modal-view-img">
													<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="'.get_the_title().'" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="modal-view-content">
													<div class="leaders-title">'.get_the_title().'</div>
													<div class="leaders-desc">'.get_field("chuc_vu").'</div>
													<div class="maincontent">'.get_the_content().'</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- modal-body -->
							</div><!-- modal-content -->
						</div><!-- modal-dialog -->
					</div>
				</div>';
			}elseif($phan_lop == 2){
				$url_img = get_the_post_thumbnail_url(get_the_ID(),'full');
				$content_second .= '<div class="leaders-item">
					<div class="li-thumb">
						<a class="sta_popup" href="#ModalView-'.get_the_ID().'" data-id="'.get_the_ID().'">
							<span class="li-thumb-inner"><img src="'.$url_img.'" alt="'.get_the_title().'"></span>
						</a>
					</div>
					<div class="li-content">
						<div class="li-row"><a class="li-title sta_popup" href="#ModalView-'.get_the_ID().'" data-id="'.get_the_ID().'">'.get_the_title().'</a></div>
						<div class="li-row"><div class="li-desc">'.get_field("chuc_vu").'</div></div>
					</div>
					<div class="modal fade wrapp-popup mfp-hide" id="ModalView-'.get_the_ID().'" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<a class="close" data-dismiss="modal" aria-label="Close"></a>
								</div><!-- modal-header -->
								<div class="modal-body">
									<div class="modal-view leaders-view">
										<div class="row">
											<div class="col-md-6">
												<div class="modal-view-img">
													<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="'.get_the_title().'" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="modal-view-content">
													<div class="leaders-title">'.get_the_title().'</div>
													<div class="leaders-desc">'.get_field("chuc_vu").'</div>
													<div class="maincontent">'.get_the_content().'</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- modal-body -->
							</div><!-- modal-content -->
						</div><!-- modal-dialog -->
					</div>
				</div>';
			}else{
				$url_img = get_the_post_thumbnail_url(get_the_ID(),'full');
				$content_third .= '<div class="leaders-item">
					<div class="li-thumb">
						<a href="#ModalView-'.get_the_ID().'" class="sta_popup" data-id="'.get_the_ID().'">
							<span class="li-thumb-inner"><img src="'.$url_img.'" alt="'.get_the_title().'"></span>
						</a>
					</div>
					<div class="li-content">
						<div class="li-row"><a class="li-title sta_popup" href="#ModalView-'.get_the_ID().'" data-id="'.get_the_ID().'">'.get_the_title().'</a></div>
						<div class="li-row"><div class="li-desc">'.get_field("chuc_vu").'</div></div>
					</div>
					<div class="modal fade wrapp-popup mfp-hide" id="ModalView-'.get_the_ID().'" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<a class="close" data-dismiss="modal" aria-label="Close"></a>
								</div><!-- modal-header -->
								<div class="modal-body">
									<div class="modal-view leaders-view">
										<div class="row">
											<div class="col-md-6">
												<div class="modal-view-img">
													<img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="'.get_the_title().'" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="modal-view-content">
													<div class="leaders-title">'.get_the_title().'</div>
													<div class="leaders-desc">'.get_field("chuc_vu").'</div>
													<div class="maincontent">'.get_the_content().'</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- modal-body -->
							</div><!-- modal-content -->
						</div><!-- modal-dialog -->
					</div>
				</div>';
			}
		endwhile; 
	endif;
	// Reset Post Data
	wp_reset_postdata();
	
	echo '<div class="wrap_first_content">'.$content_first.'</div>';
	echo '<div class="wrap_second_content">'.$content_second.'</div>';
	echo '<div class="wrap_third_content">'.$content_third.'</div>';
	
	return ob_get_clean();
}
add_shortcode('shortcode_staff','shortcode_staff');



function shortcode_album_image(){
	ob_start(); 
	$args = array(
		'post_type' => 'album',
	);
	$queryGallery = new WP_Query($args);
	$i = 1;
	/* The Loop */
	if ( $queryGallery->have_posts() ) :
		while ( $queryGallery->have_posts() ) : $queryGallery->the_post(); 
			$url_img = get_the_post_thumbnail_url(get_the_ID(),'412x245');
			if($url_img !=""){
				$url_img = get_the_post_thumbnail_url(get_the_ID(),'412x245');
			}else{
				$url_img = get_home_url()."/wp-content/uploads/2019/10/placeholder-1-412x245.png";
			}
			
			$count = 1;
		?>
			<div class="popup-gallery" id="<?php echo $i; ?>">
				
				<?php
				if( have_rows('add_image_gallery') ):
					while ( have_rows('add_image_gallery') ) : the_row();
						$image = get_sub_field('image_item');
						if($count == 1){
							$class="";
						}else{
							$class="hidden";
						}
					?>
						<a class="<?php echo $class; ?>" href="<?php echo $image['url']; ?>">
						<?php if($count == 1){ ?>
							<div class="thumb">
								<img src="<?php echo $url_img; ?>" >
							</div>
							<h3><?php echo get_the_title(); ?></h3>
							<span>Ngày <?php echo get_the_date("d/m/Y"); ?></span>
						<?php }else{ ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
						<?php } ?>
						</a>
					<?php
					$count ++;
					endwhile;
				endif;
				?>
			</div>
			
		<?php
		$i++;
		endwhile;
	endif;
	/* Reset Post Data */
	wp_reset_postdata();
	?>
	<div class="wrapper-pagination"><ul id="sta-pagination" class="pagination-sm"></ul></div>
	<?php
	return ob_get_clean();
}
add_shortcode('shortcode_album_image','shortcode_album_image');

function shortcode_video($content){
	ob_start(); 
	
	extract( shortcode_atts( array(
		'per_page' => '-1',
	) , $content) );
	
	$args = array(
		'post_type' => 'videos',
		'posts_per_page' => $per_page, 
	);
	$queryVideo = new WP_Query($args);
	$i = 1;
	/* class for 6 video page home */
	if($per_page != "-1"){
		$class='active';
	}else{
		$class='';
	}
	/* The Loop */
	if ( $queryVideo->have_posts() ) :
		while ( $queryVideo->have_posts() ) : $queryVideo->the_post(); 
			$iframe = get_field('video');
			$url_img = get_the_post_thumbnail_url(get_the_ID(),'412x245');
			if($url_img !=""){
				$url_img = get_the_post_thumbnail_url(get_the_ID(),'412x245');
			}else{
				$url_img = get_home_url()."/wp-content/uploads/2019/10/placeholder-1-412x245.png";
			}
		?>
			<a class="popup-video <?php echo $class; ?>" href="<?php echo $iframe; ?>" title="<?php echo get_the_title(); ?>" id="<?php echo $i; ?>">
				<div class="thumb">
					<img src="<?php echo $url_img; ?>" >
				</div>
				<h3><?php echo get_the_title(); ?></h3>
			</a>
		<?php
		$i++;
		endwhile;
	endif;
	/* Reset Post Data */
	wp_reset_postdata();
	
	?>
	<?php if($per_page =="-1"){ ?>
	<div class="wrapper-pagination"><ul id="sta-pagination" class="pagination-sm"></ul></div>
	<?php } ?>
	<?php
	return ob_get_clean();
}
add_shortcode('shortcode_video','shortcode_video');
function slide_bao_chi($content){
	ob_start(); 
	
	extract( shortcode_atts( array(
		'per_page' => '-1',
	) , $content) );
	
	$args = array(
		'post_type' => 'bao_chi',
		'posts_per_page' => $per_page, 
	);
	$queryBaoChi = new WP_Query($args);
	
	echo '<div class="elementor-widget-testimonial-carousel"><div class="sta_testimonial swiper-container swiper-container-horizontal"><div class="swiper-wrapper">';
	
	/* The Loop */
	if ( $queryBaoChi->have_posts() ){
		while ( $queryBaoChi->have_posts() ){ 
			$queryBaoChi->the_post(); 
			
			$url_img = get_the_post_thumbnail_url(get_the_ID(),'full');
			if($url_img != ""){
				$url_img = get_the_post_thumbnail_url(get_the_ID(),'full');
			}else{
				$url_img = get_home_url()."/wp-content/uploads/2019/10/placeholder-1-412x245.png";
			}
		?>
			<div class="swiper-slide">
				<div class="elementor-testimonial">
					<div class="elementor-testimonial__header">
						<div class="elementor-testimonial__image">
							<?php if(get_field("link_bao_noi_ve_chung_toi")){ ?>
								<a target="_blank" href="<?php echo get_field("link_bao_noi_ve_chung_toi"); ?>">
							<?php } ?>
								<img src="<?php echo $url_img; ?>" alt="">
							<?php if(get_field("link_bao_noi_ve_chung_toi")){ ?>
								</a>
							<?php } ?>
						</div>
					</div>
					<div class="elementor-testimonial__content">
						<div class="elementor-testimonial__text">
							<?php echo get_the_content(); ?>
						</div>
						
						<span class="elementor-testimonial__title"><?php echo get_the_title(); ?></span>
						
					</div>
				</div>
			</div>
			
		<?php
		}
	}
	/* Reset Post Data */
	wp_reset_postdata();
	echo '</div><div class="swiper-button swiper-button-next"><i class="eicon-chevron-right" aria-hidden="true"></i></div><div class="swiper-button swiper-button-prev"><i class="eicon-chevron-left" aria-hidden="true"></i></div><div class="sta_slider__pagination swiper-pagination"></div></div></div>';
	return ob_get_clean();
}
add_shortcode("slide_bao_chi","slide_bao_chi");


function form_filter_phan_phoi(){
	ob_start();
	get_template_part("inc/form_filter_phanphoi");
	return ob_get_clean();
}
add_shortcode("form_filter_phan_phoi","form_filter_phan_phoi");

function shortcode_phan_phoi(){
	ob_start();
	$count = 1;


	/*Show tất cả các nhà thuốc */	
	$argsNhaThuoc = array(
		'post_type' => 'phan_phoi',
		'posts_per_page'=> -1,
	);
	$queryNhaThuoc = new WP_Query($argsNhaThuoc);
	
	echo '<div id="content_phanphoi">
	<table border="0" class="easy-table easy-table-default " style="width:100%; ">
	<thead>
		<tr>
			<th>STT</th>
			<th>Mã </th>
			<th>Tên cửa hàng</th>
			<th>Địa chỉ</th>
		</tr>
	</thead>
	<tbody>';
	if ( $queryNhaThuoc->have_posts() ) :
		while ( $queryNhaThuoc->have_posts() ) : $queryNhaThuoc->the_post();
			echo '<tr class="nhathuoc_item" id="item_'.$count.'"><td>'.$count.'</td><td>'.get_field("ma").'</td><td>'.get_the_title().'</td><td>'.get_field("dia_chi").'</td></tr>';
			$count++;
		endwhile;
	endif;
	echo '</tbody></table><div class="wrapper-pagination"><ul id="sta-pagination" class="pagination-sm"></ul></div></div>';
	/* Reset Post Data */
	wp_reset_postdata();
	
	
	return ob_get_clean();
}
add_shortcode('shortcode_phan_phoi','shortcode_phan_phoi');

function load_quanhuyen(){
	$id_tinhthanh = $_POST['id_tinhthanh'];
	
	$content ='<option value="" disabled selected>Quận huyện</option><option value="all">--Tất cả--</option>';
	if($id_tinhthanh != "all"){
		$taxonomies = get_terms( array(
			'taxonomy' => 'dia_diem_phan_phoi',
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'parent'    => $id_tinhthanh,
		) );
	 
		if ( !empty($taxonomies) ) :
			foreach( $taxonomies as $category ) {
				$content.= '<option value="'. esc_attr( $category->term_id ) .'">
				'. esc_html( $category->name ) .'</option>';
			}

		endif;
	}
	$return = array(
		"content" => $content,
	);
	
	
	wp_send_json($return); 
	die(); 
}
add_action('wp_ajax_load_quanhuyen','load_quanhuyen' );
add_action('wp_ajax_nopriv_load_quanhuyen','load_quanhuyen');

function filter_phanphoi(){
	$id_quanhuyen = $_POST['id_quanhuyen'];
	$id_tinhthanh = $_POST['id_tinhthanh'];
	$id_sanpham = $_POST['id_sanpham'];
	$content="";
	$mess="";
	if(($id_quanhuyen != "null") || ($id_sanpham != "null") || ($id_tinhthanh != "null") ){
		$count = 1;
		if(($id_quanhuyen == "null") && ($id_tinhthanh != "null")){
			if($id_tinhthanh == "all"){
				$argsNhaThuoc = array(
					'post_type' => 'phan_phoi',
					'posts_per_page'=> -1,
				);
			}else{
				$argsNhaThuoc = array(
					'post_type' => 'phan_phoi',
					'posts_per_page'=> -1,
					'tax_query' => array(
						'relation' => 'OR', 
						array(
							'taxonomy' => 'dia_diem_phan_phoi',
							'field' => 'id',
							'terms' => array( $id_tinhthanh ),
							'include_children' => false,
							'operator' => 'IN'
						)
					)
				);
			}
		}elseif(($id_quanhuyen != "null") && ($id_tinhthanh != "null")){
			if($id_quanhuyen == "all"){
				$argsNhaThuoc = array(
					'post_type' => 'phan_phoi',
					'posts_per_page'=> -1,
					'tax_query' => array(
						'relation' => 'OR', 
						array(
							'taxonomy' => 'dia_diem_phan_phoi',
							'field' => 'id',
							'terms' => array( $id_tinhthanh ),
							'include_children' => false,
							'operator' => 'IN'
						)
					)
				);
			}else{
				$argsNhaThuoc = array(
					'post_type' => 'phan_phoi',
					'posts_per_page'=> -1,
					'tax_query' => array(
						'relation' => 'OR', 
						array(
							'taxonomy' => 'dia_diem_phan_phoi',
							'field' => 'id',
							'terms' => array( $id_quanhuyen ),
							'include_children' => false,
							'operator' => 'IN'
						)
					)
				);
			}
		}else{
			$argsNhaThuoc = array(
				'post_type' => 'phan_phoi',
				'posts_per_page'=> -1,
			);
		}
		
		$queryNhaThuoc = new WP_Query($argsNhaThuoc);
		if ( $queryNhaThuoc->have_posts() ) :
			while ( $queryNhaThuoc->have_posts() ) : $queryNhaThuoc->the_post();
				//print_r(get_field("loai_san_pham_ban"));
				if($id_sanpham == "all"){
					$content .= '<tr class="nhathuoc_item" id="item_'.$count.'"><td>'.$count.'</td><td>'.get_field("ma").'</td><td>'.get_the_title().'</td><td>'.get_field("dia_chi").'</td></tr>';
						
					$count ++;
				}else{
					if(in_array($id_sanpham, get_field("loai_san_pham_ban"))){
						$content .= '<tr class="nhathuoc_item" id="item_'.$count.'"><td>'.$count.'</td><td>'.get_field("ma").'</td><td>'.get_the_title().'</td><td>'.get_field("dia_chi").'</td></tr>';
						
						$count ++;
					}
				}
			endwhile;
		endif;
		
		/* Reset Post Data */
		wp_reset_postdata();
		
	}else{
		$mess = "Xin mời chọn sản phẩm";
	}
	
	$return = array(
		"content" => $content,
		"mess" => $mess
	);
	
	
	wp_send_json($return); 
	die(); 
}
add_action('wp_ajax_filter_phanphoi','filter_phanphoi' );
add_action('wp_ajax_nopriv_filter_phanphoi','filter_phanphoi');


