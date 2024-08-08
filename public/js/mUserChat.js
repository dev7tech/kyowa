var chatcommponentContainer = $('#chat-portlet-chat-form-container');
$('.chat-single-user-list-item').on('click', function(e){
    e.preventDefault();
    var $this = $(this);
    var chatUrl = $this.attr('href');
    $this.parent().find('a.chat-single-user-list-item').each(function(){
        var $that = $(this);
        $that.removeClass('selected');
    });

    $this.addClass('selected');

    window.history.pushState(null, null, chatUrl);

    chatUrl = chatUrl+'/ajax';

    $.ajax({
        url: chatUrl,
        type: 'get',
        success: function(response){
            if (response.result == "success") {
                chatcommponentContainer.html(response.htmldata);
                scrollUpdate();
                $this.removeClass('have-unread-message');
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});

function scrollUpdateAnimate(){
    var objDiv = $('.messenger-message-container__lizhe');
    objDiv.animate({
        scrollTop: objDiv[0].scrollHeight
    }, 500);
}
function scrollUpdate(){
    var objDiv = $('.messenger-message-container__lizhe');
    objDiv[0].scrollTop = objDiv[0].scrollHeight;
}

$(document).on('keypress', '#m-messenger__user_typing_input_lizhe', function(e){
    var $this = $(this);
    var currentkey = e.keyCode;
    var conversation = $this.data('conversation');
    if (currentkey == 13) {
        var message = $this.val();

        var message_data = {
            'conversation': conversation,
            'text': message
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.post(
            '/admin/chat/user/message/send/text',
            {'message': message_data},
            function(response, status){
                var unique = response.data.conversation_unique;
                var content_text = response.data.content_text;
                var createdTime = new Date(response.data.created_at);
                createdTime = createdTime.getTime()
                var content = generateAdminMessageText(content_text, createdTime);

                var messageContainer = $('#messenger-message-container-'+unique);
                messageContainer.append(content);
                scrollUpdateAnimate();
                $this.val("");
            }
        );
    }
});

$(document).on('click', '#messenger_attach_image_btn_lizhe', function(){
    $('#chat_image_choose_and_send_form>input[name=image]').click();
})

$(document).on('change', '#chat_image_choose_and_send_form>input[name=image]', function(e) {
    e.preventDefault();
    var form = $('#chat_image_choose_and_send_form');
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
        }
    });
    var url = form.attr( 'action' );

    var formData = new FormData(form[0]);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (response) {
            var unique = response.data.conversation_unique;
            var content_img = response.data.image_url;
            var createdTime = new Date(response.data.created_at);
            createdTime = createdTime.getTime()
            var content = generateAdminMessageImage(content_img, createdTime);

            var messageContainer = $('#messenger-message-container-'+unique);
            messageContainer.append(content);
            scrollUpdateAnimate();
            form[0].reset();
        },
        processData: false,
        contentType: false,
        error: function(error){
           console.log(error);
       }
    });
})

function generateAdminMessageText(message, createTime) {
    var messageContent = '\
    <div class="m-messenger__wrapper">\
    <div class="m-messenger__message m-messenger__message--out">\
    <div class="m-messenger__message-body">\
    <div class="m-messenger__message-arrow"></div>\
    <div class="m-messenger__message-content">\
    <div class="m-messenger__message-text">'+message+'</div>\
    <div class="m-messenger__message-time">'+diffForHumans(createTime)+'</div>\
    </div></div></div></div>\
    ';

    return messageContent;
}

function generateAdminMessageImage(message, createTime) {
    var messageContent = '\
    <div class="m-messenger__wrapper">\
    <div class="m-messenger__message m-messenger__message--out">\
    <div class="m-messenger__message-body">\
    <div class="m-messenger__message-arrow"></div>\
    <div class="m-messenger__message-content">\
    <div class="m-messenger__message-image">\
    <img src="'+message+'" alt="">\
    </div>\
    <div class="m-messenger__message-time">'+diffForHumans(createTime)+'</div>\
    </div></div></div></div>\
    ';

    return messageContent;
}

function generateUserMessageText(message, createTime) {
    var messageContent = '\
    <div class="m-messenger__wrapper">\
    <div class="m-messenger__message m-messenger__message--in">\
    <div class="m-messenger__message-body">\
    <div class="m-messenger__message-arrow"></div>\
    <div class="m-messenger__message-content">\
    <div class="m-messenger__message-text">'+message+'</div>\
    <div class="m-messenger__message-time">'+diffForHumans(createTime)+'</div>\
    </div></div></div></div>\
    ';

    return messageContent;
}

function generateUserMessageImage(message, createTime) {
    var messageContent = '\
    <div class="m-messenger__wrapper">\
    <div class="m-messenger__message m-messenger__message--in">\
    <div class="m-messenger__message-body">\
    <div class="m-messenger__message-arrow"></div>\
    <div class="m-messenger__message-content">\
    <div class="m-messenger__message-image">\
    <img src="'+message+'" alt="">\
    </div>\
    <div class="m-messenger__message-time">'+diffForHumans(createTime)+'</div>\
    </div></div></div></div>\
    ';

    return messageContent;
}

messaging.onMessage(function(payload) {
    var audioElement = document.getElementById('notification_sound');
    audioElement.play();
    var unique = payload.data.unique;
    var createdTime = new Date(payload.data.created_at);
    var type = payload.data.type;
    var content;
    var messageContainer = $('#messenger-message-container-'+unique);
    if (messageContainer.length > 0) {
        if (type == 1) {
            var content_text = payload.data.content_body;
            content = generateUserMessageText(content_text, createdTime);
        } else if (type == 2) {
            var content_image = payload.data.image_url;
            content = generateUserMessageImage(content_image, createdTime);
        }
        messageContainer.append(content);
        scrollUpdateAnimate();
    } else {
        $('#user-list-'+unique).addClass('have-unread-message');
    }
});

// window.onfocus = function (ev) { console.log("Asdfasdf"); }
