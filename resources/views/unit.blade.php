@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Unit</a></li>
        </ol>


    </div>
</div> -->

<!-- Add Unit -->
<div class="w3-modal" style= "padding-top:0 !important" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addUnit').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">新建单位</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addUnit').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_unit" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg"></span>
                <span id="message"></span>
                @csrf
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="name" class="col-form-label" style="font-weight: bold;color:black">单位名称 </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="">
                </div>
                <!-- <div class="form-group">
                    <label for="description" class="col-form-label" style="font-weight: bold; color:black">单位搜索键 </label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="">
                </div> -->
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addUnit').style.display='none'">取消</button>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="padding:0;min-height:1460px" >
            <span id="message"></span>
            <div class="card" style="border-radius:0">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addUnit').style.display='block'">新建</button>
                            <!-- <button id="edit_unit" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('editUnit').style.display='block'" disabled>编辑</button> -->
                            <button id="delete_unit" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                            <hr/>
                        </div>

                        <div class="toolbar-container" style="display:flex;justify-content:space-between;padding:0 30px;">
                            <div class="search-container">
                                <input id="search_value" type="text" style="height:35px;text-indent:35px;width:500px;" placeholder="输入关键字，回车">
                                    <i class="fa-solid fa-magnifying-glass" style="margin-left:-485px;"></i>
                                </input>
                            </div>
                            <div class="table-column-container">
                                <span id="column-visible-contorol" class="column-control" style="cursor:pointer;font-size:15px;color:#545499;">
                                    <i class="fa-solid fa-gear">
                                        定制列
                                    </i>
                                </span>
                            </div>
                        </div>

                        <div id="table-display">
                            @include('theme.unittable')
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
                定制列
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

    $('#unit_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {

    $("#headerUrl").html("<h3>设置 > 单元</h3>");

    $('#master_checkbox').click(function(){
        $("#unit_table #unit_check").prop('checked',$(this).prop('checked'));
    });

    $('#master_checkbox').change(function(){
        if (!$(this).prop('checked')) {
            $('#master_checkbox').prop('checked', false);
        } else if ($('#unit_table #unit_check:not(:checked)').length == 0) {
            $('#master_checkbox').prop('checked', true);
        }
    });

    $('#unit_table_filter').hide();
    $('#unit_table_length').hide();
    $('#search_value').keyup(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if(keyCode == '13'){
            search_value = $(this).val();
            id = $('#subcateId').val();
            if(search_value == ''){
                msg = '<div class="alert alert-danger mt-1">请输入搜索值</div>';
                $('#message').html(msg);
                setTimeout(function(){
                    $('#message').html('');
                }, 3000);
                $('.table').DataTable().search('').columns().search('').draw();
            }else{
                $('.table').DataTable().search(search_value).draw();
            }
        }
    });

    $('#column-visible-contorol').on("click",function(){
        $("#myModal .table-column-group").empty();
        var columns = $(".table").DataTable().columns();
        columns.every(function(){
            if(this.index() != 0){
                var header_str = $(".table").DataTable().column(this.index()).header().textContent.trim();
                var check_box_str = '<div class="form-check">';
                if(this.visible()) check_box_str += '<input class="form-check-input" type="checkbox" class="text-center" value='+this.index()+' checked></input>';
                else check_box_str += '<input class="form-check-input" type="checkbox" class="text-center" value='+this.index()+'></input>';
                check_box_str += '<label class="form-check-label">'+header_str+'</label>';
                check_box_str += '</div>';

                $("#myModal .table-column-group").append(check_box_str);
            }
        });
        $("#myModal").modal('show');
    });

    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_unit'));
        // $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/unit/store') }}",
            method:"POST",
            data:form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(result) {
                // $("#preloader").hide();
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
                    $("#add_unit")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    UnitTable();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_unit'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/unit/store') }}",
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
                    $("#addUnit").css('display', 'none');
                    $("#add_unit")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    UnitTable();
                }
            },
        })
    });

});

function clickCheckbox() {
    var $box = $(this);
    var groups = [];

    // $.each($("input[name='unit_check']:checked"), function() {
    //     groups.push($(this).val());
    //     document.getElementById('dataid'+$(this).val()).style.backgroundColor = 'CornflowerBlue';
    // });
    $.each($("input[name='unit_check']"), function() {
        if($(this).is(":checked")){
            groups.push($(this).val());
            document.getElementById('dataid'+$(this).val()).style.backgroundColor = 'CornflowerBlue';
        }
        else {
            document.getElementById('dataid'+$(this).val()).style.backgroundColor = 'white';
        }
    });

    if (groups.length == 0 ) {
        $('#delete_unit').prop('disabled', true);
        // $('#edit_unit').prop('disabled', true);
        $('#visible_unit').prop('disabled', true);
    } else if (groups.length == 1) {
        $('#delete_unit').prop('disabled', false);
        // $('#edit_unit').prop('disabled', false);
        $('#visible_unit').prop('disabled', false);
    } else {
        $('#delete_unit').prop('disabled', false);
        // $('#edit_unit').prop('disabled', true);
        $('#visible_unit').prop('disabled', true);
    }
}

function Delete() {
    var ids = [];

    $.each($("input[name='unit_check']:checked"), function() {
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
                url:"{{ URL::to('admin/unit/delete') }}",
                data: {
                    ids: ids
                },
                method: 'POST',
                success: function(response) {
                    if (response == 1) {
                        swal({
                            title: "确认的！",
                            text: "Unit has been deleted.",
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
                                UnitTable();
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

function UnitTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/unit/list') }}",
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
            $('#unit_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#delete_unit').prop('disabled', true);
            $('#visible_unit').prop('disabled', true);
        },
    });
}

function column_visible(){
    // Get the value of the checked input element
    // var checkedValue = $('.table-column-group input[type="checkbox"]:checked').val();
    var checkedValue = [];
    $.each($(".table-column-group input[type='checkbox']:checked"), function() {
        checkedValue.push($(this).val()*1);
    });

    // Log the value to the console
    // console.log(checkedValue);
    var columns = $(".table").DataTable().columns();
    columns.every(function(){
        if(this.index() != 0){
            if(checkedValue.indexOf(this.index())!== -1) this.visible(true);
            else this.visible(false);
        }
    });
    $('table#user_table').css('width','100%');
}

</script>
@endsection