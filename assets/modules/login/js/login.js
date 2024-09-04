var base_url = $('input[name="base_url"]').val()
var method = $('input[name="basemethod"]').val()

$(document).ready(function() {
    $('#login-form').submit(function(e){
        e.preventDefault();

        var formData = new FormData($(this)[0]);
        
        var sendAjaxVar = sendAjax({url: base_url + '/login/checkLogin',data: formData});
        if(sendAjaxVar.status == 'success') {
            clearError()
            window.location.href = base_url + 'characters'
        } else {
            clearError()
            $.each(sendAjaxVar, function (key, value) {
                $('input[name="' + value.name + '"]').next('.err').html(value.msg);
            })
        }  
    })

    $('#registration-form').submit(function(e){
        e.preventDefault();

        var formData = new FormData($(this)[0]);
        
        var sendAjaxVar = sendAjax({url: base_url + 'login/addUser',data: formData});
        if(sendAjaxVar.status == 'success') {
            clearError()
            window.location.href = base_url + 'thank-you';
        } else {
            if(sendAjaxVar.status == 'error_confirm_pass') {
                $('input[name="c_password"]').next('.err').html(sendAjaxVar.msg);
            }
        }  
    })
})

function sendAjax(param = {},isReturn = true){
    if(isReturn === false){
        var return_response = null
        $.ajax({
            url:param.url,
            type: 'post',
            data: param.data,
            processData:false,
            contentType:false,
            dataType:'json',
            success:function(response){
                return_response = response
            },error:function(e){
                console.log(e)
            }
        })
        return  return_response
    } else {
        var return_data = null
        $.ajax({
            url:param.url,
            type: 'post',
            data:param.data,
            processData:false,
            contentType:false,
            dataType:'json',
            async:false,
            success:function(response){
                return_data = response
            },error:function(e){
                console.log(e)
            }
        })

        if(isReturn){
            return return_data
        }
    }
}

function clearError() {
    $('.err').html('');
}