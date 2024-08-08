@extends('theme.default')

@section('content')


    <input type="hidden" id="title_id" name="title_id" value="{{$newstitle->id}}" ></input>
        <div class="w3-modal" style= "padding-top:0 !important;" id="addNewsContent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addNewsContent').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container modal-content" style="border:none">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Add News Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addNewsContent').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_newscontent" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        <span id="message"></span>
                        @csrf
                        <input type="hidden" name="title_id" value="{{$newstitle->id}}" ></input>
                        <div class="form-group">
                            <label for="content" class="col-form-label">News Content</label>
                            <textarea class="form-control" rows="5" name="content" id="content" placeholder=""></textarea>
                        </div>
                        <div class="form-group row" style="margin-right:5px;">
                            <div class="col-md-4">
                                <div style="margin-bottom:15px;">
                                    子商品
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="codeId" id="codeId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div style="margin-bottom:15px;">
                                    商品名称
                                </div>
                                <div class="row">
                                    <select name="related_product" class="form-control" id="related_product" disabled>
                                            <option value="">Select Product :</option>
                                            <?php
                                            foreach ($products as $related_product) {
                                            ?>
                                            <option style="color:blue;" value="{{$related_product->id}}" class="importantGroup">
                                                <div style="display:inline; color:blue;"><b>{{$related_product->codeNo}}</b></div>
                                                <div style="display:inline; color:black !important;">&nbsp;{{$related_product->name}}</div>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <label for="content" class="col-form-label">Upload only image or media.Both are not recommended.</label>
                        <!-- beginning of 图片 block  -->
                        <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page3"><b>图片</b></div>
                        <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page3" class="collapse show">
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="file" name="image" id="image" accept="image/*" style="border:1px grey solid;padding:5px">
                                            <div class="input-group-btn" style="margin-right:10px;">
                                                <button id="delete_image" type="button" class="btn btn-danger" style="padding:10px 30px">删除</button>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="col-md-6" id="image_create" class="img-fluid"></img>
                                </div>
                        </div>
                        <!-- end of 图片 block -->
                        <!-- beginning of 视频 block  -->
                        <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page3"><b>视频</b></div>
                        <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page3" class="collapse show">
                                <div class="form-group">
                                    输入Youtube的视频URL, 追加视频
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="file" name="video" id="video" accept="video/*" style="border:1px grey solid;padding:5px">
                                            <div class="input-group-btn" style="margin-right:10px;">
                                                <button id="delete_video" type="button" class="btn btn-danger" style="padding:10px 30px">删除</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <video id="videoSource"  width="400" controls style="display:none">

                                </video>
                        </div>
                        <!-- end of 视频 block -->
                    </div>
                    <div class="modal-footer" style="float:left; border:none">


                        <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                        <button type="submit" id="usual" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addNewsContent').style.display='none'">取消</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>

        <div class="w3-modal" style= "padding-top:0 !important" id="editNewsContent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editNewsContent').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container modal-content" style="border:none">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Edit News Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editNewsContent').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_newscontent" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        <span id="message"></span>
                        @csrf
                        <input type="hidden" name="title_id" value="{{$newstitle->id}}" ></input>
                        <input type="hidden" name="id" id="editid" ></input>
                        <div class="form-group">
                            <label for="content" class="col-form-label">News Content</label>
                            <textarea class="form-control" rows="5" name="editcontent" id="editcontent" placeholder=""></textarea>
                        </div>
                        <div class="form-group row" style="margin-right:5px;">
                            <div class="col-md-4">
                                <div style="margin-bottom:15px;">
                                    子商品
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="codeId" id="editcodeId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div style="margin-bottom:15px;">
                                    商品名称
                                </div>
                                <div class="row">
                                    <select name="related_product" class="form-control" id="editrelated_product" disabled>
                                            <option value="">Select Product :</option>
                                            <?php
                                            foreach ($products as $related_product) {
                                            ?>
                                            <option style="color:blue;" value="{{$related_product->id}}" class="importantGroup">
                                                <div style="display:inline; color:blue;"><b>{{$related_product->codeNo}}</b></div>
                                                <div style="display:inline; color:black !important;">&nbsp;{{$related_product->name}}</div>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <label for="content" class="col-form-label">Upload only image or media.Both are not recommended.</label>
                        <!-- beginning of 图片 block  -->
                        <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page3"><b>图片</b></div>
                        <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page3" class="collapse show">
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="hidden" name="removeimg" id="removeimg">
                                            <input type="file" name="image" id="editimage" accept="image/*" style="border:1px grey solid;padding:5px">
                                            <div class="input-group-btn" style="margin-right:10px;">
                                                <button id="delete_edit_image" type="button" class="btn btn-danger" style="padding:10px 30px">删除</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img class="col-md-6" id="image_edit" class="img-fluid"></img>
                        </div>
                        <!-- end of 图片 block -->
                        <!-- beginning of 视频 block  -->
                        <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page3"><b>视频</b></div>
                        <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page3" class="collapse show">
                                 <div class="form-group">
                                    输入Youtube的视频URL, 追加视频
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="hidden" name="removevideo" id="removevideo">
                                            <input type="file" name="video" id="editvideo" accept="video/*" style="border:1px grey solid;padding:5px">
                                            <div class="input-group-btn" style="margin-right:10px;">
                                                <button id="delete_edit_video" type="button" class="btn btn-danger" style="padding:10px 30px">删除</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <video id="edit_videoSource"  width="400" controls style="display:none">

                                </video>
                        </div>
                        <!-- end of 视频 block -->
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <!-- <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                        <button type="submit" id="usual_edit" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editNewsContent').style.display='none'">取消</button>

                    </div>
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">

                            <a href="{{URL::to('/admin/news')}}" style="padding-right: 30px; color:blue;">< 返回</a>
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addNewsContent').style.display='block'">新建</button>
                            <button id="edit_cate" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GetData()" disabled>编辑</button>
                            <button id="delete_cate" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                        </div>

                        <div id="table-display">
                            @include('theme.newscontenttable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')

<script type="text/javascript">
    var pageVal = localStorage.getItem('pagination');
    if (pageVal < 10) {
        pageVal = 10;
    }
    $('.table').dataTable({
        pageLength: pageVal
    });

    $('#newscontent_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {
     //create modal's
        var firstDisplayedValue=0;
        $('#codeId').keydown( function(event) {
            if(event.which==13 ){//when key: enter pressed on the  codeNo input box
                event.preventDefault();
                $("#related_product").focus();
                if(firstDisplayedValue!=0) $("#related_product").val(firstDisplayedValue);
            }
        });
        $('#codeId').keyup( function(event) {
            if(event.which!=13 && event.which!=229){//when key: enter or clicked on the  codeNo input box
                var value = $(this).val().toLowerCase();
                $("#related_product option").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                if(value.length>=4) {//filter works more than 4 letters
                    $("#related_product").removeAttr("disabled");
                    index_val = 0;
                    if(length>=10) document.getElementById("related_product").size = 10;
                    else
                        {
                            options_tag_length = $("#related_product").children().length;
                            options_tag_obj = $("#related_product").children();
                            for(var loop=0;loop<options_tag_length;loop++){
                                tag_display = $(options_tag_obj[loop]).css("display");;
                                if(tag_display != "none")
                                {
                                    index_val++;
                                    if(index_val==1) firstDisplayedValue=$(options_tag_obj[loop]).val();
                                }
                            }
                            document.getElementById("related_product").size = index_val+1;
                        }
                }
                else{//filter dont work less than 4 letters
                    document.getElementById("related_product").disabled=true;
                    document.getElementById("related_product").size = 1 ;
                }
            }
        });

        $('#related_product').click(function(){//when clicked on the  option of the comboBox
            document.getElementById("related_product").size = 1 ;
        });

        $('#related_product').keydown( function(event) {
            if(event.which==13){//when key: enter pressed on the  comboBox
                event.preventDefault();
                document.getElementById("related_product").size = 1 ;
            }
            if(event.which==37){//when key: <- pressed on the  comboBox
                event.preventDefault();
                $('#codeId').focus();
            }
        });
        //end of the create modal's

        //update modal's
        var editFirstDisplayedValue=0;
        $('#editcodeId').keydown( function(event) {
                    if(event.which==13 ){//when key: enter pressed on the  codeNo input box
                        event.preventDefault();
                        $("#editrelated_product").focus();
                        if(editFirstDisplayedValue!=0) $("#editrelated_product").val(editFirstDisplayedValue);
                    }
        });
        $('#editcodeId').keyup( function(event) {
            if(event.which!=13 && event.which!=229){//when key: enter or clicked on the  codeNo input box
                var value = $(this).val().toLowerCase();
                $("#editrelated_product option").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                if(value.length>=4) {//filter works more than 4 letters
                    $("#editrelated_product").removeAttr("disabled");
                    index_val = 0;
                    if(length>=10) document.getElementById("editrelated_product").size = 10;
                    else
                        {
                            options_tag_length = $("#editrelated_product").children().length;
                            options_tag_obj = $("#editrelated_product").children();
                            for(var loop=0;loop<options_tag_length;loop++){
                                tag_display = $(options_tag_obj[loop]).css("display");;
                                if(tag_display != "none")
                                {
                                    index_val++;
                                    if(index_val==1) editFirstDisplayedValue=$(options_tag_obj[loop]).val();
                                }
                            }
                            document.getElementById("editrelated_product").size = index_val+1;
                        }
                }
                else{//filter dont work less than 4 letters
                    document.getElementById("editrelated_product").disabled=true;
                    document.getElementById("editrelated_product").size = 1 ;
                }
            }
        });

        $('#editrelated_product').click(function(){//when clicked on the  option of the comboBox
            document.getElementById("editrelated_product").size = 1 ;
        });

        $('#editrelated_product').keydown( function(event) {
            if(event.which==13){//when key: enter pressed on the  comboBox
                event.preventDefault();
                document.getElementById("editrelated_product").size = 1 ;
            }
            if(event.which==37){//when key: <- pressed on the  comboBox
                event.preventDefault();
                $('#editcodeId').focus();
            }
        });
    //end of the update modal's


    $("#removeimg").val(false);
    $("#removevideo").val(false);
    $("#headerUrl").html("<h3>消息 > 类别 > 标题 > 内容</h3>");
    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_newscontent'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/contentStore') }}",
            method:"POST",
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                $("#preloader").hide();
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#msg').html(msg);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message').html(msg);
                    // $("#addNewsContent").modal('hide');
                    $("#image_create").attr('src', '');
                    $("#image").val(null);
                    $("#videoSource").css('display', 'none');
                    $("#video").val(null);
                    $("#add_newscontent")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsContentTable();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_newscontent'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/contentStore') }}",
            method:"POST",
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                $("#preloader").hide();
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#msg').html(msg);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message').html(msg);
                    $("#addNewsContent").css('display', 'none');
                    $("#add_newscontent")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsContentTable();
                }
            },
        })
    });

    $('#edit_newscontent').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/contentUpdate') }}",
            method:'POST',
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                $("#preloader").hide();
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#msg').html(msg);

                    $("#edit_newscontent")[0].reset();

                    setTimeout(function(){
                      $('#msg').html('');
                    }, 3000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message').html(msg);
                    $('#image_edit').attr('src','');
                    $('#edit_videoSource').attr('src','');
                    $("#editNewsContent").css('display', 'none');
                    $("#edit_newscontent")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsContentTable();
                }
            },
        });
    });
});

function clickCheckbox() {
    var $box = $(this);
    var groups = [];

    $.each($("input[name='cate_check']:checked"), function() {
        groups.push($(this).val());
    });

    if (groups.length == 0 ) {
        $('#edit_cate').prop('disabled', true);
        $('#delete_cate').prop('disabled', true);
    } else if (groups.length == 1) {
        $('#edit_cate').prop('disabled', false);
        $('#delete_cate').prop('disabled', false);
    } else {
        $('#edit_cate').prop('disabled', true);
        $('#delete_cate').prop('disabled', false);
    }
}

function GetData() {
    var id = 0;
    $.each($("input[name='cate_check']:checked"), function() {
        id = $(this).val();
    });
    $('#preloader').show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/news/contentShow') }}",
        data: {
            id: id
        },
        method: 'POST', //Post method,
        dataType: 'json',
        success: function(response) {
            $('#preloader').hide();
            console.log(response);
            jQuery("#editNewsContent").css('display', 'block');
            var content = response.content;
            $('#editid').val(content.id);
            $('#editcontent').val(content.content);
            $('#editrelated_product').val(content.product_id);
            if(content.image != null) {
                $('#image_edit').attr('src','{{asset("public/images/news/")}}' + "/" + content.image);
                $('#image_edit').css('display', 'block');
            }
            else{
                $('#image_edit').attr('src', '');
                $('#image_edit').css('display', 'none');
            }
            if(content.media != null) {
                $('#edit_videoSource').attr('src','{{asset("public/videos/news/")}}' + "/" + content.media);
                $('#edit_videoSource').css('display', 'block');
            }
            else {
                $('#edit_videoSource').attr('src', '');
                $('#edit_videoSource').css('display', 'none');
            }
            // $('.gallerys').html("<img src="+content.image+" class='img-fluid' style='max-height: 200px;'>");
        },
        error: function(error) {
            $('#preloader').hide();
        }
    })
}

function Delete() {
    var ids = [];

    $.each($("input[name='cate_check']:checked"), function() {
        ids.push($(this).val());
    });

    swal({
        title: "你确定吗？",
        text: "你确定你要删除？",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "是",
        cancelButtonText: "不",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('admin/news/contentDelete') }}",
                data: {
                    ids: ids
                },
                method: 'POST',
                success: function(response) {
                    if (response == 1) {
                        swal({
                            title: "确认的！",
                            text: "Category has been deleted.",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Ok",
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                swal.close();
                                NewsContentTable();
                            }
                        });
                    } else {
                        swal("取消", "出了些问题！", "error");
                    }
                },
                error: function(e) {
                    swal("取消", "出了些问题！", "error");
                }
            });
        } else {
            swal("取消", "您的记录是安全的", "error");
        }
    });
}

function NewsContentTable() {
    var id = 0;
    id = $('#title_id').val();
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/news/contentlist') }}",
        method:"GET",
        data: {
            id: id,
        },
        success:function(data){
            $('#preloader').hide();
            $('#table-display').html(data);
            var pageVal = localStorage.getItem('pagination');
            if (pageVal < 10) {
                pageVal = 10;
            }
            $(".zero-configuration").DataTable({
                pageLength: pageVal
            });
            $('#newscontent_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#edit_cate').prop('disabled', true);
            $('#delete_cate').prop('disabled', true);
        },
    });
}

$(document).ready(function() {
     var imagesPreview = function(input, placeToInsertImagePreview) {
          if (input.files) {
              var filesAmount = input.files.length;
              $('.gallery').html('');
              var n=0;
              for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.onload = function(event) {
                       $($.parseHTML('<div>')).attr('class', 'imgdiv').attr('id','img_'+n).html('<img src="'+event.target.result+'" class="img-fluid">').appendTo(placeToInsertImagePreview);
                      n++;
                  }
                  reader.readAsDataURL(input.files[i]);
             }
          }
      };

    var getImagePlace = function (input, id) {
        if (input.files) {
        var reader = new FileReader();
        reader.onload = function(event) {
            if(id == 0) $("#image_create").attr('src', event.target.result);
            else {
                $("#image_edit").attr('src', event.target.result);
                $("#image_edit").css('display', 'block');
                $("#removeimg").val(false);
            }
        }
        reader.readAsDataURL(input.files[0]);
        }
    }

    var getVideoPlace = function (input, id) {
        if (input.files) {
            var reader = new FileReader();
            reader.onload = function(event) {
                if(id == 0) {
                    $("#videoSource").attr('src', event.target.result);
                    $("#videoSource").css('display', 'block');
                } else {
                    $("#edit_videoSource").attr('src', event.target.result);
                    $("#edit_videoSource").css('display', 'block');
                    $("#removevideo").val(false);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#delete_edit_video').on('click', function(){
        $("#removevideo").val(true);
        $("#editvideo").val(null);
        $("#edit_videoSource").css('display', 'none');
    });

    $('#delete_edit_image').on('click', function(){
        $("#removeimg").val(true);
        $("#editimage").val(null);
        $("#image_edit").attr('src', '');
    });

    $('#delete_video').on('click', function(){
        $("#video").val(null);
        $("#videoSource").css('display', 'none');
    });

    $('#delete_image').on('click', function(){
        $("#image").val(null);
        $("#image_create").attr('src', '');
    });

    $('#image').on('change', function() {
        getImagePlace(this, 0);
    });

    $('#editimage').on('change', function() {
        getImagePlace(this, 1);
    });

    $('#editvideo').on('change', function() {
        getVideoPlace(this, 1);
    });

    $('#video').on('change', function() {
        getVideoPlace(this, 0);
    });

});
var images = [];
function removeimg(id){
    images.push(id);
    $("#img_"+id).remove();
    $('#remove_'+id).remove();
    $('#removeimg').val(images.join(","));
}

</script>
@endsection