<table id="order_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th style="text-align: center;padding-left:30px;">#</th>
            <th>订单号</th>
            <th>订购时间</th>
            <th>顾客姓名</th>
            <th>总价</th>
            <th>订购地址</th>
            <th>快递费</th>
            <th>订单经理</th>
            <th>接待时间</th>
            <th>接收状态</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($orderswithprice as $order) {
        ?>
        <tr id="dataid{{$order['order']->id}}">
            <td style="text-align: center;"><input type="checkbox" class="text-center" name="order_check" id="order_check" value="{{$order['order']->id}}"></input></td>
            <td>
                <a href="{{URL::to('/admin/orders/'.$order['order']->id.'/show')}}">{{$order['order']->id}}</a>
            </td>
            <td>{{$order['order']->order_number}}</td>
            <td>{{$order['order']['user']['name']}}</td>
            <td>{{$order['price']+$order['order']->freight}}</td>
            <td>{{$order['order']['address']['name']}}&nbsp{{$order['order']['address']['area_name']}}&nbsp{{$order['order']['address']['building_name']}}</td>
            <td>{{$order['order']->freight}}</td>
            
            @if(isset($order['order_from'])) <td>{{$order['order_from']->name}}</td>
            @else <td>{{''}}</td>
            @endif
            
            <td>{{$order['order']->created_at}}</td>
            <td>
                @if ($order['order']->status == 2)
                    <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">
                        Finished
                    </span>
                @elseif ($order['order']->status == 0)
                    <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">
                        Pending
                    </span>
                @else
                    <span class="badge badge-warning px-2" style="color: #fff; font-size: 0.875rem;">
                        Confirm
                    </span>
                @endif
                
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>