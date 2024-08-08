<table id="newscategory_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($newscategories as $newscategory) {
        ?>
        <tr id="dataid{{$newscategory->id}}">
            <td><input type="checkbox" class="text-center" name="cate_check" value='{{$newscategory->id}}'></input></td>
            <td><a href="{{URL::to('/admin/news/cate-'.$newscategory->id)}}">{{$newscategory->name}}</a></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>