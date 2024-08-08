<table id="producthistory_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>Name</th>
            <th>Gauge</th>
            <th>Tax</th>
            <th>Created At</th>
            <th>Deleted At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($products as $product) {
        ?>
        <tr id="dataid{{$product->id}}">
            <td>{{$product->name}}</td>
            <td>{{$product->gauge}}</td>
            <td>{{$product->tax}}</td>
            <td>{{$product->created_at}}</td>
            <td>{{$product->deleted_at}}</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>