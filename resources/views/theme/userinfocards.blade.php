<?php
foreach ($users as $user) {
?>
    <div class="col-lg-3 col-sm-4">
        <div class="card user-info-card" style="cursor:pointer;" id="user-info-card-{{$user->id}}"  data-user-id="{{$user->id}}">
            <div class="card-body d-flex justify-content-between">
                <div class="user-profile" style="width:25%;">
                    @if(isset($user->profile_image)) <img src="{{asset('public/images/profile/'.$user->profile_image)}}" height="40" width="40" alt="" style= "border-radius: 50%;" />
                    @else <img src="{{asset('public/images/profile/unknown.png')}}" height="40" width="40" style= "border-radius: 50%;" alt="" />
                    @endif
                    <h4 class="card-title" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">{{$user->name}}</h4>
                </div>
                <div class="user-info">
                    <div class="user-email d-flex justify-content-between">
                        <label style="font-weight:bold;color:#6a4b24;width:35%;">电子邮件: </label>
                        <label style="margin-left:5px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;width:65%;">{{$user->email}}</label>
                    </div>
                    <div class="user-join d-flex justify-content-between">
                        <label style="font-weight:bold;color:#6a4b24;">注册日期: </label>
                        <label style="margin-left:5px;">{{$user->created_at}}</label>
                    </div>
                    <div class="user-role d-flex justify-content-between">
                        <label style="font-weight:bold;color:#6a4b24;">角色: </label>
                            @if($user->type == 1)
                                <span class="badge badge-danger px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">经理</span>
                            @elseif($user->type == 0)
                                <span class="badge badge-info px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">顾客</span>
                            @else
                                <span class="badge badge-warning px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">推销员</span>
                            @endif
                    </div>
                    <div class="user-address d-flex justify-content-between mt-1">
                        <label style="font-weight:bold;color:#6a4b24;">地址信息: </label>
                        @if($user->type==0)
                            @if(isset($user->address))
                                @if($user->address->is_verified == 1)
                                    <span class="badge badge-danger px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">待办的</span>
                                @else 
                                    <span class="badge badge-success px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">确认的</span>
                                @endif
                            @else
                                <span class="badge badge-dark px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">尚未注册</span>
                            @endif
                        @else
                            <span class="badge badge-secondary px-2" style="margin-left:5px;color: #fff; font-size: 0.875rem;">员工</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<script type="text/javascript">
    var selectedPageButtone = document.getElementsByClassName("page-selector-selected")[0];
    var selectedPage = selectedPageButtone.getAttribute("page-number");
    document.getElementById("pagination-container").setAttribute("user-cnt-info", <?php echo $users_cnt ?>);
    initPageNation(selectedPage*1);
</script>