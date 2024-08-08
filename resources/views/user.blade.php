@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">User</a></li>
        </ol> -->

        <!-- Add User -->
        <!-- <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Add User
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_user">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <div class="form-group">
                            <label for="special_group" class="col-form-label">Username :</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="super star">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="star@iti.com"></input>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password :</label>
                            <input type="text" value="123456" class="form-control" name="password" id="password" placeholder="*****">
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-form-label">Role</label>
                            <select name="role" class="form-control" id="role">
                                <option value="">Select Role :</option>
                                <option value="0">Customer</option>
                                <option value="1">Admin</option>
                                <option value="2">Seller</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> -->

        <div class="w3-modal" style= "padding-top:0 !important" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addUser').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addUser').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="add_user" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg_add"></span>
                        <span id="message_add"></span>
                        @csrf
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="special_group" class="col-form-label">Username :</label>
                            <input type="text" class="form-control" name="username" id="username" required placeholder="super star">
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="email" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" name="email" id="email" required placeholder="star@iti.com"></input>
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="password" class="col-form-label">Password :</label>
                            <input type="text" value="123456" class="form-control" name="password" id="password" placeholder="*****">
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="role" class="col-form-label">Role</label>
                            <select name="role" class="form-control" id="role">
                                <option value="">Select Role :</option>
                                <option value="0">Customer</option>
                                <option value="1">Admin</option>
                                <option value="2">Seller</option>
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

        <!-- Edit User -->
        <!-- <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Edit User
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_user">
                    <div class="modal-body">
                        <span id="msg"></span>
                        @csrf
                        <input type="hidden" name="id" id="editId"></input>
                        <div class="form-group">
                            <label for="special_group" class="col-form-label">Username :</label>
                            <input type="text" class="form-control" name="username" id="editUsername" placeholder="super star">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" name="email" id="editEmail" placeholder="star@iti.com"></input>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Password :</label>
                            <input type="text" value="123456" class="form-control" name="password" id="password" placeholder="*****">
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-form-label">Role</label>
                            <select name="role" class="form-control" id="editRole">
                                <option value="">Select Role :</option>
                                <option value="0">Customer</option>
                                <option value="1">Admin</option>
                                <option value="2">Seller</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> -->

        <div class="w3-modal" style= "padding-top:0 !important" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div style="width:60%; height:100%; float:left" onclick="document.getElementById('editUser').style.display='none'"></div>
            <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
                <div class="w3-container">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Edit Point</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('editUser').style.display='none'"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="edit_user" enctype="multipart/form-data">
                    <div class="modal-body">
                        <span id="msg_edit"></span>
                        <span id="message_edit"></span>
                        @csrf
                        <input type="hidden" name="id" id="editId"></input>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="special_group" class="col-form-label">Username :</label>
                            <input type="text" class="form-control" name="username" required id="editUsername" placeholder="super star">
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="email" class="col-form-label">Email :</label>
                            <input type="email" class="form-control" name="email" required id="editEmail" placeholder="star@iti.com"></input>
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="password" class="col-form-label">Password :</label>
                            <input type="text" value="123456" class="form-control" name="password" id="password" placeholder="*****">
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="role" class="col-form-label">Role</label>
                            <select name="role" class="form-control" id="editRole">
                                <option value="">选择用户角色 :</option>
                                <option value="0">客户</option>
                                <option value="1">经理</option>
                                <option value="2">客服</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div style="color:red; display:inline;">*</div><label for="role" class="col-form-label">VIP</label>
                            <select name="role" class="form-control" id="editVIP">
                                <option value="0">没有贵宾</option>
                                <option value="1">普通会员</option>
                                <option value="2">黄金会员</option>
                                <option value="3">贵宾会员</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer" style="float:left; border:none">
                        <button type="submit" id="advance_edit" class="btn btn-primary">确定后，继续新建</button>
                        <button type="submit" id="usual_edit" class="btn btn-primary">确定</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('editUser').style.display='none'">取消</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </div>
</div> -->

<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12"  style="padding:0;min-height:1460px">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUser" data-whatever="@addUser">Add</button>
                            <button id="edit_user_btn" type="button" disabled class="btn btn-secondary" onclick="GetData()">Edit</button>
                            <button id="delete_user_btn" type="button" disabled class="btn btn-danger" onclick="Delete()">Delete</button>
                            <button id="set_role" type="button" disabled class="btn btn-secondary" onclick="setRole()">Change Role</button> -->
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addUser').style.display='block'">新建</button>
                            <button id="edit_user_btn" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GetData()" disabled>编辑</button>
                            <button id="delete_user_btn" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                            <button id="set_role" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="setRole()">Change Role</button>
                        </div>

                        <div id="table-display">
                            @include('theme.usertable')
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

    $('#user_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {

    $("#headerUrl").html("<h3>Users</h3>");

    //start add User

    // $('#add_user').on('submit', function(event){
    //     event.preventDefault();
    //     var form_data = new FormData(this);
    //     $('#preloader').show();
    //     $.ajax({
    //         url:"{{ URL::to('admin/users') }}",
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
    //                 $("#addUser").css('display','block');
    //                 $("#add_user")[0].reset();

    //                 setTimeout(function(){
    //                 $('#message').html('');
    //                 }, 3000);
    //                 UserTable();
    //             }
    //         },
    //     })
    // });

    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_user'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/users') }}",
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
                    UserTable();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_user'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/users') }}",
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
                    UserTable();
                }
            },
        })
    });


    //end add user

    //start edit user

    // $('#edit_user').on('submit', function(event){
    //     event.preventDefault();
    //     var form_data = new FormData(this);
    //     $('#preloader').show();
    //     $.ajax({
    //         url:"{{ URL::to('admin/user/update') }}",
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

    //                 $("#edit_user")[0].reset();

    //                 setTimeout(function(){
    //                 $('#msg').html('');
    //                 }, 3000);
    //             }
    //             else
    //             {
    //                 msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
    //                 $('#message').html(msg);
    //                 $("#editUser").modal('hide');
    //                 $("#edit_user")[0].reset();

    //                 setTimeout(function(){
    //                 $('#message').html('');
    //                 }, 3000);
    //                 UserTable();
    //             }
    //         },
    //     })
    // });

    $('#advance_edit').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('edit_user'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/user/update') }}",
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
                    $('#msg_edit').html(msg);

                    $("#edit_user")[0].reset();

                    setTimeout(function(){
                    $('#msg_edit').html('');
                    }, 3000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message_edit').html(msg);
                    // $("#editUser").modal('hide');
                    $("#edit_user")[0].reset();

                    setTimeout(function(){
                    $('#message_edit').html('');
                    }, 3000);
                    UserTable();
                }
            },
        })
    });

    $('#usual_edit').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('edit_user'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/user/update') }}",
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
                    $('#msg_edit').html(msg);

                    $("#edit_user")[0].reset();

                    setTimeout(function(){
                    $('#msg_edit').html('');
                    }, 3000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#message_edit').html(msg);
                    $("#editUser").css('display', 'none');
                    $("#edit_user")[0].reset();

                    setTimeout(function(){
                    $('#message_edit').html('');
                    }, 3000);
                    UserTable();
                }
            },
        })
    });

    //end edit user

});


function clickCheckbox() {
    var $box = $(this);
    var groups = [];

    $.each($("input[name='user_check']:checked"), function() {
        groups.push($(this).val());
    });

    if (groups.length == 0 ) {
        $('#edit_user_btn').prop('disabled', true);
        $('#delete_user_btn').prop('disabled', true);
        $('#set_role').prop('disabled', true);
    } else if (groups.length == 1) {
        $('#edit_user_btn').prop('disabled', false);
        $('#delete_user_btn').prop('disabled', false);
        $('#set_role').prop('disabled', false);
    } else {
        $('#edit_user_btn').prop('disabled', true);
        $('#delete_user_btn').prop('disabled', false);
        $('#set_role').prop('disabled', true);
    }
}

function setRole() {
    var id = 0;
    $.each($("input[name='user_check']:checked"), function() {
        id = $(this).val();
    });
    $('#preloader').show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/user/status') }}",
        data: {
            id: id,
        },
        method: 'POST',
        success: function(response) {
            $("#preloader").hide();
                var msg = '';
                if(!response)
                {
                    msg += '<div class="alert alert-danger">Change User Role Failed</div>';
                    $('#msg').html(msg);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">Change User Role Successful</div>';
                    $('#message').html(msg);

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    UserTable();
                }
        }
    });
}

function GetData() {
    var id = 0;
    $.each($("input[name='user_check']:checked"), function() {
        id = $(this).val();
    });
    $('#preloader').show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:"{{ URL::to('admin/user/show') }}",
        data: {
            id: id
        },
        method: 'POST', //Post method,
        dataType: 'json',
        success: function(response) {
            $('#preloader').hide();
            $("#editUser").css('display','block');
            var user = response;
            $('#editId').val(user.id);
            $('#editUsername').val(user.name);
            $('#editEmail').val(user.email);
            $('#editRole').val(user.type);
            $('#editVIP').val(user.vip);
        },
        error: function(error) {
            $('#preloader').hide();
        }
    })
}

function Delete() {
    var ids = [];

    $.each($("input[name='user_check']:checked"), function() {
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
                url:"{{ URL::to('admin/user/delete') }}",
                data: {
                    ids: ids
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
                                UserTable();
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

function UserTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/users/list') }}",
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
            $('#user_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#edit_user_btn').prop('disabled', true);
            $('#delete_user_btn').prop('disabled', true);
            $('#set_role').prop('disabled', true);
        },
    });
}

</script>
@endsection