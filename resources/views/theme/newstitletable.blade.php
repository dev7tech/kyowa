<table id="newtitle_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($newstitles as $newstitle) {
        ?>
        <tr id="dataid{{$newstitle->id}}">
            <td><input type="checkbox" class="text-center" name="cate_check" value='{{$newstitle->id}}'></input></td>
            <td><a href="{{URL::to('/admin/news/cate-'.$category->id.'/title-'.$newstitle->id)}}">{{$newstitle->title}}</a></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>