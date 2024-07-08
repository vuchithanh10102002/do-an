<div class="jTitle">
    <?php /*<i class="fa fa-shopping-basket hdnet-title-icon"></i>*/ ?>
    <h1 class="hdnet-title-name">Phần mềm quản lý bán hàng HDPOS</h1>
    <ul class="jTitle-menu">
        <li>
            <a href="#main-menu-setting"><i class="fa fa-cog"></i> <?php echo app('translator')->get('lang.Settings'); ?></a>
        </li>
        <li><a href="#main-menu-logout"><i class="fa fa-sign-out"></i> <?php echo app('translator')->get('lang.Log out'); ?></a></li>
    </ul>
</div>
<div id='jqxMenu'>
    <ul>
        <?php /*<li style="width: auto;margin-right: 10px;">*/ ?>
        <?php /*</li>*/ ?>
        <li>
            <a href="#main-menu-home">
                <i class="fa fa-home"></i>
                <span> <?php echo app('translator')->get('lang.Home'); ?></span>
            </a>
        </li>
        <li><i class="fa fa-th-large"></i><span> <?php echo app('translator')->get('lang.Structure'); ?></span>
            <ul>
                <li>
                    <a href="#main-menu-branches"><?php echo app('translator')->get('lang.Branch manager'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-users"><?php echo app('translator')->get('lang.User manager'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-user-roles"><?php echo app('translator')->get('lang.Roles manager'); ?></a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#main-menu-products-list-new">
                <i class="fa fa-shopping-bag"></i>
                <span> <?php echo app('translator')->get('lang.Products'); ?></span>
            </a>

        </li>
        <li><i class="fa fa-exchange"></i><span> <?php echo app('translator')->get('lang.Transactions'); ?></span>
            <ul>
                <li>
                    <a href="#main-menu-productmove-move"><?php echo app('translator')->get('lang.Move products'); ?></a>
                </li>
                <li>
                    <a class="not_self_produced" href="#main-menu-productimport-import"><?php echo app('translator')->get('lang.Import products'); ?></a>
                </li>
                <li>
                    <a class="not_self_produced" href="#main-menu-importreturn"><?php echo app('translator')->get('lang.Returns imported products'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-productreturn"><?php echo app('translator')->get('lang.Product returns'); ?></a>
                </li>
                <li>
                    <a class="self_produced" href="#main-menu-productimport-import-self-produced"><?php echo app('translator')->get('lang.Add product to stock'); ?></a>
                </li>
            </ul>
        </li>
        <li><i class="fa fa-list-alt"></i><span> <?php echo app('translator')->get('lang.Invoices'); ?></span>
            <ul>
                <li>
                    <a href="#main-menu-invoice"><?php echo app('translator')->get('lang.Sales invoice'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-productmove-move-history"><?php echo app('translator')->get('lang.Move invoice'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-productimport-history"><?php echo app('translator')->get('lang.Import invoice'); ?></a>
                </li>
                <li>
                    <a class="not_self_produced" href="#main-menu-importreturn-history"><?php echo app('translator')->get('lang.Return imported invoice'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-productreturn-history"><?php echo app('translator')->get('lang.Return invoice'); ?></a>
                </li>
                <li  style="display: none;">
                    <a href="#main-menu-stocktakes-history"><?php echo app('translator')->get('lang.Stocktakes invoice'); ?></a>
                </li>
            </ul>
        </li>
        <li >
            <i class="fa fa-database"></i><span><?php echo app('translator')->get('lang.Warehouses'); ?></span>
            <ul>
                <li>
                    <a href="#main-menu-stocktakes"><?php echo app('translator')->get('lang.Stocktakes'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-delivery"><?php echo app('translator')->get('lang.Delivery'); ?></a>
                </li>
            </ul>
        </li>
        <li><i class="fa fa-recycle"></i><span> <?php echo app('translator')->get('lang.Partners'); ?></span>
            <ul>
                <li>
                    <a class="not_self_produced" href="#main-menu-supplier"><?php echo app('translator')->get('lang.Supplier'); ?></a> </li>
                <li>
                    <a href="#main-menu-customer"><?php echo app('translator')->get('lang.Customer'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#main-menu-finance">
                <i class="fa fa-usd"></i><span> <?php echo app('translator')->get('lang.Finance'); ?></span>
            </a>
        </li>
        <li><i class="fa fa-area-chart"></i><span> <?php echo app('translator')->get('lang.Reports'); ?></span>
            <ul>
                <li>
                    <a href="#main-menu-report-banhang"><?php echo app('translator')->get('lang.Sales Report'); ?></a>
                </li>
                <li>
                    <a href="#main-menu-report-product-nhapxuatton"><?php echo app('translator')->get('lang.Report Import & Export'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <i class="fa fa-th"></i><span> <?php echo app('translator')->get('lang.System'); ?></span>
            <ul>
                <li>
                    <a href="#main-menu-mobile"><?php echo app('translator')->get('lang.Connect your phone'); ?></a>
                </li>
                <?php /*<li>Trạng thái</li>*/ ?>
                <li>
                    <a href="#main-menu-setting"><?php echo app('translator')->get('lang.Settings'); ?></a></li>
                <li>
                    <a href="#main-menu-print"><?php echo app('translator')->get('lang.Printed form'); ?></a>
                </li>
                <li>
                    <a><?php echo app('translator')->get('lang.Themes'); ?></a>
                    <ul style="display: none">
                        <li>
                            <a href="#main-menu-theme-metro" >Windows</a>
                        </li>
                        <li><a href="#main-menu-theme-light">Sáng</a></li>
                        <li><a href="#main-menu-theme-bootstrap">Website</a></li>
                    </ul>
                </li>
                <?php /*<li>Bản ghi lỗi</li>*/ ?>
                <li><a href="#main-menu-logout"><?php echo app('translator')->get('lang.Log out'); ?></a></li>
            </ul>
        </li>
        <li onclick="screenfull.request();">
            <a>
                <i class="fa fa-arrows-alt"></i><span> <?php echo app('translator')->get('lang.Fullscreen'); ?></span>
            </a>
        </li>
        <li>
            <a href="#main-menu-sale">
                <i class="fa fa-desktop"></i>
                <span> <?php echo app('translator')->get('lang.POS'); ?></span>
            </a>

        </li>
    </ul>
</div>