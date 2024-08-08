<!-- **********************************

    Nav header start

***********************************-->

<div class="nav-header" style="padding: 5px; background-color: white; !important">

    <div class="brand-logo">

        <a href="{{URL::to('/admin/home')}}">

            <span class="brand-title" style="color:red;padding-left: 10px; padding-top: 6px;">
                <img src="{!! asset('public/images/kyowa_logo.png') !!}" width="25%" alt="">
                <b class="text-center" style="color:red; font-size: 1.4rem;">
                  京和物流2024
                </b>
            </span>

        </a>

    </div>

</div>

<!--**********************************

    Nav header end

***********************************-->



<!--**********************************

    Header start

***********************************-->

<div class="header">

    <div class="header-content clearfix">


        <div class="header-left" id="headerUrl" style="position:fix;margin-left:40%; text-align:center; padding-top:0.8%">
            <h3>仪表板</h3>
        </div>
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </a>
                </li>

                <li class="icons dropdown">

                    <div class="user-img c-pointer position-relative"   data-toggle="dropdown">

                        <span class="activity active"></span>

                        <img src="{!! asset('public/images/user.png') !!}" height="40" width="40" alt="">

                    </div>

                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">

                        <div class="dropdown-content-body">

                            <ul>

                                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#ChangePasswordModal"><i class="icon-key"></i> <span>Change Password</span></a></li>

                                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#Selltings"><i class="fa fa-cog" aria-hidden="true"></i> <span>Settings</span></a></li>

                                <li><a href="{{URL::to('/admin/logout')}}"><i class="icon-logout"></i> <span>Logout</span></a></li>

                            </ul>

                        </div>

                    </div>

                </li>

            </ul>

        </div>

    </div>

</div>

<!--**********************************

    Header end ti-comment-alt

***********************************