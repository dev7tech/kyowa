
<?php
    foreach ($newscategories as $key=>$newscategory) {
        $page_key = 'page'.$key +1;
?>
    @if($key == 0)
        <div id="newCategory-{{$newscategory->id}}" style="display:flex;justify-content:space-between;cursor: pointer;border-radius: 5px 5px 0px 0px;border:1px solid #958f8e; padding:10px; color:blue;box-shadow: 2px 2px 4px rgb(0 0 0 / 30%);"  data-toggle="collapse" data-target="#{{ $page_key }}">
            <b id="news-category-name-{{$newscategory->id}}">{{$newscategory->name}}</b>
            <div class="controller-container">
                <span class="widget" style="margin-right: 5px;" onClick="showAddNewsTitle({{$newscategory->id}})">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
                <span class="widget" style="margin-right: 5px;" onClick="GetData({{$newscategory->id}})">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <span class="widget" style="margin-right: 5px;" onClick="Delete({{$newscategory->id}})">
                    <i class="fa-solid fa-trash"></i>
                </span>
            </div>
        </div>
        <div style="border-radius: 0px 0px 5px 5px ;border:1px solid #958f8e; padding:30px; border-top:0px solid #958f8e !important;" id="{{ $page_key }}" class="collapse show">
        <?php 
            if(isset($newscategory->newstitles) && (sizeof($newscategory->newstitles) > 0)){
                foreach($newscategory->newstitles as $loop=>$title){
                    $number = $loop + 1;
        ?>
            <div class="article-row" style="display:flex;flex-wrap:nowrap;margin-top:15px;">
                <div class="news-title" data-value="{{ $title->id }}" style="cursor: pointer;">
                    <a class="news_title" id="news_title_{{$title->id}}" href="{{URL::to('/admin/news/cate-'.$newscategory->id.'/title-'.$title->id)}}">{{$number}}. {{$title->title}}</a>
                </div>
                <div class="row-line" style="cursor: pointer;flex:1 1 auto;" ></div>
                <div class="news-control" data-value="{{ $title->id }}" style="cursor: pointer;">
                    <span class="widget" style="margin-right: 5px;" onClick="GetTitleData({{$title->id}})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    <span class="widget" style="margin-right: 5px;" onClick="DeleteTitle({{$title->id}})">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                </div>
            </div>
        <?php
                }
            }
        ?>
        </div>
    @else
        <div id="newCategory-{{$newscategory->id}}"  style="display:flex;justify-content:space-between;cursor: pointer;border-radius: 5px 5px 0px 0px;border:1px solid #958f8e; padding:10px; margin-top:20px; color:blue;box-shadow: 2px 2px 4px rgb(0 0 0 / 30%);"  data-toggle="collapse" data-target="#{{ $page_key }}">
            <b id="news-category-name-{{$newscategory->id}}">{{$newscategory->name}}</b>
            <div class="controller-container">
                <span class="widget" style="margin-right: 5px;" onClick="showAddNewsTitle({{$newscategory->id}})">
                    <i class="fa-solid fa-circle-plus"></i>
                </span>
                <span class="widget" style="margin-right: 5px;" onClick="GetData({{$newscategory->id}})">
                    <i class="fa-solid fa-pen-to-square"></i>
                </span>
                <span class="widget" style="margin-right: 5px;" onClick="Delete({{$newscategory->id}})">
                    <i class="fa-solid fa-trash"></i>
                </span>
            </div>
        </div>
        <div style="border-radius: 0px 0px 5px 5px;border:1px solid #958f8e; padding:30px; border-top:0px solid #958f8e !important;" id="{{ $page_key }}" class="collapse">
        <?php 
            if(isset($newscategory->newstitles) && (sizeof($newscategory->newstitles) > 0)){
                foreach($newscategory->newstitles as $loop=>$title){
                    $number = $loop + 1;
        ?>
            <div class="article-row" style="display:flex;flex-wrap:nowrap;margin-top:15px;"> 
                <div class="news-title" data-value="{{ $title->id }}" style="cursor: pointer;">
                    <a id="news_title_{{$title->id}}" class="news_title" href="{{URL::to('/admin/news/cate-'.$newscategory->id.'/title-'.$title->id)}}">{{$number}}.{{$title->title}}</a>
                </div>
                <div class="row-line" style="cursor: pointer;flex:1 1 auto;"></div>
                <div class="news-control" data-value="{{ $title->id }}" style="cursor: pointer;">
                    <span class="widget" style="margin-right: 5px;" onClick="GetTitleData({{$title->id}})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    <span class="widget" style="margin-right: 5px;" onClick="DeleteTitle({{$title->id}})">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                </div>
            </div>
        <?php
                }
            }
        ?>
        </div>
    @endif
<?php
    }
?>
