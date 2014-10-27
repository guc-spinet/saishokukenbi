jQuery(document).ready(function($) {
  if($('body').hasClass('widgets-php')) {
    var current_item;
    var target_id;

    $(document).on('click', '.ml_ad_widget_headline', function(){
      $(this).toggleClass('active');
      $(this).next('.ml_ad_widget_box').toggleClass('open');
    });

    $(document).on('click', 'input.select-img', function(evt){
      window.ml_ad_original_send_to_editor = window.send_to_editor;
      window.send_to_editor = function(html) {
        if(current_item && target_id) {
          var imgurl = $('img',html).attr('src');
          current_item.siblings('.img').val(imgurl);
          $('#preview_'+target_id).html('<img src="'+imgurl+'" />');
          current_item = null;
          target_id = null;
        }
        window.send_to_editor = window.ml_ad_original_send_to_editor;
        tb_remove();
      }

      current_item = $(this);
      target_id = current_item.prev('input').attr('id');
      tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
      return false;
    });

    $(document).on('click', '.delete-img', function(e) {
      $(this).prev('input').val(0);
      $(this).prev().prev('.preview_field').hide();
      $(this).closest('form').find('[name=savewidget]').trigger('click');
    });
  }
});