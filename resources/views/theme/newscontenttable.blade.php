<table id="newscontent_table" class="table table-striped table-bordered zero-configuration display">
    <thead>
        <tr>
            <th>#</th>
            <th>Content</th>
            <th>Product ID</th>
            <th>Image</th>
            <th>Media</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($newscontents as $newscontent) {
        ?>
        <tr id="dataid{{$newscontent->id}}">
            <td><input type="checkbox" class="text-center" name="cate_check" value='{{$newscontent->id}}'></input></td>
            <td>{{$newscontent->content}}</td>
            <td>{{$newscontent->product_id}}</td>
            @if($newscontent->image)
                <td><img src='{!! asset("public/images/news/".$newscontent->image) !!}' class='img-fluid' style='max-height: 50px;'></td>
            @else
                <td></td>
            @endif
            <td data-video='{!! asset("public/videos/news/".$newscontent->media) !!}'>
                
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>