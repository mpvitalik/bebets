$('.btn-leavecomment').click(function(){
    var comment = $('#comment').val();
    var prognozid = $(this).attr('prognoz-id');
    $.post('user_addcommentprognoz.php',{comment:comment,prognozid:prognozid},function(data){
        var ret_data = JSON.parse(data);

        if(ret_data.saved=="yes"){
            $('#comment').val("");
            $('#insert-ajax-comments').prepend("<div><div class=\"comment\" id=\"comment"+ret_data.idcomment+"\"><p><span class=\"comment-login\">"+ret_data.username+":</span> "+ret_data.text+"</p></div><p class=\"rightalign\" id=\"otvetp"+ret_data.idcomment+"\"> <span class=\"date_comment\">"+ret_data.datee+"</span> <a class=\"comment_otvetit\" id-comment=\""+ret_data.idcomment+"\"><small>Ответить</small></a>&nbsp; <a class=\"click_like\" data-type=\"like\" id-comment=\""+ret_data.idcomment+"\"> <i class=\"fa fa-thumbs-up grey\" aria-hidden=\"true\"></i> <span class=\"colorgreen likecount\" id-comment=\""+ret_data.idcomment+"\">0</span>&nbsp; </a> <a class=\"click_like\" data-type=\"dislike\" id-comment=\""+ret_data.idcomment+"\"> <i class=\"fa fa-thumbs-down grey\" aria-hidden=\"true\"></i> <span class=\"colorred dislikecount\" id-comment=\""+ret_data.idcomment+"\">0</span> </a></p><div class=\"subcoments_list\" id-comment=\""+ret_data.idcomment+"\">");
            $( ".comment_otvetit" ).unbind( "click" );
            $( ".click_like" ).unbind( "click" );
            clickLikeListener();
            clickCommentOtvetit();
        }else{
            alert("Комментарий не добавлен! Попробуйте еще раз!");
        }
    });
});

$('.btn-leavecomment-notreg').click(function(){
    var comment = $('#comment').val();
    var idprognoz = $(this).attr('prognoz-id');
    $.post('user_makecomment_toprogn_notreg.php',{idprognoz:idprognoz,comment:comment},function(data){
        $('#modal-golosovanie-notreg').modal('show');
    });
});


clickLikeListener();
clickCommentOtvetit();
clickSubcommentOtvetit();

var razvernut_all_comments = "no";
var razvernut_subcoments = [];
var added_comments = [];

$('.btn-replycomment').click(function(){
    var idcomment = $(this).attr('id-comment');
    var idsubcomment = $(this).attr('id-subcomment');
    var replycomment = $('#textcomment-modal').val();
    if(replycomment.length!=0 && replycomment!=" " && replycomment!="  " && replycomment!="   "){
        $('#textcomment-modal').val("");
        $('#modal-leavecomment').modal('hide');
        $.post('user_makereply_comment.php',{idcomment:idcomment,idsubcomment:idsubcomment,replycomment:replycomment},function(data){
            var comment_obj = JSON.parse(data);
            $('.subcoments_list[id-comment='+idcomment+']').append("<div class=\"subcomment\"><span class=\"written_comment\">"+comment_obj.login_replycomment+": "+comment_obj.text_replycomment+"</span><p><span class=\"comment-login\"><i class=\"fa fa-reply\" aria-hidden=\"true\"></i> "+comment_obj.username+":</span> "+comment_obj.replycomment+"</p></div><p class=\"rightalign\"> <span class=\"date_comment\">"+comment_obj.datee+"</span> <a class=\"subcomment_otvetit\" id-comment=\""+idcomment+"\" id-subcomment=\""+comment_obj.idreplycomment+"\"><small>Ответить</small></a>&nbsp; <a class=\"click_like\" data-type=\"like\" id-comment=\""+comment_obj.idreplycomment+"\"> <i class=\"fa fa-thumbs-up grey\" aria-hidden=\"true\"></i> <span class=\"colorgreen likecount\" id-comment=\""+comment_obj.idreplycomment+"\">0</span>&nbsp; </a> <a class=\"click_like\" data-type=\"dislike\" id-comment=\""+comment_obj.idreplycomment+"\"> <i class=\"fa fa-thumbs-down grey\" aria-hidden=\"true\"></i> <span class=\"colorred dislikecount\" id-comment=\""+comment_obj.idreplycomment+"\">0</span></a></p>");
            added_comments.push(comment_obj.idreplycomment);
            $( ".subcomment_otvetit" ).unbind( "click" );
            $( ".click_like" ).unbind( "click" );
            clickLikeListener();
            clickSubcommentOtvetit();
        });
    }else{
        alert("Напишите Ваш комментарий!");
    }

});

clickCommentOtvetitNotreg();
clickRazvernutAllComment();
clickRazvernutSubcomments();

$('.sort_comment').click(function(){
    var datasort = $(this).attr('data-sort');
    var scrollfromtop = document.documentElement.scrollTop;
    var date = new Date(new Date().getTime() + 60 * 1000);
    if(datasort=="date"){
        document.cookie = "comment_sort=date; path=/; expires=" + date.toUTCString();
        document.cookie = "scrollfromtop="+scrollfromtop+"; path=/; expires=" + date.toUTCString();
        window.location.reload();
    }else if(datasort=="popular"){
        document.cookie = "comment_sort=popular; path=/; expires=" + date.toUTCString();
        document.cookie = "scrollfromtop="+scrollfromtop+"; path=/; expires=" + date.toUTCString();
        window.location.reload();
    }
});


$('.golosbtn-proidet, .golosbtn-neproidet').click(function(){
    var idprognoz = $(this).attr('prognoz-id');
    var prohod = $(this).attr('prohod');
    var userreg = $(this).attr('userreg');

    if(userreg=="no"){
        if(prohod=="prohod"){
            $.post('user_makegolos_toprognoz.php',{idprognoz:idprognoz,prohod:prohod},function(data){
                if(data=='not-registered'){
                    $('#modal-golosovanie-notreg').modal('show');
                }
            });
        }else if(prohod=="neprohod"){
            $('#modal-golosovanie').modal('show');
        }
    }else if(userreg=="yes"){
        if(prohod=="prohod"){
            $.post('user_makegolos_toprognoz.php',{idprognoz:idprognoz,prohod:prohod},function(data){
                window.location.reload();
            });
        }else if(prohod=="neprohod"){
            $('#modal-golosovanie').modal('show');
        }
    }

});


$('.btn-golosmodalsend').click(function(){
    var prohod = "neprohod";
    var goloscomment = $('#golosmodal-comment').val();
    var idprognoz = $(this).attr('prognoz-id');

    if(goloscomment=="" || goloscomment==" " || goloscomment=="  "){
        alert("Сначала обоснуйте свое мнение!");
    }else{
        $('#golosmodal-comment').val("");
        $.post('user_makegolos_toprognoz.php',{idprognoz:idprognoz,prohod:prohod,goloscomment:goloscomment},function(data){
            if(data=='inserted'){
                window.location.reload();
            }else if(data=='not-registered'){
                $('#response-modal-golosovanie').html("<div class=\"centered\"> <p class=\"font16\">Оставлять комментарии могут только зарегистрированные пользователи!</p> <a href=\"register.php\" class=\"orange font16\">Регистрация</a> | <a href=\"enter.php\" class=\"orange font16\">Вход</a> </div><br>");
            }
        });
    }
});

$('.close_modalsend').click(function(){
    var prohod = "neprohod";
    var idprognoz = $(this).attr('prognoz-id');

    $('#golosmodal-comment').val("");
    $.post('user_makegolos_toprognoz.php',{idprognoz:idprognoz,prohod:prohod},function(data){
        if(data=='inserted'){
            window.location.reload();
        }else if(data=='not-registered'){
            $('#modal-golosovanie').modal('hide');
            $('#modal-golosovanie-notreg').modal('show');
        }
    });

});

/*===============================================*/


$(document).ready(function(){

    setInterval(function(){
        var json_razvernut_subcoments = JSON.stringify(razvernut_subcoments);
        var json_added_comments = JSON.stringify(added_comments);
        $.post('ajax-chechnewcooments.php',{prognozid:thisprognozid,commentssort:commentssort,razvernut_all_comments:razvernut_all_comments, json_razvernut_subcoments:json_razvernut_subcoments, json_added_comments:json_added_comments},function(data){
            $('#insert-ajax-comments').html(data);
            $( ".comment_otvetit" ).unbind( "click" );
            $( ".subcomment_otvetit" ).unbind( "click" );
            $( ".click_like" ).unbind( "click" );
            $( ".comment_otvetit_notreg" ).unbind( "click" );
            $( ".razvernut_all_comment" ).unbind( "click" );
            $( ".razvernut_subcoments" ).unbind( "click" );
            clickLikeListener();
            clickCommentOtvetit();
            clickSubcommentOtvetit();
            clickCommentOtvetitNotreg();
            clickRazvernutAllComment();
            clickRazvernutSubcomments();
        });
    },5000);
});

/*===================================================*/

function clickLikeListener(){
    $('.click_like').click(function(){
        var idcomment = $(this).attr('id-comment');
        var datatype = $(this).attr('data-type');
        $.post('user_makelike_tocomment.php',{idcomment:idcomment,datatype:datatype},function(data){
            var likes_dislikes = JSON.parse(data);
            $('.likecount[id-comment='+idcomment+']').text(likes_dislikes.likes);
            $('.dislikecount[id-comment='+idcomment+']').text(likes_dislikes.dislikes);
        });
    });
}
function clickCommentOtvetit(){
    $('.comment_otvetit').click(function(){
        var idcomment = $(this).attr('id-comment');
        $('#btn-replycomment').attr('id-comment',idcomment);
        $('#btn-replycomment').attr('id-subcomment',0);
        $('#modal-leavecomment').modal('show');

    });
}

function clickSubcommentOtvetit(){
    $('.subcomment_otvetit').click(function(){
        var idcomment = $(this).attr('id-comment');
        var idsubcomment = $(this).attr('id-subcomment');
        $('#btn-replycomment').attr('id-comment',idcomment);
        $('#btn-replycomment').attr('id-subcomment',idsubcomment);
        $('#modal-leavecomment').modal('show');
    });
}

function clickCommentOtvetitNotreg(){
    $('.comment_otvetit_notreg').click(function(){
        $('#modal-golosovanie-notreg').modal('show');
    });
}

function clickRazvernutAllComment() {
    $('.razvernut_all_comment').click(function(){
        $('.hidecomment').show();
        $(this).hide();
        razvernut_all_comments = "yes";
    });
}

function clickRazvernutSubcomments(){
    $('.razvernut_subcoments').click(function(){
        var idcomment = $(this).attr('id-comment');
        $('.hidesubcomment[id-comment='+idcomment+']').show();
        $(this).hide();
        razvernut_subcoments.push(idcomment);
    });
}