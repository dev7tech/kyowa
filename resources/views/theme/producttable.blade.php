<table id="product_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th style="text-align: center;padding-left:30px;"><input type="checkbox" class="text-center" name="master_checkbox" id="master_checkbox"></input></th>
            <th style="text-align: center;padding-left:30px;">商品ID</th>
            <th style="text-align: center;padding-left:30px;">商品名称</th>
            <th style="text-align: center;padding-left:30px;">测量</th>
            <th style="text-align: center;padding-left:30px;">数量</th>
            <th style="text-align: center;padding-left:30px;">单元</th>
            <th style="text-align: center;padding-left:30px;">价格</th>
            <th style="text-align: center;padding-left:30px;">税</th>
            <th style="text-align: center;padding-left:30px;">原产地</th>
            <th style="text-align: center;padding-left:30px;">地位</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($products as $product) {
        ?>
        <tr id="dataid{{$product->id}}">
            <td style="text-align: center;"><input type="checkbox" class="text-center" name="product_check" id="product_check" value='{{$product->id}}'></input></td>
            <td style="text-align: center;">{{$product->codeNo}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->gauge}}</td>
            @if(isset($product->unit->name)) <td>{{$product->unit->name}}</td>
            @else <td>{{''}}</td>
            @endif
            <td>{{$product->qty}}</td>

            @if(isset($product->retailsales->retailsale)) <td>{{$product->retailsales->retailsale}}</td>
            @else <td>{{''}}</td>
            @endif
            
            <td>{{$product->tax}}</td>
            <td style="text-align: center;">{{$product->mark}}</td>
            <td style="text-align: center;">
                @if ($product->is_available == 1)
                    <a class="badge badge-success px-2" style="color: #fff;">可用的</a>
                @else
                    <a class="badge badge-danger px-2" style="color: #fff;">不可用</a>
                @endif
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>