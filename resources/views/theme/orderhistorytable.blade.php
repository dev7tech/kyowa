<table id="orderhistory_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>下单时间</th>
            <th>顾客姓名</th>
            <th>Total Price</th>
            <th>总价</th>
            <th>运输成本</th>
            <th>订单经理</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Deleted At</th>
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
            <td>{{$order['order']->updated_at}}</td>
            <td>{{$order['order']->deleted_at}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>