<div class="view">
    <div id="sidebar" style="width: 220px;">
        <div class="sidebar-item">
            <div>Tìm kiếm phiếu trả</div>
            <div>
                <label>Mã hóa đơn:</label>
                <input id="code" class="input-sidebar">
                <label>Theo mã, tên hàng:</label>
                <input id="pcode" class="input-sidebar">
                <label>Chi nhánh:</label>
                <div id="branch" class="input-sidebar"></div>
                <label>Nhà cung cấp:</label>
                <div id="customer" class="input-sidebar"></div>
                <label>Nhân viên:</label>
                <div id="user" class="input-sidebar"></div>
                <label>Trạng thái:</label>
                <div id="state" class="input-sidebar"></div>
                <label>Từ ngày:</label>
                <div id="date_create1"></div>
                <label>Tới ngày:</label>
                <div id="date_create2" style="margin-bottom: 10px;"></div>

            </div>
        </div>
    </div>
    <div id="content-table" style="width: calc(100% - 232px);">
        <div id="table"></div>
    </div>
</div>

<script>
    var importReturnHistoryAPP = {};
    var table = $('#table');
    var table_source;
    var table_dataAdapter;
    var invoices = {};
    var txt_pcode = $('#pcode');
    var txt_code = $('#code');
    var txt_date_create1 = $('#date_create1');
    var txt_date_create2 = $('#date_create2');
    var cb_branch = $('#branch');
    var cb_customer = $('#customer');
    var cb_user = $('#user');
    var cb_state = $('#state');
    var btn_delete = $('<button><i class="fa fa-trash"></i> Xóa phiếu trả hàng nhập</button>');
    var branches = null;
    var customers = null;
    var users = null;

    importReturnHistoryAPP.createData = function () {
        app.loadding('open');
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 2) {
                app.loadding('close');
                //Local
                branches = JSON.parse(localStorage.getItem(tables.branches));

                customers[customers.length] = {
                    phone: 'ALL',
                    name: 'Tất cả'
                };
                branches[branches.length] = {
                    code: 'ALL',
                    name: 'Tất cả'
                };
                users[users.length] = {
                    username: 'ALL',
                    name: 'Tất cả'
                };
                var states = [
                    {code: 'ALL', name: 'Tất cả'},
                    {code: 'WAITING', name: 'Đang chờ'},
                    {code: 'SUCCESS', name: 'Hoàn thành'},
                ];

                cb_branch.jqxDropDownList({source: branches});
                cb_customer.jqxDropDownList({source: customers});
                cb_user.jqxDropDownList({source: users});
                cb_state.jqxDropDownList({source: states});

                cb_user.jqxDropDownList('selectItem', 'ALL');
                cb_customer.jqxDropDownList('selectItem', 'ALL');
                cb_branch.jqxDropDownList('selectItem', me['branch']);
                cb_state.jqxDropDownList('selectItem', 'ALL');
            }
        }

        //Server
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
    importReturnHistoryAPP.createUI = function () {
        //
        btn_delete.jqxButton({height: 28});
        $(".sidebar-item").jqxExpander({width: '100%'});
        txt_code.jqxInput({width: '100%', height: 30});
        txt_pcode.jqxInput({width: '100%', height: 30});
        var date_start = null;
        if (new Date().getMonth() === 0) {
            date_start = new Date(new Date().getFullYear() - 1, 11, new Date().getDate());
        } else {
            date_start = new Date(new Date().getFullYear(), new Date().getMonth() - 1, new Date().getDate());
        }
        txt_date_create1.jqxDateTimeInput({
            width: '100%', height: 30,
            value: date_start,
            dropDownVerticalAlignment: "top"
        });
        txt_date_create2.jqxDateTimeInput({
            width: '100%', height: 30,
            dropDownVerticalAlignment: "top"
        });
        cb_branch.jqxDropDownList({
            source: branches,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            placeHolder: ''
        });
        cb_state.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            placeHolder: ''
        });
        cb_customer.jqxDropDownList({
            source: customers,
            displayMember: "name",
            valueMember: "phone",
            width: '100%',
            height: 30,
            placeHolder: '',
            filterable: true
        });
        cb_user.jqxDropDownList({
            source: users,
            displayMember: "name",
            valueMember: "username",
            width: '100%',
            height: 30,
            placeHolder: ''
        });

        //
        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
            container_toolbar.append($("<div class='table-title'><span>Phiếu trả hàng nhập</span></div>"));
            container_toolbar.append(btn_delete);
            toolbar.append(container_toolbar);
        }

        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            //console.log(parentElement);
            datarecord = table.jqxGrid('getrowdata', index);
            var tabsdiv = null;
            var container_products = null;
            tabsdiv = $($(parentElement).children()[0]);
            if (tabsdiv != null) {
                container_products = tabsdiv.find('.container_products');
                //Danh sách sản phẩm
                $(tabsdiv).jqxTabs({width: (table.find('.jqx-grid-content').width() - 35), height: 310});

                var table_products = $('<div></div>');
                container_products.append(table_products);
                table_products.jqxGrid({
                    width: 'calc(100% - 2px)',
                    height: 'calc(100% - 2px)',
                    selectionmode: 'none',
                    columnsResize: true,
                    columns: [
                        {
                            text: 'TT',
                            dataField: 'id',
                            width: '35'
                        }, {
                            text: 'Mã sản phẩm',
                            dataField: 'code',
                            width: '120'
                        }, {
                            text: 'Tên sản phẩm',
                            dataField: 'name',
                            width: '250'
                        }, {
                            text: 'Số lượng',
                            dataField: 'number',
                            width: '80'
                        }, {
                            text: 'Đơn giá',
                            dataField: 'price_sale',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'

                        }, {
                            text: 'Thành tiền',
                            dataField: 'price',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: ' ',
                            dataField: 'other'
                        }
                    ]
                });

                //Event
                table_products.jqxGrid('showloadelement');
                download_data_where(urls.url_apis.select, {
                    table: "invoices",
                    select: "WHERE code LIKE '" + datarecord['mahd'] + "'",
                    data: "products"
                }, table_products, function (result) {
                    if (result['success']) {
                        var table_x = result['sent'];
                        var data_result = JSON.parse(result['data'][0]['products']);
                        table_x.jqxGrid('clear');
                        for (var i = 0; i < data_result.length; i++) {
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
                {name: 'ngayhd', type: 'date'},
                {name: 'id', type: 'string'},
                {name: 'mahd', type: 'string'},
                {name: 'makh', type: 'string'},
                {name: 'tenkh', type: 'string'},
                {name: 'tongtien', type: 'number'},
                {name: 'tienkm', type: 'number'},
                {name: 'tienkhac', type: 'number'},
                {name: 'tientra', type: 'number'},
                {name: 'trangthai', type: 'string'},
                {name: 'ghichu', type: 'string'}
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            altRows: true,
            pageable: false,
            height: '100%',
            width: '100%',
            rowsheight: 40,
            columnsheight: 40,
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
                "<li>Danh sách sản phẩm</li>" +
                "</ul>" +
                "<div class='container_products'></div>" +
                "</div>",
                rowdetailsheight: 330
            },
            initrowdetails: initrowdetails,
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 25,
            columns: [
                {
                    text: 'Ngày HD', dataField: 'ngayhd', width: '100',
                    aggregates: ['count'],
                    filtertype: 'date', cellsformat: 'dd/MM/yyyy',
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['count'] == null) {
                            aggregates['count'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;'>" + aggregates['count'] + "</div>";
                    }
                },
                {text: 'Mã HD', dataField: 'mahd', width: '110'},
                {text: 'Mã NCC', dataField: 'makh', width: '100'},
                {
                    text: 'Tên nhà cung cấp', dataField: 'tenkh', width: '180',
                    aggregatesrenderer: function (aggregates, column, element) {
                        return "<div style='text-align:right;padding-top: 4px;font-weight: bold;'>Tổng cộng: </div>";
                    }
                },
                {
                    text: 'Tổng tiền',
                    dataField: 'tongtien',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }, align: 'right',
                }, {
                    text: 'Khuyến mãi',
                    dataField: 'tienkm',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }, align: 'right',
                }, {
                    text: 'Tiền khác',
                    dataField: 'tienkhac',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }, align: 'right',
                }, {
                    text: 'NCC trả',
                    dataField: 'tientra',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    }, align: 'right',
                },
                {
                    text: 'Trạng thái', dataField: 'trangthai', width: '100', align: 'center',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (state_invoice[value] != undefined) {
                            return "<div class='price_sale-cell' style='font-weight: normal'>" + state_invoice[value] + "</div>";
                        }
                    }
                },
                {text: 'Ghi chú', dataField: 'ghichu', },

            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };
    importReturnHistoryAPP.createEvent = function () {
        //Filter
        function request_filter() {
            var branch_f = cb_branch.jqxDropDownList('val');
            var customer_f = cb_customer.jqxDropDownList('val');
            var user_f = cb_user.jqxDropDownList('val');
            var state_f = cb_state.jqxDropDownList('val');
            var dateS_f = txt_date_create1.jqxDateTimeInput('val');
            var dateE_f = txt_date_create2.jqxDateTimeInput('val');
            var code_f = txt_code.jqxInput('val');
            var pcode_f = txt_pcode.jqxInput('val');

            if (branch_f !== 'ALL') {
                branch_f = " AND branch LIKE '" + branch_f + "'";
            } else {
                branch_f = '';
            }
            if (customer_f !== 'ALL') {
                customer_f = " AND customer LIKE '" + customer_f + "'";
            } else {
                customer_f = '';
            }
            if (user_f !== 'ALL') {
                user_f = " AND user LIKE '" + user_f + "'";
            } else {
                user_f = '';
            }
            if (state_f !== 'ALL') {
                state_f = " AND state LIKE '" + state_f + "'";
            } else {
                state_f = '';
            }
            if (code_f !== '') {
                code_f = " AND code LIKE '" + code_f + "'";
            } else {
                code_f = '';
            }
            if (pcode_f !== '') {
                pcode_f = " AND products LIKE '%" + pcode_f + "%'";
            } else {
                pcode_f = '';
            }

            dateS_f = " AND STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y')>=STR_TO_DATE('00:00" + txt_date_create1.jqxDateTimeInput('val') + "','%H:%i %d/%m/%Y')";
            dateE_f = " AND STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y')<=STR_TO_DATE('23:59" + txt_date_create2.jqxDateTimeInput('val') + "','%H:%i %d/%m/%Y')";

            var string_where = pcode_f + code_f + dateE_f + dateS_f + customer_f + branch_f + user_f + state_f;
            table.jqxGrid('showloadelement');
            download_data_where(urls.url_apis.select, {
                table: "invoices",
                select: "WHERE 1 AND type LIKE 'RETURNIMPORT'" + string_where + ' ORDER BY id DESC',
                data: "invoices.id AS 'id',DATE_FORMAT(STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y'),'%d/%m/%Y') AS 'ngayhd', invoices.code AS 'mahd',invoices.customer AS 'makh', invoices.customer_name as 'tenkh',invoices.total_price AS 'tongtien', invoices.discount AS 'tienkm', invoices.other_price AS 'tienkhac', invoices.total_pay AS 'tientra', invoices.state AS 'trangthai',invoices.note AS 'ghichu'"
            }, null, function (result) {
                if (result['success']) {
                    table_source.localdata = result['data'];
                    table.jqxGrid('updatebounddata', 'cells');
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                table.jqxGrid('hideloadelement');
            });
        }

        //event
        $('#code').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#pcode').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#date_create1').on('valueChanged', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#date_create2').on('valueChanged', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#branch').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#customer').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#user').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#state').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });

        //Delete invoice
        btn_delete.click(function () {
            if (table.jqxGrid('getselectedrowindex') < 0) {
                app.notify('Bạn chưa chọn hóa đơn cần xóa!', 'warning');
                return;
            }
            var data_delete = table.jqxGrid('getrowdata', table.jqxGrid('getselectedrowindex'));
            swal({
                title: 'Bạn có chắc?',
                text: "Xóa phiếu trả hàng nhập, khôi phục sản phẩm và xóa các dữ liệu liên quan?",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Xóa ngay',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                delete_data(urls.url_apis.product_return_import, data_delete['id'], function (result) {
                    if (result['success']) {
                        app.notify("Xóa phiếu trả hàng nhập hàng thành công!", 'success');
                        table.jqxGrid('deleterow', result.sent.index.uid);
                    } else {
                        app.notify('Xóa phiếu trả hàng nhập hàng không thành công!', 'error');
                    }
                }, data_delete);
            }).catch(swal.noop);

        });

        //auto expand row
        table.on("cellclick", function (event) {
            // event arguments.
            var args = event.args;
            // row's bound index.
            var rowBoundIndex = args.rowindex;
            setTimeout(function () {
                var goto_x = args.visibleindex + 2;
                if (goto_x > table.jqxGrid('getrows').length - 1) {
                    table.jqxGrid('scrolloffset', table.jqxGrid('getrows').length * 40, 0);
                } else {
                    table.jqxGrid('ensurerowvisible', goto_x);
                }
            }, 50);
            if (!args.row.rowdetailshidden) {
                setTimeout(function () {
                    table.jqxGrid('hiderowdetails', rowBoundIndex);
                    table.jqxGrid('unselectrow', rowBoundIndex);
                }, 50);
            }
            else {
                if (args.column.datafield == null) {
                    setTimeout(function () {
                        table.jqxGrid('showrowdetails', rowBoundIndex);
                    }, 50);
                }
                table.jqxGrid('hiderowdetails', table.jqxGrid('selectedrowindex'));
                table.jqxGrid('clearselection');
                table.jqxGrid('selectrow', rowBoundIndex);
                table.jqxGrid('showrowdetails', rowBoundIndex);
            }

        });
    };

    function view_start() {
        importReturnHistoryAPP.createData();
        importReturnHistoryAPP.createUI();
        importReturnHistoryAPP.createEvent();
    }
</script>