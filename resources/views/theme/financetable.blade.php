<table id="finance_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>订购时间</th>
            <th>顾客姓名</th>
            <th>总价</th>
            <th>订单价格</th>
            <th>货运</th>
            <th>订购地址</th>
            <th>订单经理</th>
            <th>接收状态</th>
            <th>接待时间</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($orderswithprice as $order) {
        ?>
        <tr id="dataid{{$order['order']->id}}">
            <td><input type="checkbox" class="text-center" name="order_check" value="{{$order['order']->id}}"></input></td>
            <td>{{$order['order']->order_number}}</td>
            <td>{{$order['order']['user']['name']}}</td>
            <td>{{$order['price']+$order['order']->freight}}$</td>
            <td>{{$order['price']}}$</td>
            <td>{{$order['order']->freight}}$</td>
            <td>{{$order['order']['address']['name']}}&nbsp{{$order['order']['address']['area_name']}}&nbsp{{$order['order']['address']['building_name']}}</td>
            <td>{{$order['order_from']['name']}}</td>
            <td>
                @if ($order['order']->status == 1)
                    <span class="badge badge-warning px-2" style="color: #fff; font-size: 0.875rem;">
                        Accept
                    </span>
                @elseif ($order['order']->status == 2)
                    <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">
                        Confirm
                    </span>
                @else
                    <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">
                        Pending
                    </span>
                @endif
                
            </td>
            <td>
                @if ($order['order']->status == 2)
                {{$order['order']->updated_at}}
                @endif
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>