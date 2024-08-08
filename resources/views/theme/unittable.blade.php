<table id="unit_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th><input type="checkbox" class="text-center" name="master_checkbox" id="master_checkbox"></input></th>
            <th>姓名</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($units as $unit) {
        ?>
        <tr id="dataid{{$unit->id}}">
            <td><input type="checkbox" class="text-center" name="unit_check" value='{{$unit->id}}'></input></td>
            <td>{{$unit->name}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>