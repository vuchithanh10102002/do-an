<div class="jTitle">
    {{--<i class="fa fa-shopping-basket hdnet-title-icon"></i>--}}
    <h1 class="hdnet-title-name">Phần mềm quản lý bán hàng HDPOS</h1>
    <ul class="jTitle-menu">
        <li>
            <a href="#main-menu-setting"><i class="fa fa-cog"></i> @lang('lang.Settings')</a>
        </li>
        <li><a href="#main-menu-logout"><i class="fa fa-sign-out"></i> @lang('lang.Log out')</a></li>
    </ul>
</div>
<div id='jqxMenu'>
    <ul>
        {{--<li style="width: auto;margin-right: 10px;">--}}
        {{--</li>--}}
        <li>
            <a href="#main-menu-home">
                <i class="fa fa-home"></i>
                <span> @lang('lang.Home')</span>
            </a>
        </li>
        <li><i class="fa fa-th-large"></i><span> @lang('lang.Structure')</span>
            <ul>
                <li>
                    <a href="#main-menu-branches">@lang('lang.Branch manager')</a>
                </li>
                <li>
                    <a href="#main-menu-users">@lang('lang.User manager')</a>
                </li>
                <li>
                    <a href="#main-menu-user-roles">@lang('lang.Roles manager')</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="#main-menu-products-list-new">
                <i class="fa fa-shopping-bag"></i>
                <span> @lang('lang.Products')</span>
            </a>

        </li>
        <li><i class="fa fa-exchange"></i><span> @lang('lang.Transactions')</span>
            <ul>
                <li>
                    <a href="#main-menu-productmove-move">@lang('lang.Move products')</a>
                </li>
                <li>
                    <a class="not_self_produced" href="#main-menu-productimport-import">@lang('lang.Import products')</a>
                </li>
                <li>
                    <a class="not_self_produced" href="#main-menu-importreturn">@lang('lang.Returns imported products')</a>
                </li>
                <li>
                    <a href="#main-menu-productreturn">@lang('lang.Product returns')</a>
                </li>
                <li>
                    <a class="self_produced" href="#main-menu-productimport-import-self-produced">@lang('lang.Add product to stock')</a>
                </li>
            </ul>
        </li>
        <li><i class="fa fa-list-alt"></i><span> @lang('lang.Invoices')</span>
            <ul>
                <li>
                    <a href="#main-menu-invoice">@lang('lang.Sales invoice')</a>
                </li>
                <li>
                    <a href="#main-menu-productmove-move-history">@lang('lang.Move invoice')</a>
                </li>
                <li>
                    <a href="#main-menu-productimport-history">@lang('lang.Import invoice')</a>
                </li>
                <li>
                    <a class="not_self_produced" href="#main-menu-importreturn-history">@lang('lang.Return imported invoice')</a>
                </li>
                <li>
                    <a href="#main-menu-productreturn-history">@lang('lang.Return invoice')</a>
                </li>
                <li  style="display: none;">
                    <a href="#main-menu-stocktakes-history">@lang('lang.Stocktakes invoice')</a>
                </li>
            </ul>
        </li>
        <li >
            <i class="fa fa-database"></i><span>@lang('lang.Warehouses')</span>
            <ul>
                <li>
                    <a href="#main-menu-stocktakes">@lang('lang.Stocktakes')</a>
                </li>
                <li>
                    <a href="#main-menu-delivery">@lang('lang.Delivery')</a>
                </li>
            </ul>
        </li>
        <li><i class="fa fa-recycle"></i><span> @lang('lang.Partners')</span>
            <ul>
                <li>
                    <a class="not_self_produced" href="#main-menu-supplier">@lang('lang.Supplier')</a> </li>
                <li>
                    <a href="#main-menu-customer">@lang('lang.Customer')</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#main-menu-finance">
                <i class="fa fa-usd"></i><span> @lang('lang.Finance')</span>
            </a>
        </li>
        <li><i class="fa fa-area-chart"></i><span> @lang('lang.Reports')</span>
            <ul>
                <li>
                    <a href="#main-menu-report-banhang">@lang('lang.Sales Report')</a>
                </li>
                <li>
                    <a href="#main-menu-report-product-nhapxuatton">@lang('lang.Report Import & Export')</a>
                </li>
            </ul>
        </li>
        <li>
            <i class="fa fa-th"></i><span> @lang('lang.System')</span>
            <ul>
                <li>
                    <a href="#main-menu-mobile">@lang('lang.Connect your phone')</a>
                </li>
                {{--<li>Trạng thái</li>--}}
                <li>
                    <a href="#main-menu-setting">@lang('lang.Settings')</a></li>
                <li>
                    <a href="#main-menu-print">@lang('lang.Printed form')</a>
                </li>
                <li>
                    <a>@lang('lang.Themes')</a>
                    <ul style="display: none">
                        <li>
                            <a href="#main-menu-theme-metro" >Windows</a>
                        </li>
                        <li><a href="#main-menu-theme-light">Sáng</a></li>
                        <li><a href="#main-menu-theme-bootstrap">Website</a></li>
                    </ul>
                </li>
                {{--<li>Bản ghi lỗi</li>--}}
                <li><a href="#main-menu-logout">@lang('lang.Log out')</a></li>
            </ul>
        </li>
        <li onclick="screenfull.request();">
            <a>
                <i class="fa fa-arrows-alt"></i><span> @lang('lang.Fullscreen')</span>
            </a>
        </li>
        <li>
            <a href="#main-menu-sale">
                <i class="fa fa-desktop"></i>
                <span> @lang('lang.POS')</span>
            </a>

        </li>
    </ul>
</div>