var blogImageSlimPicker;

function blogNormallTextInput(count) {
    var textInputBox = '\
        <div class="form-group m-form__group row blog-content">\
        <div class="col-12" style="position: relative;">\
        <a class="blog-content-remove-btn" ><i class="la la-remove" ></i></a>\
        <textarea class="form-control m-input m-input--air blog-text-input normall" name="blog_text" data-order="'+count+'" data-text_type="0" rows="4" required></textarea>\
        <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
        </div>\
        </div>\
        ';
    return textInputBox;
}

function blogBoldTextInput(count) {
    var textInputBox = '\
        <div class="form-group m-form__group row blog-content">\
        <div class="col-12" style="position: relative;">\
        <a class="blog-content-remove-btn" ><i class="la la-remove" ></i></a>\
        <textarea class="form-control m-input m-input--air blog-text-input bold" name="blog_text" data-order="'+count+'" data-text_type="1" rows="4" required></textarea>\
        <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
        </div>\
        </div>\
        ';
    return textInputBox;
}

function blogItalicTextInput(count) {
    var textInputBox = '\
        <div class="form-group m-form__group row blog-content">\
        <div class="col-12" style="position: relative;">\
        <a class="blog-content-remove-btn" ><i class="la la-remove" ></i></a>\
        <textarea class="form-control m-input m-input--air blog-text-input italic" name="blog_text" data-order="'+count+'" data-text_type="2" rows="4" required></textarea>\
        <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
        </div>\
        </div>\
        ';
    return textInputBox;
}

function ImageSelectedForm(url, id, count) {
    var imageSelectedBox = '';

    if (count == 0) {
        imageSelectedBox ='\
            <div class="form-group m-form__group row blog-content">\
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-12" style="position: relative;">\
            <a class="blog-content-image-change-btn" ><i class="la la-edit" ></i></a>\
            <input type="hidden" name="blog_image" id="blog_image_content_first_img_hidden" data-order="'+count+'" value="'+id+'">\
            <img src="'+url+'" id="blog_image_content_first_img" style="width: 100%;" alt="">\
            <div class="blog-image-url-container">\
            <input type="text" class="blog-image-url-input" autocorrect="off" name="blog_img_url" value="">\
            </div>\
            <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
            </div>\
            </div>\
            ';
    } else {
        imageSelectedBox ='\
            <div class="form-group m-form__group row blog-content">\
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-12" style="position: relative;">\
            <a class="blog-content-remove-btn" ><i class="la la-remove" ></i></a>\
            <input type="hidden" name="blog_image" data-order="'+count+'" value="'+id+'">\
            <img src="'+url+'" style="width: 100%;" alt="">\
            <div class="blog-image-url-container">\
            <input type="text" class="blog-image-url-input" autocorrect="off" name="blog_img_url" value="">\
            </div>\
            <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
            </div>\
            </div>\
            ';
    }

    return imageSelectedBox;
}

function VideoSelectedForm(url, type, id, count) {
    var videoSelectedBox= '';
    if (count == 0) {
        videoSelectedBox ='\
            <div class="form-group m-form__group row blog-content">\
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12" style="position: relative;">\
            <a class="blog-content-video-change-btn" ><i class="la la-edit" ></i></a>\
            <input type="hidden" name="blog_video" id="blog_video_content_first_video_hidden" data-order="'+count+'" value="'+id+'">\
            <video style="width: 100%;" id="blog_video_content_first_video" controls autoplay>\
            <source src="'+url+'" type="video/'+type+'">\
            </video>\
            <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
            </div>\
            </div>\
            ';
    } else {
        videoSelectedBox ='\
            <div class="form-group m-form__group row blog-content">\
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12" style="position: relative;">\
            <a class="blog-content-remove-btn" ><i class="la la-remove" ></i></a>\
            <input type="hidden" name="blog_video" data-order="'+count+'" value="'+id+'">\
            <video style="width: 100%;" controls autoplay>\
            <source src="'+url+'" type="video/'+type+'">\
            </video>\
            <a class="blog_content_add_after_this_btn" data-count_order="'+count+'"><i class="la la-plus" ></i></a>\
            </div>\
            </div>\
            ';
    }

    return videoSelectedBox;
}

function slimPickerInit() {

    blogImageSlimPicker = new Slim(document.getElementById('blog-form-image-select-slim'), {
        minSize: {
            width: 100,
            height: 100,
        },
        download: false,
        label: 'Drop your image here or Click',
        statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.',
    });

    blogImageSlimPicker.size = { width:1000, height:1000 };

    blogImageUpdateSlimPicker = new Slim(document.getElementById('blog-form-image-update-select-slim'), {
        minSize: {
            width: 100,
            height: 100,
        },
        download: false,
        label: 'Drop your image here or Click',
        statusImageTooSmall: 'Image too small. Min Size is $0 pixel. Try again.',
    });

    blogImageUpdateSlimPicker.size = { width:1000, height:1000 };
}

function slimDestroy() {
    blogImageSlimPicker.destroy();
    blogImageUpdateSlimPicker.destroy();
}

function checkFirstElement() {
    var blogFirstContent = $('#blogMainContentContainer > .blog-content').first();

    if (blogFirstContent.length > 0) {
        var imageContent = blogFirstContent.find('input[name=blog_image]');
        var videoContent = blogFirstContent.find('input[name=blog_video]');

        if (imageContent.length > 0 || videoContent.length > 0) {
            $('.blogFormAddTextInput').css({'display': 'block'});
        } else {
            $('.blogFormAddTextInput').css({'display': 'none'});
        }
    } else {
        $('.blogFormAddTextInput').css({'display': 'none'});
    }
}

var _validFileExtensions = [".mp4", ".mkv", ".ogg", ".webm"];

function VideoValidate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    // alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                    return false;
                }
            }
        }
    }

    return true;
}

var blogPoster={
    init:function(){
        slimPickerInit();

        localStorage.setItem('contentCount', "null");

        var $contextMenu = $("#contextMenu");

        var blogFormContainer = $('#blogMainContentContainer');

        $("body").on("contextmenu", "#blog-post-contextmenu", function(e) {
            checkFirstElement();
            $contextMenu.css({
                display: "block",
                left: e.pageX,
                top: e.pageY
            });
            return false;
        });

        $('html').click(function() {
            $contextMenu.hide();
        });

        $(document).on('click', '.blogFormAddNormallTextInput', function() {
            var count = 0;
            var localCount = localStorage.getItem('contentCount');
            if (localCount != 'null') {
                count = localCount;
            } else {
                count = descriptionPosition();
            }
            console.log(count);
            var beforeCount = parseInt(count) - 1;

            var textInputForm = blogNormallTextInput(count);

            var blogMainContainer = $('#blogMainContentContainer');

            var checkCount = 0;

            blogMainContainer.find('div.form-group.blog-content').each(function(){
                var $this = $(this);
                var textareaInput = $this.find('textarea');
                var imageInput = $this.find('input[name=blog_image]');
                var videoInput = $this.find('input[name=blog_video]');

                if (textareaInput.length > 0) {
                    if (textareaInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        textareaInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                if (imageInput.length > 0) {
                    if (imageInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        imageInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                if (videoInput.length > 0) {
                    if (videoInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        videoInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                count++;
            });

            // $("html, body").animate({ scrollTop: $(document).height() }, "slow");

            descriptionPosition();

            localStorage.setItem('contentCount', "null");
        });

        $(document).on('click', '.blogFormAddBoldTextInput', function() {
            var count = 0;
            var localCount = localStorage.getItem('contentCount');
            if (localCount != 'null') {
                count = localCount;
            } else {
                count = descriptionPosition();
            }
            var beforeCount = parseInt(count) - 1;

            var textInputForm = blogBoldTextInput(count);

            var blogMainContainer = $('#blogMainContentContainer');

            var checkCount = 0;

            blogMainContainer.find('div.form-group.blog-content').each(function(){
                var $this = $(this);
                var textareaInput = $this.find('textarea');
                var imageInput = $this.find('input[name=blog_image]');
                var videoInput = $this.find('input[name=blog_video]');

                if (textareaInput.length > 0) {
                    if (textareaInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        textareaInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                if (imageInput.length > 0) {
                    if (imageInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        imageInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                if (videoInput.length > 0) {
                    if (videoInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        videoInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                count++;
            });

            // $("html, body").animate({ scrollTop: $(document).height() }, "slow");

            descriptionPosition();

            localStorage.setItem('contentCount', "null");
        });

        $(document).on('click', '.blogFormAddItalicTextInput', function() {
            var count = 0;
            var localCount = localStorage.getItem('contentCount');
            if (localCount != 'null') {
                count = localCount;
            } else {
                count = descriptionPosition();
            }
            var beforeCount = parseInt(count) - 1;

            var textInputForm = blogItalicTextInput(count);

            var blogMainContainer = $('#blogMainContentContainer');

            var checkCount = 0;

            blogMainContainer.find('div.form-group.blog-content').each(function(){
                var $this = $(this);
                var textareaInput = $this.find('textarea');
                var imageInput = $this.find('input[name=blog_image]');
                var videoInput = $this.find('input[name=blog_video]');

                if (textareaInput.length > 0) {
                    if (textareaInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        textareaInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                if (imageInput.length > 0) {
                    if (imageInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        imageInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                if (videoInput.length > 0) {
                    if (videoInput.data('order') == beforeCount) {
                        $this.after(textInputForm);
                        checkCount = count;
                    } else {
                        videoInput.data('order', checkCount);
                    }
                    checkCount++;
                }
                count++;
            });

            // $("html, body").animate({ scrollTop: $(document).height() }, "slow");

            descriptionPosition();

            localStorage.setItem('contentCount', "null");
        });

        $(document).on('click', '.blogFormAddImageModal', function() {
            $('#blog-form-image-select-modal').modal('show');
        });

        $(document).on('click', '.blogFormAddVideoModal', function() {
            $('#blog-video-selector').click();
        });

        $('#blog-preview-image-select-slim>input').on('change', function(e) {
            var form = $('#new-blog-post-form');
        });

        $('#blog-video-selector').change(function(e) {
            var form = $(this).parent();
            if (!VideoValidate(form[0])) {
                swal({
                    "title": "Error",
                    "text": "Please select correct video file !",
                    "type": "error",
                    "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                });
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr( 'action' );

            var formData = new FormData(form[0]);

            $('.transparent-loader').fadeIn();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('.transparent-loader').fadeOut();
                    if (response.result === "success") {
                        var count = 0;
                        var localCount = localStorage.getItem('contentCount');
                        if (localCount != 'null') {
                            count = localCount;
                        } else {
                            count = descriptionPosition();
                        }
                        var beforeCount = parseInt(count) - 1;

                        var videoGeneratedForm = VideoSelectedForm(response.file_url, response.type, response.video_id, count);

                        var blogMainContainer = $('#blogMainContentContainer');

                        var checkCount = 0;

                        if (count == 0) {
                            blogMainContainer.append(videoGeneratedForm);
                        } else {
                            blogMainContainer.find('div.form-group.blog-content').each(function(){
                                var $this = $(this);
                                var textareaInput = $this.find('textarea');
                                var imageInput = $this.find('input[name=blog_image]');
                                var videoInput = $this.find('input[name=blog_video]');

                                if (textareaInput.length > 0) {
                                    if (textareaInput.data('order') == beforeCount) {
                                        $this.after(videoGeneratedForm);
                                        checkCount = count;
                                    } else {
                                        textareaInput.data('order', checkCount);
                                    }
                                    checkCount++;
                                }
                                if (imageInput.length > 0) {
                                    if (imageInput.data('order') == beforeCount) {
                                        $this.after(videoGeneratedForm);
                                        checkCount = count;
                                    } else {
                                        imageInput.data('order', checkCount);
                                    }
                                    checkCount++;
                                }
                                if (videoInput.length > 0) {
                                    if (videoInput.data('order') == beforeCount) {
                                        $this.after(videoGeneratedForm);
                                        checkCount = count;
                                    } else {
                                        videoInput.data('order', checkCount);
                                    }
                                    checkCount++;
                                }
                                count++;
                            });
                        }

                        // $("html, body").animate({ scrollTop: $(document).height() }, "slow");

                        descriptionPosition();

                        localStorage.setItem('contentCount', "null");

                        checkFirstElement();
                        form[0].reset();
                    }
                },
                processData: false,
                contentType: false,
                error: function(error){
                   console.log(error);
               }
            });

        });

        $('#blog-form-image-select-form').on('submit', function(e) {
            e.preventDefault();

            var $this = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            var form = $this[0];
            var url = $(form).attr( 'action' );

            var formData = new FormData($(form)[0]);
            var submit_btn = $(form).find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result === "success") {
                        var count = 0;
                        var localCount = localStorage.getItem('contentCount');
                        if (localCount != 'null') {
                            count = localCount;
                        } else {
                            count = descriptionPosition();
                        }
                        var beforeCount = parseInt(count) - 1;

                        var imageSelectedForm = ImageSelectedForm(response.img_url, response.image_id, count);

                        var blogMainContainer = $('#blogMainContentContainer');

                        var checkCount = 0;

                        console.log(count);

                        if (count == 0) {
                            blogMainContainer.append(imageSelectedForm);
                        } else {
                            blogMainContainer.find('div.form-group.blog-content').each(function(){
                                var $this = $(this);
                                var textareaInput = $this.find('textarea');
                                var imageInput = $this.find('input[name=blog_image]');
                                var videoInput = $this.find('input[name=blog_video]');

                                if (textareaInput.length > 0) {
                                    if (textareaInput.data('order') == beforeCount) {
                                        $this.after(imageSelectedForm);
                                        checkCount = count;
                                    } else {
                                        textareaInput.data('order', checkCount);
                                    }
                                    checkCount++;
                                }
                                if (imageInput.length > 0) {
                                    if (imageInput.data('order') == beforeCount) {
                                        $this.after(imageSelectedForm);
                                        checkCount = count;
                                    } else {
                                        imageInput.data('order', checkCount);
                                    }
                                    checkCount++;
                                }
                                if (videoInput.length > 0) {
                                    if (videoInput.data('order') == beforeCount) {
                                        $this.after(imageSelectedForm);
                                        checkCount = count;
                                    } else {
                                        videoInput.data('order', checkCount);
                                    }
                                    checkCount++;
                                }
                                count++;
                            });
                        }

                        // $("html, body").animate({ scrollTop: $(document).height() }, "slow");

                        descriptionPosition();

                        localStorage.setItem('contentCount', "null");

                        checkFirstElement();
                        $('#blog-form-image-select-modal').modal('hide');
                        slimDestroy();
                        slimPickerInit();
                    }
                },
                processData: false,
                contentType: false,
                error: function(error){
                   console.log(error);
               }
            });
        });

        $(document).on('click', '.blog-content-remove-btn', function() {
            var content = $(this).parents('div.form-group.m-form__group');
            var selectedContentOrder = "null";
            var firstImage = content.find('input[name=blog_image]');
            var firstVideo = content.find('input[name=blog_video]');
            if (firstImage.length > 0 ) {
                selectedContentOrder = firstImage.data('order');
            } else {
                selectedContentOrder = firstVideo.data('order');
            }
            if (selectedContentOrder != 0) {
                content.remove();
                descriptionPosition();
                checkFirstElement();
            }
        });

        $('#new-blog-post-form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var count = form.find("div.blog-content").length;

            if (count === 0) {
                swal({
                    "title": "Error",
                    "text": "Please Add Blog Contents",
                    "type": "error",
                    "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                });
                return false;
            }

            var requestArray = new Array();

            form.find('div.blog-content').each(function() {
                var $this = $(this);
                var singleTextContent = $this.find('textarea[name=blog_text]');
                // console.log(singleTextContent);
                if (singleTextContent.length > 0) {
                    var blogOrder = singleTextContent.data('order');
                    var contentType = "text";
                    var contentValue = singleTextContent.val();
                    var textType = singleTextContent.data('text_type');

                    var textContent = {"order": blogOrder, "type": contentType, "textType": textType, "value": contentValue};

                    requestArray.push(textContent);
                }

                var singleImageContent = $this.find('input[name=blog_image]');
                if (singleImageContent.length > 0) {
                    var blogOrder = singleImageContent.data('order');
                    var contentType = "image";
                    var contentValue = singleImageContent.val();
                    var imageUrl = $this.find('input[name=blog_img_url]').val();

                    var imageContent = {"order": blogOrder, "type": contentType, "value": contentValue, 'url': imageUrl};

                    requestArray.push(imageContent);
                }

                var singleVideoContent = $this.find('input[name=blog_video]');
                if (singleVideoContent.length > 0) {
                    var blogOrder = singleVideoContent.data('order');
                    var contentType = "video";
                    var contentValue = singleVideoContent.val();

                    var videoContent = {"order": blogOrder, "type": contentType, "value": contentValue};

                    requestArray.push(videoContent);
                }
            });

            if (requestArray.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });

                var url = form.attr( 'action' );
                var submit_btn = form.find('.form-submit-btn');
                submit_btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
                var blog_title = form.find('input[name=blog_title]').val();

                var finalBlogs = {
                    'blogTitle': blog_title,
                    'blogContents': requestArray
                }

                $.post(
                    url,
                    {'blogs': finalBlogs},
                    function(response, status){
                        submit_btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        if (response.result === "success") {
                            window.history.pushState(null, null, response.redirect_url);
                            window.location.reload();
                        }
                    }
                );
            }
        });

        $('.blog-preview-show-btn').on('click', function(e) {
            var form = $('#new-blog-post-form');
            var count = form.find("div.blog-content").length;
            var blogTitleCheck = form.find('input[name=blog_title]').val();

            if (blogTitleCheck === "") {
                swal({
                    "title": "Error",
                    "text": "Please Add Blog Title",
                    "type": "error",
                    "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                });
                return false;
            }

            if (count === 0) {
                swal({
                    "title": "Error",
                    "text": "Please Add Blog Contents",
                    "type": "error",
                    "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                });
                return false;
            }

            var generatedHtml = generatePreviewhtml();

            $('#blog-preview-scroll-container .simplebar-content').html(generatedHtml);
            $('#blog-preview-modal').modal('show');
            reduceFrame();
        });

        $(document).on('click', '.blog_content_add_after_this_btn', function(e) {
            var $this = $(this);
            var chosenCount = $this.data('count_order');
            var myPosition = parseInt(chosenCount)+1;
            localStorage.setItem('contentCount', myPosition);
            checkFirstElement();
            $contextMenu.css({
                display: "block",
                left: e.pageX,
                top: e.pageY
            });
            return false;
        });

        $(document).on('click', '.blog-content-image-change-btn', function() {
            $('#blog-form-image-update-select-modal').modal('show');
        });

        $('#blog-form-image-update-select-form').on('submit', function(e) {
            e.preventDefault();

            var $this = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            var form = $this[0];
            var url = $(form).attr( 'action' );

            var formData = new FormData($(form)[0]);
            var submit_btn = $(form).find('.form-submit-btn');
            submit_btn.addClass('m-loader m-loader--right m-loader--accent').attr('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    submit_btn.removeClass('m-loader m-loader--right m-loader--accent').attr('disabled', false);
                    if (response.result == 'success') {
                        $('#blog_image_content_first_img').attr('src', response.img_url);
                        $('#blog_image_content_first_img_hidden').val(response.image_id);
                        $('#blog-form-image-update-select-modal').modal('hide');
                        slimDestroy();
                        slimPickerInit();
                    }
                },
                processData: false,
                contentType: false,
                error: function(error){
                   console.log(error);
               }
            });
        });

        $(document).on('click', '.blog-content-video-change-btn', function() {
            $('#blog-video-update-selector').click();
        });

        $('#blog-video-update-selector').change(function(e) {
            var form = $(this).parent();
            if (!VideoValidate(form[0])) {
                swal({
                    "title": "Error",
                    "text": "Please select correct video file !",
                    "type": "error",
                    "confirmButtonClass": "btn m-btn--air m-btn btn-outline-accent m-btn--wide"
                });
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            var url = form.attr( 'action' );

            var formData = new FormData(form[0]);

            $('.transparent-loader').fadeIn();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('.transparent-loader').fadeOut();
                    console.log(response);
                    if (response.result == "success") {
                        var changedvideo_html = '<source src="'+response.file_url+'" type="video/'+response.type+'">';
                        $('#blog_video_content_first_video').html(changedvideo_html);
                        var video = document.getElementById('blog_video_content_first_video');
                        video.load();
                        $('#blog_video_content_first_video_hidden').val(response.video_id);
                    }
                    form[0].reset();
                },
                processData: false,
                contentType: false,
                error: function(error){
                   console.log(error);
               }
            });

        });
    }
};

jQuery(document).ready(function(){
    blogPoster.init();
    checkFirstElement();
});

jQuery(window).resize(function(){
    reduceFrame();
});

function reduceFrame() {
    var currentWidth = $(window).outerWidth();
    if (currentWidth<414) {
        var phoneFrameWidth = currentWidth-30;
        var phoneFrameHeight = phoneFrameWidth*1390/700;
        var currentHeight = $(window).height() -30;
        if (currentHeight < phoneFrameHeight) {
            phoneFrameHeight = currentHeight-30;
            phoneFrameWidth = phoneFrameHeight*700/1390;
            $('#blog-preview-container').css({'width': phoneFrameWidth});
        }
        $('#blog-preview-container').css({'height': phoneFrameHeight});
    }
}

function generatePreviewhtml()
{
    var previewHtmlGenreate = '<div style="width:100%;" >';
    var blogFormContainer = $('#new-blog-post-form');
    var blogFirstContent = $('#blogMainContentContainer > .blog-content').first();
    var imageContent = blogFirstContent.find('img');
    var videoContent = blogFirstContent.find('source');

    if (imageContent.length > 0) {
        var blogPreviewImageUrl = imageContent.attr('src');
        previewHtmlGenreate += '<img src="'+blogPreviewImageUrl+'" style="width: 100%;" alt="">';
    } else if(videoContent.length > 0) {
        var blogPreviewVideoUrl = videoContent.attr('src');
        var blogPreviewVideoType = videoContent.attr('type');

        previewHtmlGenreate += '\
            <video autoplay class="blog-preview-video-tag">\
            <source src="'+blogPreviewVideoUrl+'" type="'+blogPreviewVideoType+'">\
            </video>\
            ';
    }
    var blogTitle = blogFormContainer.find('input[name=blog_title]').val();
    previewHtmlGenreate += '<p class="blog-title">'+blogTitle+'</p>';

    blogFormContainer.find('div.blog-content').each(function() {
        if (this !== blogFirstContent.get(0)) {
            var $this = $(this);

            var singleTextContent = $this.find('textarea[name=blog_text]');
            // console.log(singleTextContent);
            if (singleTextContent.length > 0) {
                var contentValue = singleTextContent.val();
                var contentTextType = singleTextContent.data('text_type');
                if (contentTextType === 1) {
                    previewHtmlGenreate += '<p class="bold">'+contentValue+'</p>';
                } else if (contentTextType === 2) {
                    previewHtmlGenreate += '<p class="italic">'+contentValue+'</p>';
                } else {
                    previewHtmlGenreate += '<p>'+contentValue+'</p>';
                }
            }

            var singleImageContent = $this.find('input[name=blog_image]');
            if (singleImageContent.length > 0) {
                var blogImageUrl = $this.find('img').attr('src');

                previewHtmlGenreate += '<img src="'+blogImageUrl+'" style="width: 100%;" alt="">';
            }

            var singleVideoContent = $this.find('input[name=blog_video]');
            if (singleVideoContent.length > 0) {
                var blogVideoUrl = $this.find('video>source').attr('src');
                console.log(blogVideoUrl);
                var blogVideoType = $this.find('video>source').attr('type');

                previewHtmlGenreate += '\
                    <video autoplay class="blog-preview-video-tag">\
                    <source src="'+blogVideoUrl+'" type="'+blogVideoType+'">\
                    </video>\
                    ';
            }
        }
    });

    previewHtmlGenreate += '</div>';
    return previewHtmlGenreate;
}

function descriptionPosition() {
    var blogMainContainer = $('#blogMainContentContainer');

    var count = 0;

    blogMainContainer.find('div.form-group.blog-content').each(function(){
        var $this = $(this);
        var textareaInput = $this.find('textarea');
        var imageInput = $this.find('input[name=blog_image]');
        var videoInput = $this.find('input[name=blog_video]');
        if (typeof textareaInput != 'undefined') {
            textareaInput.data("order", count);
        }
        if (typeof imageInput != 'undefined') {
            imageInput.data("order", count);
        }
        if (typeof videoInput != 'undefined') {
            videoInput.data("order", count);
        }

        $this.find('a.blog_content_add_after_this_btn').data("count_order", count);

        count++;
    });

    return count;
}
