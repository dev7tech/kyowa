@extends('theme.default')

@section('content')

<div class="w3-modal" style= "padding-top:0 !important" id="orderProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('orderProduct').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">Change Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('orderProduct').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="order_product" enctype="multipart/form-data">
            <div class="modal-content" style="border:none">
                <span id="smsg"></span>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="sid" name="id">
                    <div class="form-group">
                        <label for="sn_id" class="col-form-label" style="color:blue;">商品ID :</label>
                        <input type="number" class="form-control" name="n_id" id="sn_id" placeholder="">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="swap(0)">Before</button>
                        <button type="button" class="btn btn-secondary" onclick="swap(1)">After</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
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

<input type="hidden" class="form-control" id="subcateId" value="{{$category->id}}" name="id">

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;">
                            <a href="{{URL::to('/admin/category/'.$pcategory->id)}}" style="padding-right: 30px; color:blue;">< 返回</a>
                            <button type="button" style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GotoCreatePage('{{URL::to('/admin/category/'.$category->id.'/products/create')}}',0)">新建</button>
                            <button id="edit1_product" type="button" disabled style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="GotoCreatePage('{{URL::to('/admin/category/'.$category->id.'/products/update')}}',1)">编辑</button>
                            <button id="order_product_btn" type="button" disabled style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="changeOrder()">移动</button>
                            <button id="delete_product" type="button" disabled style="padding:6px 30px 6px 30px" class="w3-button w3-white w3-border" onclick="Delete()">删除</button>
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
                            @include('theme.producttable')
                        </div>
                        <div id="hidden_value_1" style="display:none;">{{$category->name}}</div>
                        <div id="hidden_value_2" style="display:none;">{{$pcategory->name}}</div>
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
    $('.table').DataTable({
        pageLength: pageVal,
    });

    $('#product_table').on('click', 'input[type="checkbox"]', clickCheckbox);

    $('#master_checkbox').click(function(){
        $("#product_table #product_check").prop('checked',$(this).prop('checked'));
    });

    $('#master_checkbox').change(function(){
        if (!$(this).prop('checked')) {
            $('#master_checkbox').prop('checked', false);
        } else if ($('#product_table #product_check:not(:checked)').length == 0) {
            $('#master_checkbox').prop('checked', true);
        }
    });

    function clickCheckbox() {
        var $box = $(this);
        var groups = [];

        $.each($("input[name='product_check']:checked"), function() {
            groups.push($(this).val());
        });

        if (groups.length == 0 ) {
            $('#edit1_product').prop('disabled', true);
            $('#order_product_btn').prop('disabled', true);
            $('#delete_product').prop('disabled', true);
            $('#visible_product').prop('disabled', true);
        } else if (groups.length == 1) {
            $('#edit1_product').prop('disabled', false);
            $('#order_product_btn').prop('disabled', false);
            $('#delete_product').prop('disabled', false);
            $('#visible_product').prop('disabled', false);
        } else {
            $('#edit1_product').prop('disabled', true);
            $('#order_product_btn').prop('disabled', true);
            $('#delete_product').prop('disabled', false);
            $('#visible_product').prop('disabled', true);
        }
    }

    function GotoCreatePage(targetUrl,ifUpdate){
        if(ifUpdate==1){
            var id = 0;
            $.each($("input[name='product_check']:checked"), function() {
                id = $(this).val();
            });
            targetUrl+='?productId='+id;
            window.location.assign(targetUrl);

        }
        else{
            window.location.assign(targetUrl);

        }
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
        $('table#product_table').css('width','100%');
    }

    function Delete() {
        var ids = [];

        $.each($("input[name='product_check']:checked"), function() {
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
                    url:"{{ URL::to('admin/product/delete') }}",
                    data: {
                        ids: ids
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
                                    ProductTable();
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
        var nid = $('#sn_id').val();
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/product/swap') }}",
            data: {
                id: id,
                nid: nid,
                method: method
            },
            method: 'POST',
            success: function(response) {
                $('#preloader').hide();
                $('#sn_id').val('');
                var msg = '';
                if (response == 1) {
                    msg += '<div class="alert alert-success mt-1">Change product order successful</div>';
                    $('#message').html(msg);
                    setTimeout(function(){
                        $('#message').html('');
                    }, 3000);
                } else {
                    msg += '<div class="alert alert-danger mt-1">Cannot change product order<button class="close-dialog" onclick="closeError()">X</button></div>';
                    $('#message').html(msg);
                }
                jQuery("#orderProduct").modal('hide');
                ProductTable();
            },
            error: function(e) {
                $('#preloader').hide();
                $('#sn_id').val('');
                var msg = '';
                msg += '<div class="alert alert-danger mt-1">Change product order failed<button class="close-dialog" onclick="closeError()">X</button></div>';
                $('#message').html(msg);
                jQuery("#orderProduct").modal('hide');
            }
        });
    }

    function changeOrder() {
        var id = 0;
        $.each($("input[name='product_check']:checked"), function() {
            id = $(this).val();
        });
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/product/show') }}",
            data: {
                id: id
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#preloader').hide();
                jQuery("#orderProduct").css('display', 'block');
                $('#sid').val(response.id);
            },
            error: function(error) {
                $('#preloader').hide();
            }
        })
    }

    function ProductTable() {
        var id = 0;
        id = $('#subcateId').val();
        $('#preloader').show();
        $.ajax({
            url:"{{ URL::to('admin/product/list') }}",
            method:'get',
            data: {
                id: id
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
                $('#product_table').on('click', 'input[type="checkbox"]', clickCheckbox);
                $('#edit1_product').prop('disabled', true);
                $('#order_product_btn').prop('disabled', true);
                $('#delete_product').prop('disabled', true);
                $('#visible_product').prop('disabled', true);
            },
        });
    }



    $(document).ready(function() {
        var type = eval(<?php echo($category->type)?>);
        if(type == 1){
            $("#headerUrl").html("<h3>商品 > 大分类 > "+$("#hidden_value_2").html()+" > "+$("#hidden_value_1").html()+"</h3>");
        } else {
            $("#headerUrl").html("<h3>商品 > 大分类 > "+$("#hidden_value_2").html()+"</h3>");
        }
        $("#headerUrl").css({"margin-left":"40%",});

        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;
                $('div.gallery').html('');
                var n=0;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $($.parseHTML('<div>')).attr('class', 'imgdiv').attr('id','img_'+n).html('<img src="'+event.target.result+'" class="img-fluid">').appendTo(placeToInsertImagePreview);
                        n++;
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        var imagePlace = function (input, id) {
            if (input.files) {
            var reader = new FileReader();
            reader.onload = function(event) {
                if (id == 0) {
                    $("#editimg_big").attr('src', event.target.result);
                } else if (id == 1) {
                    $("#editimg_med").attr('src', event.target.result);
                } else {
                    $("#editimg_small").attr('src', event.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
            }
        }

        var getImagePlace = function (input, id) {
            if (input.files) {
            var reader = new FileReader();
            reader.onload = function(event) {
                if (id == 0) {
                    $("#getimg_big").attr('src', event.target.result);
                } else if (id == 1) {
                    $("#getimg_med").attr('src', event.target.result);
                } else {
                    $("#getimg_small").attr('src', event.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
            }
        }

        $('#editimage').on('change', function() {
            imagePlace(this, 0);
        });

        $('#editimage1').on('change', function() {
            imagePlace(this, 1);
        });

        $('#editimage2').on('change', function() {
            imagePlace(this, 2);
        });

        $('#getimage').on('change', function() {
            getImagePlace(this, 0);
        });

        $('#getimage1').on('change', function() {
            getImagePlace(this, 1);
        });

        $('#getimage2').on('change', function() {
            getImagePlace(this, 2);
        });

        $('#product_table_filter').hide();
        $('#product_table_length').hide();
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

    var images = [];
    function removeimg(id){
        images.push(id);
        $("#img_"+id).remove();
        $('#remove_'+id).remove();
        $('#removeimg').val(images.join(","));
        input.replaceWith(input.val('').clone(true));
    }
</script>
@endsection