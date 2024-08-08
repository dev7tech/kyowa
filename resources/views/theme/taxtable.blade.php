<table id="tax_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Tax Rate</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($taxes as $tax) {
        ?>
        <tr id="dataid{{$tax->id}}">
            <td><input type="checkbox" class="text-center" name="tax_check" value='{{$tax->id}}'></input></td>
            <td>{{$tax->tax}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>