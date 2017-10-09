
$(document).ready(function() {
    $('[data-ajax]').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var formData = {action: $(this).attr('data-ajax')};
        $(this).parent('form').find('input, textarea').each(function() {
            formData[$(this).attr('name')] = $(this).val();
        });
        $(this).parent('form').parent().find('[data-ajax-display]').html('');
        $.ajax({
            url: callBackURL,
            type: 'POST',
            data: formData,
            success: function(data) {
                for (var k in data){
                    if (data.hasOwnProperty(k)) {
                        var v = data[k];
                        for (var kk in v) {
                            if (v.hasOwnProperty(kk)) {
                                var vv = v[kk];
                                var elm = $('[data-ajax-display="' + kk + '"]');
                                elm.html(vv);
                                elm.css('display', 'block');
                                console.log(kk, vv, elm);
                            }
                        }
                    }
                }
            },
            error: function () {
                window.alert('Erreur lors de la communication avec le serveur. La demande n\'a pas pu être traitée.');
            }
        });
    });
});