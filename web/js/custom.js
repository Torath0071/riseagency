
$(document).ready(function() {
    $('[data-ajax]').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var formData = {action: $(this).attr('data-ajax')};
        var form = $('form[data-form=' + formData.action + ']');
        form.find('input, textarea').each(function() {
            formData[$(this).attr('name')] = $(this).val();
        });
        form.parent().find('[data-ajax-display]').html('').removeClass('error');
        console.log(formData);
        $.ajax({
            url: callBackURL,
            type: 'POST',
            data: formData,
            success: function(data) {
                var doClear = false;
                for (var k in data){
                    if (data.hasOwnProperty(k)) {
                        var v = data[k];
                        for (var kk in v) {
                            if (v.hasOwnProperty(kk)) {
                                if (kk == 'success') {
                                    doClear = true;
                                }
                                var vv = v[kk];
                                var elm = $('[data-ajax-display="' + kk + '"]');
                                elm.html(vv);
                                elm.css('display', 'block');
                                elm.addClass('error');
                            }
                        }
                    }
                }
                if (doClear) {
                    form.find('input, textarea').each(function() {
                        $(this).val('');
                    });
                }
            },
            error: function () {
                window.alert('Erreur lors de la communication avec le serveur. La demande n\'a pas pu être traitée.');
            }
        });
    });
});