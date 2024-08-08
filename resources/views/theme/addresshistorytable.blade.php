<table id="addresshistory_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>Name</th>
            <th>phone</th>
            <th>Email Number</th>
            <th>Area Name</th>
            <th>Building Name</th>
            <th>Created At</th>
            <th>Deleted At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($addresses as $address) {
        ?>
        <tr id="dataid{{$address->id}}">
            <td>{{$address->name}}</td>
            <td>{{$address->phone}}</td>
            <td>{{$address->email_number}}</td>
            <td>{{$address->area_name}}</td>
            <td>{{$address->building_name}}</td>
            <td>{{$address->created_at}}</td>
            <td>{{$address->deleted_at}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>