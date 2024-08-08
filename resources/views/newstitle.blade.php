@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <input type="hidden" id="cate_id" name="cate_id" value="{{$category->id}}" ></input>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/news')}}">News</a></li>
            <li class="breadcrumb-item active">{{$category->name}}</li>
        </ol> -->

        <!-- Add Title -->
        <!-- <div class="modal fade" id="addNewsTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add News Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_newstitle" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <input type="hidden" id="cate_id" name="cate_id" value="{{$category->id}}" ></input>
                        <div class="form-group">
                            <label for="title" class="col-form-label">News Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="News Content">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> -->

        <div class="w3-modal" style= "padding-top:0 !important" id="addNewsTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addNewsTitle').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Add News Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addNewsTitle').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_newstitle" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        <span id="message"></span>
                        @csrf
                        <input type="hidden" id="cate_id" name="cate_id" value="{{$category->id}}" ></input>
                        <div class="form-group">
                            <label for="title" class="col-form-label">News Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="News Content">
                        </div>
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <!-- <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                        <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                        <button type="submit" id="usual" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addNewsTitle').style.display='none'">取消</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>

        <!-- Edit Title -->
        <!-- <div class="modal fade" id="editNewsTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit News Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_newstitle" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <input type="hidden" name="id" id="editid" ></input>
                        <div class="form-group">
                            <label for="title" class="col-form-label">News Title</label>
                            <input type="text" class="form-control" name="title" id="edittitle" placeholder="News Title">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> -->Edit

        <div class="w3-modal" style= "padding-top:0 !important" id="editNewsTitle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editNewsTitle').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editNewsTitle').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_newstitle" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        <span id="message"></span>
                        @csrf
                        <input type="hidden" name="id" id="editid" ></input>
                        <div class="form-group">
                            <label for="title" class="col-form-label">News Title</label>
                            <input type="text" class="form-control" name="title" id="edittitle" placeholder="News Title">
                        </div>
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <!-- <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                        <button type="submit" id="usual_edit" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editNewsTitle').style.display='none'">取消</button>

                    </div>
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>

    <!-- </div>
</div> -->
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewsTitle" data-whatever="@addNewsTitle">Add</button>
                            <button id="edit_cate" type="button" disabled class="btn btn-secondary" onclick="GetData()">Edit</button>
                            <button id="delete_cate" type="button" disabled class="btn btn-danger" onclick="Delete()">Delete</button> -->
                            <a href="{{URL::to('/admin/news')}}" style="padding-right: 30px; color:blue;">< 返回</a>
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addNewsTitle').style.display='block'">新建</button>
                            <button id="edit_cate" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GetData()" disabled>编辑</button>
                            <button id="delete_cate" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                        </div>

                        <div id="table-display">
                            @include('theme.newstitletable')
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

    $('#newtitle_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {

    $("#headerUrl").html("<h3>消息 > 类别 > 标题</h3>");

    // $('#add_newstitle').on('submit', function(event){
    //     event.preventDefault();
    //     var form_data = new FormData(this);
    //     $('#preloader').show();
    //     $.ajax({
    //         url:"{{ URL::to('admin/news/titleStore') }}",
    //         method:"POST",
    //         data:form_data,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         dataType: "json",
    //         success: function(result) {
    //             $("#preloader").hide();
    //             var msg = '';
    //             if(result.error.length > 0)
    //             {
    //                 for(var count = 0; count < result.error.length; count++)
    //                 {
    //                     msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
    //                 }
    //                 $('#msg').html(msg);
    //             }
    //             else
    //             {
    //                 msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
    //                 $('#message').html(msg);
    //                 $("#addNewsTitle").modal('hide');
    //                 $("#add_newstitle")[0].reset();

    //                 setTimeout(function(){
    //                   $('#message').html('');
    //                 }, 3000);
    //                 NewsTitleTable();
    //             }
    //         },
    //     })
    // });

    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_newstitle'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/titleStore') }}",
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
                    // $("#addNewsTitle").modal('hide');
                    $("#add_newstitle")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsTitleTable();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_newstitle'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/titleStore') }}",
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
                    $("#addNewsTitle").css('display', 'none');
                    $("#add_newstitle")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsTitleTable();
                }
            },
        })
    });

    $('#edit_newstitle').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/titleUpdate') }}",
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

                    $("#edit_newstitle")[0].reset();

                    setTimeout(function(){
                      $('#msg').html('');
                    }, 3000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message').html(msg);
                    $("#editNewsTitle").css('display', 'none');
                    $("#edit_newstitle")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsTitleTable();
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
        url:"{{ URL::to('admin/news/titleShow') }}",
        data: {
            id: id
        },
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            $('#preloader').hide();
            jQuery("#editNewsTitle").css('display', 'block');
            var title = response.title;
            $('#editid').val(title.id);
            $('#edittitle').val(title.title);
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
                url:"{{ URL::to('admin/news/titleDelete') }}",
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
                                NewsTitleTable();
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

function NewsTitleTable() {
    var id = 0;
    id = $('#cate_id').val();
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/news/titlelist') }}",
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
            $('#newtitle_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#edit_cate').prop('disabled', true);
            $('#delete_cate').prop('disabled', true);
        },
    });
}

</script>
@endsection