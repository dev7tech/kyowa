@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Tax</a></li>
        </ol>


    </div>
</div> -->


<div class="w3-modal" style= "padding-top:0 !important" id="addTax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addTax').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">新建单位</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addTax').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_tax" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg"></span>
                <span id="message"></span>
                @csrf
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div><label for="tax" class="col-form-label" style="font-weight: bold;color:black">单位名称 </label>
                    <input type="text" class="form-control" name="tax" id="tax" placeholder="">
                </div>

            </div>
            <div class="modal-footer" style="float:left; border:none">
                <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addTax').style.display='none'">取消</button>
            </div>
            </form>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="padding:0;min-height:1460px" >
            <span id="message"></span>
            <div class="card" style="border-radius:0">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addTax').style.display='block'">新建</button>
                            <button id="delete_tax" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                            <hr/>
                        </div>

                        <div id="table-display">
                            @include('theme.taxtable')
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

    $('#tax_table').on('click', 'input[type="checkbox"]', clickCheckbox);

$(document).ready(function() {



    $('#advance').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_tax'));
        // $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/tax/store') }}",
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
                    $("#add_tax")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    TaxTable();
                }
            },
        })
    });

    $('#usual').on('click', function(event){
        event.preventDefault();
        var form_data = new FormData(document.getElementById('add_tax'));
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/tax/store') }}",
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
                    $("#addTax").css('display', 'none');
                    $("#add_tax")[0].reset();

                    setTimeout(function(){
                      $('#message').html('');
                    }, 3000);
                    TaxTable();
                }
            },
        })
    });

});

function clickCheckbox() {
    var $box = $(this);
    var groups = [];


    $.each($("input[name='tax_check']"), function() {
        if($(this).is(":checked")){
            groups.push($(this).val());
            document.getElementById('dataid'+$(this).val()).style.backgroundColor = 'CornflowerBlue';
        }
        else {
            document.getElementById('dataid'+$(this).val()).style.backgroundColor = 'white';
        }
    });

    if (groups.length == 0 ) {
        $('#delete_tax').prop('disabled', true);
        $('#visible_tax').prop('disabled', true);
    } else if (groups.length == 1) {
        $('#delete_tax').prop('disabled', false);
        $('#visible_tax').prop('disabled', false);
    } else {
        $('#delete_tax').prop('disabled', false);
        // $('#edit_tax').prop('disabled', true);
        $('#visible_tax').prop('disabled', true);
    }
}

function Delete() {
    var ids = [];

    $.each($("input[name='tax_check']:checked"), function() {
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
                url:"{{ URL::to('admin/tax/delete') }}",
                data: {
                    ids: ids
                },
                method: 'POST',
                success: function(response) {
                    if (response == 1) {
                        swal({
                            title: "确认的！",
                            text: "Tax has been deleted.",
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
                                TaxTable();
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

function TaxTable() {
    $('#preloader').show();
    $.ajax({
        url:"{{ URL::to('admin/tax/list') }}",
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
            $('#tax_table').on('click', 'input[type="checkbox"]', clickCheckbox);
            $('#delete_tax').prop('disabled', true);
            $('#visible_tax').prop('disabled', true);
        },
    });
}

</script>
@endsection