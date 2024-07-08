<div class="view">
    <div id="loader_view"></div>
    <div id="table"></div>
</div>

<script>
    var XuatNhapTonAPP = {};
    var table = $('#table');
    var subdetalis = {};
    var branches = null;
    var table_source = null;
    var table_dataAdapter = null;
    var products_list = null;
    var txt_datebegin = $("<div style='float: right'></div>");
    var txt_dateend = $("<div style='float: right'></div>");
    var txt_branch = $('<div style="float: right"></div>');
    var btn_filter = $("<button style='margin-left: 5px;'><i class='fa fa-filter'></i> Lọc</button>");
    var data_before = null;
    var data_after = null;
    var data_import = null;
    var data_export = null;
    var data_list = null;
    var dowloaded = 0;

    XuatNhapTonAPP.createUI = function () {
        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
            container_toolbar.append($("<div class='table-title'><span>Báo cáo xuất nhập tồn</span></div>"));
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
                width: 180,
                source: branches,
                displayMember: 'name',
                valueMember: 'code',
                placeHolder: ""
            });
            toolbar.append(container_toolbar);
        }

        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            datarecord = table.jqxGrid('getrowdata', index);
            var tabsdiv = null;
            var container_xuatonchitiet = null;
            tabsdiv = $($(parentElement).children()[0]);
            if (tabsdiv != null) {
                container_xuatonchitiet = tabsdiv.find('.container_xuatonchitiet');
                //Danh sách sản phẩm
                $(tabsdiv).jqxTabs({width: (table.find('.jqx-grid-content').width() - 35), height: 310});
                var table_products = $('<div></div>');
                container_xuatonchitiet.append(table_products);
                table_products.jqxGrid({
                    width: 'calc(100% - 2px)',
                    height: 'calc(100% - 2px)',
                    selectionmode: 'none',
                    columnsResize: true,
                    columns: [
                        {
                            text: 'Ngày CT',
                            dataField: 'ngayct',
                            width: '100'
                        },
                        {
                            text: 'Mã CT',
                            dataField: 'mact',
                            width: '120'
                        }, {
                            text: 'Loại CT',
                            dataField: 'loaict',
                            width: '120',
                            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                                return '<div style="padding: 5px 0 0 5px;display:block;margin-right: 2px; ">' + type_invoice[value] + '</div>';
                            }
                        }, {
                            text: 'Mã KH',
                            dataField: 'makh',
                            width: '100'
                        }, {
                            text: 'Tên KH',
                            dataField: 'tenkh',
                            width: '180'
                        }, {
                            text: 'Mã kho',
                            dataField: 'makho',
                            width: '60'

                        }, {
                            text: 'Giá',
                            dataField: 'gia',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: 'SL nhập',
                            dataField: 'slnhap',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: 'Tiền nhập',
                            dataField: 'tiennhap',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: 'SL xuất',
                            dataField: 'slxuat',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: 'Tiền xuất',
                            dataField: 'tienxuat',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }
                    ]
                });

                //Event
                table_products.jqxGrid('showloadelement');
                download_data_where(urls.url_apis.select, {
                    table: "product_logs,products_list,branch",
                    select: "WHERE products_list.code=product_logs.product_list AND product_logs.branch=branch.code AND products_list.code='" + datarecord['product_code'] + "' AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')<=STR_TO_DATE('" + txt_dateend.jqxDateTimeInput('val') + "','%d/%m/%Y') AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')>=STR_TO_DATE('" + txt_datebegin.jqxDateTimeInput('val') + "','%d/%m/%Y') AND product_logs.branch LIKE '" + txt_branch.jqxDropDownList('val') + "' AND products_list.branch LIKE '" + txt_branch.jqxDropDownList('val') + "'",
                    data: "product_logs.invoice AS 'mact',product_logs.customer_name AS 'tenkh',product_logs.customer AS 'makh',product_logs.create_at AS 'ngayct', product_logs.type AS 'loaict', product_logs.branch AS 'makho', branch.name as 'tenkho', product_logs.price/ABS(product_logs.number) AS 'gia', IF(product_logs.number > 0,product_logs.number,0) AS 'slnhap', IF(product_logs.number > 0,product_logs.price,0) AS 'tiennhap', IF(product_logs.number < 0,ABS(product_logs.number),0) AS 'slxuat', IF(product_logs.number < 0,product_logs.price,0) AS 'tienxuat'"
                }, table_products, function (result) {
                    if (result['success']) {
                        var table_x = result['sent'];
                        var data_result = result['data'];
                        table_x.jqxGrid('clear');
                        for (var i = 0; i < data_result.length; i++) {
                            data_result[i]['tiennhap'] = parseInt(data_result[i]['tiennhap']);
                            data_result[i]['tienxuat'] = parseInt(data_result[i]['tienxuat']);
                            data_result[i]['gia'] = parseInt(data_result[i]['gia']);
                            table_x.jqxGrid('addrow', null, data_result[i]);
                        }
                    } else {
                        app.notify("Tải dữ liệu bị lỗi!", 'error');
                    }
                    table_products.jqxGrid('hideloadelement');
                });
            }
        };
        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'product_code', type: 'string'},
                {name: 'product_name', type: 'string'},
                {name: 'tondau', type: 'number'},
                {name: 'dudau', type: 'number'},
                {name: 'slnhap', type: 'number'},
                {name: 'tiennhap', type: 'number'},
                {name: 'slxuat', type: 'number'},
                {name: 'tienxuat', type: 'number'},
                {name: 'toncuoi', type: 'number'},
                {name: 'ducuoi', type: 'number'},
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
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div class='content-detail-grid'> " +
                "<ul style='margin-left: 30px;'>" +
                "<li>Xuất tồn chi tiết</li>" +
                "</ul>" +
                "<div class='container_xuatonchitiet'></div>" +
                "</div>",
                rowdetailsheight: 330
            },
            initrowdetails: initrowdetails,
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 40,
            columns: [
                {text: 'Mã SP', dataField: 'product_code', width: '100'},
                {
                    text: 'Tên sản phẩm', dataField: 'product_name',
                    aggregatesrenderer: function (aggregates, column, element) {
                        return "<div style='text-align:right;padding-top: 4px;font-weight: bold;'>Tổng cộng: </div>";
                    }
                },
                {
                    text: 'Tồn đầu', dataField: 'tondau', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'Dư đầu', dataField: 'dudau', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'SL nhập', dataField: 'slnhap', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'Tiền nhập', dataField: 'tiennhap', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'SL xuất', dataField: 'slxuat', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'Tiền xuất', dataField: 'tienxuat', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'Tồn cuối', dataField: 'toncuoi', width: '90', cellsformat: 'd', cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {
                    text: 'Dư cuối',
                    dataField: 'ducuoi',
                    width: '90',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    salign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }
                },
                {text: ' '}
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };

    XuatNhapTonAPP.createData = function () {
        table.jqxGrid('showloadelement');
        //local
        if (branches === null) {
            branches = JSON.parse(localStorage.getItem(tables.branches));
            branches[branches.length] = {code: "%", name: "Tất cả kho hàng"};
            txt_branch.jqxDropDownList({source: branches});
            txt_branch.jqxDropDownList('selectItem', me['branch']);
        }

        //Server
        btn_filter.html('<i class="fa fa-spin fa-spinner"></i> Đang tải...');

        function tonghop() {
            dowloaded += 1;
            if (dowloaded >= 5) {
                for (var i = 0; i < data_list.length; i++) {
                    data_list[i]['product_code'] = data_list[i]['code'];
                    data_list[i]['product_name'] = data_list[i]['name'];
                    data_list[i]['dau'] = app.getDataByCode(data_list[i]['code'], data_before);
                    if (data_list[i]['dau'] == null) {
                        data_list[i]['dau'] = {};
                        data_list[i]['dau']['tondau'] = 0;
                        data_list[i]['dau']['dudau'] = 0;
                    }
                    data_list[i]['tondau'] = data_list[i]['dau']['tondau'];
                    data_list[i]['dudau'] = data_list[i]['dau']['dudau'];
                    data_list[i]['nhap'] = app.getDataByCode(data_list[i]['code'], data_import);
                    if (data_list[i]['nhap'] == null) {
                        data_list[i]['nhap'] = {};
                        data_list[i]['nhap']['slnhap'] = 0;
                        data_list[i]['nhap']['tiennhap'] = 0;
                    }
                    data_list[i]['slnhap'] = data_list[i]['nhap']['slnhap'];
                    data_list[i]['tiennhap'] = data_list[i]['nhap']['tiennhap'];
                    data_list[i]['xuat'] = app.getDataByCode(data_list[i]['code'], data_export);
                    if (data_list[i]['xuat'] == null) {
                        data_list[i]['xuat'] = {};
                        data_list[i]['xuat']['slxuat'] = 0;
                        data_list[i]['xuat']['tienxuat'] = 0;
                    }
                    data_list[i]['slxuat'] = data_list[i]['xuat']['slxuat'];
                    data_list[i]['tienxuat'] = data_list[i]['xuat']['tienxuat'];
                    data_list[i]['cuoi'] = app.getDataByCode(data_list[i]['code'], data_after);
                    if (data_list[i]['cuoi'] == null) {
                        data_list[i]['cuoi'] = {};
                        data_list[i]['cuoi']['ducuoi'] = 0;
                        data_list[i]['cuoi']['toncuoi'] = 0;
                    }
                    data_list[i]['ducuoi'] = data_list[i]['cuoi']['ducuoi'];
                    data_list[i]['toncuoi'] = data_list[i]['cuoi']['toncuoi'];

                    if (data_list[i]['dudau'] == null) {
                        data_list[i]['dudau'] = 0
                    }
                    if (data_list[i]['tondau'] == null) {
                        data_list[i]['tondau'] = 0
                    }
                    if (data_list[i]['tiennhap'] == null) {
                        data_list[i]['tiennhap'] = 0
                    }
                    if (data_list[i]['slnhap'] == null) {
                        data_list[i]['slnhap'] = 0
                    }
                    if (data_list[i]['slxuat'] == null) {
                        data_list[i]['slxuat'] = 0
                    }
                    if (data_list[i]['tienxuat'] == null) {
                        data_list[i]['tienxuat'] = 0
                    }
                    if (data_list[i]['ducuoi'] == null) {
                        data_list[i]['ducuoi'] = 0
                    }
                    if (data_list[i]['toncuoi'] == null) {
                        data_list[i]['toncuoi'] = 0
                    }

                    btn_filter.html('<i class="fa fa-filter"></i> Lọc');
                }
                table_source.localdata = data_list;
                table.jqxGrid('updatebounddata', 'cells');
                table.jqxGrid('hideloadelement');
            }
        }

        download_data_where(urls.url_apis.select, {
            table: "product_logs,products_list",
            select: "WHERE products_list.code=product_logs.product_list AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')<STR_TO_DATE('" + txt_datebegin.jqxDateTimeInput('val') + "','%d/%m/%Y') AND product_logs.branch LIKE '" + txt_branch.jqxDropDownList('val') + "' AND products_list.branch LIKE '" + txt_branch.jqxDropDownList('val') + "'  GROUP BY products_list.code",
            data: "product_logs.id AS 'id',products_list.code AS 'code',SUM(product_logs.number) AS 'tondau', SUM(product_logs.number/ABS(product_logs.number)*product_logs.price) AS 'dudau'"
        }, null, function (result) {
            if (result['success']) {
                data_before = result['data'];
                tonghop();
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs,products_list",
            select: "WHERE products_list.code=product_logs.product_list AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')<=STR_TO_DATE('" + txt_dateend.jqxDateTimeInput('val') + "','%d/%m/%Y') AND product_logs.branch LIKE '" + txt_branch.jqxDropDownList('val') + "' AND products_list.branch LIKE '" + txt_branch.jqxDropDownList('val') + "'  GROUP BY products_list.code",
            data: "product_logs.id AS 'id',products_list.code AS 'code',SUM(product_logs.number) AS 'toncuoi', SUM(product_logs.number/ABS(product_logs.number)*product_logs.price) AS 'ducuoi'"
        }, null, function (result) {
            if (result['success']) {
                data_after = result['data'];
                tonghop();
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs,products_list",
            select: "WHERE products_list.code=product_logs.product_list AND product_logs.number<0 AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')<=STR_TO_DATE('" + txt_dateend.jqxDateTimeInput('val') + "','%d/%m/%Y') AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')>=STR_TO_DATE('" + txt_datebegin.jqxDateTimeInput('val') + "','%d/%m/%Y') AND product_logs.branch LIKE '" + txt_branch.jqxDropDownList('val') + "' AND products_list.branch LIKE '" + txt_branch.jqxDropDownList('val') + "'  GROUP BY(product_logs.product_list)",
            data: "product_logs.id AS 'id',products_list.code AS 'code',SUM(ABS(product_logs.number)) AS 'slxuat', SUM(product_logs.price) AS 'tienxuat'"
        }, null, function (result) {
            if (result['success']) {
                data_export = result['data'];
                tonghop();
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs,products_list",
            select: "WHERE products_list.code=product_logs.product_list AND product_logs.number>0 AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')<=STR_TO_DATE('" + txt_dateend.jqxDateTimeInput('val') + "','%d/%m/%Y') AND STR_TO_DATE(product_logs.create_at,'%d/%m/%Y')>=STR_TO_DATE('" + txt_datebegin.jqxDateTimeInput('val') + "','%d/%m/%Y') AND product_logs.branch LIKE '" + txt_branch.jqxDropDownList('val') + "' AND products_list.branch LIKE '" + txt_branch.jqxDropDownList('val') + "'  GROUP BY(product_logs.product_list)",
            data: "product_logs.id AS 'id',products_list.code AS 'code',SUM(product_logs.number) AS 'slnhap', SUM(product_logs.price) AS 'tiennhap'"
        }, null, function (result) {
            if (result['success']) {
                data_import = result['data'];
                tonghop();
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });

        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE branch LIKE '" + txt_branch.jqxDropDownList('val') + "'",
            data: "*"
        }, null, function (result) {
            if (result['success']) {
                data_list = result['data'];
                tonghop();
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
    };

    XuatNhapTonAPP.createEvent = function () {
        btn_filter.click(function () {
            XuatNhapTonAPP.createData();
        });

        //auto expand row
        table.on("cellclick", function (event) {
            // event arguments.
            var args = event.args;
            // row's bound index.
            var rowBoundIndex = args.rowindex;
            setTimeout(function () {
                var goto_x=args.visibleindex+2;
                if(goto_x>table.jqxGrid('getrows').length-1){
                    table.jqxGrid('scrolloffset', table.jqxGrid('getrows').length*40, 0);
                }else {
                    table.jqxGrid('ensurerowvisible', goto_x);
                }
            },50);
            if(!args.row.rowdetailshidden){
                setTimeout(function () {
                    table.jqxGrid('hiderowdetails', rowBoundIndex);
                    table.jqxGrid('unselectrow', rowBoundIndex);
                },50);
            }
            else {
                if(args.column.datafield==null){
                    setTimeout(function () {
                        table.jqxGrid('showrowdetails', rowBoundIndex);
                    },50);
                }
                table.jqxGrid('hiderowdetails', table.jqxGrid('selectedrowindex'));
                table.jqxGrid('clearselection');
                table.jqxGrid('selectrow', rowBoundIndex);
                table.jqxGrid('showrowdetails', rowBoundIndex);
            }

        });
    };


    function view_start() {
        XuatNhapTonAPP.createUI();
        XuatNhapTonAPP.createData();
        XuatNhapTonAPP.createEvent();
    }
</script>