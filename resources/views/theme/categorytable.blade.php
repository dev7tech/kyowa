<table id="category_table" class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th width="3%"  style="text-align: center;">#</th>
            @if($type != 1)
                <th width="8%" style="text-align: center;">大分类ID</th>
            @else
                <th width="8%" style="text-align: center;">小分类ID</th>
            @endif
            @if($type != 1)
                <th width="12%" style="text-align: center;">大分类名</th>
            @else
                <th width="10%" style="text-align: center;">小分类名</th>
            @endif
            <th width="6%" style="text-align: center;">地位</th>
            @if($type != 1) <th width="12%" style="text-align: center;">小分类个数 </th> @endif
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($categories as $category) {
        ?>
        <tr id="dataid{{$category->id}}">
            <td style="text-align: center;">
                <input type="checkbox" class="text-center" name="cate_check" value='{{$category->id}}'></input>
            </td>
            <td  style="text-align: center;">
                {{$category->id}}
            </td>
            @if ($category->type == 0)
                <td style="text-align: center;">
                    <a href="{{URL::to('/admin/category/'.$category->id)}}">{{$category->name}}</a>
                </td>
            @elseif ($category->type == 2)
                <td style="text-align: center;">
                    <a href="{{URL::to('/admin/category/'.$category->id.'/products')}}">{{$category->name}}</a>
                </td>
            @else
                <td>
                    <a href="{{URL::to('/admin/category/'.$category->id.'/products')}}">{{$category->name}}</a>
                </td>
            @endif
            <td style="text-align: center;">
            @if ($category->is_available == 1)
                <span class="badge badge-success px-2" style="color: #fff; font-size: 0.875rem;">可用的</span>
            @else
                <span class="badge badge-danger px-2" style="color: #fff; font-size: 0.875rem;">不可用</span>
            @endif

            </td>
            @if($type != 1)
                <td style="text-align: center;">
                    {{count($category->p_products)}}
                </td>
            @endif
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>