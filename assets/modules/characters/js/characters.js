var base_url = $('input[name="base_url"]').val()
var method = $('input[name="basemethod"]').val()

$(document).ready(function(){

    if(method == 'index') {
        loadPeople({page:1});   
    } else if(method == 'savedCharacters') {
        loadSavedCharacters({page:1});
    }

   $(document).on('click', '.page-item', function(e) {
        e.preventDefault();
        let page = $(this).find('a.page-link').attr('data-page');
        let param = {
            page
        };
        if(method == 'index') {
            loadPeople(param);
        } else if(method == 'savedCharacters') {
            loadSavedCharacters(param);
        }
        
   })

   $(document).on('click', '.btn-save-character', function(e) {
        e.preventDefault();
        $(this).html('Saving...');
        let character_id = $(this).attr('data-charid');
        let formData = new FormData();
        formData.append('character_id',character_id);

        let sendAjaxVar = sendAjax({url: base_url + 'characters/saveUserCharacter',data: formData});
        if(sendAjaxVar) {
            if(sendAjaxVar.status == 'success') {
                window.location.href = base_url + '/characters'
            }
        }   
   })

   $(document).on('click', '.btn-delete-character', function(e) {
    e.preventDefault();
    $(this).html('Deleting...');
    let save_id = $(this).attr('data-saveid');
    let formData = new FormData();
    formData.append('save_id',save_id);

    let sendAjaxVar = sendAjax({url: base_url + 'characters/removeUserCharacter',data: formData});
    if(sendAjaxVar) {
        if(sendAjaxVar.status == 'success') {
            window.location.href = base_url + '/characters'
        }
    }   
})

}) // End of Document Ready

function loadPeople(param = {}) {

    $.ajax({
        url: base_url + 'characters/listingPeople',
        type: 'post',
        data: param,
        dataType:'json',
        beforeSend:function(e) {
            $('.character-cards').html('');
            $('.pagination').html('');
            $('.loader').show();
        },
        success:function(response){
            $('.character-cards').html(response.cards);
            $('.pagination').html(response.pagination);
            $('.loader').hide();
        },error:function(e){
            console.log(e)
        }
    })
}

function loadSavedCharacters(param = {}) {

    $.ajax({
        url: base_url + 'characters/listSavedCharacter',
        type: 'post',
        data: param,
        dataType:'json',
        beforeSend:function(e) {
            $('.character-cards').html('');
            $('.pagination').html('');
            $('.loader').show();
        },
        success:function(response){
            $('.character-cards').html(response.cards);
            $('.pagination').html(response.pagination);
            $('.loader').hide();
        },error:function(e){
            console.log(e)
        }
    })
}


function sendAjax(param = {},isReturn = true){
    if(isReturn === false){
        var return_response = null
        $.ajax({
            url:param.url,
            type: 'post',
            data: param.data,
            dataType:'json',
            beforeSend:function(e) {
                $('.character-cards').html('');
                $('.pagination').html('');
                $('.loader').show();
            },
            success:function(response){
                return_response = response
                $('.loader').hide();
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
            beforeSend:function(e) {
                $('.character-cards').html('')
                $('.pagination').html('')
                $('.loader').show();
            },
            success:function(response){
                $('.loader').hide();
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
    $('.err').html('')
}

function input(element,value){
    $(element).val(value)
}