<div class="form_filter">
	<div class="wrapp_form_filter">
	<?php
	/* Select show loại sản phẩm */
	$argsProduct = array(
		'post_type' => 'san_pham',
	);
	$argsProduct = new WP_Query($argsProduct); ?>
	
	<select id="id_sanpham" name="id_sanpham">
		<option value="" disabled selected>Chọn sản phẩm</option>
		<option value="all">--Tất cả--</option>
	<?php
		if ( $argsProduct->have_posts() ) :
			while ( $argsProduct->have_posts() ) : $argsProduct->the_post();
				echo '<option value="'.get_the_ID().'">'.get_the_title().'</option>';
			endwhile;
		else:
			echo '<option value="null">Chưa có sản phẩm nào</option>';
		endif;
		wp_reset_postdata();
	?>
	</select>
	
	<?php
	/* Select show tỉnh thành */
	$taxonomies = get_terms( array(
		'taxonomy' => 'dia_diem_phan_phoi',
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => false, //can be 1, '1' too
		'parent' => 0,
	) );
	?>
	<select id="tinh_thanh" name="tinh_thanh">
		<option value="" disabled selected>Tỉnh thành</option>
		<option value="all">--Tất cả--</option>
		<?php
		if ( !empty($taxonomies) ) : 
			foreach( $taxonomies as $category ) {
				echo '<option value="'. esc_attr( $category->term_id ) .'">'. esc_html( $category->name ) .'</option>';
			}
		endif;
		?>
	</select>
	
	
	<!--Select show quận huyện -->
	<select id="quan_huyen" name="quan_huyen" disabled>
		<option value="" disabled selected>Quận huyện</option>
		
	</select>
	
	<a id="button_timkiem" href="#">Tìm kiếm</a>
	</div>
	<div class="mess_err"></div>
</div>