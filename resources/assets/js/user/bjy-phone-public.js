

// 发送验证码
function sendCode() {
    var phone=$("input[name='phone']").val();
    var postData={
        'phone': phone
    };
    
    $.post(get_code, postData ,function (response) {
        console.log(response);
    })

}