/**
 * Created by smart on 12.12.17.
 */


/*-----------Open modal when try close website------------*/

function getCookieMy(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
// проверяем, есть ли у нас cookie, с которой мы не показываем окно и если нет, запускаем показ
var alertwin = getCookieMy("alertwin");
if (alertwin != "no") {
    $(document).mouseleave(function(e){
        if (e.clientY < 0) {
            var alertwinCheck = getCookieMy("alertwin");
            if(alertwinCheck!="no"){
                $('#alertwinMouseleave').modal("show");
                // записываем cookie на 1 день, с которой мы не показываем окно
                var date = new Date;
                date.setDate(date.getDate() + 1);
                document.cookie = "alertwin=no; path=/; expires=" + date.toUTCString();
            }
        }
    });

}


/*-----------------EXPRESS-----------------*/

$('#submitemail').click(function(){
    var ischecked = $("#agreeemail").prop('checked');
    var email = $('#email').val();
    var type = $('#type').val();

    if(!validateEmail(email)){
        alert("Введите email!");
    }else if(!ischecked){
        alert("Вы забыли поставить галочку :)");
    }else{
        window.location.href = 'korzina.php?type='+type+'&email='+email;
    }
});

/*----------------PROGNOZ-----------------------*/

$('#submitemail_prognoz').click(function(){
    var ischecked = $("#agreeemail").prop('checked');
    var email = $('#email').val();
    var type = $('#type').val();
    var id = $('#id').val();

    if(!validateEmail(email)){
        alert("Введите email!");
    }else if(!ischecked){
        alert("Вы забыли поставить галочку :) ");
    }else{
        window.location.href = 'korzina.php?type='+type+'&email='+email+'&id='+id;
    }
});

/*------------------------------------------------*/



$('.btn-podpiska').click(function(){
    var email_podpiska = $('#email-podpiska').val();

    if(validateEmail(email_podpiska)){
        $.post('podpiska-ajax.php',{email_podpiska:email_podpiska},function(data){
            if(data=="ok"){
                alert("На ваш email выслано письмо для подтверждения!");
            }else{
                alert("Ваша подписка уже оформелна!");
            }
        });
    }else{
        alert("Введите правильно email!");
    }

});


/*----------------CHAT-------------*/

$('.showpredlogprognoz').click(function(){
    $('.usersprognoz').hide();
    $('.usersprognoz_buttons').hide();
    $('.form-userprognoz').slideDown( "slow", function() {});
});

$('.showpredlogprognoz_nouser').click(function(){
    alert("Чтобы добавить прогноз, авторизуйтесь на сайте!");
});

/*$('.back_userprognoz').click(function(){
    $('.usersprognoz').slideDown( "slow", function() {});
    $('.usersprognoz_buttons').show();
    $('.form-userprognoz').hide();
});*/

$('.sendprognoz').click(function(){
    $('#userprognoz_championat_error').text("");
    $('#userprognoz_time_error').text("");
    $('#userprognoz_komandi_error').text("");
    $('#userprognoz_prognoz_error').text("");
    $('#userprognoz_koef_error').text("");


    var userprognoz_championat = $('#userprognoz_championat').val();
    var userprognoz_time = $('#userprognoz_time').val();
    var userprognoz_komandi = $('#userprognoz_komandi').val();
    var userprognoz_prognoz = $('#userprognoz_prognoz').val();
    var userprognoz_koef = $('#userprognoz_koef').val();

    if(userprognoz_championat.length==0){
        $('#userprognoz_championat_error').text("Введите Чемпионат!");
    }else if(userprognoz_time.length<5){
        $('#userprognoz_time_error').text("Введите время начала матча!");
    }else if(userprognoz_komandi.length==0){
        $('#userprognoz_komandi_error').text("Введите название команд!");
    }else if(userprognoz_prognoz.length==0){
        $('#userprognoz_prognoz_error').text("Введите прогноз!");
    }else if(userprognoz_koef.length==0){
        $('#userprognoz_koef_error').text("Введите коэффициет!");
    }else{
        $.post('user_addprognoz.php',
            {
                userprognoz_championat:userprognoz_championat,
                userprognoz_time:userprognoz_time,
                userprognoz_komandi:userprognoz_komandi,
                userprognoz_prognoz:userprognoz_prognoz,
                userprognoz_koef:userprognoz_koef
            },function(data){
                var obj = JSON.parse(data);
                if(obj.error=='no'){
                    var championat = obj.championat;
                    var time = obj.time;
                    var komandi = obj.komandi;
                    var prognoz = obj.prognoz;
                    var koef = obj.koef;
                    var name = obj.name;

                    var prognoz = "<p>"+championat+"<br>"+komandi+"<br>"+time+"<br>"+prognoz+"<br>"+koef+"<br>"+name+"</p><hr>";
                    $('.usersprognoz').prepend(prognoz);

                    $('#userprognoz_championat_error').text("");
                    $('#userprognoz_time_error').text("");
                    $('#userprognoz_komandi_error').text("");
                    $('#userprognoz_prognoz_error').text("");
                    $('#userprognoz_koef_error').text("");

                    $('#userprognoz_championat').val("");
                    $('#userprognoz_time').val("");
                    $('#userprognoz_komandi').val("");
                    $('#userprognoz_prognoz').val("");
                    $('#userprognoz_koef').val("");

                    $('.form-userprognoz').hide();

                    $('.usersprognoz').show();
                    $('.usersprognoz_buttons').show();
                }
            });
    }

});



function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function closeNewmessagePopup() {
    $('.close_new_message_popup').click(function(){
        var idpage = $(this).attr('id-page');
        var typepage = $(this).attr('type-page');
        $.post('user_makeclose_messpopup.php',{idpage:idpage,typepage:typepage},function(data){
            $('.message_popup[page='+typepage+idpage+']').remove();
        });
    });
}

