@extends('theme.default')

@section('content')
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

<div class="w3-modal" style= "padding-top:0 !important" id="deliveryMethod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('deliveryMethod').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">添加方法</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_method" enctype="multipart/form-data">
            <div class="modal-body">
                <span id="msg_add"></span>
                <span id="message_add"></span>
                @csrf
                <input type="hidden" name="id" id="editId"></input>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div>
                    <label for="special_group" class="col-form-label">方法名 :</label>
                    <input type="text" class="form-control" name="method_name" id="method_name" required>
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div>
                    <label for="min-order-price" class="col-form-label">最低订购价 :</label>
                    <input type="number" class="form-control" name="min_price" id="min_price" required></input>
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div>
                    <label for="max-order-price" class="col-form-label">最大订单价 :</label>
                    <input type="number" class="form-control" name="max_price" id="max_price">
                </div>
                <div class="form-group">
                    <div style="color:red; display:inline;">*</div>
                    <label for="delivory-fee" class="col-form-label">交货价 :</label>
                    <input type="number" class="form-control" name="delivery_fee" id="delivery_fee">
                </div>
            </div>
            <div class="modal-footer" style="float:left; border:none">
                <button type="submit" id="advance" class="btn btn-primary">确定后，继续新建</button>
                <button type="submit" id="usual" class="btn btn-primary">确定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">取消</button>
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
                            <button id="create_method" type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="create()">新建</button>
                            <button id="edit_method" type="button" disabled style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="edite();">编辑</button>
                            <button id="delete_method" type="button" disabled style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="delete_method();">删除</button>
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
                            @include('theme.deliverytable')
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
        $("#headerUrl").html("<h3>设置 > 运输方式</h3>");

        $('#search_value').keyup(function(event){
            var keyCode = (event.keyCode ? event.keyCode : event.which);
            if(keyCode == '13'){
                UserCards();
            }
        });

        $('#advance').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(document.getElementById('add_method'));
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/delivery/store') }}",
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
                        $("#add_method")[0].reset();

                        setTimeout(function(){
                          $('#message').html('');
                        }, 3000);
                        methodTable();
                    }
                },
            })
        });

        $('#usual').on('click', function(event){
            event.preventDefault();
            var form_data = new FormData(document.getElementById('add_method'));
            $('#preloader').show();
            $.ajax({
                url:"{{ URL::to('admin/delivery/store') }}",
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
                        $("#deliveryMethod").css('display', 'none');
                        $("#add_method")[0].reset();

                        setTimeout(function(){
                          $('#message').html('');
                        }, 3000);
                        methodTable();
                    }
                },
            })
        });

        $('#method_table_filter').hide();
        $('#method_table_length').hide();
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

        $('#method_table').on('click', 'input[type="checkbox"]', clickCheckbox);
    });

    function clickCheckbox() {
        var $box = $(this);
        var groups = [];

        $.each($("input[name='method_check']:checked"), function() {
            groups.push($(this).val());
        });

        if (groups.length == 0 ) {
            $('#edit_method').prop('disabled', true);
            $('#delete_method').prop('disabled', true);
        } else if (groups.length == 1) {
            $('#edit_method').prop('disabled', false);
            $('#delete_method').prop('disabled', false);
        } else {
            $('#edit_method').prop('disabled', true);
            $('#delete_method').prop('disabled', false);
        }
    }

    function create(){
        document.getElementById('deliveryMethod').style.display='block';
    }

    function edite(){
        var id = 0;
        $.each($("input[name='method_check']:checked"), function() {
            id = $(this).val();
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('admin/delivery/show') }}",
            method:'POST',
            data:{'id':id},
            success:function(data){
                $('#preloader').hide();
                $('#editId').val(data.id);
                $('#method_name').val(data.method_name);
                $('#min_price').val(data.min_price);
                $('#max_price').val(data.max_price);
                $('#delivery_fee').val(data.delivery_fee);

                document.getElementById('deliveryMethod').style.display='block';
            },
            error: function(error) {
                $('#preloader').hide();
            }
        });
    }

    function delete_method(){
        var id = 0;
        $.each($("input[name='method_check']:checked"), function() {
            id = $(this).val();
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
                    url:"{{ URL::to('admin/delivery/delete') }}",
                    data: {
                        id: id
                    },
                    method: 'POST',
                    success: function(response) {
                        if (response == 1) {
                            swal({
                                title: "确认的！",
                                text: "Method has been deleted.",
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
                                    methodTable();
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

    function closeModal(){
        $("#add_method")[0].reset();
        document.getElementById('deliveryMethod').style.display='none';
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
        $('table#method_table').css('width','100%');
    }

    function methodTable(){
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/delivery/list') }}",
            method:'post',
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

                $('#method_table_filter').hide();
                $('#method_table_length').hide();
                $('#method_table').on('click', 'input[type="checkbox"]', clickCheckbox);
                $('#edit_method').prop('disabled', true);
                $('#delete_method').prop('disabled', true);
            },
        });
    }

</script>
@endsection