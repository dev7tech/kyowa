<table id="orderlist_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th style="text-align: center;padding-left:30px;">商品ID</th>
            <th style="text-align: center;padding-left:30px;">商品名称</th>
            <th style="text-align: center;padding-left:30px;">税率(%)</th>
            <th style="text-align: center;padding-left:30px;">价格(円)</th>
            <th style="text-align: center;padding-left:30px;">数量</th>
            <th style="text-align: center;padding-left:30px;">小计(円)</th>
            <th style="text-align: center;padding-left:30px;">规则</th>
            <th style="text-align: center;padding-left:30px;">客户留言</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($order_info->orderDetail as $order) {
        ?>
        <tr id="dataid{{$order->id}}">
            <td style="text-align: center;">{{$order->product_id}}</td>
            <td style="text-align: center;">{{$order->adminproduct->name}}</td>
            <td style="text-align: center;">{{$order->tax * 100}}</td>
            <td style="text-align: center;">{{$order->adminproduct->retailsales->retailsale}}</td>
            <td style="text-align: center;">{{$order->qty}}{{$order->adminproduct->unit->name}}</td>
            <td style="text-align: center;">{{$order->adminproduct->retailsales->retailsale * $order->qty}}</td>
            @if($order->adminproduct->is_irregular == 1) <td style="text-align: center;">不规则</td>
            @else <td style="text-align: center;"></td>
            @endif
            <td style="text-align: center;"></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>