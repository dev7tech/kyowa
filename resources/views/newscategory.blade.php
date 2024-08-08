@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">News</a></li>
        </ol>
         -->
        <!-- Add NewsCategory -->
        <!-- <div class="modal fade" id="addNewsCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add News Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_newscategory" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <div class="form-group">
                            <label for="newscategory" class="col-form-label">News Category</label>
                            <input type="text" class="form-control" name="newscategory" id="newscategory" placeholder="News Category">
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

        <div class="w3-modal" style= "padding-top:0 !important" id="addNewsCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addNewsCategory').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Add News Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addNewsCategory').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_newscategory" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        <span id="message"></span>
                        @csrf
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="newscategory" class="col-form-label">News Category</label>
                            <input type="text" class="form-control" name="newscategory" id="newscategory" placeholder="News Category">
                        </div>
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <!-- <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                        <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                        <button type="submit" id="usual" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addNewsCategory').style.display='none'">取消</button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>

        <!-- Edit NewsCategory -->
        <!-- <div class="modal fade" id="editNewsCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit News Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_newscategory" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <input type="hidden" name="id" id="editid" ></input>
                        <div class="form-group">
                            <label for="editnewscategory" class="col-form-label">News Category</label>
                            <input type="text" class="form-control" name="editnewscategory" id="editnewscategory" placeholder="News Category">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> -->

        <div class="w3-modal" style= "padding-top:0 !important" id="editNewsCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editNewsCategory').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editNewsCategory').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_newscategory" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                        <span id="message"></span>
                        @csrf
                        <div class="form-group">
                            <label for="editnewscategory" class="col-form-label">News Category</label>
                            <input type="text" class="form-control" name="editnewscategory" id="editnewscategory" placeholder="News Category">
                        </div>
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <!-- <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                        <button type="submit" id="usual_edit" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editNewsCategory').style.display='none'">取消</button>

                    </div>
                    </form>
                </div>
            </div>
            <!-- </div> -->
        </div>
<!--
    </div>
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
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewsCategory" data-whatever="@addNewsCategory">Add</button>
                            <button id="edit_cate" type="button" disabled class="btn btn-secondary" onclick="GetData()">Edit</button>
                            <button id="delete_cate" type="button" disabled class="btn btn-danger" onclick="Delete()">Delete</button> -->

                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addNewsCategory').style.display='block'">新建</button>
                            <button id="edit_cate" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GetData()" disabled>编辑</button>
                            <button id="delete_cate" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                        </div>

                        <div id="table-display">
                            @include('theme.newscategorytable')
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

    $('#newscategory_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {

    $("#headerUrl").html("<h3>News > Category</h3>");

    // $('#add_newscategory').on('submit', function(event){
    //     event.preventDefault();
    //     var form_data = new FormData(this);
    //     $('#preloader').show();
    //     $.ajax({
    //         url:"{{ URL::to('admin/news/categoryStore') }}",
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
    //                 $("#addNewsCategory").modal('hide');
    //                 $("#add_newscategory")[0].reset();

    //                 setTimeout(function(){
    //                   $('#message').html('');
    //                 }, 3000);
    //                 NewsCategoryTable();
    //             }
    //         },
    //     })
    // });

    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_newscategory'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/categoryStore') }}",
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
                    $("#add_newscategory")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsCategoryTable();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_newscategory'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/categoryStore') }}",
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
                    $("#addNewsCategory").css('display', 'none');
                    $("#add_newscategory")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsCategoryTable();
                }
            },
        })
    });

    $('#edit_newscategory').on('submit', function(event){
        event.preventDefault();
        var form_data = new FormData(this);
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/news/categoryUpdate') }}",
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

                    $("#edit_newscategory")[0].reset();

                    setTimeout(function(){
                      $('#msg').html('');
                    }, 3000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message').html(msg);
                    $("#editNewsCategory").css('display', 'none');
                    $("#edit_newscategory")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    NewsCategoryTable();
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
        url:"{{ URL::to('admin/news/categoryShow') }}",
        data: {
            id: id
        },
        method: 'POST', //Post method,
        dataType: 'json',
        success: function(response) {
            $('#preloader').hide();
            jQuery("#editNewsCategory").css('display', 'block');
            var category = response.category;
            $('#editnewscategory').val(category.name);
            $('#editid').val(category.id);
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
                url:"{{ URL::to('admin/news/categoryDelete') }}",
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
                                NewsCategoryTable();
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

function setVisible(id,status) {
    var id = 0;
    $.each($("input[name='cate_check']:checked"), function() {
        id = $(this).val();
    });
    $('#preloader').show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/category/status') }}",
        data: {
            id: id,
        },
        method: 'POST',
        success: function(response) {
            $('#preloader').hide();
            CatetgoryTable();
        }
    });
}

function NewsCategoryTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/news/categorylist') }}",
        method:"GET",
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
            $('#newscategory_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#edit_cate').prop('disabled', true);
            $('#delete_cate').prop('disabled', true);
        },
    });
}

</script>
@endsection