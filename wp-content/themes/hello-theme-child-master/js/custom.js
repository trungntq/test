jQuery(document).ready(function($){
	var $el, leftPos, newWidth;
	
	/* Add Magic Line markup via JavaScript, because it ain't gonna work without */
	$(".sta_main_menu .cmm4e-horizontal").append("<li id='magic-line'></li>");

	/* Cache it */
	var $magicLine = $("#magic-line");
	if($(".sta_main_menu .cmm4e-horizontal > li").hasClass("cmm4e-current-menu-item")){
		$magicLine
			.css({
				"width" : $(".cmm4e-current-menu-item > .cmm4e-nav-link").width(),
				"left": $(".cmm4e-current-menu-item > .cmm4e-nav-link").position().left + 5,
			})
			.data("origLeft", $magicLine.position().left)
			.data("origWidth", $magicLine.width());
	}
	$(".sta_main_menu .cmm4e-horizontal > li > .cmm4e-nav-link")
		.hover(
			function() {
				$el = $(this);
				$position = $el.position();
				leftPos = $position.left;
				newWidth = $el.width();
				
				/* console.log("Left position: " + leftPos + " Width: " + newWidth);
				console.log("Content: " + $el.html()); */
				
				$magicLine.stop().animate({
					left: leftPos ,
					width: newWidth
				});
			},
			function() {
				if($(".sta_main_menu .cmm4e-horizontal > li").hasClass("cmm4e-current-menu-item")){
					var current_width = $magicLine.data("origWidth");
				}else{
					var current_width = 0;
				}
				$magicLine.stop().animate({
				left: $magicLine.data("origLeft") + 5,
				width: current_width
			});
		}
	);
	$(function () {
        $(".sta_popup").magnificPopup({
			type: 'inline',
			preloader: false,
			modal: true,
			
        });
        $(document).on('click', '.modal-header .close', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
        });
	});
	
      
	$('.popup-gallery').each(function() { 
		$(this).find('a').magnificPopup({ 
			type: 'image',
			gallery:{enabled:true},
			callbacks: {
				buildControls: function() {
					// re-appends controls inside the main container
					this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
				}
			}
		});
	});
	
	$('.popup-video').magnificPopup({
		disableOn: 320,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,

		fixedContentPos: false
	});
	if(jQuery("body").hasClass("page-id-672")){
		var i= 0;
		jQuery(".popup-video").each(function(){
			i++;
		});
		var item_total_page = Math.ceil(i/9);

		if( item_total_page / 5 >= 1){
			var min = 5;
		}else{
			var min = item_total_page;
		}
		if(i <= 9){
			jQuery('.popup-video').addClass('active');
		}else{
			jQuery('#sta-pagination').twbsPagination({
				totalPages: item_total_page ,
				visiblePages: min ,
				next: '>',
				prev: '<',
				onPageClick: function (event, page) {
					
					jQuery('.popup-video').removeClass('active');
					var countMax = 9 * page;
					var countMin = countMax - 8;
					
					for (c = countMin; c <= countMax; c++){
						jQuery(".popup-video").each(function(){
							jQuery('.popup-video#'+c).addClass('active');
						});
					};
					
				}
			});
		}
	}
    if(jQuery("body").hasClass("page-id-677")){
		var i= 0;
		jQuery(".popup-gallery").each(function(){
			i++;
		});
		var item_total_page = Math.ceil(i/9);

		if( item_total_page / 5 >= 1){
			var min = 5;
		}else{
			var min = item_total_page;
		}
		if(i <= 9){
			jQuery('.popup-gallery').addClass('active');
		}else{
			jQuery('#sta-pagination').twbsPagination({
				totalPages: item_total_page ,
				visiblePages: min ,
				next: '>',
				prev: '<',
				onPageClick: function (event, page) {
					
					jQuery('.popup-gallery').removeClass('active');
					var countMax = 9 * page;
					var countMin = countMax - 8;
					
					for (c = countMin; c <= countMax; c++){
						jQuery(".popup-gallery").each(function(){
							jQuery('.popup-gallery#'+c).addClass('active');
						});
					};
					
				}
			});
		}
	}
	if(jQuery("body").hasClass("page-id-14")){
		var i= 0;
		jQuery(".nhathuoc_item").each(function(){
			i++;
		});
		var item_total_page = Math.ceil(i/15);

		if( item_total_page / 5 >= 1){
			var min = 5;
		}else{
			var min = item_total_page;
		}
		if(i <= 15){
			jQuery('.nhathuoc_item').addClass('active');
		}else{
			jQuery('#sta-pagination').twbsPagination({
				totalPages: item_total_page ,
				visiblePages: min ,
				next: '>',
				prev: '<',
				onPageClick: function (event, page) {
					
					jQuery('.nhathuoc_item').removeClass('active');
					var countMax = 15 * page;
					var countMin = countMax - 14;
					
					for (c = countMin; c <= countMax; c++){
						jQuery(".nhathuoc_item").each(function(){
							jQuery('.nhathuoc_item#item_'+c).addClass('active');
						});
					};
					
				}
			});
		}
	}
	var swiper = new Swiper('.sta_testimonial', {
		spaceBetween: 0,
		effect: 'slide',
		loop: true,
		mousewheel: false,
		autoplay: {
			delay: 100000,
		},
		navigation: {
			nextEl: '.sta_testimonial .swiper-button-next',
			prevEl: '.sta_testimonial .swiper-button-prev',
		},
		pagination: {
			el: '.sta_slider__pagination',
			clickable: true,
		}
	});
	$('select#tinh_thanh').on("change",function(){
		var id_tinhthanh = $(this).val();
		$(this).prop('disabled', 'disabled');
		$('select#quan_huyen').prop('disabled', 'disabled');
		$.ajax({
            method: "post",
            url: livespo.ajaxurl,
            data: "action=load_quanhuyen&" + "id_tinhthanh="+id_tinhthanh ,
            success: function(response){
				$('select#quan_huyen').html(response.content);
				$('select#quan_huyen').prop('disabled', false);
				$('select#tinh_thanh').prop('disabled', false);
			}
        });
	});
	$('#button_timkiem').on("click",function(){
		var id_quanhuyen = $('select#quan_huyen').val();
		var id_tinhthanh = $('select#tinh_thanh').val();
		var id_sanpham = $('select#id_sanpham').val();
		$(this).prop('disabled', 'disabled');
		$('select#id_sanpham').prop('disabled', 'disabled');
		$('select#tinh_thanh').prop('disabled', 'disabled');
		$('select#quan_huyen').prop('disabled', 'disabled');
		$('#content_phanphoi').addClass("loadding");
		$('#content_phanphoi').html('<svg version="1.1" id="L2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><circle fill="none" stroke="#fff" stroke-width="4" stroke-miterlimit="10" cx="50" cy="50" r="48"/><line fill="none" stroke-linecap="round" stroke="#fff" stroke-width="4" stroke-miterlimit="10" x1="50" y1="50" x2="85" y2="50.5"><animateTransform attributeName="transform" dur="2s" type="rotate" from="0 50 50" to="360 50 50" repeatCount="indefinite" /></line><line fill="none" stroke-linecap="round" stroke="#fff" stroke-width="4" stroke-miterlimit="10" x1="50" y1="50" x2="49.5" y2="74"><animateTransform attributeName="transform" dur="15s" type="rotate" from="0 50 50" to="360 50 50" repeatCount="indefinite" /></line></svg>Loadding...');
		$('.mess_err').empty();
		$.ajax({
            method: "post",
            url: livespo.ajaxurl,
            data: "action=filter_phanphoi&" + "id_quanhuyen="+id_quanhuyen+"&id_tinhthanh="+id_tinhthanh+"&id_sanpham="+id_sanpham ,
            success: function(response){
				if(response.mess ==''){
					$('#content_phanphoi').empty();
					if(response.content !=''){
						$('#content_phanphoi').removeClass("loadding");
						var before_content = '<table border="0" class="easy-table easy-table-default" style="width:100%; "><thead><tr><th>STT</th><th>Mã</th><th>Tên cửa hàng</th><th>Địa chỉ</th></tr></thead><tbody>', after_content = '</tbody></table><div class="wrapper-pagination"><ul id="sta-pagination" class="pagination-sm"></ul></div></div>';
						$('#content_phanphoi').html(before_content+response.content+after_content);
						if(jQuery("body").hasClass("page-id-14")){
							var i= 0;
							jQuery(".nhathuoc_item").each(function(){
								i++;
							});
							var item_total_page = Math.ceil(i/15);

							if( item_total_page / 5 >= 1){
								var min = 5;
							}else{
								var min = item_total_page;
							}
							if(i <= 15){
								jQuery('.nhathuoc_item').addClass('active');
							}else{
								jQuery('#sta-pagination').twbsPagination({
									totalPages: item_total_page ,
									visiblePages: min ,
									next: '>',
									prev: '<',
									onPageClick: function (event, page) {
										
										jQuery('.nhathuoc_item').removeClass('active');
										var countMax = 15 * page;
										var countMin = countMax - 14;
										
										for (c = countMin; c <= countMax; c++){
											jQuery(".nhathuoc_item").each(function(){
												jQuery('.nhathuoc_item#item_'+c).addClass('active');
											});
										};
										
									}
								});
							}
						}
						
					}else{
						$('#content_phanphoi').html("Không tìm thấy nhà thuốc nào!!!");
					}
					
					
				}else{
					$('#content_phanphoi').removeClass("loadding");
					$('#content_phanphoi').empty();
					$('.mess_err').html(response.mess);
				}
				$('select#id_sanpham').prop('disabled', false);
				$('select#tinh_thanh').prop('disabled', false);
				$('select#quan_huyen').prop('disabled', false);
			}
        });
		return false;
	});
});


	
	

