<table id="purse_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Customer Name</th>
            <th>Point</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($purse as $pur) {
        ?>
        <tr id="dataid{{$pur->id}}">
            <td><input type="checkbox" class="text-center" name="purse_check" value='{{$pur->id}}'></input></td>
            <td>{{$pur->user->name}}</td>
            <td>{{$pur->point}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>