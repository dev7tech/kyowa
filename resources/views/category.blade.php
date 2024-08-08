@extends('theme.default')

@section('content')
    <input type="hidden" id="cate_type" value="{{$type}}"></input>
    <input type="hidden" id="p_id" value="{{$pid}}"></input>


    <div class="w3-modal" style= "padding-top:0 !important" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addCategory').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">
                            @if ($type == 1)
                            Small Category
                            @else
                            Category
                            @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addCategory').style.display='none'"><span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="add_category" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg"></span>
                    <span id="message"></span>
                    @csrf
                    <input type="hidden" name="pid" value="{{$pid}}" ></input>
                    @if ($type != 1)
                    <div class="form-group">
                        <label for="special_group" class="col-form-label">建立 :</label>
                        <div class="row" id="special_group" style="margin: 10px !important;">
                            <div class="col-md-6">
                                <input type="radio" checked value="0" name="type" id="type1" >
                                <label for="type1" class="col-form-label">&nbsp;&nbsp;大分类</label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" value="2" name="type" id="type3" >
                                <label for="type3" class="col-form-label">&nbsp;&nbsp;特別分类</label>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="category_name" class="col-form-label">
                            @if ($type == 1)
                            小分类名
                            @else
                            分类名
                            @endif
                        </label>
                        <input type="text" class="form-control" name="category_name" id="category_name" placeholder=""></input>
                    </div>
                </div>
                <div class="modal-footer" style="float:left; border:none">
                    <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                    <button type="submit" id="usual" class="btn btn-primary">确定</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addCategory').style.display='none'">取消</button>
                </div>
            </form>
            </div>
        </div>
        <!-- </div> -->
    </div>

    <div class="w3-modal" style= "padding-top:0 !important" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editCategory').style.display='none'"></div>
        <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
            <div class="w3-container">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">
                        @if ($type == 1)
                        小分类
                        @else
                        分类
                        @endif
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editCategory').style.display='none'"><span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit_category" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg_edit"></span>
                        <span id="message_edit"></span>
                        @csrf
                        <input type="hidden" name="pid" value="{{$pid}}" ></input>
                        <input type="hidden" class="form-control" id="editid" name="id"></input>
                        <div class="form-group">
                            <label for="editcategory_name" class="col-form-label">
                                @if ($type == 1)
                                小分类名
                                @else
                                分类名
                                @endif
                            </label>
                            <input type="text" class="form-control" name="category_name" id="editcategory_name" placeholder=""></input>
                        </div>
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <button type="submit" id="advance_edit" class="btn btn-primary">确定后，继续新建</button>
                        <button type="submit" id="usual_edit" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editCategory').style.display='none'">取消</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <div class="w3-modal" style= "padding-top:0 !important" id="orderCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div style="width:60%; height:100%; float:left" onclick="document.getElementById('orderCategory').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">改变顺序</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('orderCategory').style.display='none'"><span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <span id="smsg"></span>
                <span id="smessage"></span>
                <form method="post" id="order_category" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" id="pid" name="id">
                    <input type="hidden" class="form-control" id="sid" name="id">
                    <div class="form-group">
                        <label for="sn_id" class="col-form-label">分类 ID :</label>
                        <input type="number" class="form-control" name="n_id" id="sn_id" placeholder="">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="swap(0)">上一篇</button>
                        <button type="button" class="btn btn-secondary" onclick="swap(1)">下一個</button>
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
                                @if($type==1)
                                <a href="{{URL::to('/admin/categories')}}" style="padding-right: 30px; color:blue;">< 返回</a>
                                @endif
                                <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addCategory').style.display='block'">新建</button>
                                <button id="edit_cate" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GetData()" disabled>编辑</button>
                                <button id="order_cate_btn" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" disabled onclick="changeOrder()">改变顺序</button>
                                <button id="delete_cate" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                                <button id="visible_cate" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="setVisible()">情况</button>
                            </div>

                            <div id="table-display">
                                @include('theme.categorytable')
                            </div>
                            <div id="hidden_value" style="display:none;">{{$name}}<div>
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
    $(document).ready(function() {
        var type = eval(<?php echo($type)?>);

        if(type == 1) {
            $("#headerUrl").html("<h3>商品 > 大分类 > "+ $("#hidden_value").html() +"</h3>");
        } else {
            $("#headerUrl").html("<h3>商品 > 大分类</h3>");
        }

        $('#category_table').on('click', 'input[type="checkbox"]', clickCheckbox);

        $('#advance').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(document.getElementById('add_category'));
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/category/store') }}",
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
                        $("#add_category")[0].reset();

                        setTimeout(function(){
                          $('#message').html('');
                        }, 3000);
                        CatetgoryTable();
                    }
                },
            })
        });

        $('#usual').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(document.getElementById('add_category'));
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/category/store') }}",
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
                        $("#addCategory").css('display', 'block');
                        $("#add_category")[0].reset();

                        setTimeout(function(){
                          $('#message').html('');
                        }, 3000);
                        CatetgoryTable();
                    }
                },
            })
        });

        $('#advance_edit').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(this);
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/category/update') }}",
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
                        $('#msg_edit').html(msg);

                        $("#edit_category")[0].reset();

                        setTimeout(function(){
                          $('#msg_edit').html('');
                        }, 3000);
                    }
                    else
                    {
                        msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                        $('#message_edit').html(msg);
                        $("#edit_category")[0].reset();

                        setTimeout(function(){
                          $('#message_edit').html('');
                        }, 3000);
                        CatetgoryTable();
                    }
                },
            });
        });

        $('#usual_edit').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(this);
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/category/update') }}",
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
                        $('#msg_edit').html(msg);

                        $("#edit_category")[0].reset();

                        setTimeout(function(){
                          $('#msg_edit').html('');
                        }, 3000);
                    }
                    else
                    {
                        msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                        $('#message_edit').html(msg);
                        $("#editCategory").css('display', 'none');
                        $("#edit_category")[0].reset();

                        setTimeout(function(){
                          $('#message_edit').html('');
                        }, 3000);
                        CategoryTable();
                    }
                },
            });
        });

        //end edit category
    });
    var pageVal = localStorage.getItem('pagination');
    if (pageVal < 10) {
        pageVal = 10;
    }
    $('.table').dataTable({
        pageLength: pageVal
    });


    function clickCheckbox() {
        var $box = $(this);
        var groups = [];

        $.each($("input[name='cate_check']:checked"), function() {
            groups.push($(this).val());
        });

        console.log(groups);

        if (groups.length == 0 ) {
            $('#edit_cate').prop('disabled', true);
            $('#order_cate_btn').prop('disabled', true);
            $('#delete_cate').prop('disabled', true);
            $('#visible_cate').prop('disabled', true);
            $('#order_cate').prop('disabled', true);
        } else if (groups.length == 1) {
            $('#edit_cate').prop('disabled', false);
            $('#order_cate_btn').prop('disabled', false);
            $('#delete_cate').prop('disabled', false);
            $('#visible_cate').prop('disabled', false);
            $('#order_cate').prop('disabled', false);
        } else {
            $('#edit_cate').prop('disabled', true);
            $('#order_cate_btn').prop('disabled', true);
            $('#delete_cate').prop('disabled', false);
            $('#visible_cate').prop('disabled', true);
            $('#order_cate').prop('disabled', true);
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
            url:"{{ URL::to('admin/category/show') }}",
            data: {
                id: id
            },
            method: 'POST', //Post method,
            dataType: 'json',
            success: function(response) {
                $('#preloader').hide();
                var category = response.category;
                $('#editid').val(category.id);
                $('#editcategory_name').val(category.name);
                if (category.type == 0) {
                    $('#edittype1').prop('checked', true);
                } else if (category.type == 2) {
                    $('#edittype3').prop('checked', true);
                }
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
                    url:"{{ URL::to('admin/category/delete') }}",
                    data: {
                        ids: ids
                    },
                    method: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            swal({
                                title: "确认的！",
                                text: "类别已被删除。",
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
                                    CatetgoryTable();
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

    function swap(method) {
        var id = $('#sid').val();
        var pid = $('#pid').val();
        var nid = $('#sn_id').val();
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/category/swap') }}",
            data: {
                id: id,
                pid: pid,
                nid: nid,
                method: method
            },
            method: 'POST',
            success: function(response) {
                $('#preloader').hide();
                $('#sn_id').val('');
                var msg = '';
                if (response == 1) {
                    msg += '<div class="alert alert-success mt-1">更改类别订单成功</div>';
                    $('#message').html(msg);
                    setTimeout(function(){
                        $('#message').html('');
                    }, 3000);
                } else {
                    msg += '<div class="alert alert-danger mt-1">无法更改类别顺序<button class="close-dialog" onclick="closeError()">X</button></div>';
                    $('#message').html(msg);
                }
                jQuery("#orderCategory").modal('hide');
                CategoryTable();
            },
            error: function(e) {
                $('#preloader').hide();
                $('#sn_id').val('');
                var msg = '';
                msg += '<div class="alert alert-danger mt-1">更改类别订单失败<button class="close-dialog" onclick="closeError()">X</button></div>';
                $('#message').html(msg);
                jQuery("#orderCategory").modal('hide');
            }
        });
    }

    function changeOrder() {
        var id = 0;
        $.each($("input[name='cate_check']:checked"), function() {
            id = $(this).val();
        });
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/category/show') }}",
            data: {
                id: id
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#preloader').hide();
                jQuery("#orderCategory").css('display', 'block');
                $('#pid').val(response.category.p_id);
                $('#sid').val(response.category.id);
            },
            error: function(error) {
                $('#preloader').hide();
            }
        })
    }

    function setVisible() {
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

    function CatetgoryTable() {
        var pid = 0;
        var type = 0;
        pid = $('#p_id').val();
        type = $('#cate_type').val();
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/categories/list') }}",
            method:'get',
            data: {
                pid: pid,
                type: type,
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
                $('#category_table').on('click', 'input[type="checkbox"]', clickCheckbox);
                $('#edit_cate').prop('disabled', true);
                $('#order_cate_btn').prop('disabled', true);
                $('#delete_cate').prop('disabled', true);
                $('#visible_cate').prop('disabled', true);
            },
        });
    }
</script>
@endsection