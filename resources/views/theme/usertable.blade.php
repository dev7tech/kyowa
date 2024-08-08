<table id="user_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th><input type="checkbox" class="text-center" name="master_checkbox" id="master_checkbox"></input></th>
            <th>姓名</th>
            <th>电子邮件</th>
            <th>角色</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($users as $user) {
        ?>
        <tr id="dataid{{$user->id}}">
            <td><input type="checkbox" class="text-center" name="user_check" value="{{$user->id}}"></input></td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                @if ($user->type == 0)
                    <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">
                        顾客
                    </span>
                @elseif ($user->type == 2)
                    <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">
                        卖方
                    </span>
                @elseif ($user->type == 1)
                    <span class="badge badge-warning px-2" style="color: #fff; font-size: 0.875rem;">
                        经理
                    </span>
                @endif
                
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>