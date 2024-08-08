<table id="method_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th style="text-align: center;">#</th>
            <th style="text-align: center;">方法名</th> 
            <th style="text-align: center;">最低订购价</th> 
            <th style="text-align: center;">最大订单价</th> 
            <th style="text-align: center;">交货价</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($delivery_methods as $method) {
        ?>
        <tr id="dataid{{$method->id}}">
            <td style="text-align: center;">
                <input type="checkbox" class="text-center" name="method_check" value='{{$method->id}}'></input>
            </td>
            <td>{{$method->method_name}}</td>
            <td>{{$method->min_price}}</td>
            <td>{{$method->max_price}}</td>
            <td>{{$method->delivery_fee}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>