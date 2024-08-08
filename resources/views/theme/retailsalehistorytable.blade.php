<table id="retailsalehistory_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>产品名称</th>
            <th>零售价</th>
            <th>地位</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($retailsales as $retailsale) {
        ?>
        <tr id="dataid{{$retailsale->id}}">
            @if(isset($retailsale->product['name']))
                <td>{{$retailsale->product['name']}}</td>
                <td>{{$retailsale->retailsale}}</td>
                @if ($retailsale->is_available == 1)
                <td>可用的</td>
                @else
                <td>不可用</td>
                @endif
                <td>{{$retailsale->created_at}}</td>
            @else
                <td></td>
                <td>{{$retailsale->retailsale}}</td>
                @if ($retailsale->is_available == 1)
                <td>可用的</td>
                @else
                <td>不可用</td>
                @endif
                <td>{{$retailsale->created_at}}</td>
            @endif

            
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>