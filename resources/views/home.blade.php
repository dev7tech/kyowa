@extends('theme.default')

@section('content')


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <a href="{{URL::to('/admin/news')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">消息</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-rss"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <a href="{{URL::to('/admin/orders')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">命令</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-shopping-cart"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <a href="{{URL::to('/admin/categories')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">产品</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-gift"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <a href="{{URL::to('/admin/address')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">地址</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-location-dot"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <a href="{{URL::to('/admin/payments')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">付款方式</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-plus"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <a href="{{URL::to('/admin/finance')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">交易</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-usd"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <a href="{{URL::to('/admin/units')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">单元</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-plus"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <a href="{{URL::to('/admin/purse')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">信用点</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-plus"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <a href="{{URL::to('/admin/reports')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">统计数据</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-bar-chart"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <a href="{{URL::to('/admin/service')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">服务</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-users"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <a href="{{URL::to('/admin/users')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">用户</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-users"></i></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <a href="{{URL::to('/admin/chat/user')}}">
                        <div class="card-body">
                            <h3 class="card-title text-white">聊天记录</h3>
                            <div class="d-inline-block">
                            </div>
                            <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-users"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- #/ container -->
@endsection
@section('script')
<script type="text/javascript">
    $('.table').dataTable({
      aaSorting: [[0, 'DESC']]
    });
    function DeleteData(id) {
        swal({
            title: "你确定吗？",
            text: "Do you want to delete this Order ?",
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
                    url:"{{ URL::to('admin/orders/destroy') }}",
                    data: {
                        id: id
                    },
                    method: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            swal({
                                title: "确认的！",
                                text: "Order has been deleted.",
                                type: "success",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Ok",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true,
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    $('#dataid'+id).remove();
                                    swal.close();
                                    // location.reload();
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

    function StatusUpdate(id,status) {
        swal({
            title: "你确定吗？",
            text: "Do you want to change status?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, change it!",
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
                    url:"{{ URL::to('admin/orders/update') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    method: 'POST', //Post method,
                    dataType: 'json',
                    success: function(response) {
                        swal({
                            title: "确认的！",
                            text: "Status has been changed.",
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
                                location.reload();
                            }
                        });
                    },
                    error: function(e) {
                        swal("取消", "出了些问题！", "error");
                    }
                });
            } else {
                swal("取消", "Something went wrong :)", "error");
            }
        });
    }

    $(document).on("click", ".open-AddBookDialog", function () {
         var myBookId = $(this).data('id');
         $(".modal-body #bookId").val( myBookId );
    });

    function assign(){
        var bookId=$("#bookId").val();
        var driver_id = $('#driver_id').val();
        var CSRF_TOKEN = $('input[name="_token"]').val();
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-Token': CSRF_TOKEN
            },
            url:"{{ URL::to('admin/orders/assign') }}",
            method:'POST',
            data:{'bookId':bookId,'driver_id':driver_id},
            dataType:"json",
            success:function(data){
                $('#preloader').hide();
                if (data == 1) {
                    location.reload();
                }
            },error:function(data){

            }
        });
    }
</script>
@endsection