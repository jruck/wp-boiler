(function($) {
  "use strict";
  	jQuery(window).load(function(){
  		// FLIP BOX START
  		var flip_resize_count=0, flip_time_resize=0;  		
  		var flip_box_resize = function(){
			jQuery('.ifb-jq-height').each(function(){			
				jQuery(this).find('.ifb-back').css('height','auto');
				jQuery(this).find('.ifb-front').css('height','auto');
				var fh = parseInt(jQuery(this).find('.ifb-front').outerHeight(true));
				var bh = parseInt(jQuery(this).find('.ifb-back').outerHeight(true));
				var gr = (fh>bh)?fh:bh;

				jQuery(this).find('.ifb-front').css('height',gr+'px');
				jQuery(this).find('.ifb-back').css('height',gr+'px');
				//viraj
				if(jQuery(this).hasClass('vertical_door_flip')) {
					jQuery(this).find('.ifb-flip-box').css('height',gr+'px');
				}
				else if(jQuery(this).hasClass('horizontal_door_flip')) {
					jQuery(this).find('.ifb-flip-box').css('height',gr+'px');
				}
				else if(jQuery(this).hasClass('style_9')) {
					jQuery(this).find('.ifb-flip-box').css('height',gr+'px');
				}
			})	
			
			jQuery('.ifb-auto-height').each(function(){
				if( (jQuery(this).hasClass('horizontal_door_flip')) || (jQuery(this).hasClass('vertical_door_flip')) ){
					var fh = parseInt(jQuery(this).find('.ifb-front').outerHeight());
					var bh = parseInt(jQuery(this).find('.ifb-back').outerHeight());
					var gr = (fh>bh)?fh:bh;
					jQuery(this).find('.ifb-flip-box').css('height',gr+'px');
				}
			})

		}		
		if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){			
			setTimeout(function() {
				flip_box_resize();	
			}, 500);	
		}
		else{
			flip_box_resize()
		}
		jQuery(window).resize(function(){
			flip_resize_count++;
			setTimeout(function() {
				flip_time_resize++;
				if(flip_resize_count == flip_time_resize){
					flip_box_resize();					
				}
			}, 500);
			
		})

		// FLIP BOX END
		var tiid=0;
		var mason_des=0;
		jQuery(window).resize(function(){
					if(jQuery('.smile-icon-timeline-wrap.jstime .timeline-line').css('display')=='none'){
				if(mason_des===0){
					$('.jstime .timeline-wrapper').masonry('destroy');
					mason_des=1;
				}
			}else{
				if(mason_des==1){					
					jQuery('.jstime .timeline-wrapper').masonry({
						"itemSelector": '.timeline-block',					
					});
					setTimeout(function() {
						jQuery('.jstime .timeline-wrapper').masonry({
							"itemSelector": '.timeline-block',					
						});
						jQuery(this).find('.timeline-block').each(function(){
							if(jQuery(this).css('left')=='0px'){
								jQuery(this).addClass('timeline-post-left');
							}
							else{
								jQuery(this).addClass('timeline-post-right');
							}
						});
						mason_des=0;
					}, 300);
				}				

			}
		});
		$('.smile-icon-timeline-wrap').each(function(){			
			var cstm_width = jQuery(this).data('timeline-cutom-width');
			if(cstm_width){
				jQuery(this).css('width',((cstm_width*2)+40)+'px');
			}
			//$(this).find('.smile_icon_timeline').attr('id','timeline-wrapper-'+(++tiid));
			// Initialize Masonry
			var width = parseInt(jQuery(this).width());
			var b_wid = parseInt(jQuery(this).find('.timeline-block').width());				
			var l_pos = (b_wid/width)*100;
			if(jQuery(this).hasClass('jstime')){
				//jQuery(this).find('.timeline-line').css('left',l_pos+'%');
			}
			var time_r_margin = (width - (b_wid*2) - 40);			
			time_r_margin = (time_r_margin/width)*100;
			//jQuery(this).find('.timeline-separator-text').css('margin-right',time_r_margin+'%');
			//jQuery(this).find('.timeline-feature-item').css('margin-right',time_r_margin+'%');
			$('.jstime .timeline-wrapper').each(function(){
				jQuery(this).masonry({
					"itemSelector": '.timeline-block',
					//gutter : 40
				});
			});
			setTimeout(function() {
				$('.jstime .timeline-wrapper').each(function(){
					jQuery(this).find('.timeline-block').each(function(){
						if(jQuery(this).css('left')=='0px'){
							jQuery(this).addClass('timeline-post-left');
						}
						else{
							jQuery(this).addClass('timeline-post-right');
						}
					});
					jQuery('.timeline-block').each(function(){
						var div=parseInt(jQuery(this).css('top'))-parseInt(jQuery(this).next().css('top'));
						//console.log(jQuery(this).css('top'))
						//console.log(jQuery(this).next().css('top'))
						if((div < 14 && div > 0)|| div==0) {
							//console.log('clash-right'+div)
							jQuery(this).next().addClass('time-clash-right');
						}
						else if(div > -14){
							//console.log('clash-left'+div)
							jQuery(this).next().addClass('time-clash-left');
						}
					})
					// Block bg
					jQuery('.smile-icon-timeline-wrap').each(function(){
						var block_bg =jQuery(this).data('time_block_bg_color');
						jQuery(this).find('.timeline-block').css('background-color',block_bg);
					    jQuery(this).find('.timeline-post-left.timeline-block l').css('border-left-color',block_bg);
					    jQuery(this).find('.timeline-post-right.timeline-block l').css('border-right-color',block_bg);	
					    jQuery(this).find('.feat-item').css('background-color',block_bg);	
					    jQuery(this).find('.feat-item l').css('border-bottom-color',block_bg);	
					})
					jQuery('.jstime.timeline_preloader').remove();
					jQuery('.smile-icon-timeline-wrap.jstime').css('opacity','1');
				});
				jQuery('.timeline-post-right').each(function(){
					var cl = jQuery(this).find('.timeline-icon-block').clone();
					jQuery(this).find('.timeline-icon-block').remove(); 
					jQuery(this).find('.timeline-header-block').after(cl);

				})
			}, 1000);
			jQuery(this).find('.timeline-wrapper').each(function(){
				if(jQuery(this).text().trim()===''){
					jQuery(this).remove();
				}
			});
			if( ! jQuery(this).find('.timeline-line ').next().hasClass('timeline-separator-text')){
				jQuery(this).find('.timeline-line').prepend('<o></o>');
			}			
			var sep_col = jQuery(this).data('time_sep_color');
			var sep_bg =jQuery(this).data('time_sep_bg_color');
			
			
			var line_color = jQuery('.smile-icon-timeline-wrap .timeline-line').css('border-right-color');
			jQuery(this).find('.timeline-dot').css('background-color',sep_bg);
			jQuery(this).find('.timeline-line z').css('background-color',sep_bg);
			jQuery(this).find('.timeline-line o').css('background-color',sep_bg);
			// Sep Color
			jQuery(this).find('.timeline-separator-text').css('color',sep_col);
			jQuery(this).find('.timeline-separator-text .sep-text').css('background-color',sep_bg);
			jQuery(this).find('.ult-timeline-arrow s').css('border-color','rgba(255, 255, 255, 0) '+line_color);
			jQuery(this).find('.feat-item .ult-timeline-arrow s').css('border-color',line_color+' rgba(255, 255, 255, 0)');
			jQuery(this).find('.timeline-block').css('border-color',line_color);
			jQuery(this).find('.feat-item').css('border-color',line_color);
  		});
		jQuery('.timeline-block').each(function(){
			var link_b = $(this).find('.link-box').attr('href');
			var link_t = $(this).find('.link-title').attr('href');
			if(link_b){				
				jQuery(this).wrap('<a href='+link_b+'></a>')
				//var htht = jQuery(this).html();
				//jQuery(this).html('<a href='+link_b+'>'+htht+'</a>')
				//jQuery(this).find('.timeline-header-block').wrap('<a href='+link_b+'></a>')
				//jQuery(this).find('.timeline-icon-block').wrap('<a href='+link_b+'></a>')
			}
			if(link_t){
				jQuery(this).find('.ult-timeline-title').wrap('<a href='+link_t+'></a>')
			}
		});
		jQuery('.feat-item').each(function(){
			var link_b = $(this).find('.link-box').attr('href');			
			if(link_b){				
				jQuery(this).wrap('<a href='+link_b+'></a>')
			}
		});
	});	
	jQuery(document).ready(function() {
		jQuery('.smile-icon-timeline-wrap.jstime').css('opacity','0');
		jQuery('.jstime.timeline_preloader').css('opacity','1');
		jQuery('.smile-icon-timeline-wrap.csstime .timeline-wrapper').each(function(){
			jQuery('.csstime .timeline-block:even').addClass('timeline-post-left');
			jQuery('.csstime .timeline-block:odd').addClass('timeline-post-right');
		})
		jQuery('.csstime .timeline-post-right').each(function(){
			jQuery(this).css('float','right');
			jQuery("<div style='clear:both'></div>").insertAfter(jQuery(this));
		})
		jQuery('.csstime.smile-icon-timeline-wrap').each(function(){
			var block_bg =jQuery(this).data('time_block_bg_color');
			jQuery(this).find('.timeline-block').css('background-color',block_bg);
		    jQuery(this).find('.timeline-post-left.timeline-block l').css('border-left-color',block_bg);
		    jQuery(this).find('.timeline-post-right.timeline-block l').css('border-right-color',block_bg);	
		    jQuery(this).find('.feat-item').css('background-color',block_bg);	
		    jQuery(this).find('.feat-item l').css('border-bottom-color',block_bg);	
		})
		// CSS3 Transitions.
		jQuery('*').each(function(){
			if(jQuery(this).attr('data-animation')) {
				var animationName = jQuery(this).attr('data-animation'),
					animationDelay = "delay-"+jQuery(this).attr('data-animation-delay');
				jQuery(this).bsf_appear(function() {
					jQuery(this).addClass('animated').addClass(animationName);
					jQuery(this).addClass('animated').addClass(animationDelay);
				});
			} 
		});
		// Icon Tabs
	
		
	
		// Stats Counter
		jQuery('.stats-block').each(function() {
			jQuery(this).bsf_appear(function() {
				var endNum = parseFloat(jQuery(this).find('.stats-number').data('counter-value'));
				var Num = (jQuery(this).find('.stats-number').data('counter-value'))+' ';
				var speed = parseInt(jQuery(this).find('.stats-number').data('speed'));
				var ID = jQuery(this).find('.stats-number').data('id');
				var sep = jQuery(this).find('.stats-number').data('separator');
				var dec = jQuery(this).find('.stats-number').data('decimal');
				var dec_count = Num.split(".");
				if(dec_count[1]){
					dec_count = dec_count[1].length-1;
				} else {
					dec_count = 0;
				}
				var grouping = true;
				if(dec == "none"){
					dec = "";
				}
				if(sep == "none"){
					grouping = false;
				} else {
					grouping = true;
				}
				var settings = {
					useEasing : true, 
					useGrouping : grouping, 
					separator : sep, 
					decimal : dec
				}
				var counter = new countUp(ID, 0, endNum, dec_count, speed, settings);
				setTimeout(function(){
					counter.start();
				},500);
			});
		});
		// Flip-box	
		var is_touch_device = 'ontouchstart' in document.documentElement;		
		jQuery('#page').click(function(){			
			jQuery('.ifb-hover').removeClass('ifb-hover');
		});
		if(!is_touch_device){
			jQuery('.ifb-flip-box').hover(function(event){			
				event.stopPropagation();				
				jQuery(this).addClass('ifb-hover');	
				
			},function(event){
				event.stopPropagation();
				jQuery(this).removeClass('ifb-hover');			
			});
		}
		
		jQuery('.ifb-flip-box').each(function(index, element) {
			if(jQuery(this).parent().hasClass('style_9')) {
				
				jQuery(this).hover(function(){
						jQuery(this).addClass('ifb-door-hover');						
					},
					function(){
						jQuery(this).removeClass('ifb-door-hover');
					})
				
				jQuery(this).on('click',function(){
						jQuery(this).toggleClass('ifb-door-right-open');
						jQuery(this).removeClass('ifb-door-hover');						
					});
				
			}
		});

		
		jQuery('.ifb-flip-box').click(function(event){
			event.stopPropagation();
			if(jQuery(this).hasClass('ifb-hover')){				
				jQuery(this).removeClass('ifb-hover');							
			}
			else{
				jQuery('.ifb-hover').removeClass('ifb-hover');
				jQuery(this).addClass('ifb-hover');
			}
		});
		/*
		jQuery('.timeline-wrapper').each(function(){
			var timeline_icon_width = jQuery(this).find('.timeline-block .timeline-icon-block').width();
			jQuery(this).find('.timeline-post-left.timeline-block .timeline-icon-block').css('left', timeline_icon_width/2);
			jQuery(this).find('.timeline-post-right.timeline-block .timeline-icon-block').css('left', timeline_icon_width/-2);			
		})
		jQuery(window).resize(function(){
			jQuery('.timeline-wrapper').each(function(){
				var timeline_icon_width = jQuery(this).find('.timeline-block .timeline-icon-block').width();
				jQuery(this).find('.timeline-post-left.timeline-block .timeline-icon-block').css('left', timeline_icon_width/2);
				jQuery(this).find('.timeline-post-right.timeline-block .timeline-icon-block').css('left', timeline_icon_width/-2);			
			})
		})*/		
		/*
		jQuery('.timeline-wrapper').each(function(){
			var timeline_icon_width = jQuery(this).find('.timeline-block .timeline-icon-block').width();
			jQuery(this).find('.timeline-post-left.timeline-block').css('left', timeline_icon_width/2);
			jQuery(this).find('.timeline-post-right.timeline-block').css('left', timeline_icon_width/-2);			
		})
		jQuery(window).resize(function(){
			jQuery('.timeline-wrapper').each(function(){
				var timeline_icon_width = jQuery(this).find('.timeline-block .timeline-icon-block').width();
				jQuery(this).find('.timeline-post-left.timeline-block').css('left', timeline_icon_width/2);
				jQuery(this).find('.timeline-post-right.timeline-block').css('left', timeline_icon_width/-2);			
			})
		})
		*/
	
	
	
	
		//Flipbox
			//Vertical Door Flip
			jQuery('.vertical_door_flip .ifb-front').each(function() {
				jQuery(this).wrap('<div class="v_door ifb-multiple-front ifb-front-1"></div>');
				jQuery(this).parent().clone().removeClass('ifb-front-1').addClass('ifb-front-2').insertAfter(jQuery(this).parent());
			});
	
			//Reverse Vertical Door Flip
			jQuery('.reverse_vertical_door_flip .ifb-back').each(function() {
				jQuery(this).wrap('<div class="rv_door ifb-multiple-back ifb-back-1"></div>');
				jQuery(this).parent().clone().removeClass('ifb-back-1').addClass('ifb-back-2').insertAfter(jQuery(this).parent());
			});

			//Horizontal Door Flip
			jQuery('.horizontal_door_flip .ifb-front').each(function() {
				jQuery(this).wrap('<div class="h_door ifb-multiple-front ifb-front-1"></div>');
				jQuery(this).parent().clone().removeClass('ifb-front-1').addClass('ifb-front-2').insertAfter(jQuery(this).parent());
			});
	
			//Reverse Horizontal Door Flip
			jQuery('.reverse_horizontal_door_flip .ifb-back').each(function() {
				jQuery(this).wrap('<div class="rh_door ifb-multiple-back ifb-back-1"></div>');
				jQuery(this).parent().clone().removeClass('ifb-back-1').addClass('ifb-back-2').insertAfter(jQuery(this).parent());
			});
	
	
	
			//Stlye 9 front
			jQuery('.style_9 .ifb-front').each(function() {
				jQuery(this).wrap('<div class="new_style_9 ifb-multiple-front ifb-front-1"></div>');
				jQuery(this).parent().clone().removeClass('ifb-front-1').addClass('ifb-front-2').insertAfter(jQuery(this).parent());
			});
	
			//Style 9 back
			jQuery('.style_9 .ifb-back').each(function() {
				jQuery(this).wrap('<div class="new_style_9 ifb-multiple-back ifb-back-1"></div>');
				jQuery(this).parent().clone().removeClass('ifb-back-1').addClass('ifb-back-2').insertAfter(jQuery(this).parent());
			});
			
			
				
			if( jQuery.browser.safari ){
				jQuery('.vertical_door_flip').each(function(index, element) {
                    var safari_link = jQuery(this).find('.flip_link').outerHeight();
					jQuery(this).find('.flip_link').css('top', - safari_link/2 +'px');
                    jQuery(this).find('.ifb-multiple-front').css('width', '50.2%');
                });
				jQuery('.horizontal_door_flip').each(function(index, element) {
                    var safari_link = jQuery(this).find('.flip_link').outerHeight();
					jQuery(this).find('.flip_link').css('top', - safari_link/2 +'px');
                    jQuery(this).find('.ifb-multiple-front').css('height','50.2%');
                });
				jQuery('.reverse_vertical_door_flip').each(function(index, element) {
                    var safari_link = jQuery(this).find('.flip_link').outerHeight();
					jQuery(this).find('.flip_link').css('top', - safari_link/2 +'px');
                });
				jQuery('.reverse_horizontal_door_flip').each(function(index, element) {
                    var safari_link = jQuery(this).find('.flip_link').outerHeight();
					jQuery(this).find('.flip_link').css('top', - safari_link/2 +'px');
					
					jQuery(this).find('.ifb-back').css('position', 'inherit');
                });
			}

			
			
			
			//Info Box
			jQuery('.square_box-icon').each(function(index, element) {
                var ib_box_style_icon_height = parseInt(jQuery(this).find('.aio-icon').outerHeight());
				var ib_padding = ib_box_style_icon_height/2;
				//var icon_pos = ib_box_style_icon_height*2;
				jQuery(this).css('padding-top', ib_padding+'px');
				jQuery(this).parents().find('.aio-icon-component').css('margin-top', ib_padding+20+'px');
				jQuery(this).find('.aio-icon').css('top', - ib_box_style_icon_height+'px');
            });

			
	});
})(jQuery);
//ready