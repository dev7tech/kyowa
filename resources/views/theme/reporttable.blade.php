<div class="row mt-5">
    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-1">
            <a href="#" style="text-decoration: none;">
                <div class="card-body">
                    <h3 class="card-title text-white">总订单</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{@$totalcount}}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-bar-chart"></i></span>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-2">
            <a href="#" style="text-decoration: none;">
                <div class="card-body">
                    <h3 class="card-title text-white">取消订单</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{@$canceledcount}}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-shopping-cart"></i></span>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-3">
            <a href="#" style="text-decoration: none;">
                <div class="card-body">
                    <h3 class="card-title text-white">总收入</h3>
                    <div class="d-inline-block">
                        <h2 class="text-white">{{@$profits}}</h2>
                    </div>
                    <span class="float-right display-5 opacity-5"  style="color:#fff;"><i class="fa fa-usd"></i></span>
                </div>
            </a>
        </div>
    </div>

    

</div>
<div class="row toolbar-container" style="display:flex;justify-content:space-between;padding:0 30px;">
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
<table id="report_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>订购时间</th>
            <th>顾客姓名</th>
            <th>总价</th>
            <th>订购地址</th>
            <th>快递费</th>
            <th>订单经理</th>
            <th>接待时间</th>
            <th>订单状态</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($orderswithprice as $order) {
        ?>
        <tr id="dataid{{$order['order']->id}}">
            <td>{{$order['order']->order_number}}</td>
            <td>{{$order['order']['user']['name']}}</td>
            <td>{{$order['price']+$order['order']->freight}}$</td>
            <td>{{$order['order']['address']['name']}}&nbsp{{$order['order']['address']['area_name']}}&nbsp{{$order['order']['address']['building_name']}}</td>
            <td>{{$order['order']->freight}}$</td>

            @if(isset($order['order_from'])) <td>{{$order['order_from']->name}}</td>
            @else <td>{{''}}</td>
            @endif
            
            <td>{{$order['order']->created_at}}</td>
            <td>
                @if ($order['order']->status == 1)
                    <span class="badge badge-warning px-2" style="color: #fff; font-size: 0.875rem;">
                        接受
                    </span>
                @elseif ($order['order']->status == 0)
                    <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">
                        待办的
                    </span>
                @else
                    <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">
                        确认
                    </span>
                @endif
                
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<br>
<br><br><br><br>
<br><br><br>