<table id="wholesalehistory_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>No</th>
            <th>产品名称</th>
            <th>批发价</th>
            <th>地位</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($wholesales as $wholesale) {
        ?>
        <tr id="dataid{{$wholesale->id}}">
            @if(isset($wholesale->product['name']))
                <td>{{$wholesale->id}}</td>
                <td>{{$wholesale->product['name']}}</td>
                <td>{{$wholesale->wholesale}}</td>
                @if ($wholesale->is_available == 1)
                <td>可用的</td>
                @else
                <td>不可用</td>
                @endif
                <td>{{$wholesale->created_at}}</td>
            @else
                <td>{{$wholesale->id}}</td>
                <td></td>
                <td>{{$wholesale->wholesale}}</td>
                @if ($wholesale->is_available == 1)
                <td>可用的</td>
                @else
                <td>不可用</td>
                @endif
                <td>{{$wholesale->created_at}}</td>
            @endif
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>