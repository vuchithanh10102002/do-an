<div class="view">
    <div id="loader_view"></div>
    <div id="table"></div>
</div>


<script>
    var BaoCaoBanHangAPP = {};
    var table = $('#table');
    var subdetalis = {};
    var branches = null;
    var me = null;
    var table_source = null;
    var data_list;
    var table_dataAdapter = null;
    var products_list = null;
    var txt_datebegin = $("<div style='float: right'></div>");
    var txt_dateend = $("<div style='float: right'></div>");
    var txt_branch = $('<div style="float: right"></div>');
    var btn_filter = $("<button style='margin-left: 5px;'><i class='fa fa-filter'></i> Lọc</button>");

    BaoCaoBanHangAPP.createUI = function () {
        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
            container_toolbar.append($("<div class='table-title'><span>Báo cáo bán hàng</span></div>"));
            container_toolbar.append(btn_filter);
            container_toolbar.append(txt_branch);
            container_toolbar.append($("<div style='float: right;padding: 5px;'><span>Kho: </span></div>"));
            container_toolbar.append(txt_dateend);
            container_toolbar.append($("<div style='float: right;padding: 5px;'><span>Đến: </span></div>"));
            container_toolbar.append(txt_datebegin);
            container_toolbar.append($("<div style='float: right;padding: 5px;'><span>Từ: </span></div>"));
            var date_start = null;
            if (new Date().getMonth() === 0) {
                date_start = new Date(new Date().getFullYear() - 1, 11, new Date().getDate());
            } else {
                date_start = new Date(new Date().getFullYear(), new Date().getMonth() - 1, new Date().getDate());
            }
            txt_datebegin.jqxDateTimeInput({height: 30, value: date_start});
            txt_dateend.jqxDateTimeInput({height: 30});
            btn_filter.jqxButton({height: 30, width: '100px', template: 'primary'});
            txt_branch.jqxDropDownList({
                height: 30,
                width: '180px',
                source: branches,
                displayMember: 'name',
                valueMember: 'code',
                placeHolder: ""
            });
            toolbar.append(container_toolbar);
        }

        var groupsrenderer = function (text, group, expanded, data) {
//            console.log(data);
            var sum = {};
            console.log(sum);
            var data_subItems = data.subItems;
            sum['number'] = 0;
            sum['price'] = 0;
            sum['price_import'] = 0;
            sum['price_VAT'] = 0;
            for (var i = 0; i < data_subItems.length; i++) {
                sum['number'] += parseInt(data_subItems[i]['number']);
                sum['price'] += parseInt(data_subItems[i]['price']);
                sum['price_import'] += parseInt(data_subItems[i]['price_import']);
                sum['price_VAT'] += parseInt(data_subItems[i]['price_VAT']);
            }

            return '<div class="row-g">' +
                '<span style="width: 385px;text-align: left;padding-left: 5px;">' + data.group + '</span>' +
                '<span style="width: 50px;text-align: right;">' + parseInt(sum['number']).toLocaleString() + '</span>' +
                '<span style="width: 100px;text-align: right;">' + parseInt(sum['price_import']).toLocaleString() + '</span>' +
                '<span style="width: 100px;text-align: right;">' + parseInt(sum['price_VAT']).toLocaleString() + '</span>' +
                '<span style="width: 100px;text-align: right;">' + parseInt(sum['price']).toLocaleString() + '</span>' +
                '</div>';
        };
        table_source = {
            localdata: data_list, datatype: "array", datafields: [
                {name: 'id', type: 'string'},
                {name: 'pcode', type: 'string'},
                {name: 'pname', type: 'string'},
                {name: 'number', type: 'number'},
                {name: 'price_import', type: 'number'},
                {name: 'price_VAT', type: 'number'},
                {name: 'price', type: 'number'},
                {name: 'customer_name', type: 'number'},
                {name: 'name', type: 'number'},
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            altRows: true,
            rowsheight: 40,
            columnsheight: 40,
            pageable: false,
            height: '100%',
            width: '100%',
            filterable: true,
            autoshowfiltericon: true,
            sortable: true,
            columnsResize: true,
            source: table_dataAdapter,
            selectionmode: 'none',
            statusbarheight: 25,
            columns: [
                {text: 'TT', dataField: 'id', width: '50'},
                {text: 'Mã SP', dataField: 'pcode', width: '100'},
                {text: 'Tên sản phẩm', dataField: 'pname', width: 250},
                {
                    text: 'SL', dataField: 'number', width: 50,
                    cellsformat: 'd', cellsalign: 'right', align: 'right'
                },
                {
                    text: 'Tiền vốn', dataField: 'price_import', width: 100,
                    cellsformat: 'd', cellsalign: 'right', align: 'right'
                },
                {
                    text: 'Tiền VAT', dataField: 'price_VAT', width: 100,
                    cellsformat: 'd', cellsalign: 'right', align: 'right'
                },
                {
                    text: 'Doanh thu', dataField: 'price', width: 100,
                    cellsformat: 'd', cellsalign: 'right', align: 'right'
                },
                {text: 'Tên KH', dataField: 'customer_name', width: 150,
                    cellsalign: 'right', align: 'right'
                },
                {text: 'Người bán', dataField: 'name', width: 150,
                    cellsalign: 'right', align: 'right'
                },
                {text: ' '}
            ],
            groupable: true,
            groups: ['pname'],
            groupsrenderer: groupsrenderer,
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };


    var dowloaded = 0;
    BaoCaoBanHangAPP.createData = function () {
        table.jqxGrid('showloadelement');
        //local
        me = JSON.parse(localStorage.getItem(tables.me));
        if (branches == null) {
            branches = JSON.parse(localStorage.getItem(tables.branches));
            branches[branches.length] = {code: "%", name: "Tất cả kho hàng"};
            txt_branch.jqxDropDownList({source: branches});
            txt_branch.jqxDropDownList('val', me['branch']);
        }

        //Server
        function tonghop() {
            dowloaded += 1;
            if (dowloaded >= 1) {
                table_source.localdata = data_list;
                table.jqxGrid('updatebounddata', 'cells');
                table.jqxGrid('expandallgroups');
                table.jqxGrid('hideloadelement');
            }
        }

        download_data_where(urls.url_apis.select, {
            table: "product_logs JOIN invoices ON product_logs.invoice=invoices.code JOIN products_list ON product_logs.product_list=products_list.code JOIN users ON invoices.user=users.username",
            select: "WHERE products_list.branch LIKE '"+txt_branch.jqxDropDownList('val')+"' AND product_logs.branch LIKE '"+txt_branch.jqxDropDownList('val')+"' AND invoices.branch LIKE '"+txt_branch.jqxDropDownList('val')+"' AND product_logs.type='INVOICE' AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')<=STR_TO_DATE('" + txt_dateend.jqxDateTimeInput('val') + "','%d/%m/%Y') AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')>=STR_TO_DATE('" + txt_datebegin.jqxDateTimeInput('val') + "','%d/%m/%Y') ORDER BY product_logs.id DESC",
            data: "'0' AS 'price_VAT', product_logs.product_list AS 'pcode',products_list.name AS 'pname' ,ABS(product_logs.number) AS 'number',product_logs.price_import,product_logs.price,invoices.customer_name,users.name,product_logs.id"
        }, null, function (result) {
            if (result['success']) {
                data_list = result['data'];
                tonghop();
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
    };
    BaoCaoBanHangAPP.createEvent = function () {
        btn_filter.click(function () {
            BaoCaoBanHangAPP.createData();
        });
    };


    function view_start() {
        BaoCaoBanHangAPP.createUI();
        BaoCaoBanHangAPP.createData();
        BaoCaoBanHangAPP.createEvent();
    }
</script>