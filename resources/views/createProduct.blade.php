@extends('theme.default')

@section('content')
    <div  id="urlDiv" style="display:none;">{{URL::to('/admin/category/'.$category->id.'/products')}}</div>


        <input type="hidden" class="form-control" id="subcateId" value="{{$category->id}}" name="id">

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <form id="add_product" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <div style="padding: 5px 30px 10px;">
                                <input type="hidden" class="form-control" id="productId" value="" name="productId">

                                <a href="{{URL::to('/admin/category/'.$category->id.'/products')}}" style="padding-right: 30px; color:blue;">< 返回</a>

                                <button type="submit" id="subBtn" style="padding:6px 30px 6px 30px;color:white;" class="w3-button w3-blue w3-border" disabled>
                                @if($CorU==1)
                                    新建
                                @else
                                    保存
                                @endif
                                </button>


                                <hr/>
                                <ol style="font-size:20px;color:black; display:inline;">

                                    @if ($category->type == 1)

                                        <li style="display:inline-block;"><a href="{{URL::to('/admin/category/'.$pcategory->id)}}">{{$pcategory->id}}&nbsp;({{$pcategory->name}})&nbsp;/</a></li>
                                        <li  style="display:inline-block;"><a href="{{URL::to('/admin/category/'.$category->id.'/products')}}">{{$category->id}}&nbsp;({{$category->name}})</a></li>
                                        @if($CorU == 0)
                                            <li  style="display:inline-block;">/&nbsp;<div id="labelForCodeNo" style="display:inline-block;">></div>&nbsp;(<div id="nameTag1" style="display:inline-block;"></div>)</li>
                                        @endif
                                    @else

                                        <li  style="display:inline-block;"><a href="{{URL::to('/admin/category/'.$category->id.'/products')}}">{{$category->id}}&nbsp;({{$category->name}})</a></li>
                                        @if($CorU == 0)
                                            <li  style="display:inline-block;">/&nbsp;<div id="labelForCodeNo" style="display:inline-block;">></div>&nbsp;(<div id="nameTag2" style="display:inline-block;"></div>)</li>
                                        @endif
                                    @endif
                                </ol>
                            </div>

                            <div style="padding: 5px 30px 10px;">


                                    <span id="msg"></span>
                                    @csrf
                                    <input type="hidden" id="type" value="{{$category->type}}">
                                    <input type="hidden" name="pcat_id" value="{{$category->p_id}}">
                                    <input type="hidden" name="cat_id" value="{{$category->id}}">
                                    <!-- beginning of 基本 block  -->
                                    <div style="border:1px solid black; padding:10px;"  data-toggle="collapse" data-target="#page1"><b>基本</b></div>
                                    <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page1" class="collapse show">
                                        <div class="row">
                                            <div class="col-md-2" style="margin-right:20px;">
                                                <div class="form-group">
                                                    <label for="codeNo" class="col-form-label"><div style="color:red; display:inline;">*</div>商品ID</label>
                                                    <input type="text" class="form-control" name="codeNo" id="codeNo" placeholder="5位数字">
                                                </div>
                                                <div class="form-group">
                                                    <label for="product_name" class="col-form-label"><div style="color:red; display:inline;">*</div>产品名称</label>
                                                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="">
                                                </div>
                                                <div class="form-group">

                                                    <label for="tax_rate" class="col-form-label"><div style="color:red; display:inline;">*</div>税率</label>
                                                    <select name="tax_rate" class="form-control" id="tax_rate">
                                                        <option value="">Select Tax :</option>
                                                        <?php
                                                        foreach ($taxes as $tax) {
                                                        ?>
                                                        <option value="{{$tax->id}}">{{$tax->tax}}</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6">


                                                        <div style="margin-bottom:15px;">
                                                            <div style="color:red; display:inline;">*</div>
                                                            不规律的?
                                                        </div>

                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" name="is_irregular" id="is_irregular" class="custom-control-input" value="1">
                                                            <label class="custom-control-label" for="is_irregular">是</label>
                                                        </div>

                                                        <br>
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="gauge" class="col-form-label"><div style="color:red; display:inline;">*</div>测量</label>
                                                            <input type="text" class="form-control" name="gauge" id="gauge" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">

                                                            <label for="quantity" class="col-form-label"><div style="color:red; display:inline;">*</div>数量</label>
                                                            <input type="number" class="form-control" name="quantity" id="quantity" placeholder="">

                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="unit" class="col-form-label"><div style="color:red; display:inline;">*</div>单元</label>
                                                            <select name="unit" class="form-control" id="unit">
                                                                <option value="">选择单位 :</option>
                                                                <?php
                                                                foreach ($units as $unit) {
                                                                ?>
                                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="wholesales" class="col-form-label"><div style="color:red; display:inline;">*</div>进价</label>
                                                                <input type="text" class="form-control" name="wholesales" id="wholesales" placeholder="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="point" class="col-form-label"><div style="color:red; display:inline;">*</div>添加点</label>
                                                                <input type="number" class="form-control" name="point" id="point" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="retailsales" class="col-form-label"><div style="color:red; display:inline;">*</div>卖价</label>
                                                                <input type="text" class="form-control" name="retailsales" id="retailsales" placeholder="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mark" class="col-form-label"><div style="color:red; display:inline;">*</div>标记</label>
                                                                <input type="text" class="form-control" name="mark" id="mark" placeholder="">
                                                            </div>
                                                        </div>

                                                </div>
                                                <div class="form-group">
                                                    <label for="description" class="col-form-label"><div style="color:red; display:inline;">*</div>描述</label>
                                                    <textarea class="form-control" rows="5" name="description" id="description" placeholder=""></textarea>
                                                </div>
                                                <div style="margin-bottom:15px;">
                                                    <div style="color:red; display:inline;">*</div>
                                                    系统显示
                                                </div>

                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="is_available" id="is_available" class="custom-control-input" value="1" checked>
                                                    <label class="custom-control-label" for="is_available">是</label>
                                                </div>

                                                <br>


                                            </div>
                                            <div class="col-md-1">

                                            </div>
                                        </div>





                                    </div>
                                    <!-- end of 基本 block -->

                                    <!-- beginning of 图片 block  -->
                                    <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page2"><b>图片</b></div>
                                    <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page2" class="collapse">
                                            <div class="form-group row">
                                                <div class="col-md-10">
                                                    <div class="input-group">
                                                        <input type="file"  name="image" id="getimage" accept="image/*" style="border:1px grey solid;padding:5px">
                                                        <div class="input-group-btn" style="margin-right:10px;">
                                                            <button id="delete" type="button" class="btn btn-danger" style="padding:10px 30px">删除</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="inputs">

                                                </div>

                                            </div>
                                            <div class="gallery_create">

                                            </div>
                                    </div>
                                    <!-- end of 图片 block -->

                                    <!-- beginning of 视频 block  -->
                                    <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page3"><b>视频</b></div>
                                    <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page3" class="collapse">
                                            <div class="form-group row">

                                                <div class="col-md-4">
                                                    <div><label for="getvideo" class="col-form-label">输入Youtube的视频URL, 追加视频</label></div>
                                                    <div class="input-group">
                                                        <input type="file"  name="video" id="getvideo" accept="video/*" style="border:1px grey solid;padding:5px">
                                                        <input type="hidden" name="removevideo" id="removevideo">
                                                        <div class="input-group-btn" style="margin-right:10px;">
                                                            <button id="delete_video" type="button" class="btn btn-danger" style="padding:10px 30px">删除</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <video id="videoSource"  width="400" controls style="display:none">

                                            </video>

                                    </div>
                                    <!-- end of 视频 block -->

                                    <!-- beginning of 商城 block  -->
                                    <div style="border:1px solid black; padding:10px; margin-top:20px;" data-toggle="collapse" data-target="#page4"><b>商城</b></div>
                                    <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page4" class="collapse">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <div style="margin-bottom:15px;">

                                                        商城显示
                                                    </div>

                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" name="is_relative" id="is_relative" class="custom-control-input" value="1">
                                                        <label class="custom-control-label" for="is_relative">是</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div style="margin-bottom:15px;">
                                                        子商品
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="codeId" id="codeId" placeholder="" disabled="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div style="margin-bottom:15px;">
                                                        商品名称
                                                    </div>
                                                    <div class="form-group row">
                                                        <select name="related_product" class="form-control" id="related_product" disabled>
                                                                <option value="">Select Product :</option>
                                                                <?php
                                                                foreach ($products as $related_product) {
                                                                ?>
                                                                <option style="color:blue;" value="{{$related_product->id}}" class="importantGroup">
                                                                    <div style="display:inline; color:blue;"><b>{{$related_product->codeNo}}</b></div>
                                                                    <div style="display:inline; color:black !important;">&nbsp;{{$related_product->name}}</div>
                                                                </option>
                                                                <?php
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <input type="hidden" name="count_img" id="count_img">
                                            <input type="hidden" name="del_array" id="del_array">
                                            <input type="hidden" name="threshold" id="threshold">
                                            <div>
                                                <div>图片-视频选择</div>
                                                <div id="agata_div">

                                                </div>
                                            </div>
                                    </div>
                                    <!-- end of 商城 block -->

                            </div>
                        </div>
                    </form>
                    <div id="hidden_value_1" style="display:none;">{{$category->name}}</div>
                    <div id="hidden_value_2" style="display:none;">{{$pcategory->name}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')

<script type="text/javascript">
    var is_checked=false;
    var CorU=eval(<?php echo($CorU) ?>);//1: create 0:update
    var productId=eval(<?php echo($productId) ?>);
    $("#productId").val(productId);
    if(CorU==0) {
        GetData(productId);
    }
    else {
        $("#subBtn").removeAttr("disabled");
    }
    var pageVal = localStorage.getItem('pagination');
    if (pageVal < 10) {
        pageVal = 10;
    }

    let del_array = [];
    let index = 0; let swp=[]; let img_array=[]; let threshold = 0

    $('.table').dataTable({
        pageLength: pageVal
    });

    $('#product_table').on('click', 'input[type="checkbox"]', clickCheckbox);

    $(document).ready(function() {
        if(CorU == 1){
            $("#headerUrl").html("<h3>商品 > "+$("#hidden_value_2").html()+"> "+$("#hidden_value_1").html()+"> 商品列表 > 新建商品</h3>");
        } else {
            $("#headerUrl").html("<h3>商品 > "+$("#hidden_value_2").html()+"> "+$("#hidden_value_1").html()+"> "+"<div id='nameTag2' style='display:inline-block;'></div>"+" > 保存商品</h3>");
        }
        $("#headerUrl").css("margin-left", "38%");

        $('#removevideo').val(false);
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

                $("#getimage").clone().attr({'id':'getimage_'+id, 'name':'image'+id}).css('display', 'none').appendTo(".inputs");
                $(".gallery_create").append('<img class="img_mng" src="'+event.target.result+'" id="getimg_med_'+id+'" class="img-fluid" style="width:300px;height:300px; margin:20px" onclick="deleteList(this);"></img>');
                $("#agata_div").append('<img class="img_mng" src="'+event.target.result+'" id="order_img_'+id+'" class="img-fluid" style="width:300px;height:300px; margin:20px" onclick="OrderList(this);"></img>');
                img_array.push(id.toString());

                $("#count_img").val(img_array.toString());
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
            getImagePlace(this, index);
            index++;
        });



        $('#add_product').on('submit', function(event){
            if(CorU==1){//when you are going to work on create page
                event.preventDefault();
                var form_data = new FormData(this);
                $('#preloader').show();
                $.ajax({
                    url:"{{ URL::to('admin/product/store') }}",
                    method:"POST",
                    data:form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(result) {
                        $('#preloader').hide();
                        var msg = '';

                        if(result.error.length > 0)
                        {
                            for(var count = 0; count < result.error.length; count++)
                            {
                                msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                            }
                            $('#msg').html(msg);
                            setTimeout(function(){
                                $('#msg').html('');
                            }, 5000);
                        }
                        else
                        {
                            location.reload();
                        }
                    },
                });
            }
            else{//when you are going to work on upadate page
                event.preventDefault();
                var form_data = new FormData(this);
                $('#preloader').show();
                $.ajax({
                    url:"{{ URL::to('admin/product/update') }}",
                    method:'POST',
                    data:form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(result) {
                        $('#preloader').hide();
                        var msg = '';
                        if(result.error.length > 0)
                        {
                            for(var count = 0; count < result.error.length; count++)
                            {
                                msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                            }
                            $('#msg').html(msg);
                            setTimeout(function(){
                            $('#msg').html('');
                            }, 5000);
                        }
                        else
                        {

                            window.location.assign($("#urlDiv").html());
                        }
                    },
                });
            }
        });

        $("#delete").on('click', function(event){

            if( del_array.length > 0){
                del_array.forEach(element => {
                    if( Number(element) > threshold - 1){
                        img_array.splice(img_array.indexOf(element), 1);
                        del_array.splice(del_array.indexOf(element), 1);
                        $("#getimage_"+element).remove();
                        $("#getimg_med_"+element).remove();
                        $("#order_img_"+element).remove();
                    } else {
                        $("#getimg_med_"+element).remove();
                        $("#order_img_"+element).remove();
                    }
                });
                $("#count_img").val(img_array.toString());
                $("#del_array").val(del_array.toString());
            } else{
                alert('There is no image selecting for delete');
            }
            // }
        });
        $("#delete_video").on('click', function(event){
            $("#removevideo").val(true);
            $("#videoSource").css('display', 'none');
            $("#getvideo").val(null);
        });
    });



    document.getElementById("is_relative").addEventListener("click", function(){


            is_checked=!is_checked;
            if(is_checked){
                $('#codeId').attr('disabled',false);
                $('#codeId').val('');
                $('#related_product').attr('disabled',true);
            }
            else{
                $('#codeId').attr('disabled',true);
                $('#codeId').val('');
                $('#related_product').attr('disabled',true);
                document.getElementById("related_product").size = 1;
            }

    });
    var firstDisplayedValue=0;
    $('#codeId').keydown( function(event) {
        if(event.which==13 ){//when key: enter pressed on the  codeNo input box
            event.preventDefault();
            $("#related_product").focus();
            if(firstDisplayedValue!=0) $("#related_product").val(firstDisplayedValue);
        }
    });
    $('#codeId').keyup( function(event) {
        if(event.which!=13 && event.which!=229){//when key: enter or clicked on the  codeNo input box
            var value = $(this).val().toLowerCase();
            $("#related_product option").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            if(value.length>=4) {//filter works more than 4 letters
                $("#related_product").removeAttr("disabled");
                index_val = 0;
                if(length>=10) document.getElementById("related_product").size = 10;
                else
                    {
                        options_tag_length = $("#related_product").children().length;
                        options_tag_obj = $("#related_product").children();
                        for(var loop=0;loop<options_tag_length;loop++){
                            tag_display = $(options_tag_obj[loop]).css("display");;
                            if(tag_display != "none")
                            {
                                index_val++;
                                if(index_val==1) firstDisplayedValue=$(options_tag_obj[loop]).val();
                            }
                        }
                        document.getElementById("related_product").size = index_val+1;
                    }
            }
            else{//filter dont work less than 4 letters
                document.getElementById("related_product").disabled=true;
                document.getElementById("related_product").size = 1 ;
            }
        }
    });

    $('#related_product').click(function(){//when clicked on the  option of the comboBox
        document.getElementById("related_product").size = 1 ;
    });

    $('#related_product').keydown( function(event) {
        if(event.which==13){//when key: enter pressed on the  comboBox
            event.preventDefault();
            document.getElementById("related_product").size = 1 ;
        }
        if(event.which==37){//when key: <- pressed on the  comboBox
            event.preventDefault();
            $('#codeId').focus();
        }
    });

    var getVideoPlace = function (input) {
        if (input.files) {
            var reader = new FileReader();
            reader.onload = function(event) {
                $("#videoSource").attr('src', event.target.result);
                $("#videoSource").css('display', 'block');
            }
            reader.readAsDataURL(input.files[0]);
            }
        }

    $('#getvideo').on('change', function() {
        $("#removevideo").val(false);
        getVideoPlace(this);
    });

    function deleteList(img){
        var temp = img.id.split("_");
        if(del_array.includes(temp[2])){
            del_array.splice(del_array.indexOf(temp[2]), 1);
            $("#"+img.id).css('border', 'none');
        } else{
            del_array.push(temp[2]);
            $("#"+img.id).css('border', '4px yellow solid');
        }
    }

    function OrderList(img){
        var temp = img.id.split("_");
        if(swp.length>0){

            var order1 = img_array.indexOf(swp[0]);
            var order2 = img_array.indexOf(temp[2]);


            //order list
            var temp1 = $("#order_img_"+swp[0]).clone();
            var temp2 = $("#"+img.id).clone();
            if(order1>order2){
                $("#order_img_"+swp[0]).replaceWith(temp2);
                $("#"+img.id).replaceWith(temp1);
            } else {
                $("#"+img.id).replaceWith(temp1);
                $("#order_img_"+swp[0]).replaceWith(temp2);
            }


            var temp1 = $("#getimg_med_"+swp[0]).clone();
            var temp2 = $("#getimg_med_"+temp[2]).clone();
            if(order1>order2){
                $("#getimg_med_"+swp[0]).replaceWith(temp2);
                $("#getimg_med_"+temp[2]).replaceWith(temp1);
            } else{
                $("#getimg_med_"+temp[2]).replaceWith(temp1);
                $("#getimg_med_"+swp[0]).replaceWith(temp2);
            }


            $("#"+img.id).css('border', 'none');
            $("#order_img_"+swp[0]).css('border', 'none');


            img_array[order1] = temp[2];
            img_array[order2] = swp[0];

            swp=[];


            $("#count_img").val(img_array.toString());

        } else {
            swp.push(temp[2].toString());
            $("#"+img.id).css('border', '4px yellow solid');
        }
    }


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

    function GetData(id) {
        $('#preloader').show();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/product/show') }}",
            data: {
                id: id
            },
            method: 'POST', //Post method,
            dataType: 'json',
            success: function(response) {
                $("#subBtn").removeAttr("disabled");
                $('#preloader').hide();

                // jQuery("#editProduct").modal('show');
                $('#id').val(response.id);
                $('#product_name').val(response.name);
                $('#nameTag1').html(response.name);
                $('#nameTag2').html(response.name);
                $('#labelForCodeNo').html(response.codeNo);

                $('#codeNo').val(response.codeNo);
                $('#wholesales').val(response.wholesales.wholesale);
                $('#retailsales').val(response.retailsales.retailsale);
                var taxArray= eval(<?php echo $taxes?>);
                var i=0;
                for (i = 0; i < taxArray.length; i++) {
                    if(taxArray[i].tax==response.tax) break;
                }
                $('#tax_rate').val(taxArray[i].id);
                $('#gauge').val(response.gauge);
                $('#quantity').val(response.qty);
                $('#unit').val(response.unit_id);

                $('#point').val(response.point);
                $('#mark').val(response.mark);

                if(response.related_id== response.id){

                }
                else{
                    $("#is_relative").attr("checked","true");
                    is_checked=true;
                    $('#related_product').val(response.related_id);
                    $('#codeId').attr('disabled',false);
                    $('#codeId').val('');
                    $('#related_product').attr('disabled',true);
                }
                if (response.is_available == 1) {

                    $('#is_available').val(response.is_available);
                } else {

                    $('#is_available').removeAttr("checked");
                    $('#is_available').val(response.is_available);
                }
                if (response.is_irregular == 1) {
                    $('#is_irregular').attr("checked", 0);
                    $('#is_irregular').val(response.is_irregular);
                } else {
                    $('#is_irregular').val(response.is_irregular);
                }
                $('#description').val(response.description);
                if(response.images.length > 0 ){
                    while (response.images[index]) {
                        $(".gallery_create").append('<img class="img_mng" src="'+'{{asset("public/images/product/")}}'+'/'+response.images[index].image_src+'" id="getimg_med_'+index+'" class="img-fluid" style="width:300px;height:300px; margin:20px" onclick="deleteList(this);"></img>');
                        $("#agata_div").append('<img class="img_mng" src="'+'{{asset("public/images/product/")}}'+'/'+response.images[index].image_src+'" id="order_img_'+index+'" class="img-fluid" style="width:300px;height:300px; margin:20px" onclick="OrderList(this);"></img>');
                        img_array.push(index.toString());
                        index++;
                    }
                    threshold = index;
                    $("#threshold").val(threshold.toString());
                    $("#count_img").val(img_array.toString());
                }

                if(response.medias.length > 0 ){
                    $("#videoSource").attr('src', '{{asset("public/videos/product/")}}'+'/'+response.medias[0].media_src);
                    $("#videoSource").css('display', 'block');
                }
            },
            error: function(error) {
                $('#preloader').hide();
            }
        })
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