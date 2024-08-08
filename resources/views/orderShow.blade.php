@extends('theme.default')

@section('content')
<div  id="urlDiv" style="display:none;">{{URL::to('/admin/orders')}}</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <span id="message"></span>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="padding: 5px 30px 10px;" class="d-flex justify-content-between">
                            <div>
                                <input type="hidden" class="form-control" id="orderID" value="" name="orderID">
                                <a href="{{URL::to('/admin/orders/jingheobian')}}" style="padding-right: 30px; color:blue;">< 返回</a>
                            </div>
                            <div class="d-flex">
                                <select class="form-control order_status" id = "order-status" style="width:120px;" data-seller-info="{{ $order_info->order_from }}">
                                <option value="0">no seller</option>
                                <?php
                                    foreach ($sellers as $seller){
                                        if($seller->id == $order_info->order_from) echo '<option value="'.$seller->id.'" selected>'.$seller->name.'</option>';
                                        else echo '<option value="'.$seller->id.'">'.$seller->name.'</option>';
                                    }
                                ?>
                                    
                                </select>
                                <button type="submit" id="subBtn" style="padding:6px 30px 6px 30px;color:white;margin-left:5px;" class="w3-button w3-blue w3-border" disabled>
                                    保存
                                </button>
                            </div>
                        </div>
                        <div style="padding: 5px 30px 10px;">
                            <!-- beginning of 订单 block  -->
                            <div style="border:1px solid black; padding:10px;"  data-toggle="collapse" data-target="#page1"><b>订单</b></div>
                            <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page1" class="collapse show">
                                <div class="row">
                                    <div class="col-md-3 col-sd-4">订单ID</div>
                                    <div class="col-md-5 col-sd-4">配送地址</div>
                                </div>

                                <div class="row" style="margin-top:5px;">
                                    <div class="col-md-3 col-sd-4">
                                        <div id="orderId" class="order-info-disable-text order-number" style="width:200px;" data-order-id="{{ $order_info->id }}">
                                            {{ $order_info->id}}/{{ $order_info->order_number}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sd-4">
                                        <div class="order-info-disable-text deliver-addr" style="width:350px;">
                                            {{ $order_info->address->area_name}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:15px;">
                                    <div class="col-md-3 col-sd-4">昵称 / 客户ID</div>
                                    <div class="col-md-4 col-sd-4">邮费模式</div>
                                    <div class="col-md-4 col-sd-4">备注</div>
                                </div>

                                <div class="row" style="margin-top:5px;">
                                    <div class="col-md-3 col-sd-4">
                                        <div id ="UserInfoLabel" class="order-info-disable-text client-id" style="width:200px;color:blue;cursor:pointer;" data-user-id="{{ $order_info->user_id }}">
                                            {{$order_info->user->name}} / {{ $order_info->user_id }}  
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sd-4">
                                        <div class="order-info-disable-text deliver-price" style="width:350px;">
                                            {{ $order_info->delivery->method_name }}(最小订单:{{ $order_info->delivery->min_price }}円 / 邮费:{{ $order_info->delivery->delivery_fee }}円 / 免费:{{ $order_info->delivery->max_price}}円)
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sd-4">
                                        <div class="order-info-disable-text other-info" style="width:350px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- beginning of 订单明细 block  -->
                            <div style="border:1px solid black; padding:10px; margin-top:20px;"  data-toggle="collapse" data-target="#page2"><b>订单明细</b></div>
                            <div style="border:1px solid black; padding:30px; border-top:0px solid black !important;" id="page2" class="collapse show">
                                <div class="d-flex justify-content-between"  style="padding: 5px 30px 10px;">
                                    
                                    <div class="price-info-container d-flex">
                                        <label class="total_price">支付金额(円)</label>
                                        <div id="PriceInfoLabel" class="order-info-disable-text total-price" style="width:85px;color:blue;margin-left:10px;cursor:pointer;">{{ $totalprice - $order_info->purse_point }}</div>
                                    </div>
                                </div>
                                <div id="table-display">
                                    @include('theme.orderlisttable')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Address Info Modal -->
<div class="w3-modal" style= "padding-top:0 !important" id="UserInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('UserInfo').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">查看-客户</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('UserInfo').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="userInfo" enctype="multipart/form-data">
            <div class="modal-content" style="border:none">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name" class="col-form-label">昵称</label>
                        <input type="text" class="form-control" name="user_name" id="user_name" disabled style="border:none;width:200px;"/>
                    </div>

                    <div class="form-group address-container">
                        
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

<!--  Address Info Modal -->
<div class="w3-modal" style= "padding-top:0 !important" id="PriceInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document" style="margin:0; float:right"> -->
    <div style="width:60%; height:100%; float:left" onclick="document.getElementById('PriceInfo').style.display='none'"></div>
    <div class="w3-modal-content w3-animate-right" style="display:inline; margin:0; float:right; height:100%; width:40%">
        <div class="w3-container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:black">查看-金额</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="document.getElementById('PriceInfo').style.display='none'"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="PriceInfo" enctype="multipart/form-data">
            <div class="modal-content" style="border:none">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="total-price-info">
                            <label class="col-form-label" style="font-weight:bold;">积分</label>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6" style="align-items:center;">使用积分(円)</div>
                                <div class="col-md-6" style="align-items:center;">总额-税前(円)</div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{$order_info->purse_point}}"/>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;"  value="{{ $price_8 + $price_10 + $order_info->freight - $order_info->purse_point }}"/>
                                </div>
                            </div>
                            <div class="d-flex row mt-2 ml-3">
                                <div class="col-md-6" style="align-items:center;">
                                    
                                </div>
                                <div class="col-md-6" style="align-items:center;">总额-税后(円)
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{ $price_total_8 + $price_total_10 + $order_info->freight - $order_info->purse_point }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="post-price-info mt-2">
                            <label class="col-form-label" style="font-weight:bold;">邮费</label>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">邮费(円)</div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{$order_info->freight}}" />
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                        <div class="detail-price-info mt-5">
                            <label class="col-form-label" style="font-weight:bold;">支付</label>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">8%対象税前总额(円)</div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{ $price_8 }}"/>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="d-flex row ml-3 mt-3">
                                <div class="col-md-6">8%対象税额(円)</div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{ $price_total_8  - $price_8}}"/>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="d-flex row ml-3 mt-3">
                                <div class="col-md-6">10%対象税前总额(円)</div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{ $price_10 }}"/>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="d-flex row ml-3 mt-3">
                                <div class="col-md-6">10%対象税额(円)</div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;" value="{{ $price_total_10  - $price_10}}"/>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="d-flex row ml-3 mt-3">
                                <div class="col-md-6">支付方式</div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="d-flex row ml-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled style="border:none;text-align:right;width:55%;"/>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- </div> -->
</div>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#orderlist_table_filter').hide();
        $('#orderlist_table_length').hide();
        
        $(".content-body").css("minHeight","500px");
        $("#UserInfoLabel").on("click",function(){
            showUserAddressInfo();
        });

        $('#PriceInfoLabel').on("click",function(){
            showPriceInfo();
        });

        $("#order-status").change(function(){
            seller_info     = $(this).attr("data-seller-info");
            selected_seller = $(this).val();
            if(selected_seller*1 != 0){
                if(seller_info == selected_seller) $("#subBtn").prop("disabled",true);
                else $("#subBtn").prop("disabled",false);
            }
        });

        $("#subBtn").on("click",function(){
            orderId = $("#orderId").attr("data-order-id");
            selected_seller = $("#order-status").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ URL::to('admin/orders/confirm') }}",
                data: {
                    order_id: orderId,
                    seller: selected_seller
                },
                method: 'POST',
                success: function(response) {
                    $('#preloader').hide();
                    var msg = '';
                    $('#message').html(msg);
                    if (response == 1) {
                        msg += '<div class="alert alert-success mt-1">订单已确认。</div>';
                        $('#message').html(msg);
                        setTimeout(function(){
                            $('#message').html('');
                        }, 3000);
                    }else{
                        msg += '<div class="alert alert-danger mt-1">在处理过程中发生错误。</div>';
                        $('#message').html(msg);
                        setTimeout(function(){
                            $('#message').html('');
                        }, 3000);
                    }
                },
                error: function(e) {
                    msg += '<div class="alert alert-danger mt-1">在处理过程中发生错误。</div>';
                    $('#message').html(msg);
                    setTimeout(function(){
                        $('#message').html('');
                    }, 3000);
                }
            });
        });

    });

    function showUserAddressInfo(){
        user_id = $('#UserInfoLabel').attr("data-user-id")*1;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ url('admin/orders/showUserAddress') }}",
            method:'POST',
            data:{'user_id':user_id},
            success:function(response){
                var data = response['address'];
                for(var loop in data){
                    var address_component = '';
                    address_component = '<div style="margin-left:25px;margin-top:20px;">'
                        address_component += '<label class="col-form-label">地址'+(loop*1+1)+'</label>';
                        address_component += '<br/>';
                        address_component += '<div class="address-info" style="margin-left:30px;">';
                            address_component += '<label class="col-form-label">收件人姓名/手机号码/邮编</label>';
                            address_component += '<input type="text" class="form-control" name="receiver_info" id="receiver_info" disabled style="border:none;width:450px;" value="'+data[loop].name+'/'+data[loop].phone+'/'+data[loop].email_number+'" />';
                            address_component += '<label class="col-form-label">地址</label>';
                                address_component += '<div class="d-flex">';
                                    address_component += '<input type="text" class="form-control" name="address" id="address" disabled style="border:none;width:450px;" value="'+data[loop].area_name+'"/>';
                                    address_component += '<button type="button" class="btn btn-primary" style="margin-left:5px;" onclick="ViewMap(this)" data-addr-info="'+data[loop].area_name+'">地图</button>';
                                address_component += '</div>';
                            address_component += '<label class="col-form-label">建筑名屋号</label>';
                            address_component += '<input type="text" class="form-control" name="building" id="building" disabled style="border:none;width:450px;" value="'+data[loop].building_name+'"/>';
                            address_component += '<label class="col-form-label">配送种类</label>';
                            address_component += '<br />';
                            address_component += '<div class="select-delivory-type d-flex">';
                            if(data[loop].delivery_type == 0){
                                address_component += '<input class="d_type" type="radio" id="d_type_0_'+loop+'" checked disabled/><div style="width:120px;line-height:40px;margin-left:5px;" for="html">Yamato便</div>';
                                address_component += '<input class="d_type" type="radio" id="d_type_1_'+loop+'" disabled/><div style="width:120px;line-height:40px;margin-left:5px;" for="html">京和便</div>';
                            }else{
                                address_component += '<input class="d_type" type="radio" id="d_type_0_'+loop+'" disabled/><div style="width:120px;line-height:40px;margin-left:5px;" for="html">Yamato便</div>';
                                address_component += '<input class="d_type" type="radio" id="d_type_1_'+loop+'" checked disabled/><div style="width:120px;line-height:40px;margin-left:5px;" for="html">京和便</div>';
                            }
                        address_component += ' </div>';
                    address_component += ' </div>';
                    $(".address-container").append(address_component);
                }
                $("#user_name").val(response['user'].name);
                $(".w3-container").css("padding","0");
                jQuery("#UserInfo").css('display', 'block');
            },
            error: function(error) {
                $('#preloader').hide();
            }
        });
    }

    function showPriceInfo(){
        $(".w3-container").css("padding","0");
        jQuery("#PriceInfo").css('display', 'block');
    }

    function ViewMap(btn){
        var addrInfo = $(btn).attr("data-addr-info");
        window.open('https://www.google.com/maps/search/?api=1&query='+addrInfo, '_blank');
    }


</script>
@endsection