<div class="view">
    <div id="sidebar">
        <div class="sidebar-item">
            <div>Tìm kiếm thông tin</div>
            <div style="padding-top: 10px;padding-bottom: 10px;">
                <label>Mã nhà cung cấp:</label>
                <input id="code" class="input-sidebar">
                <label>Tên nhà cung cấp:</label>
                <input id="name" class="input-sidebar">
            </div>
        </div>
    </div>
    <div id="content-table">
        <div id="table"></div>
    </div>
</div>

<script>
    var supplierApp = {};
    var table = $('#table');
    var table_source;
    var table_dataAdapter;
    var invoices = {};
    var txt_name = $('#name');
    var txt_code = $('#code');
    var branches = null;
    var customers = null;
    var users = null;

    supplierApp.createData = function () {
        app.loadding('open');
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 3) {
                app.loadding('close');
            }
        }

        //Local
        branches = JSON.parse(localStorage.getItem(tables.branches));
        //Server
        download_data_where(urls.url_apis.select, {
            table: "supplier LEFT JOIN invoices ON invoices.customer=supplier.code",
            select: " WHERE 1 GROUP BY invoices.customer",
            data: "supplier.id AS 'id',supplier.code AS 'ma',supplier.name AS 'ten',supplier.phone AS 'dt',supplier.email,SUM(invoices.total_price) AS 'tongmua',SUM(invoices.total_price)-SUM(invoices.total_pay) AS 'no' , supplier.state AS 'trangthai',supplier.note AS 'ghichu'"
        }, null, function (result) {
            if (result['success']) {
                var datax=result['data'];
                for(var i=0;i<datax.length;i++){
                    if(datax[i].no==null){
                        datax[i].no=0;
                    }
                    if(datax[i].tongmua==null){
                        datax[i].tongmua=0;
                    }
                }
                console.log(datax);
                table_source.localdata = datax;
                table.jqxGrid('updatebounddata', 'cells');
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
        download_data(urls.url_apis.customers, function (result) {
            if (result['success']) {
                customers = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
        download_data(urls.url_apis.users, function (result) {
            if (result['success']) {
                users = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
    };
    supplierApp.createUI = function () {

        //
        $(".sidebar-item").jqxExpander({width: '100%'});
        txt_code.jqxInput({width: '100%', height: 30});
        txt_name.jqxInput({width: '100%', height: 30});

        //
        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
            container_toolbar.append($("<div class='table-title'><span>Quản lý nhà cung cấp</span></div>"));
            toolbar.append(container_toolbar);
        }

        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            //console.log(parentElement);
            datarecord = table.jqxGrid('getrowdata', index);
            var tabsdiv = null;
            var container_1 = null;
            var container_2 = null;
            tabsdiv = $($(parentElement).children()[0]);
            if (tabsdiv != null) {
                container_1 = tabsdiv.find('.container_1');
                container_2 = tabsdiv.find('.container_2');
                //Danh sách sản phẩm
                $(tabsdiv).jqxTabs({width: (table.find('.jqx-grid-content').width() - 35), height: 310});

                var table_1 = $('<div></div>');
                container_1.append(table_1);
                table_1.jqxGrid({
                    width: 'calc(100% - 2px)',
                    height: 'calc(100% - 2px)',
                    selectionmode: 'none',
                    columnsResize: true,
                    rowsheight: 40,
                    columnsheight: 40,
                    columns: [
                        {
                            text: 'Mã phiếu',
                            dataField: 'ma',
                            width: '120'
                        }, {
                            text: 'Thời gian',
                            dataField: 'tg',
                            width: '150'
                        }, {
                            text: 'Loại phiếu',
                            dataField: 'loai',
                            width: '130',
                            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                                if (type_invoice[value] != undefined) {
                                    return "<div class='price_sale-cell' style='font-weight: normal;text-align: left'>" + type_invoice[value] + "</div>";
                                } else {
                                    return "<div class='price_sale-cell' style='font-weight: normal;text-align: left'>" + value + "</div>";
                                }
                            }
                        }, {
                            text: 'Người tạo',
                            dataField: 'nguoitao',
                            width: '150'
                        }, {
                            text: 'Giá trị',
                            dataField: 'giatri',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right',
                            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                                return '<span style="padding: 6px 0 0 0;display:block;margin-right: 2px; text-align: right;font-weight: 500;">' + parseInt(value).toLocaleString() + '</span>';
                            }
                        }, {
                            text: ' ',
                            dataField: 'other'
                        }
                    ]
                });

                //Event
                table_1.jqxGrid('showloadelement');
                download_data_where(urls.url_apis.select, {
                    table: "invoices,users",
                    select: "WHERE users.username=invoices.user AND type IN('IMPORT','RETURNIMPORT') AND customer LIKE '" + datarecord['ma'] + "' ORDER BY invoices.id DESC",
                    data: "invoices.code AS 'ma',invoices.create_at AS 'tg',invoices.type AS 'loai',users.name AS 'nguoitao',invoices.total_price AS 'giatri'"
                }, table_1, function (result) {
                    if (result['success']) {
                        var table_x = result['sent'];
                        table_x.jqxGrid('addrow', null, result['data']);
                    } else {
                        app.notify("Tải dữ liệu bị lỗi!", 'error');
                    }
                    table_1.jqxGrid('hideloadelement');
                });

            }
        };
        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'string'},
                {name: 'ma', type: 'string'},
                {name: 'ten', type: 'string'},
                {name: 'dt', type: 'string'},
                {name: 'email', type: 'number'},
                {name: 'no', type: 'number'},
                {name: 'tongmua', type: 'number'},
                {name: 'trangthai', type: 'string'},
                {name: 'ghichu', type: 'string'}
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            altRows: true,
            pageable: false,
            rowsheight: 40,
            columnsheight: 40,
            height: '100%',
            width: '100%',
            filterable: true,
            autoshowfiltericon: true,
            sortable: true,
            columnsResize: true,
            source: table_dataAdapter,
            selectionmode: 'singlerow',
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div class='content-detail-grid'>" +
                "<ul style='margin-left: 30px;'>" +
                "<li>Lịch sử giao dịch</li><li>Lịch sử thanh toán</li>" +
                "</ul>" +
                "<div class='container_1 scroollbar-c'></div>" +
                "<div class='container_2 scroollbar-c'></div>" +
                "</div>",
                rowdetailsheight: 330
            },
            initrowdetails: initrowdetails,
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 25,

            columns: [
                {text: 'ID', dataField: 'id', width: '50'},
                {text: 'Mã NCC', dataField: 'ma', width: '110'},
                {text: 'Tên nhà cung cấp', dataField: 'ten',},
                {text: 'Điện thoại', dataField: 'dt', width: '100'},
                {text: 'Email', dataField: 'email', width: '160'},
                {
                    text: 'Tiền nợ',
                    dataField: 'no',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div  class='price_sale-cell' style='text-align: right;padding-top: 4px;font-weight: bold;'>" + aggregates['sum'] + "</div>";
                    }, align: 'right',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        return '<div class="price_sale-cell" style="text-align: right;font-weight: normal;">' + parseInt(value).toLocaleString() + '</div>';
                    }
                }, {
                    text: 'Tiền mua',
                    dataField: 'tongmua',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;margin-right: 2px;'>" + aggregates['sum'] + "</div>";
                    }, align: 'right',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        return '<div class="price_sale-cell" style="text-align: right;font-weight: inherit;">' + parseInt(value).toLocaleString() + '</div>';
                    }
                },
                {
                    text: 'Trạng thái', dataField: 'trangthai', width: '90', align: 'center',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (state_invoice[value] != undefined) {
                            return "<div class='price_sale-cell' style='font-weight: normal; text-align: left'>" + state_invoice[value] + "</div>";
                        }
                    }
                },
//                {text: 'Ghi chú', dataField: 'ghichu', width: '100'},
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };


    supplierApp.createEvent = function () {
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
        supplierApp.createData();
        supplierApp.createUI();
        supplierApp.createEvent();
    }
</script>