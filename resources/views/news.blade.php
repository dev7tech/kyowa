@extends('theme.default')

@section('content')

<!-- add news category Modal-->
<div class="w3-modal" style= "padding-top:0 !important" id="addNewsCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addNewsCategory').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">添加新闻类别</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addNewsCategory').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_newscategory" enctype="multipart/form-data">
                <div class="modal-body">
                    <span id="msg"></span>
                    <span id="message"></span>
                    @csrf
                    <div class="form-group">
                        <div style="color:red; display:inline;">*</div><label for="newscategory" class="col-form-label">新闻分类</label>
                        <input type="text" class="form-control" name="newscategory" id="newscategory" placeholder="News Category">
                    </div>
                </div>
                <div class="modal-footer" style="float:left; border:none">
                    <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                    <button type="submit" id="usual" class="btn btn-primary">确定</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addNewsCategory').style.display='none'">取消</button>
                </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

<!-- edit news category Modal-->
<div class="w3-modal" style= "padding-top:0 !important" id="editNewsCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <input type="hidden" name="id" id="edit_category_id" ></input>
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
</div>

<!-- add news title Modal-->
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
                <input type="hidden" id="category_title_id" name="cate_id"></input>
                <div class="form-group">
                    <label for="title" class="col-form-label">News Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="News Content">
                </div>
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <!-- <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                <button type="submit" id="advance_title" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual_title" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addNewsTitle').style.display='none'">取消</button>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

<!-- edit news title Modal-->
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
                <input type="hidden" name="id" id="edit_title_id" ></input>
                <div class="form-group">
                    <label for="title" class="col-form-label">News Title</label>
                    <input type="text" class="form-control" name="title" id="edittitle" placeholder="News Title">
                </div>
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <!-- <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                <button type="submit" id="usual_title" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editNewsTitle').style.display='none'">取消</button>

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
                    <div style="padding: 5px 30px 10px;text-align: end;">
                        <button type="button" style="padding:6px 30px 6px 30px;border-radius:25px;" class="btn btn-success" onclick="document.getElementById('addNewsCategory').style.display='block'">
                            <i class="fa-solid fa-circle-plus">
                                新建
                            </i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            @include('theme.newscategorylist')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#headerUrl").html("<h3>消息</h3>");

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
                    }
                },
            })
        });

        $('#advance_title').on('click', function(event){
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
                                            }
                },
            })
        });

        $('#usual_title').on('click', function(event){
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
                        category_id = $('#edit_category_id').val();
                        category_new_name = $('#editnewscategory').val();
                        msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                        $('#message').html(msg);
                        $("#editNewsCategory").css('display', 'none');
                        $("#edit_newscategory")[0].reset();

                        setTimeout(function(){
                        $('#message').html('');
                        }, 3000);
                        $("#news-category-name-"+category_id).html(category_new_name);
                    }
                },
            });
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
                        title_id = $('#edit_title_id').val();
                        title_new_name = $('#edittitle').val();
                        title_number = $('#news_title_'+title_id).html().split('.')[0];

                        msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                        $('#message').html(msg);
                        $("#editNewsTitle").css('display', 'none');
                        $("#edit_newstitle")[0].reset();

                        setTimeout(function(){
                            $('#message').html('');
                        }, 3000);

                        $('#news_title_'+title_id).html(title_number+'.'+title_new_name);

                    }
                },
            });
        });
    });

    function Delete(id) {
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
                        ids: id
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

    function GetData(id) {
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
                $('#edit_category_id').val(category.id);
            },
            error: function(error) {
                $('#preloader').hide();
            }
        })
    }

    function GetTitleData(id) {
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
                $('#edit_title_id').val(title.id);
                $('#edittitle').val(title.title);
            },
            error: function(error) {
                $('#preloader').hide();
            }
        });
    }

    function DeleteTitle(id) {
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
                        ids: id
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

    function showAddNewsTitle(category_id){
        $('#addNewsTitle #category_title_id').val(category_id);
        document.getElementById('addNewsTitle').style.display='block';
    }
</script>
@endsection

