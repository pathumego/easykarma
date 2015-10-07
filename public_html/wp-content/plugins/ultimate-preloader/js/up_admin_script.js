jQuery(document).ready(function($) {

    $('.color').each(function() {
        if (this.id) {
            $('#' + this.id + '_picker').farbtastic('#' + this.id);
        };
    }).click(function() {
        $(this).next().fadeIn();
    });

    $('.color-picker-abs').hide();

    $(document).mousedown(function() {
        $('.color-picker-abs:visible').fadeOut();
    });

    $('#upload_image_button').click(function() {
        tb_show('Upload an image', 'media-upload.php?referer=up_options_page&type=image&TB_iframe=true&post_id=0', false);
        return false;
    });

    $('input:checkbox.chck_me').checkbox();

    $( "#up_sortable" ).sortable({
        cancel: "li.no_move",
        stop: function(event, ui) {
            $('#bg_image_position_opt').val(ui.item.index());
        }
    });

    $( "#up_sortable_perc" ).sortable({
        cancel: "li.no_move",
        stop: function(event, ui) {
            $('#percetange_position_opt').val(ui.item.index());
        }
    });


    $( "#up_sortable, #up_sortable_perc" ).disableSelection();


    jQuery.fn.tzCheckbox = function(options){
        options = jQuery.extend({
            labels : ['ON','OFF']
        },options);

        return this.each(function(){
            var originalCheckBox = jQuery(this), labels = [];

            if(originalCheckBox.data('on')){
                labels[0] = originalCheckBox.data('on');
                labels[1] = originalCheckBox.data('off');
            }
            else labels = options.labels;

            var checkBox = jQuery('<span>');
            checkBox.addClass(this.checked?' tzCheckBox checked':'tzCheckBox');
            checkBox.prepend('<span class="tzCBContent">'+labels[this.checked?0:1]+ '</span><span class="tzCBPart"></span>');

            checkBox.insertAfter(originalCheckBox.hide());

            checkBox.click(function(){
                checkBox.toggleClass('checked');

                var isChecked = checkBox.hasClass('checked');
                originalCheckBox.attr('checked',isChecked);
                checkBox.find('.tzCBContent').html(labels[isChecked?0:1]);
            });

            originalCheckBox.bind('change',function(){
                checkBox.click();
            });
        });
    };

    jQuery('.ch_location').tzCheckbox({
        labels:['On','Off']
        });
});

window.send_to_editor = function(html) {
    var image_url = jQuery('img',html).attr('src');
    jQuery('#image_url').val(image_url);
    tb_remove();
    jQuery('#submit-up-options').trigger('click');
}