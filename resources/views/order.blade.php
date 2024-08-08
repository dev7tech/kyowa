@extends('theme.default')

@section('content')

<!-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Order</a></li>
        </ol>
    </div>
</div> -->

<!-- row -->
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

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div style="padding: 5px 30px 10px;">
                        <button id="finishe_order" type="button" disabled style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border">订单完成</button>
                        <hr/>
                    </div>
                    <div class="table-responsive">
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
                            @include('theme.ordertable')
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
    $(document).ready(function(){
        $("#headerUrl").html("<h3>订单</h3>");

        $('#order_table_filter').hide();
        $('#order_table_length').hide();
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
                var header_str = $(".table").DataTable().column(this.index()).header().textContent.trim();
                var check_box_str = '<div class="form-check">';
                if(this.visible()) check_box_str += '<input class="form-check-input" type="checkbox" class="text-center" value='+this.index()+' checked></input>';
                else check_box_str += '<input class="form-check-input" type="checkbox" class="text-center" value='+this.index()+'></input>';
                check_box_str += '<label class="form-check-label">'+header_str+'</label>';
                check_box_str += '</div>';

                $("#myModal .table-column-group").append(check_box_str);
            });
            $("#myModal").modal('show');
        });

        $('#order_table').on('click', 'input[type="checkbox"]', clickCheckbox);

        $('#finishe_order').on('click',function(){
            var order_id = $("input[name='order_check']:checked").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('admin/orders/finished') }}",
                data: {
                    order_id: order_id
                },
                method: 'POST',
                success: function(response) {
                    $('#preloader').hide();
                    var msg = '';
                    $('#message').html(msg);
                    if (response == 1) {
                        msg += '<div class="alert alert-success mt-1">您已完成订单。</div>';
                        $('#message').html(msg);
                        setTimeout(function(){
                            $('#message').html('');
                        }, 3000);

                        OrderTable();
                    }else{
                        msg += '<div class="alert alert-danger mt-1">在处理过程中发生错误。</div>';
                        $('#message').html(msg);
                        setTimeout(function(){
                            $('#message').html('');
                        }, 3000);

                        OrderTable();
                    }
                },
                error: function(e) {
                    msg += '<div class="alert alert-danger mt-1">在处理过程中发生错误。</div>';
                    $('#message').html(msg);
                    setTimeout(function(){
                        $('#message').html('');
                    }, 3000);

                    OrderTable();
                }
            });
        });
    });

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
            if(checkedValue.indexOf(this.index())!== -1) this.visible(true);
            else this.visible(false);
        });
        $('table#order_table').css('width','100%');
    }

    function clickCheckbox() {
        var $box = $(this);
        var groups = [];

        $.each($("input[name='order_check']:checked"), function() {
            groups.push($(this).val());
        });

        if (groups.length == 0 ) {
            $('#finishe_order').prop('disabled', true);
        } else if (groups.length == 1) {
            $('#finishe_order').prop('disabled', false);
        } else {
            $('#finishe_order').prop('disabled', true);
        }
    }

    function OrderTable() {
        var pid = 0;
        var type = 0;
        pid = $('#p_id').val();
        type = $('#cate_type').val();
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/orders/jingheobianlist') }}",
            method:'get',
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
                $('#order_table').on('click', 'input[type="checkbox"]', clickCheckbox);
                $('#finished').prop('disabled', true);
            },
        });
    }
</script>
@endsection