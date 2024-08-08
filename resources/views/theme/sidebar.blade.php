<!--**********************************
    Sidebar start
***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?php echo e(URL::to('/admin/news')); ?>" aria-expanded="false" menu-commponent-name="news">
                    <i class="fa fa-rss"></i>
                    <b class="nav-text">说明文</b>
                </a>
            </li>
            <!-- <li>
                <a href="<?php echo e(URL::to('/admin/finance')); ?>" aria-expanded="false">
                    <i class="fa fa-shopping-cart"></i>
                    <b class="nav-text">订单收据</b>
                </a>
            </li> -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false" style="background-color:white; !important;" menu-commponent-name="Orders">
                    <i class="fa fa-shopping-cart"></i>
                    <b class="nav-text">
                        订单
                    </b>
                </a>
                <ul class="submenu_sug" aria-expanded="false">
                    <li>
                        <a href="<?php echo e(URL::to('/admin/orders/jingheobian')); ?>" aria-expanded="false" menu-commponent-name="jingheobian">
                            <i class="fa fa-shopping-cart"></i>
                            <b class="nav-text">
                                京和便
                            </b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/orders/yamato')); ?>" aria-expanded="false" menu-commponent-name="">
                            <i class="fa fa-plane"></i>
                            <b class="nav-text">
                                ヤマト便
                            </b>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false" style="background-color:white; !important;" menu-commponent-name="product">
                    <i class="fa fa-gift"></i>
                    <b class="nav-text">
                        商品
                    </b>
                </a>
                <ul class="submenu_sug" aria-expanded="false">
                    <li>
                        <a href="<?php echo e(URL::to('/admin/categories')); ?>" aria-expanded="false" menu-commponent-name="product">
                            <i class="fa fa-tag"></i>
                            <b class="nav-text">
                                商品
                            </b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/import')); ?>" aria-expanded="false" menu-commponent-name="excelimport">
                            <i class="fa fa-file"></i>
                            <b class="nav-text">
                                上传Excel
                            </b>
                        </a>
                    </li>
                </ul>

            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false" style="background-color:white; !important;" menu-commponent-name="Customer">
                    <i class="fa fa-user"></i>
                    <b class="nav-text">
                        客户
                    </b>
                </a>
                <ul class="submenu_sug" aria-expanded="false">
                    <li>
                        <a href="<?php echo e(URL::to('/admin/address')); ?>" aria-expanded="false" menu-commponent-name="address">
                            <i class="fa fa-map-marker"></i>
                            <b class="nav-text">地址审查</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/users')); ?>" aria-expanded="false" menu-commponent-name="">
                            <i class="fa fa-users"></i>
                            <b class="nav-text">
                                客户信息
                            </b>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void();" aria-expanded="false" style="background-color:white; !important;" menu-commponent-name="report">
                    <i class="fa fa-bar-chart"></i>
                    <b class="nav-text">分析</b>
                </a>
                <ul class="submenu_sug" aria-expanded="false">
                    <li>
                        <a href="<?php echo e(URL::to('/admin/reportsDay')); ?>" aria-expanded="false" menu-commponent-name="set_service_time">
                            <i class="fa fa-bar-chart"></i>
                            <b class="nav-text">日</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/reportsMonth')); ?>" aria-expanded="false" menu-commponent-name="users">
                            <i class="fa fa-bar-chart"></i>
                            <b class="nav-text">月</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/reportsYear')); ?>" aria-expanded="false">
                            <i class="fa fa-bar-chart"></i>
                            <b class="nav-text">年</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/reports')); ?>" aria-expanded="false">
                            <i class="fa fa-bar-chart"></i>
                            <b class="nav-text">部分报告</b>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false" style="background-color:white; !important;" menu-commponent-name="setting">
                    <i class="fa fa-gear"></i>
                    <b class="nav-text">
                        设置
                    </b>
                </a>
                <ul class="submenu_sug" aria-expanded="false">
                    <li>
                        <a href="<?php echo e(URL::to('/admin/serviceTime')); ?>" aria-expanded="false" menu-commponent-name="set_service_time">
                            <i class="fa fa-clock-o"></i>
                            <b class="nav-text">
                                接单时间
                            </b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/delivery')); ?>" aria-expanded="false" menu-commponent-name="set_service_time">
                            <i class="fa fa-truck"></i>
                            <b class="nav-text">
                                运输方式
                            </b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/service')); ?>" aria-expanded="false">
                            <i class="fa fa-user-circle"></i>
                            <b class="nav-text">服务</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/payments')); ?>" aria-expanded="false">
                            <i class="fa fa-paypal"></i>
                            <b class="nav-text">支付方式</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/units')); ?>" aria-expanded="false">
                            <i class="fa fa-gear"></i>
                            <b class="nav-text">单位</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/purse')); ?>" aria-expanded="false">
                            <i class="fa fa-star"></i>
                            <b class="nav-text">钱包</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/tax')); ?>" aria-expanded="false">
                            <i class="fa fa-gear"></i>
                            <b class="nav-text">税</b>
                        </a>
                    </li>

                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false" style="background-color:white; !important;">
                    <i class='fa fa-history'></i>
                    <b class="nav-text">历史</b>
                </a>
                <ul class="submenu_sug" aria-expanded="false">
                    <li>
                        <a href="<?php echo e(URL::to('/admin/address/history')); ?>" aria-expanded="false">
                            <i class="fa fa-map-marker"></i>
                            <b class="nav-text">地址</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/product/history')); ?>" aria-expanded="false">
                            <i class="fa fa-tag"></i>
                            <b class="nav-text">商品</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/order/history')); ?>" aria-expanded="false">
                            <i class="fa fa-first-order"></i>
                            <b class="nav-text">订单</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/chat/user')); ?>" aria-expanded="false">
                            <i class="fa fa-wechat"></i>
                            <b class="nav-text">聊天</b>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo e(URL::to('/admin/price/wholesalehistory')); ?>" aria-expanded="false">
                            <i class='fa fa-money'></i>
                            <b class="nav-text">批发的</b>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(URL::to('/admin/price/retailsalehistory')); ?>" aria-expanded="false">
                            <i class='fa fa-money'></i>
                            <b class="nav-text">袖子</b>
                        </a>
                    </li>

                </ul>

            </li>
        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->