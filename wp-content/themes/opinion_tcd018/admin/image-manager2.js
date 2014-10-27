jQuery(document).ready(function($){
	//Drag resizing
	if($('#tcd-w-logo-adjuster2').length > 0){
		var resizeRatio = $('#tcd-w-logo-adjuster2').attr('class').split('-');
		resizeRatio = resizeRatio[2] / resizeRatio[1];
		$('#tcd-w-logo-adjuster2 img').draggable({
			containment: 'parent',
			drag: function(){
				var top = Math.round(parseInt($(this).css('top'), 10) / resizeRatio);
				var left = Math.round(parseInt($(this).css('left'), 10) / resizeRatio);
				$('#dp-options-logotop2').val(top);
				$('#dp-options-logoleft2').val(left);
			}
		});
		$('#dp-adjust-realvalue2').click(function(e){
			e.preventDefault();
			var top = Math.round(parseInt($('#dp-options-logotop2').val(), 10) * resizeRatio);
			var left = Math.round(parseInt($('#dp-options-logoleft2').val(), 10) * resizeRatio);
			$('#tcd-w-footer-logo-adjuster2 img').css({
				top: top + 'px',
				left: left + 'px'
			});
		});
		var dpResizeValueDisplay = function(){
			var percent = parseInt($('#dp_resize_ratio2').val(), 10);
			if(isNaN(percent)){
				percent = 100;
			}
			var originalToDisplayRatio = percent / 100 / parseFloat($('input[name=dp_logo_to_resize_ratio2]').val());
			$('#dp_resized_height2').val(Math.round(parseInt($('input[name=dp_logo_resize_height2]').val(), 10) * originalToDisplayRatio));
			$('#dp_resized_width2').val(Math.round(parseInt($('input[name=dp_logo_resize_width2]').val(), 10) * originalToDisplayRatio));
		};
		$('#dp_logo_to_resize2').imgAreaSelect({
			handles: true,
			onSelectChange: function(img, selection){
				$('input[name=dp_logo_resize_height2]').val(selection.height);
				$('input[name=dp_logo_resize_width2]').val(selection.width);
				$('input[name=dp_logo_resize_left2]').val(selection.x1);
				$('input[name=dp_logo_resize_top2]').val(selection.y1);
				dpResizeValueDisplay();
			}
		});
		$('#dp_resize_ratio2').blur(function(e){
			var percent = parseInt($(this).val(), 10);
			if(isNaN(percent) || percent > 100){
				$(this).val(100);
			}
			dpResizeValueDisplay();
		});
		$('#dp-resize-canceler2').click(function(e){
			e.preventDefault();
			$('input[name=dp_logo_resize_left2]').val('');
			$('input[name=dp_logo_resize_top2]').val('');
			$('#dp_resized_height2').val('');
			$('#dp_resized_width2').val('');
		});
	}
});