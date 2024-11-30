$(document).ready(function () {

    /*Tooltip*/    
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    /*Tooltip*/

    /*Search You Send*/
    var $block1 = $('.no-result-from');

    $(document).on("input keyup", "#search_from", function() {
        var val = $(this).val().toLowerCase();
        var isMatch = false;

        $("#exchange_from_list li:not('.exclude-search')").each(function (i) {
            var content = $(this).text();
            if (content.toLowerCase().indexOf(val) == -1) {
                $(this).hide();
                $('.exclude-search').hide();
            } else {
                isMatch = true;
                $(this).show();
                $('.exclude-search').show();
            }
        });
        $block1.toggle(!isMatch);
    });
    /*Search You Send*/

    /*Search You Get*/
    var $block2 = $('.no-result-to');

    $(document).on("input keyup", "#search_to", function() {
        var val = $(this).val().toLowerCase();
        var isMatch = false;

        $("#exchange_to_list li:not('.exclude-search')").each(function (i) {
            var content = $(this).text();
            if (content.toLowerCase().indexOf(val) == -1) {
                $(this).hide();
                $('.exclude-search').hide();
            } else {
                isMatch = true;
                $(this).show();
                $('.exclude-search').show();
            }
        });
        $block2.toggle(!isMatch);
    });
    /*Search You Get*/

    /*Close Respectively*/
    $('#exchange_from, #exchange_from').change(function () {
        if($('#exchange_from').is(':checked')){
            $('#exchange_to').prop('checked', false);
            console.log('close to');
        }
        else if($('#exchange_to').is(':checked')){
            $('#exchange_from').prop('checked', false);
            console.log('close from');
        }
        else{
            $('#exchange_to').prop('checked', false);
            $('#exchange_from').prop('checked', false);
            console.log('close all');
        }
    });
    /*Close Respectively*/

    /*Copy Text*/
    $('.copy-to-clipboard').click(function() {
        var copyText = $('.copy-text');
        copyToClipboard(copyText);
    });
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $('.copy-to-clipboard i').removeClass('fa-copy').addClass('fa-clipboard');
        $('.copy-to-clipboard').attr('data-bs-original-title','Copied').tooltip('show');
        setTimeout(() => {            
            $('.copy-to-clipboard i').removeClass('fa-clipboard').addClass('fa-copy');
            $('.copy-to-clipboard').attr('data-bs-original-title','Copy');
        }, 3000);
        $temp.remove();
    }

    $('.copy-to-clipboard.hash-out').click(function() {
        var copyText = $('#hash_out');
        copyToClipboardHash(copyText);
    });
    function copyToClipboardHash(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $('.copy-to-clipboard span.icon').removeClass('icon-copy').addClass('icon-copied');
        $('.copy-text').text('Copied');
        setTimeout(() => {            
            $('.copy-to-clipboard span.icon').removeClass('icon-copied').addClass('icon-copy');
            $('.copy-text').text('Copy');
        }, 3000);
        $temp.remove();
    }
    
    /*Copy Text*/
});