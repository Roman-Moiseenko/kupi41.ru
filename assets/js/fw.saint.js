$(document).ready(function () {
    $('body').on('click', '#registration_submit', function () {
        if ($('#password').val() != $('#password2').val()) {
            //alert('Пароли не совпадают!');
            $('#error_password_2').removeAttr('style');
            $('#password2').attr('class', 'form-control form-control-sm is-invalid');
            return false;
        } else {
            $('#error_password_2').attr('style', 'display: none;');
            $('#password2').attr('class', 'form-control form-control-sm');
        }
        if ($('#firmcheck').is(':checked')) {
            var namefirm = $('#namefirm').val();
            var INN = $('#INN').val();
            var KPP = $('#KPP').val();
            var OGRN = $('#OGRN').val();
            var BIK = $('#BIK').val();
            var bank = $('#bank').val();
            var account = $('#account').val();
            $('#firm').val('{"namefirm":"'+ namefirm + '",' +
                            '"INN":"'+ INN + '","KPP":"'+ KPP + '",' +
                            '"OGRN":"'+ OGRN + '","BIK":"'+ BIK + '",' +
                            '"bank":"'+ bank + '","account":"'+ account + '"}');
        } else {$('#firm').val('');}
        $('#registration_form').submit();
        return true;
    });

    $('body').on('click', '#edit_submit', function () {
        if ($('#firmcheck').is(':checked')) {
            var namefirm = $('#namefirm').val();
            var INN = $('#INN').val();
            var KPP = $('#KPP').val();
            var OGRN = $('#OGRN').val();
            var BIK = $('#BIK').val();
            var bank = $('#bank').val();
            var account = $('#account').val();
            $('#firm').val('{"namefirm":"'+ namefirm + '",' +
                '"INN":"'+ INN + '","KPP":"'+ KPP + '",' +
                '"OGRN":"'+ OGRN + '","BIK":"'+ BIK + '",' +
                '"bank":"'+ bank + '","account":"'+ account + '"}');
        } else {$('#firm').val('');}
        $('#edit_form').submit();
        return true;
    });

    $('body').on('click', '#search_submit', function () {
        var str = $('#search_input').val();
        str = str.replace(/ +/g, ' ').trim();
        //alert(str);
        if (str.length == 0) return false;
        if (str.length <= 2) {
            alert('Слишком короткое ключево слово(не менее 3 символов)!'); return false;
        } else {
            $('#search_input').val(vl);
            $('#search_input').change();
            $('#search_form').submit();
            return true;
        }
    });

    $('body').on('input', '.only_dig', function () {
        var vl = $(this).val().replace(/\D/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        $(this).val(vl);
        $(this).change();
    });
    $('body').on('input', '.only_text', function () {
        var vl = $(this).val().replace(/[^a-zA-Z0-9а-яА-Я.,_\- ]/g, ''); //str.replace(/[^a-zA-Z ]/g, "")
        $(this).val(vl);
        $(this).change();
    });
    $('body').on('click', '#password_submit', function () {
        if ($('#password').val() != $('#password2').val()) {
            //alert('Пароли не совпадают!');
            $('#error_password_2').removeAttr('style');
            $('#password2').attr('class', 'form-control form-control-sm is-invalid');
            return false;
        } else {
            $('#error_password_2').attr('style', 'display: none;');
            $('#password2').attr('class', 'form-control form-control-sm');
        }

        $('#password_form').submit();
        return true;
    });

//AJAX Корзина!!!!!
    $('body').on('click', '.change_cart', function () {
        var idp = $(this).attr("data_id");
        var oper = $(this).attr("data_type");
        // Ajax запрос изменения кол-ва в корзине ДОДЕЛАТЬ на кнопки+,-, input
        var idinput = "#change_cart"+idp;
        var price = parseFloat($(idinput).attr('price'));
        var inputprice = parseInt($(idinput).val());
        if (oper == 2) {
            var count = parseInt(inputprice) - 1;
            count = count < 1 ? 1 : count;
            $(idinput).val(count);
            $(idinput).change();
        }
        if (oper == 1) {
            if(inputprice + 1 > parseInt($(idinput).attr("remains"))) return false; ////
            $(idinput).val(parseInt(inputprice) + 1);
            $(idinput).change();
        }
        count = parseInt($(idinput).val());

        $("#cart_price"+idp).html(number_format(price * count, 2, ',', ' '));
        $.post("/cart/change/"+idp, {oper: oper, count: count}, function (data) {$(".cart_count").html(data);});
        $.post("/cart/totalprice", {}, function (data) {$("#cart_sum").html(data);});
        $('#myModal').modal('show');
        setTimeout(function(){ $('#myModal').modal('hide');},2000);
        return false;
    });
    $('body').on('input', 'input', function () {
        if($(this).attr("name") == "count") {
            //подмена неправильно введеных символов
            var vl = $(this).val().replace(/[^0-9+]/, "");
            if (vl == "") {
                vl = "1";
            }
            if (parseInt(vl) == 0) {
                vl = 1;
            }
            if (parseInt(vl) > parseInt($(this).attr("remains"))) {vl = $(this).attr("remains");}
            $(this).val(vl);
            $(this).change();
        }
    });
    $('body').on('keyup', 'input', function () {
        if($(this).attr("name") == "count") {
            var idp = $(this).attr("data_id");
            var price = parseFloat($(this).attr('price'));
            var count = parseInt($(this).val());
            //alert(idp + '  ' + parseInt($(this).val()));
            $("#cart_price"+idp).html(number_format(price * count, 2, ',', ' '));
            $.post("/cart/change/" + idp, {oper: 3, count: count}, function (data) {$(".cart_count").html(data);});

            $.post("/cart/totalprice", {}, function (data) {$("#cart_sum").html(data);});
            return false;
        }
    });
    $('body').on('click','#delivery', function () {
        var delivery = $('#delivery').attr('delivery');
        var total = $('#total').attr('total');


        if ($('#delivery').is(':checked')) {
            $('#delivery_address').attr('style', 'color: green');
            $('#div_type_pay_1').attr('class', 'form-check disable');
            $('#radio_type_pay_1').prop('disabled', true);
            $('#radio_type_pay_2').prop('checked', true);
            //$('#radio_type_pay_3').prop('disabled', true);
            $('#delivery_sum').html('+ ' + delivery);
            var sum = parseFloat(total) + parseFloat(delivery);
            $('#total').html(number_format(sum, 2, ',', ' '));

        } else {
            $('#delivery_address').attr('style', 'color: grey'); //#5a6268
            $('#div_type_pay_1').attr('class', 'form-check');
            $('#radio_type_pay_1').prop('disabled', false);
            $('#delivery_sum').html('+ 0');
            $('#total').html(number_format(total, 2, ',', ' '));
        }

    });


    $('body').on('change', '.choose_file',function(e){
        //get the file name
        $(this).next('.custom-file-label').html(e.target.files[0].name);
        //var fileName = $(this).val();
        //replace the "Choose a file" label
        //$(this).next('.custom-file-label').html(fileName);
    });

    $('body').on('click', '.show_accord', function (e) {
        var rb = sessionStorage.getItem('reboot_btn');
        if (rb == '1') {
            sessionStorage.setItem('reboot_btn', '0');
            //$(this).click();
        } else {
            sessionStorage.setItem('reboot_btn', '1');

            var type_btn = $(this).attr('type_btn');
            if (type_btn == 'plus') {
                $(this).attr('type_btn', 'minus');
//                var target = $(this).attr('data-target');
                $(this).html('<i class="far fa-minus-square"></i>');
                // $(target).addClass('show');
  //              return true;
            } else { //if (type_btn == 'minus')
                $(this).attr('type_btn', 'plus');
                //var target = $(this).attr('data-target');
                $(this).html('<i class="far fa-plus-square"></i>');
                //$(target).removeClass('show');
//                return true;
            }
            $(this).click();
        }
    });


});

$(document).ready(function(){
    $("#accordion").dcAccordion();
});

function number_format(number, decimals, dec_point, separator ) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof separator === 'undefined') ? ',' : separator ,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };
    // Фиксим баг в IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

