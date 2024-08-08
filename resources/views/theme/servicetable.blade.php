<table id="conversation_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th><input type="checkbox" class="text-center" name="master_checkbox" id="master_checkbox"></input></th>
            <th>顾客姓名</th>
            <th>卖家姓名</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($conversation_users as $conversation_user) {
        ?>
        <tr id="dataid{{$conversation_user['id']}}">
            <td><input type="checkbox" class="text-center" id="conversation_check" name="conversation_check" value="{{$conversation_user['id']}}"></input></td>
            <td>{{$conversation_user['cur']}}</td>
            <td>{{$conversation_user['sal']}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>