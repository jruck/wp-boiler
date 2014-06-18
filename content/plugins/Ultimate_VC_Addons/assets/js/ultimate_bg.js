/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 * jQuery.browser.mobile will be true if the browser is a mobile device
 **/
(function(a,b){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))window.location=b})(navigator.userAgent||navigator.vendor||window.opera,'http://detectmobilebrowser.com/mobile');

(function ( jQuery ) {
	jQuery.fn.ultimate_video_bg = function(option) {
		jQuery(this).each(function(){
			var selector =jQuery(this);
			var vdo = selector.data('ultimate-video');
			var muted =selector.data('ultimate-video-muted');
			var loop =selector.data('ultimate-video-loop');
			var autoplay =selector.data('ultimate-video-autoplay');
			var poster =selector.data('ultimate-video-poster');
			var ride = selector.data('bg-override');
			var start = selector.data('start-time');
			var stop = selector.data('stop-time');
			var anim_style= selector.data('upb-bg-animation');
			var  overlay_color = selector.data('upb-overlay-color')

			if( overlay_color != ''){
				overlay_color = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+'"></div>';
			}
			else{
				//console.warn("Overlay color not selected");
			}
			if(stop!=0){
				stop = stop;
			}else{
				stop ='';
			}
			var parent = selector.prev();
			selector.remove();
			selector = parent;
			var vd_html = selector.html();
			selector.addClass('upb_video_class');
			selector.attr('data-upb_br_animation',anim_style);
			if(vdo){
				if(vdo.indexOf('youtube.com')!=-1){
					option='youtube';
				}
				else if (vdo.indexOf('vimeo.com')!=-1){
					option='vimeo'
				}
			}
			if(option=='youtube' || option=='vimeo'){
				selector.html(' <div class="upb_video-wrapper"><div class="upb_video-bg utube" data-bg-override="'+ride+'"></div><div class="upb_video-text"></div></div>');
			}else{
				selector.html(' <div class="upb_video-wrapper"><div class="upb_video-bg" data-bg-override="'+ride+'"><video class="upb_video-src"  ></video>'+overlay_color+'</div><div class="upb_video-text"></div></div>');
			}
			selector.find('.upb_video-text').html(vd_html);
			if(option=='youtube'){
				vdo = vdo.substring((vdo.indexOf('watch?v='))+8,(vdo.indexOf('watch?v='))+19);
				var content = selector.find('.upb_video-bg');
				if(loop=='loop') loop=true;
				if(muted=='muted') muted=true;
				//alert(loop+' '+muted+' '+vdo);
				content.attr('data-vdo',vdo);content.attr('data-loop',loop);content.attr('data-poster',poster);
				content.attr('data-muted',muted);content.attr('data-start',start);content.attr('data-stop',stop);
				//content.html('<iframe class="upb_utube_iframe" frameborder="0" allowfullscreen="1" src="https://www.youtube.com/embed/'+vdo+'?autoplay=1&loop=1&controls=0&disablekb=1&enablejsapi=1&fs=0&iv_load_policy =3&modestbranding=1&rel=0&showinfo=0&wmode=transparent&amp;start='+start+'&amp;'+stop+'" width="900" height="1600"></iframe>')
			}else if(option=='vimeo'){
				vdo = vdo.substring((vdo.indexOf('vimeo.com/'))+10,(vdo.indexOf('vimeo.com/'))+18);
				var content = selector.find('.upb_video-bg');
				content.html('<iframe class="upb_vimeo_iframe" src="http://player.vimeo.com/video/'+vdo+'?portrait=0&amp;byline=0&amp;title=0&amp;badge=0&amp;loop=0&amp;autoplay=1&amp;api=1&amp;rel=0&amp;" height="1600" width="900" frameborder=""></iframe>')
				//.controls-wrapper
				//.controls

				/*jQuery(window).load(function(){
					setTimeout(function() {
						var if_co = jQuery('iframe.upb_vimeo_iframe').contents().find("#player");
						if_co.find(".controls-wrapper").css("display","none");

					}, 5000);

				})
				*/



			}
			else{
				var content = selector.find('.upb_video-src');
				content.attr({'src':vdo});
				if(autoplay=='autoplay'){ content.attr({'autoplay':autoplay}); }
				if(muted=='muted'){ content.attr({'muted':muted}); }
				if(loop=='loop'){ content.attr({'loop':loop}); }
				if(poster){ content.attr({'poster':poster}); }
			}
			var resizee = function(){

				var w,h,ancenstor,al='',bl='';
				ancenstor = selector;
				selector = selector.find('.upb_video-bg');

				if(ride=='full'){
					ancenstor= jQuery('body');
				}
				if(ride=='ex-full'){
					ancenstor= jQuery('html');
				}
				if( ! isNaN(ride)){
					for(var i=0;i<ride;i++){
						if(ancenstor.prop("tagName")!='HTML'){
							ancenstor = ancenstor.parent();
						}else{
							break;
						}
					}
				}

				h = selector.parents('upb_video_class').outerHeight();
				w = ancenstor.outerWidth();
				if(ride=='browser_size'){
					h = jQuery(window).height();
					w = jQuery(window).width();
					ancenstor.css('min-height',h+'px');
				}

				selector.css({'min-height':h+'px','min-width':w+'px'});
				if(ancenstor.offset()){
					al = ancenstor.offset().left;
					if(selector.offset()){
						bl = selector.offset().left;
					}
				}
				if(al!=''){
					if(bl!=''){
						//selector.css({'left':(al-bl)+'px'});
					}
				}


			 	var width =w,
	            pWidth, // player width, to be defined
	            //height = selector.height(),
	            height = h,
	            pHeight, // player height, tbd
	        	vimeovideoplayer = selector.find('.upb_vimeo_iframe');
	        	youvideoplayer = selector.find('.upb_utube_iframe');
	        	embeddedvideoplayer = selector.find('.upb_video-src');
	        	var ratio =(16/9);
		        if(vimeovideoplayer){
			        if (width / ratio < height) { // if new video height < window height (gap underneath)
		                pWidth = Math.ceil(height * ratio); // get new player width
		                vimeovideoplayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
		            } else { // new video width < window width (gap to right)
		                pHeight = Math.ceil(width / ratio); // get new player height
		                vimeovideoplayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
		            }
		        }
		        /*if(youvideoplayer){
			        if (width / ratio < height) { // if new video height < window height (gap underneath)
		                pWidth = Math.ceil(height * ratio); // get new player width
		                youvideoplayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
		            } else { // new video width < window width (gap to right)
		                pHeight = Math.ceil(width / ratio); // get new player height
		                youvideoplayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
		            }
		        }*/
		        if(embeddedvideoplayer){

			        if (width / (16/9) < height) {
			            pWidth = Math.ceil(height * (16/9));
			            embeddedvideoplayer.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0});
			        } else {
			            pHeight = Math.ceil(width / (16/9));
			            //youvideoplayer.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2});
			            embeddedvideoplayer.width(width).height(pHeight).css({left: 0, top: 0});
			        }
		        }
		    }
		    resizee();
		    jQuery(window).resize(function(){
		    	resizee();
		    })
		})
		return this;
	}
	jQuery.fn.ultimate_bg_shift = function() {
		jQuery(this).each(function(){
			var selector =jQuery(this);
			var bg = selector.data('ultimate-bg');   // dep in vc v4.1
			var style = selector.data('ultimate-bg-style');
		 	/*var bg ='';
			if(style=='vcpb-fs-jquery' || style=='vcpb-mlvp-jquery'){
				bg = selector.data('ultimate-bg');
			}
			else{
				bg = selector.prev().css('background-image');
			}*/
			var bg_color = selector.prev().css('background-color');
			var rep = selector.data('bg-img-repeat');
			var size = selector.data('bg-img-size');
			var pos = selector.data('bg-img-position');
			var sense = selector.data('parallx_sense');
			var ride = selector.data('bg-override');
			var attach = selector.data('bg_img_attach');
			var anim_style= selector.data('upb-bg-animation');
			var al,bl,overlay_color='';
			var  overlay_color = selector.data('upb-overlay-color')
			if(overlay_color!=''){
				//overlay_color = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+'"></div>';
			}
			selector.prev().prepend('<div class="upb_row_bg">'+overlay_color+'</div>');
			var parent = selector.prev();
			selector.remove();
			selector = parent;
			selector.css('background-image','');
			selector = selector.find('.upb_row_bg');
			selector.attr('data-upb_br_animation',anim_style)
			if(size!='automatic'){
				selector.css({'background-size':size});
			}
			else{
				selector.addClass('upb_bg_size_automatic');
			}
			selector.css({'background-repeat':rep,'background-position':pos,'background-color':bg_color});
			if(style=='vcpb-fs-jquery' || style=='vcpb-mlvp-jquery'){
				selector.attr('data-img-array',bg);
			}
			else{
				selector.css({'background-image':bg,'background-attachment':attach})
			}

			selector.attr('data-parallax_sense',sense);
			selector.attr('data-bg-override',ride);
			selector.addClass(style);
			var resize = function(){
				var w,h,ancenstor,al,bl;
				ancenstor = selector.parent();
				if(ride=='full'){
					ancenstor= jQuery('body');
					al=0;

				}
				if(ride=='ex-full'){
					ancenstor= jQuery('html');
					al=0;
				}
				if( ! isNaN(ride)){
					for(var i=0;i<ride;i++){
						if(ancenstor.prop("tagName")!='HTML'){
							ancenstor = ancenstor.parent();
						}else{
							break;
						}

					}
					al = ancenstor.offset().left;
				}
				h = selector.parent().outerHeight();
				w = ancenstor.outerWidth();
				selector.css({'min-height':h+'px','min-width':w+'px'});
				bl = selector.offset().left;
				selector.css({'left':-(Math.abs(al-bl))+'px'});
				if(ride=='browser_size'){
					selector.parent().css('min-height',jQuery(window).height()+'px');
				}
			}
			resize();
			jQuery(window).resize(function(){
				resize();
			})
		})
		return this;
	}
	jQuery.fn.ultimate_grad_shift = function() {
		jQuery(this).each(function(){
			var selector =jQuery(this);
			var grad = selector.data('grad');
			var parent = selector.prev();
			var ride = jQuery(this).data('bg-override');
			var  overlay_color = selector.data('upb-overlay-color');
			var anim_style= selector.data('upb-bg-animation');
			if(overlay_color!=''){
				overlay_color = '<div class="upb_bg_overlay" style="background-color:'+overlay_color+'"></div>';
			}
			parent.prepend('<div class="upb_row_bg">'+overlay_color+'</div>');
			selector.remove();
			selector = parent;
			selector.css('background-image','');
			selector = selector.find('.upb_row_bg');
			selector.attr('data-upb_br_animation',anim_style)
			grad = grad.replace('url(data:image/svg+xml;base64,','');
	    	var e_pos = grad.indexOf(';');
	    	grad = grad.substring(e_pos+1);
			selector.attr('style',grad);
			selector.attr('data-bg-override',ride);
		})
		return this;
	}
	jQuery.fn.ultimate_parallax_animation = function(applyTo) {
		var windowHeight = jQuery(window).height();
		var getHeight = function(obj) {
				return obj.height();
			};
		var $this = jQuery(this);
		var prev_pos = jQuery(window).scrollTop();
		function update(){
			var firstTop;
			var paddingTop = 0;
			var pos = jQuery(window).scrollTop();
			$this.each(function(){
				if(jQuery(this).data('upb_br_animation')=='upb_fade_animation'){
					firstTop = jQuery(this).offset().top;
					var $element = jQuery(this);
					var top = $element.offset().top;
					var height = getHeight($element);
					if (top + height < pos || top > pos + windowHeight-100) {
						return;
					}
					var pos_change = prev_pos-pos;
					if ((top+height)-windowHeight < pos) {
						var op_c = (pos_change/windowHeight);
						if(applyTo=='parent'){
							var op = parseInt(jQuery(this).css('opacity'));
							console.log(pos_change)
							op += op_c/2.3;
							console.log(op)
							jQuery(this).parents('.wpb_row').css({opacity :op})
						}

						if(applyTo=='self'){
							var op = parseInt(jQuery(this).css('opacity'));
							op += op_c/2.3;
							//console.log(op)
							jQuery(this).css({opacity :op})
						}
					}
					prev_pos = pos;
				}
			});

		}

		jQuery(window).bind('scroll', update).resize(update);
		update();
	}
}( jQuery ));
 // Auto Initialization
 jQuery(document).ready(function(){

 	//if(!jQuery.browser.mobile){
	 	jQuery('.upb_content_video, .upb_content_iframe').prev().css('background-image','').css('background-repeat','');
		jQuery('.upb_content_video').ultimate_video_bg();
		jQuery('.upb_bg_img').ultimate_bg_shift();
		jQuery('.upb_no_bg').prev().css('background-image','').css('background-repeat','');
		jQuery('.upb_content_iframe').ultimate_video_bg();
		jQuery('.upb_grad').ultimate_grad_shift();
		//jQuery('.upb_row_bg').ultimate_parallax_animation('parent');
		var resizees = function(){
	    	jQuery('.upb_row_bg').each(function() {
				var ride = jQuery(this).data('bg-override');
				var ancenstor,parent;
				parent = jQuery(this).parent();

				if(ride=='browser_size'){
					ancenstor=jQuery('html');
				}
				if(ride == 'ex-full'){
					ancenstor = jQuery('html');
				}
				else if(ride == 'full'){
					ancenstor = jQuery('body');
				}
				//if ( isNaN( ride ) ) {	return;	}
				else if(! isNaN(ride)){
					ancenstor = parent;
					for ( var i = 0; i < ride; i++ ) {
						if ( ancenstor.is('html') ) {
							break;
						}
						ancenstor = ancenstor.parent();
					}
				}
				var al= parseInt( ancenstor.css('paddingLeft') );
				var ar= parseInt( ancenstor.css('paddingRight') )
				//console.log(al+' '+ar);
				var w = al+ar + ancenstor.width();
				var bl = - ( parent.offset().left - ancenstor.offset().left );
				//console.log(bl);
				if ( bl > 0 ) {	left = 0; }
				jQuery(this).css({'width': w,'left': bl	})
				if(ride=='browser_size'){
					parent.css('min-height',jQuery(window).height()+'px');
				}
			});
			jQuery('.upb_video-bg').each(function() {
				var ride = jQuery(this).data('bg-override');
				var ancenstor,parent;
				parent = jQuery(this).parent();
				if(ride=='browser_size'){
					ancenstor=jQuery('html');
				}
				if(ride == 'ex-full'){
					ancenstor = jQuery('html');
					jQuery(this).parents('.upb_video_class').css('overflow','visible');
				}
				else if(ride == 'full'){
					ancenstor = jQuery('body');
					jQuery(this).parents('.upb_video_class').css('overflow','visible');
				}
				//if ( isNaN( ride ) ) {	return;	}
				else if(! isNaN(ride)){
					ancenstor = parent;
					for ( var i = 0; i < ride; i++ ) {
						if ( ancenstor.is('html') ) {
							break;
						}
						ancenstor = ancenstor.parent();
						console.log(ancenstor.attr('class'))
						if(ancenstor.hasClass('upb_video_class')){
							ancenstor.css('overflow','visible');
						}
					}
				}
				var al= parseInt( ancenstor.css('paddingLeft') );
				var ar= parseInt( ancenstor.css('paddingRight') )
				//console.log(al+' '+ar);
				var w = al+ar + ancenstor.width();
				var bl = - ( parent.offset().left - ancenstor.offset().left );
				//console.log(bl);
				if ( bl > 0 ) {	left = 0; }
				jQuery(this).css({'width': w,'left': bl	})
				if(ride=='browser_size'){
					parent.css('min-height',jQuery(window).height()+'px');
				}
			});
			/*jQuery('.upb_bg_size_automatic.vcpb-vz-jquery').each(function(){
				var vh = jQuery(window).outerHeight();
				var bh = jQuery(this).parent().outerHeight();
				var speed = jQuery(this).data('parallax_sense');
				var ih = (((vh+bh)/100)*speed)+bh;
				jQuery(this).css('background-size','auto '+ih+'px')
			})
			jQuery('.upb_bg_size_automatic.vcpb-hz-jquery').each(function(){
				var vh = jQuery(window).outerHeight();
				var bh = jQuery(this).parent().outerHeight();
				var speed = jQuery(this).data('parallax_sense');
				var bw = jQuery(this).outerWidth()
				var ih = (((vh+bh)/100)*speed)+bw;
				jQuery(this).css('background-size',ih+'px auto');
			})
			jQuery('.upb_bg_size_automatic.vcpb-hz-jquery').each(function(){

			})*/
		};
		resizees();
		//jQuery('.upb_video-bg').parents('.upb_video_class').css('overflow','visible');

		jQuery(window).resize(function(){
			resizees();
		})
		//jQuery('.upb_video_class').ultimate_parallax_animation('self');
	//}
 })

	