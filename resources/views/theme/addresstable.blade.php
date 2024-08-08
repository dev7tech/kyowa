<table id="address_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>顾客姓名</th>
            <th>收件者姓名</th>
            <th>电话</th>
            <th>识别信息</th>
            <th>电子邮件</th>
            <th>区域名称</th>
            <th>代表建筑</th>
            <th>地位</th>
            <th>确认</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($addresses as $address) {
        ?>
        <tr id="dataid{{$address->id}}">
            <td><input type="checkbox" class="text-center" name="address_check" value='{{$address->id}}'></input></td>
            <td>{{$address->user->name}}</td>
            <td>{{$address->name}}</td>
            <td>{{$address->phone}}</td>
            <td>{{$address->identification}}</td>
            <td>{{$address->email_number}}</td>
            <td>{{$address->area_name}}</td>
            <td>{{$address->building_name}}</td>
            <td>
                @if ($address->is_verified == 0)
                    <span class="badge badge-warning px-2" style="color: #fff; font-size: 0.875rem;">
                        等待
                    </span>
                @elseif ($address->is_verified == 1)
                    <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">
                        等待
                    </span>
                @else
                    <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">
                        确认的
                    </span>
                @endif
                
            </td>
            <td>
                <button type="button" class="btn btn-primary" style="margin-left:5px;" onclick="ViewMap(this)" data-addr-info="{{$address->area_name}}">地图</button>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>