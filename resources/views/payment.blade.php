@extends('theme.default')

@section('content')

<div class="w3-modal" style= "padding-top:0 !important" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('addPayment').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('addPayment').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_payment" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg"></span>
                <span id="message"></span>
                @csrf
                <div class="form-group">
                    <label for="name" class="col-form-label" style="font-weight: bold;color:black"><div style="color:red; display:inline;">*</div>Payment Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="">
                </div>
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('addPayment').style.display='none'">取消</button>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12"  style="padding:0;min-height:1460px">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">

                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="document.getElementById('addPayment').style.display='block'">新建</button>
                            <button id="delete_payment" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" type="button" disabled onclick="Delete()">删除</button>
                            <button id="visible_payment" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="setVisible()" disabled>设置状态</button>
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
                            @include('theme.paymenttable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->

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

    $('#payment_table').on('click', 'input[type="checkbox"]', clickCheckbox);

    $(document).ready(function() {

        $("#headerUrl").html("<h3>设置 > 支付 </h3>");

        $('#advance').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(document.getElementById('add_payment'));

            $.ajax({
                url:"{{ URL::to('admin/payment/store') }}",
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
                        $("#add_payment")[0].reset();

                        setTimeout(function(){
                        $('#message').html('');
                        }, 3000);
                        PaymentTable();
                    }
                },
            })
        });

        $('#usual').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(document.getElementById('add_payment'));
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/payment/store') }}",
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
                        $("#addPayment").modal('hide');
                        $("#add_payment")[0].reset();

                        setTimeout(function(){
                        $('#message').html('');
                        }, 3000);
                        PaymentTable();
                    }
                },
            })
        });

        $('#master_checkbox').click(function(){
            $("#payment_table #payment_check").prop('checked',$(this).prop('checked'));
        });

        $('#master_checkbox').change(function(){
            if (!$(this).prop('checked')) {
                $('#master_checkbox').prop('checked', false);
            } else if ($('#payment_table #payment_check:not(:checked)').length == 0) {
                $('#master_checkbox').prop('checked', true);
            }
        });

        $('#payment_table_filter').hide();
        $('#payment_table_length').hide();
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

    });

    function clickCheckbox() {
        var $box = $(this);
        var groups = [];

        $.each($("input[name='payment_check']:checked"), function() {
            groups.push($(this).val());
        });

        if (groups.length == 0 ) {
            $('#delete_payment').prop('disabled', true);
            $('#visible_payment').prop('disabled', true);
        } else if (groups.length == 1) {
            $('#delete_payment').prop('disabled', false);
            $('#visible_payment').prop('disabled', false);
        } else {
            $('#delete_payment').prop('disabled', false);
            $('#visible_payment').prop('disabled', true);
        }
    }

    function Delete() {
        var ids = [];

        $.each($("input[name='payment_check']:checked"), function() {
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
                    url:"{{ URL::to('admin/payment/delete') }}",
                    data: {
                        ids: ids
                    },
                    method: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            swal({
                                title: "确认的！",
                                text: "payment has been deleted.",
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
                                    PaymentTable();
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
        $.each($("input[name='payment_check']:checked"), function() {
            id = $(this).val();
        });
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/payment/status') }}",
            data: {
                id: id,
            },
            method: 'POST',
            success: function(response) {
                $('#preloader').hide();
                PaymentTable();
            }
        });
    }

    function PaymentTable() {
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/payment/list') }}",
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
                $('#payment_table').on('click', 'input[type="checkbox"]', clickCheckbox);
                $('#delete_payment').prop('disabled', true);
                $('#visible_payment').prop('disabled', true);
            },
        });
    }

</script>
@endsection