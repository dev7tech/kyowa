@extends('theme.default')

@section('content')
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12"  style="padding:0;overflow:hidden;">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div style="padding: 5px 30px 10px;">
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="AddUser()">新建</button>
                            <button id="edit_user_btn" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" disabled>编辑</button>
                            <button id="delete_user_btn" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="DeleteUser()">删除</button>
                    </div>
                    <div class="table-responsive">
                        <div class="toolbar-container" style="display:flex;justify-content:space-between;padding:0 30px;">
                            <div class="search-container">
                                <input id="search_value" type="text" style="height:35px;text-indent:35px;width:500px;" placeholder="输入关键字，回车">
                                    <i class="fa-solid fa-magnifying-glass" style="margin-left:-485px;"></i>
                                </input>
                            </div>
                        </div>

                        <div id="table-display" style="margin-top:25px;display:flex;flex-wrap: wrap;"  class="userinfo-cards">
                            @include('theme.userinfocards')
                        </div>

                        <div id="pagination-container" class="d-flex justify-content-center" user-cnt-info="{{ $users_cnt }}">
                            <div id="pagenation-list" class="pagenation_container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                用户信息
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" id="assign">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="form-group table-column-group" style="display: flex;justify-content: space-between;flex-wrap: wrap;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="column_visible()" data-dismiss="modal">确定</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
            </form>
        </div>

    </div>
</div>

<div class="w3-modal" style= "padding-top:0 !important" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addUser').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">添加用户</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addUser').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_user" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg_add"></span>
                <span id="message_add"></span>
                @csrf
                <input type="hidden" name="id" id="editId"></input>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="special_group" class="col-form-label">用户名 :</label>
                    <input type="text" class="form-control" name="username" id="username" required placeholder="super star">
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="email" class="col-form-label">电子邮件 :</label>
                    <input type="email" class="form-control" name="email" id="email" required placeholder="star@iti.com"></input>
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="password" class="col-form-label">密码 :</label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="*****">
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="role" class="col-form-label">角色</label>
                    <select name="role" class="form-control" id="role">
                        <option value="0">客户</option>
                        <option value="1">经理</option>
                        <option value="2">客服</option>
                    </select>
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="vip" class="col-form-label">贵宾</label>
                    <select name="vip" class="form-control" id="vip">
                        <option value="0">没有贵宾</option>
                        <option value="1">普通会员 - 5%</option>
                        <option value="2">黄金会员 - 10%</option>
                        <option value="3">贵宾会员 - 30%</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addUser').style.display='none'">取消</button>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

<!-- #/ container -->
@endsection
@section('script')

<script type="text/javascript">
$(document).ready(function() {
    $("#headerUrl").html("<h3>用户</h3>");

    $(".card-content").empty();

    $(".user-info-card").on("click",function(){
        $(".user-info-card-selected").removeClass("user-info-card-selected");
        $(this).addClass("user-info-card-selected");

        $('#edit_user_btn').prop('disabled', false);
        $('#delete_user_btn').prop('disabled', false);
        // $('#set_role').prop('disabled', false);

    })

    $('#search_value').keyup(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if(keyCode == '13'){
            UserCards();
        }
    });

    $("#edit_user_btn").click(function(event){
        user_id = $(".user-info-card-selected").attr("data-user-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('admin/user/show') }}",
            method:'POST',
            data:{'id':user_id},
            success:function(data){
                $('#preloader').hide();
                $('#editId').val(data.id);
                $('#username').val(data.name);
                $('#email').val(data.email);
                $('#role').val(data.type);
                $('#vip').val(data.vip);
            },
            error: function(error) {
                $('#preloader').hide();
            }
        });
        $("#exampleModalLabel").html("编辑用户");
        document.getElementById('addUser').style.display='block';
    });

    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_user'));
        if($("#editId").val() == 0) var url = "{{ URL::to('admin/users') }}";
        else var url = "{{ URL::to('admin/user/update') }}";

        $('#preloader').show();
        $.ajax({
            url:url,
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
                    $('#msg_add').html(msg);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message_add').html(msg);
                    $("#add_user")[0].reset();

                    setTimeout(function(){
                    $('#message_add').html('');
                    }, 3000);
                    UserCards();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_user'));

        if($("#editId").val() == 0) var url = "{{ URL::to('admin/users') }}";
        else var url = "{{ URL::to('admin/user/update') }}";

        $('#preloader').show();
        $.ajax({
            url:url,
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
                    $('#msg_add').html(msg);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message_add').html(msg);
                    $("#addUser").css('display','none');
                    $("#add_user")[0].reset();

                    setTimeout(function(){
                    $('#message_add').html('');
                    }, 3000);
                }
                UserCards();
            },
        })
    });

    // define variables
    // createPaginationButtons(1);
    initPageNation(1);
});

function AddUser(){
    $("#exampleModalLabel").html("添加用户");
    $('#editId').val(0);
    $('#username').val('');
    $('#email').val('');
    $('#role').val('');

    document.getElementById('addUser').style.display='block';
}

function UserCards() {
    var search_value = $("#search_value").val();
    var selectedPage = $(".page-selector-selected").attr("page-number") * 1;
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/users/list') }}",
        method:"GET",
        data:{'search_value':search_value, 'offset':selectedPage},
        success:function(data){
            $('#preloader').hide();
            $('#table-display').empty();
            $('#table-display').html(data);
            $('#edit_user_btn').prop('disabled', true);
            $('#delete_user_btn').prop('disabled', true);
            $(".user-info-card").on("click",function(){
                $(".user-info-card-selected").removeClass("user-info-card-selected");
                $(this).addClass("user-info-card-selected");

                $('#edit_user_btn').prop('disabled', false);
                $('#delete_user_btn').prop('disabled', false);
            });
        },
    });
}

function DeleteUser() {
    var id = $(".user-info-card-selected").attr("data-user-id");;
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
                url:"{{ URL::to('admin/user/delete') }}",
                data: {
                    id: id
                },
                method: 'POST',
                success: function(response) {
                    if (response == 1) {
                        swal({
                            title: "确认的！",
                            text: "User has been deleted.",
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
                                UserCards();
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


function initPageNation(selectPage){
    cnt = $("#pagination-container").attr("user-cnt-info");
    btn_number = Math.ceil(cnt/24);
    if(selectPage <= 0) return;
    if(selectPage > btn_number) return;
    $(".pagenation_container").empty();
    var btn_str = "<Button class='page-selector' page-number='-1'><i class='fa fa-backward-fast'></i></Button>";
    btn_str += "<Button class='page-selector' page-number='0'><i class='fa fa-backward'></i></Button>";
    $(".pagenation_container").append(btn_str);
    if(btn_number > 6){
        switch(selectPage){
            case 1:
                var btn_str = "<Button id='page-1' class='page-selector page-selector-selected' page-number='1'>1</Button>";
                btn_str += "<Button id='page-2' class='page-selector' page-number='2'>2</Button>";
                btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                btn_str += "<Button id='page-"+(btn_number-1)+"' class='page-selector' page-number='"+(btn_number-1)+"'>"+(btn_number-1)+"</Button>";
                btn_str += "<Button id='page-"+(btn_number)+"' class='page-selector' page-number='"+(btn_number)+"'>"+(btn_number)+"</Button>";
                $(".pagenation_container").append(btn_str);
            break;
            case 2:
                var btn_str = "<Button id='page-1' class='page-selector' page-number='1'>1</Button>";
                btn_str += "<Button id='page-2' class='page-selector page-selector-selected' page-number='2'>2</Button>";
                btn_str += "<Button id='page-3' class='page-selector' page-number='3'>3</Button>";
                btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                btn_str += "<Button id='page-"+(btn_number-1)+"' class='page-selector' page-number='"+(btn_number-1)+"'>"+(btn_number-1)+"</Button>";
                btn_str += "<Button id='page-"+(btn_number)+"' class='page-selector' page-number='"+(btn_number)+"'>"+(btn_number)+"</Button>";
                $(".pagenation_container").append(btn_str);
            break;
            case (btn_number-1):
                var btn_str = "<Button id='page-1' class='page-selector' page-number='1'>1</Button>";
                btn_str += "<Button id='page-2' class='page-selector' page-number='2'>2</Button>";
                btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                btn_str += "<Button id='page-"+(btn_number-2)+"' class='page-selector page-number='"+(btn_number-2)+"'>"+(btn_number-2)+"</Button>";
                btn_str += "<Button id='page-"+(btn_number-1)+"' class='page-selector  page-selector-selected' page-number='"+(btn_number-1)+"'>"+(btn_number-1)+"</Button>";
                btn_str += "<Button id='page-"+(btn_number)+"' class='page-selector' page-number='"+(btn_number)+"'>"+(btn_number)+"</Button>";
                $(".pagenation_container").append(btn_str);
            break;
            case btn_number:
                var btn_str = "<Button id='page-1' class='page-selector' page-number='1'>1</Button>";
                btn_str += "<Button id='page-2' class='page-selector' page-number='2'>2</Button>";
                btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                btn_str += "<Button id='page-"+(btn_number-1)+"' class='page-selector' page-number='"+(btn_number-1)+"'>"+(btn_number-1)+"</Button>";
                btn_str += "<Button id='page-"+(btn_number)+"' class='page-selector page-selector-selected' page-number='"+(btn_number)+"'>"+(btn_number)+"</Button>";
                $(".pagenation_container").append(btn_str);
            break;

            default:
                var btn_str = "<Button id='page-1' class='page-selector' page-number='1'>1</Button>";
                btn_str += "<Button id='page-2' class='page-selector' page-number='2'>2</Button>";
                if(selectPage != 3) {
                    if(selectPage != (btn_number-2)){
                        if((selectPage-2)>2) btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                        btn_str += "<Button id='page-"+(selectPage-1)+"' class='page-selector' page-number='"+(selectPage-1)+"'>"+(selectPage-1)+"</Button>";
                        btn_str += "<Button id='page-"+(selectPage)+"' class='page-selector page-selector-selected' page-number='"+(selectPage)+"'>"+(selectPage)+"</Button>";
                        btn_str += "<Button id='page-"+(selectPage+1)+"' class='page-selector' page-number='"+(selectPage+1)+"'>"+(selectPage+1)+"</Button>";
                        if((selectPage+2)<(btn_number-1)) btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                    }else{
                        btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                        btn_str += "<Button id='page-"+(btn_number-2)+"' class='page-selector page-selector-selected' page-number='"+(btn_number-2)+"'>"+(btn_number-2)+"</Button>";
                    }
                }else{
                    btn_str += "<Button id='page-3' class='page-selector page-selector-selected' page-number='3'>3</Button>";
                    btn_str += "<Button id='page-4' class='page-selector' page-number='4'>4</Button>";
                    btn_str += "<Button id='page-ellipsis' class='page-selector' page-number='ellipsis'><i class='fa fa-ellipsis'></i></Button>";
                }
                btn_str += "<Button id='page-"+(btn_number-1)+"' class='page-selector' page-number='"+(btn_number-1)+"'>"+(btn_number-1)+"</Button>";
                btn_str += "<Button id='page-"+(btn_number)+"' class='page-selector' page-number='"+(btn_number)+"'>"+(btn_number)+"</Button>";
                $(".pagenation_container").append(btn_str);
            break;
        }
    }else{
        for(var loop=1;loop<=btn_number;loop++){
            if(loop == selectPage) var btn_str = "<Button id='page-"+loop+"' class='page-selector page-selector-selected' page-number='"+loop+"'>"+loop+"</Button>";
            else var btn_str = "<Button id='page-"+loop+"' class='page-selector' page-number='"+loop+"'>"+loop+"</Button>";
            $(".pagenation_container").append(btn_str);
        }
    }
    var btn_str = "<Button class='page-selector' page-number='-2'><i class='fa fa-forward'></i></Button>";
    btn_str += "<Button class='page-selector' page-number='-3'><i class='fa fa-forward-fast'></i></Button>";
    $(".pagenation_container").append(btn_str);

    $('.page-selector').on('click',function(event){
        var selectedButtonValue = $(this).attr("page-number") * 1;
        var CurrentSelectedPage = $(".page-selector-selected").attr("page-number") * 1;
        if(selectedButtonValue > 0){
            initPageNation(selectedButtonValue);
        }
        else{
            switch(selectedButtonValue){
                case -1:
                    initPageNation(1);
                break;
                case 0:
                    initPageNation(CurrentSelectedPage - 1);
                break;
                case -2:
                    initPageNation(CurrentSelectedPage + 1);
                break;
                case -3:
                    initPageNation(btn_number);
                break;
            }
        }
        UserCards();
    });
}

</script>
@endsection