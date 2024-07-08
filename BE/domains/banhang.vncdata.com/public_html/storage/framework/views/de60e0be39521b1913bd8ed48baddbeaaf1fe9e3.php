<script>
    app.router=function () {
        var action = location.hash;
        switch (action) {
            case '#main-menu-branches':
            {
                setupView(views.branches);
                break;
            }
            case '#main-menu-products-all-products':
            {
                setupView(views.products_package);
                break;
            }
            case '#main-menu-users':
            {
                setupView(views.users);
                break;
            }
            case '#main-menu-products-list-new':
            {
                setupView(views.products_list);
                break;
            }
            case '#main-menu-print':
            {
                setupView(views.print_template);
                break;
            }
            case '#main-menu-finance':
            {
                setupView(views.finance);
                break;
            }
            case '#main-menu-kiemkho-add':
            {
                setupView(views.kiemkho_add);
                break;
            }
            case '#main-menu-kiemkho-start':
            {
                setupView(views.kiemkho_start);
                break;
            }
            case '#main-menu-kiemkho-history':
            {
                setupView(views.kiemkho_history);
                break;
            }
            case '#main-menu-invoice':
            {
                setupView(views.invoice);
                break;
            }
            case '#main-menu-stocktakes':
            {
                setupView(views.stocktakes);
                break;
            }
            case '#main-menu-supplier':
            {
                setupView(views.supplier);
                break;
            }
            case '#main-menu-mobile':
            {
                app.show_mobile();
                break;
            }
            case '#main-menu-productreturn':
            {
                setupView(views.productreturn);
                break;
            }
            case '#main-menu-productreturn-history':
            {
                setupView(views.productreturn_history);
                break;
            }
            case '#main-menu-importreturn':
            {
                setupView(views.importreturn);
                break;
            }
            case '#main-menu-importreturn-history':
            {
                setupView(views.importreturn_history);
                break;
            }
            case '#main-menu-productimport-import':
            {
                setupView(views.product_import);
                break;
            }
            case '#main-menu-productimport-import-self-produced':
            {
                setupView(views.product_import_self_produced);
                break;
            }
            case '#main-menu-productimport-history':
            {
                setupView(views.product_import_history);
                break;
            }
            case '#main-menu-productmove-move':
            {
                setupView(views.product_move);
                break;
            }
            case '#main-menu-productmove-move-history':
            {
                setupView(views.product_move_history);
                break;
            }
            case '#main-menu-user-roles':
            {
                setupView(views.user_roles);
                break;
            }

            case '#main-menu-report-product-nhapxuatton':
            {
                setupView(views.report_product_nhapxuatton);
                break;
            }
            case '#main-menu-report-banhang':
            {
                setupView(views.report_banhang_banhang);
                break;
            }
            case '#main-menu-sale':
            {
                setupView(views.sale);
                break;
            }
            case '#main-menu-setting':
            {
                setupView(views.setting);
                break;
            }
            case '#main-menu-customer':
            {
                setupView(views.customer);
                break;
            }
            case '#main-menu-delivery':
            {
                setupView(views.delivery);
                break;
            }
            case '#main-menu-home':
            {
                setupView(views.home);
                break;
            }
            case '#main-menu-logout':
            {
                window.location.href = urls.url_logout;
                break;
            }
            case '#main-menu-theme-light':
            {
                localStorage.setItem('theme', 'light');
                $.jqx.theme = localStorage.getItem('theme');
                window.location.reload();
                break;
            }
            case '#main-menu-theme-metro':
            {
                localStorage.setItem('theme', 'metro');
                $.jqx.theme = localStorage.getItem('theme');
                window.location.reload();
                break;
            }
            case '#main-menu-theme-bootstrap':
            {
                localStorage.setItem('theme', 'bootstrap');
                $.jqx.theme = localStorage.getItem('theme');
                window.location.reload();
                break;
            }
            case '#main-menu-notify':
            {
                app.show_notifyCenter();
                break;
            }
            default:
            {
                setupView(views.home);
                break;
            }
        }
    };
</script>