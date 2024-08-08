<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>ロゴイメージ</th>
            <th>メニュー画像</th>
            <th>印刷の可用性</th>
            <th>ニュースの可視性</th>
            <th>呼出の可視性</th>
            <th>検索の可視性</th>
            <th>価格オプション</th>
            <th>シークレットコード</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($settings as $setting) {
        ?>
        <tr id="dataid{{$setting->id}}">
            <td><img class="img-fluid" src='{!! asset("public/images/setting/".$setting->logo) !!}' style="max-height: 50px;" ></td>
            <td><img class="img-fluid" src='{!! asset("public/images/setting/".$setting->menu_back) !!}' style="max-height: 50px;" ></td>
            <td>
                @if ($setting->print_order == 1)
                    <a class="badge badge-success px-2" onclick="StatusUpdate('{{$setting->id}}','1')" style="color: #fff;">目に見える</a>
                @else
                    <a class="badge badge-danger px-2" onclick="StatusUpdate('{{$setting->id}}','1')" style="color: #fff;">見えない</a>
                @endif
            </td>
            <td>
                @if ($setting->is_news == 1)
                    <a class="badge badge-success px-2" onclick="StatusUpdate('{{$setting->id}}','2')" style="color: #fff;">目に見える</a>
                @else
                    <a class="badge badge-danger px-2" onclick="StatusUpdate('{{$setting->id}}','2')" style="color: #fff;">見えない</a>
                @endif
            </td>
            <td>
                @if ($setting->is_call == 1)
                    <a class="badge badge-success px-2" onclick="StatusUpdate('{{$setting->id}}','2')" style="color: #fff;">目に見える</a>
                @else
                    <a class="badge badge-danger px-2" onclick="StatusUpdate('{{$setting->id}}','1')" style="color: #fff;">見えない</a>
                @endif
            </td>
            <td>
                @if ($setting->is_search == 1)
                    <a class="badge badge-success px-2" onclick="StatusUpdate('{{$setting->id}}','2')" style="color: #fff;">目に見える</a>
                @else
                    <a class="badge badge-danger px-2" onclick="StatusUpdate('{{$setting->id}}','1')" style="color: #fff;">見えない</a>
                @endif
            </td>
            <td>
                @if ($setting->tax_option == 0)
                    <a class="badge badge-success px-2" onclick="StatusUpdate('{{$setting->id}}','2')" style="color: #fff;">すべて</a>
                @elseif ($setting->tax_option == 1)
                    <a class="badge badge-danger px-2" onclick="StatusUpdate('{{$setting->id}}','1')" style="color: #fff;">価格(税抜)</a>
                @else 
                    <a class="badge badge-danger px-2" onclick="StatusUpdate('{{$setting->id}}','1')" style="color: #fff;">価格(税込)</a>
                @endif
            </td>
            <td>****</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>