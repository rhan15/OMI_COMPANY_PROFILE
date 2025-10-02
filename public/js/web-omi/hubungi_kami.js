$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function ValidateEmail(email){;
    var emailFeedback = document.getElementById('EmailFeedback');
    if(email.trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/)) {
        emailFeedback.style.display = "none";
        return "true";
    } else {
        emailFeedback.style.display = "block";
        return "false";
    }
}

function ValidateRecaptcha(response){
    var recaptchaFeedback = document.getElementById('gCaptchaFeedback');
    if(response==""){
        recaptchaFeedback.style.display = "block";
        return "false";
    }else{
        recaptchaFeedback.style.display = "none";
        return "true";
    }
}

$("#form-saran").submit(function (e) {
    /* stop form from submitting normally */
    e.preventDefault();

    //get form data
    var user_name = document.getElementsByName('user-name')[0].value;
    var email = document.getElementsByName('email')[0].value;
    var phone = document.getElementsByName('phone')[0].value;
    var province = document.getElementsByName('provinsi')[0].value;
    var content = document.getElementsByName('content')[0].value;
    var recaptcha = grecaptcha.getResponse();

    //send data
    var form = new FormData();
    form.append('user_name', user_name);
    form.append('email', email);
    form.append('phone', phone);
    form.append('province', province);
    form.append('content', content);
    form.append('recaptcha', recaptcha);

    //check
    var cekEmail = ValidateEmail(email);
    var cekCaptcha = ValidateRecaptcha(recaptcha);

    // console.log(province);

    if ( cekCaptcha=="true" &&  cekEmail== "true") {
        console.log("kirim");
        $.ajax({
            type: "POST",
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            url: urlSaran + "/hubungi-kami/saran",
            success: function (response) {
                console.log(response);
                Swal.fire({
                    position: 'center',
                    icon: response['AlertIcon'],
                    title: response['AlertInfo'],
                }), setTimeout(function () {
                    location.reload();
                }, 2000);
                },
                error: function(response) {
                    console.log(response.responseText);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Koneksi gagal!',
                        text: 'Silahkan coba lagi!'
                    }).then(function(){
                        location.reload();
                    });
                },
        });
    } else {
        console.log("salah");
    }
});
