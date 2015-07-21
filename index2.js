$(function () {
    var user = {},
        flg = {};
    init();
    $('.upload').click(function () {
        if (flg.upd == 0) {
            upd('upload');
            flg.upd = 1
        } else {
            upd('');
            flg.upd = 0
        }
    });
    $('#login').click(function () {
        initub();
        $('#logmsk').fadeIn();
        ub(0)
    });
    $('#logint').click(function () {
        initub();
        if (flg.logt == 0) {
            ub(1);
            flg.logt = 1
        } else {
            ub(0);
            flg.logt = 0
        }
    });
    


    function init() {
        flg.logt = 0
    }

    function initub() {
        flg.name = -1;
        flg.pass = -1;
        $('#sumsk').hide();
        $('#nameal').hide();
        $('#passal').hide();
        //$('#name, #pass, #logint, #nameal, #passal, #signupb').css('opacity', '1');
        $('#name').css('background', 'rgb(255, 255, 255)');
        $('#pass').css('background', 'rgb(255, 255, 255)');
        //$('#signupb').css('opacity', '0.2').css('cursor', 'default');
        $('#name, #pass').val('')
    }

    //function upd(button) {
    //    location.hash = button;
    //    if (flg.upd == 0) {
    //        $('#drop').fadeIn()
    //    } else {
    //        $('#drop').fadeOut()
    //    }
    //}
    //
    

    function ub(flg) {
        if (flg == 1) {
            //$('#signup').text('Sign up').css('background', '#76ABDB');
            //$('#signupb').text('Sign up');
            $('#logint').text('Login as an existing user');
            $('#loginform').attr('action','register.php');
            $('#name').attr('name','registername');
            $('#pass').attr('name','registerpassword');
            $('#signup1').text('Sign up');
            $('#signupb').attr('value','Sign up');
        } else {
            //$('#signup').text('Login').css('background', '#FFA622');
            //$('#signupb').text('Login');
            $('#logint').text('Not member yet? Click here to register.')
            $('#loginform').attr('action','authentication.php')
            $('#name').attr('name','loginname');
            $('#pass').attr('name','loginpassword');
            $('#signup1').text('Log in');
            $('#signupb').attr('value','Sign in');
        }
    }

    function blsp() {
        $('#signupb').css('opacity', '0.2').css('cursor', 'default')
    }
});