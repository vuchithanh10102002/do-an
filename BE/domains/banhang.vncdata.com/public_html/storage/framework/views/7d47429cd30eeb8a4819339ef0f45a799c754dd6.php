<script type="text/javascript">
    <?php /*setup token*/ ?>
    localStorage.setItem('access_token',location.search.replace('?access_token=',''));

    var loader = $('#jqxLoader');
    var urls = {
        urlviews: '<?php echo \App\CusstomPHP\CustomURL::route('view'); ?>',
        url_apis: {
            product_logs: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-logs'); ?>',
            product_list: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-list'); ?>',
            product_move: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-move'); ?>',
            product_by_package: '<?php echo \App\CusstomPHP\CustomURL::routeApi('get-products-by-package'); ?>',
            product_import: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-import'); ?>',
            product_return: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-return'); ?>',
            product_return_import: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-return-import'); ?>',
            invoices: '<?php echo \App\CusstomPHP\CustomURL::routeApi('invoices'); ?>',
            branches: '<?php echo \App\CusstomPHP\CustomURL::routeApi('branches'); ?>',
            finance_cat: '<?php echo \App\CusstomPHP\CustomURL::routeApi('finance-cat'); ?>',
            customer_cat: '<?php echo \App\CusstomPHP\CustomURL::routeApi('customer-cat'); ?>',
            customers: '<?php echo \App\CusstomPHP\CustomURL::routeApi('customers'); ?>',
            product_cat: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-cat'); ?>',
            suppliers: '<?php echo \App\CusstomPHP\CustomURL::routeApi('suppliers'); ?>',
            users: '<?php echo \App\CusstomPHP\CustomURL::routeApi('users'); ?>',
            levels_user: '<?php echo \App\CusstomPHP\CustomURL::routeApi('users-levels'); ?>',
            current_user: '<?php echo \App\CusstomPHP\CustomURL::routeApi('users-information'); ?>',
            select: '<?php echo \App\CusstomPHP\CustomURL::routeApi('select'); ?>',
            check: '<?php echo \App\CusstomPHP\CustomURL::routeApi('check'); ?>',
            settings: '<?php echo \App\CusstomPHP\CustomURL::routeApi('settings'); ?>',
            login: '<?php echo \App\CusstomPHP\CustomURL::routeApi('login'); ?>',
            sale: '<?php echo \App\CusstomPHP\CustomURL::routeApi('sale'); ?>',
            update_product_invoice: '<?php echo \App\CusstomPHP\CustomURL::routeApi('update-product-invoice'); ?>',
            stream_get: '<?php echo \App\CusstomPHP\CustomURL::routeApiParameters('stream-get',['name'=>'']); ?>',
            stream_set: '<?php echo \App\CusstomPHP\CustomURL::routeApiParameters('stream-set',['name'=>'']); ?>',
            permissions: '<?php echo \App\CusstomPHP\CustomURL::routeApi('permissions'); ?>',
            user_roles: '<?php echo \App\CusstomPHP\CustomURL::routeApi('user-roles'); ?>',
            finance: '<?php echo \App\CusstomPHP\CustomURL::routeApi('finance'); ?>',
            upload_image: '<?php echo \App\CusstomPHP\CustomURL::route('upload-image'); ?>',
            product_data: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-data'); ?>',
            product_import_self_produced: '<?php echo \App\CusstomPHP\CustomURL::routeApi('product-import-self-produced'); ?>',
        },
        url_logout: '<?php echo \App\CusstomPHP\CustomURL::route('logout'); ?>',
    };
    var views = {
        branches: 'branch.branches',
        products_package: 'product.products_package',
        products_list: 'product.products_list',
        users: 'user.users',
        kiemkho_add: 'stock.kiemkho_add',
        kiemkho_start: 'stock.kiemkho_start',
        kiemkho_history: 'stock.kiemkho_history',
        product_import: 'product_import.product_import',
        product_import_self_produced: 'product_import.product_import_self_produced',
        product_import_history: 'product_import.import_history',
        product_move: 'product_move.product_move',
        product_move_history: 'product_move.move_history',
        report_product_nhapxuatton: 'report.product.nhapxuatton',
        report_banhang_banhang: 'report.banhang.banhang',
        sale: 'sale.sale',
        delivery: 'delivery.delivery',
        print_template: 'prints.change_print',
        invoice: 'invoice.invoice',
        supplier: 'supplier.supplier',
        importreturn: 'product_import_return.importreturn',
        importreturn_history: 'product_import_return.importreturn_history',
        productreturn: 'product_return.product_return',
        productreturn_history: 'product_return.return_history',
        stocktakes: 'stocktakes.stocktakes',
        customer: 'customer.customer',
        finance: 'finance.finance',
        user_roles: 'user_role.user_roles',
        setting: 'setting.setting',
        home: 'home.home',
    };

    var tables = {
        products: 'products',
        products_stock: 'products_stock',
        product_cat: 'product_cat',
        finance_cat: 'finance_cat',
        suppliers: 'suppliers',
        branches: 'branches',
        me: 'current_user',
        levels_user: 'levels_user',
        customer_cat: 'customer_cat',
        cache_data_delivery:'cache_data_delivery',
        settings:'settings',
    };

    var app = {};
    var me={};

    app.notify = function (message, type_message) {
        $('#notify_content').html(message);
        var notify = $("#notify");
        notify.jqxNotification({template: type_message});
        notify.jqxNotification('open');
    };

    app.download_and_save = function () {
        var downloaded = 0;
        app.loadding('open');
        function download_success() {
            downloaded += 1;
            if (downloaded >= 7) {
                //Get me data
                me=JSON.parse(localStorage.getItem(tables.me));
                //data from server setting
                download_data_where(urls.url_apis.select, {
                    table: "settings",
                    select: "WHERE name LIKE 'settings' AND branch LIKE '" + me.branch + "'",
                    data: "value"
                }, null, function (result) {
                    if (result['success']) {
                        settings = JSON.parse(result['data'][0]['value']);
                        localStorage.setItem(tables.settings, JSON.stringify(settings));
                        app.applySetting();
                    } else {

                    }
                    app.loadding('close');
                    app.router();
                });
            }
        }

        function tai(url, data_name) {
            download_data(url, function (result) {
                if (result['success']) {
                    var data = result['data'];
                    localStorage.setItem(data_name, JSON.stringify(data));
                }
                download_success();
            });
        }


        tai(urls.url_apis.current_user, tables.me);
        tai(urls.url_apis.branches, tables.branches);
        tai(urls.url_apis.customer_cat, tables.customer_cat);
        tai(urls.url_apis.product_cat, tables.product_cat);
        tai(urls.url_apis.user_roles, tables.levels_user);
        tai(urls.url_apis.suppliers, tables.suppliers);
        tai(urls.url_apis.finance_cat, tables.finance_cat);
        me=JSON.parse(localStorage.getItem(tables.me));
    };

    app.getNameByCode = function (code, data) {
        var index = data.findIndex(x => x.code === code);
        if (index >= 0) {
            return data[index]['name'];
        }
        return '';
    };
    app.getDataByCode = function (code, data) {
        var index = data.findIndex(x => x.code === code);
        if (index >= 0) {
            return data[index];
        }
        return null;
    };

    function createGuiMain() {
        if (localStorage.getItem('theme') == null) {
            $.jqx.theme = 'metro';
        } else {
            $.jqx.theme = localStorage.getItem('theme');
        }


        $("#jqxLoader").jqxLoader({text: "<?php echo app('translator')->get('lang.loadding'); ?>...", isModal: true, width: 100, height: 60, imagePosition: 'top'});
        $("#notify").jqxNotification({
            width: 250, position: "top-right", opacity: 0.9,
            autoOpen: false,
            animationOpenDelay: 800,
            autoClose: true,
            autoCloseDelay: 5000,
            template: "error"
        });

    }

    function createEventMain() {
        window.addEventListener("hashchange", function (event) {
            app.router();
        }, false);
    }

    app.applySetting=function () {
        //apply self_produced
        if(settings.self_produced){
            $('.not_self_produced').parent().hide();
        }else {
            $('.self_produced').parent().hide();
        }
    };


    app.loadding = function (action) {
        loader.jqxLoader(action);
    };


    app.decode=function(str) {
        // Going backwards: from bytestream, to percent-encoding, to original string.
        return decodeURIComponent(atob(str).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    };


    var container_view=null;
    function setupView(viewname) {
        loader.jqxLoader('open');
        if(container_view!==null){
            container_view.remove();
        }
        $('#content').empty();
        $('.jqx-window').remove();
        container_view=$('<div style="height: 100%;"></div>');
        $('#content').append(container_view);
        //remove view function
        get_view(urls.urlviews, viewname, function (result) {
            loader.jqxLoader('close');
            if (result['success']) {
                var data=app.decode(result['data']);
                container_view.html(data);
                try {
                    view_start();
                } catch (e) {
                    console.warn(e);
                }
            }

        });
    }

    $(document).ready(function () {
        createGuiMain();
        createEventMain();
        app.download_and_save();
        //Reload
        $(window).on("beforeunload", function () {
            return false;
        });
    });

</script>
<?php echo $__env->make('page.main.router', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('page.main.location_VI', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('page.main.const_data', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>