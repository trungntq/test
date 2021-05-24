<?php


class contentExcelImporterQuery{
	


	public function selectPostType(){ ?>
		<select name="contentExcelImporter_post_type" id="contentExcelImporter_post_type"   value="" >
		<option value=''>Select</option>
		<?php if($_REQUEST['contentExcelImporter_post_type']){
			?><option value='<?php print sanitize_text_field($_REQUEST['contentExcelImporterPro_post_type']); ?>'><?php print sanitize_text_field($_REQUEST['contentExcelImporter_post_type']); ?></option><?php
		}
		
		$postType = array('spp','phan_phoi');
		
		foreach (  get_post_types( '', 'names' ) as $post_type ) {
			if(in_array($post_type,$postType) ){
				echo "<option value='".esc_attr($post_type)."'>" . $post_type . "</option>";
			}
			
		}	
		?>
		</select>	 
		
		<select name="choose_product" id="choose_product" >
			<option value='' disabled selected >Chọn sản phẩm</option>
			<?php 
			$hihihaha = array(
				'post_type' => 'san_pham',
				'posts_per_page' => -1,
				'order' => 'DESC',
			);
			$query_sanpham = new WP_Query( $hihihaha );
			if ( $query_sanpham->have_posts() ) : 
				while ( $query_sanpham->have_posts() ) : $query_sanpham->the_post(); ?>
					<option value="<?php echo  get_the_ID() ; ?>"><?php the_title(); ?></option>
				<?php
				endwhile;
			endif;
			// Reset Post Data
			wp_reset_postdata();
			?>
		</select>
		<?php 	
	}
	
	public function selectPostTypeForm(){
		
		if(isset($_REQUEST['tab']) && $_REQUEST['tab'] =='main' || empty($_REQUEST['tab']) ){
			print "<form id='selectPostType' action= '".admin_url( 'admin.php?page=content-excel-importer' )."' method='POST'>";
		}else print "<form id='selectPostType' action= '".admin_url( 'admin.php?page=content-excel-importer-pro' )."' method='POST'>"; 		
		?>
		
		<label>SELECT POST TYPE</label>

		<?php $this->selectPostType(); ?>
		
		<input type='hidden' name='getPostType' value='1'  />
		<?php wp_nonce_field('getPostType','getPostType'); ?>
		
		</form>
		<?php	
	}

	public function getFields($post_type){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_can('administrator')  ){
			
			print "<p style='display:none;'><b>POST TYPE </b> <input type='text' name='post_type' id='post_type_insert' required readonly  value='".$post_type."' /></p>";
			

				
			
			$data =array('post_title');
			foreach($data as $d){
				print "<p><b>Tên nhà thuốc</b> <input type='text' name='".$d."'  readonly class='droppable' placeholder='Kéo thả cột bên vào đây' /></p>";
			}
			
			if($post_type=='post'){
				$taxonomy_objects = get_object_taxonomies( 'post', 'objects' );			
				foreach( $taxonomy_objects as $voc){
					//ADDITION : INCLUDE ONLY PRODUCT CATEGORY AND TAGS NOT CUSTOM TAXONOMIES
					if($voc->name == 'post_tag' ||  $voc->name == 'category' || $voc->name =='language' || $voc->name =='post_translations' ){
						echo "<p>". strtoupper(str_replace('_',' ',esc_attr($voc->name))). " <input type='text' style='min-width:200px' name='".esc_attr($voc->name)."' required readonly class='droppable' placeholder='Drop here column' key /></p>";
					}
				}
			}
			if($post_type=='page'){
				$taxonomy_objects = get_object_taxonomies( 'page', 'objects' );			
				foreach( $taxonomy_objects as $voc){
					//ADDITION : INCLUDE ONLY PRODUCT CATEGORY AND TAGS NOT CUSTOM TAXONOMIES
					if($voc->name =='language' || $voc->name =='post_translations' ){
						echo "<p>". strtoupper(str_replace('_',' ',esc_attr($voc->name))). " <input type='text' style='min-width:200px' name='".esc_attr($voc->name)."' required readonly class='droppable' placeholder='Kéo thả cột bên vào đây' key /></p>";
					}
				}
			}
			
			if($post_type=='spp'|| $post_type=='phan_phoi'){
				
				$post_meta = array(
					'Mã nhà thuốc'		=>	'manhathuoc' ,
					'Địa chỉ nhà thuốc'	=>	'adiachi',
					'Số điện thoại'		=> 'sodienthoai',
					
				);
				foreach($post_meta as $key =>$item){
					echo "<p>".esc_attr($key)." <input type='text' style='min-width:200px' name='".esc_attr($item)."' required readonly class='droppable' placeholder='Kéo thả cột bên vào đây'  /></p>";
				} 
				$taxonomy_objects = get_object_taxonomies( 'phan_phoi', 'objects' );			
				foreach( $taxonomy_objects as $voc){
					//ADDITION : INCLUDE ONLY PRODUCT CATEGORY AND TAGS NOT CUSTOM TAXONOMIES
					if($voc->name == 'product_tag' ||  $voc->name == 'product_cat' ||  $voc->name == 'dia_diem_phan_phoi' ){
						echo "<p>Quận huyện <input type='text' style='min-width:200px' name='".esc_attr($voc->name)."' required readonly class='droppable' placeholder='Kéo thả cột bên vào đây' key /></p>";
					}
				}				
			}
			
			//echo "<p>Custom Taxonomy <input type='text' name='custom_tax' required readonly class='droppable' placeholder='Drop here column'  /></p>";				
			
		}
	}	

}
