<div class="view">
    <div id="loader_view"></div>
    <div id="sidebar">
        <div class="sidebar-item">
            <div>Tìm kiếm sản phẩm</div>
            <div>
                <div>
                    <label>Số điện thoại:</label>
                    <input id="s_code">
                </div>
                <div>
                    <label>Tên khách hàng:</label>
                    <input id="s_name">
                </div>
                <div>
                    <label>Lượt mua:</label>
                    <input id="s_hit">
                </div>
                <div>
                    <label>Dư nợ:</label>
                    <input id="s_debt">
                </div>

                <div>
                    <label>Danh mục:</label>
                    <div id="s_cat"></div>
                </div>
                <div>
                    <label>Chi nhánh:</label>
                    <div id="s_branch"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="content-table">
        <div id="table"></div>
    </div>
    <div id="sidebar2"
         style="position: absolute;width: 350px;height: 100%;right: -350px;background-color: white;z-index: 9999;">
        <div class="sidebar-item">
            <div>Thông tin khách hàng</div>
            <div>

            </div>
        </div>
    </div>


    <div id="windows_sent" class="windows">
        <div><i class="fa fa-envelope-open-o"></i> Gửi tin nhắn</div>
        <div>
            <div>
                <div>
                    <label>Nội dung tin nhắn:</label>
                    <textarea id="content_sent"></textarea>
                </div>
            </div>
            <div>
                <div style="float: right; margin-top: 15px;width: 100%;">
                    <div class="f-left" style=' overflow: hidden; margin-top: 8px;' id='processBar_sent'></div>
                    <input class="btn f-right" type="button" id="btn_cancel_sent" value="Hủy bỏ"/>
                    <button style="margin-right: 5px;" class="btn f-right" type="button" id="btn_submit_sent">
                        <i class="fa fa-send"></i> Gửi ngay
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var CustomerAPP = {};
    var customers = null;
    var customers_cat = null;
    var branches = null;
    var finance_cats = null;
    var txt_s_code = $('#s_code');
    var txt_s_name = $('#s_name');
    var txt_s_cat = $('#s_cat');
    var txt_s_branch = $('#s_branch');
    var txt_s_hit = $('#s_hit');
    var txt_s_debt = $('#s_debt');
    var table = $('#table');
    var table_dataAdapter;
    var table_source;
    var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
    var btn_add = $("<button><i class='fa fa-plus-circle'></i> Thêm</button>");
    var btn_sent_sms = $("<button><i class='fa fa-envelope-open-o'></i> Gửi tin nhắn</button>");
    var btn_edit = $("<button><i class='fa fa-pencil'></i> Sửa</button>");
    var btn_delete = $("<button><i class='fa fa-trash'></i> Xóa</button>");
    var btn_export_excel = $("<button><i class='fa fa-file-excel-o'></i> Xuất Excel</button>");
    var btn_export_print = $("<button><i class='fa fa-print'></i> In</button>");
    var lb_table = $("<div class='table-title'><span>Quản lý danh sách khách hàng</span></div>");
    var windows_sent = $('#windows_sent');
    var btn_cancel_sent = $('#btn_cancel_sent');
    var btn_submit_sent = $('#btn_submit_sent');
    var content_sent = $('#content_sent');
    var processBar_sent = $('#processBar_sent');

    CustomerAPP.createData = function () {
        app.loadding('open');
        var downloaded = 0;
        branches = JSON.parse(localStorage.getItem(tables.branches));
        finance_cats=JSON.parse(localStorage[tables.finance_cat]);

        function download_completed() {
            downloaded++;
            if (downloaded >= 1) {
                app.loadding('close');


                customers_cat[customers_cat.length] = {
                    code: 'ALL',
                    name: 'Tất cả danh mục'
                };
                branches[branches.length] = {
                    code: 'ALL',
                    name: 'Tất cả chi nhánh'
                };

                txt_s_cat.jqxDropDownList({source: customers_cat});
                txt_s_branch.jqxDropDownList({source: branches});

                txt_s_cat.jqxDropDownList('selectItem', 'ALL');
                txt_s_branch.jqxDropDownList('selectItem', 'ALL');

                table_source.localdata = customers;
                table.jqxGrid('updatebounddata', 'cells');
            }
        }


        download_data(urls.url_apis.customer_cat, function (result) {
            if (result['success']) {
                customers_cat = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
    };

    CustomerAPP.createUI = function () {
        //
        windows_sent.jqxWindow({
            position: {x: (($(window).width() - 400) / 2), y: '10%'},
            width: 400,
            resizable: false, isModal: true,
            modalOpacity: 0.3,
            cancelButton: btn_cancel_sent,
            autoOpen: false
        });
        btn_submit_sent.jqxButton({
            height: '30px',
            template: 'success'
        });
        btn_cancel_sent.jqxButton({
            height: '30px',
            template: 'danger'
        });
        content_sent.jqxTextArea({
            width: '100%',
            height: 200
        });
        var renderText = function (text, value) {
            if (value < 55) {
                return "<span class='jqx-progressbar-text' style='color: #333;'>" + text + "</span>";
            }
            if (value == 100) {
                return "<span class='jqx-progressbar-text' style='color: #fff;'>Hoàn thành!</span>";
            }
            return "<span class='jqx-progressbar-text' style='color: #fff;'>" + text + "</span>";
        };
        processBar_sent.jqxProgressBar({
            width: 100,
            height: 15,
            value: 0,
            showText: true,
            renderText: renderText,
            animationDuration: 30,
            theme: 'light'
        });
        //
        $(".sidebar-item").jqxExpander({width: '100%'});
        txt_s_code.jqxInput({width: '100%', height: 30});
        txt_s_name.jqxInput({width: '100%', height: 30});
        txt_s_debt.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0,
            decimalDigits: 0,
            max: 9999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_s_hit.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0,
            decimalDigits: 0,
            max: 9999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            symbolPosition: 'right'
        });
        txt_s_cat.jqxDropDownList({
            source: customers_cat,
            width: '100%',
            height: 30,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: ''
        });
        txt_s_branch.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            placeHolder: '',
            dropDownVerticalAlignment: 'top'
        });

        btn_add.jqxButton({height: 28, template: 'primary'});
        btn_sent_sms.jqxButton({height: 28, template: 'primary'});
        btn_delete.jqxButton({height: 28, template: 'primary'});
        btn_edit.jqxButton({height: 28, template: 'primary'});
        btn_export_excel.jqxButton({height: 28, template: 'primary'});
        btn_export_print.jqxButton({height: 28, template: 'primary'});

        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            container_toolbar.append(lb_table);
            container_toolbar.append(btn_export_print);
            container_toolbar.append(btn_export_excel);
            container_toolbar.append(btn_delete);
            container_toolbar.append(btn_edit);
            container_toolbar.append(btn_add);
            container_toolbar.append(btn_sent_sms);
            toolbar.append(container_toolbar);
        }

        var initrowdetails = function (index, parentElement, gridElement, datarecord) {
            //console.log(parentElement);
            datarecord = table.jqxGrid('getrowdata', index);
            var tabsdiv = null;
            var container_invoice = null;
            tabsdiv = $($(parentElement).children()[0]);
            if (tabsdiv != null) {
                container_invoice = tabsdiv.find('.container_invoice');
                //Danh sách sản phẩm
                $(tabsdiv).jqxTabs({width: (table.find('.jqx-grid-content').width() - 35), height: 310});

                var table_products = $('<div></div>');
                container_invoice.append(table_products);
                table_products.jqxGrid({
                    width: 'calc(100% - 2px)',
                    height: 'calc(100% - 2px)',
                    selectionmode: 'none',
                    columnsResize: true,
                    rowsheight: 40,
                    columnsheight: 40,
                    columns: [
                        {
                            text: 'TT',
                            dataField: 'id',
                            width: '35'
                        }, {
                            text: 'Ngày tạo',
                            dataField: 'create_at',
                            width: '130'
                        }, {
                            text: 'Mã HĐ',
                            dataField: 'code',
                            width: '150'
                        }, {
                            text: 'Loại HD',
                            dataField: 'type',
                            width: '120',
                            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                                if (type_invoice[value] != undefined) {
                                    return "<div class='price_sale-cell' style='font-weight: normal;text-align: left'>" + type_invoice[value] + "</div>";
                                } else {
                                    return "<div class='price_sale-cell' style='font-weight: normal;text-align: left'>" + value + "</div>";
                                }
                            }
                        }, {
                            text: 'Tài khoản',
                            dataField: 'finance_cat',
                            width: '100',
                            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                                return '<div class="price_sale-cell" style="text-align: left;font-weight: inherit;">'+app.getNameByCode(value,finance_cats)+'</div>';
                            }
                        },
                        {
                            text: 'Giá trị',
                            dataField: 'total_price',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: 'Thanh toán',
                            dataField: 'total_pay',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        },
                        {
                            text: 'Nợ lại',
                            dataField: 'price',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        },
                        {
                            text: ' ',
                            dataField: 'other'
                        }
                    ]
                });

                //Event
                table_products.jqxGrid('showloadelement');
                download_data_where(urls.url_apis.select, {
                    table: "invoices",
                    select: "WHERE customer LIKE '" + datarecord['code'] + "' ORDER BY id DESC",
                    data: "*"
                }, table_products, function (result) {
                    if (result['success']) {
                        var table_x = result['sent'];
                        var data_result = result['data'];
                        table_x.jqxGrid('clear');
                        for (var i = 0; i < data_result.length; i++) {
                            data_result[i]['number_rev'] = 0;
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
                {name: 'id', type: 'string'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'phone', type: 'string'},
                {name: 'email', type: 'string'},
                {name: 'customer_cat', type: 'string'},
                {name: 'customer_cat_name', type: 'string'},
                {name: 'hit', type: 'float'},
                {name: 'debt', type: 'float'},
                {name: 'point', type: 'float'},
                {name: 'price', type: 'float'},
                {name: 'id_facebook', type: 'string'},
                {name: 'address', type: 'string'},
                {name: 'id_branch', type: 'string'},
                {name: 'birthday', type: 'string'},
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            pageSize: 20,
            rowsheight: 40,
            columnsheight: 40,
            altRows: true,
            pageable: false,
            height: '100%',
            width: '100%',
            filterable: true,
            autoshowfiltericon: true,
            sortable: true,
            columnsResize: true,
            source: table_dataAdapter,
            selectionmode: 'checkbox',
            rowdetails: true,
            rowdetailstemplate: {
                rowdetails: "<div class='content-detail-grid'>" +
                "<ul style='margin-left: 30px;'>" +
                "<li>Công nợ chi tiết</li>" +
                "</ul>" +
                "<div class='container_invoice'></div>" +
                "</div>",
                rowdetailsheight: 330
            },
            initrowdetails: initrowdetails,
            columns: [
                {
                    text: 'ID',
                    dataField: 'id',
                    width: '50',
                },
                {
                    text: 'Mã',
                    dataField: 'code',
                    width: '90',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (rowdata['id_facebook'] == '') {
                            return '<div style="font-weight: normal;text-align: left;" class="price_sale-cell price_sale-row-' + row + '"><i class="fa fa-facebook-official f-grid"></i> ' + value + '</div>';
                        } else {
                            return '<div style="font-weight: normal;text-align: left;" class="price_sale-cell price_sale-row-' + row + '"><i style="color: #0a73a7" class="fa fa-facebook-official f-grid"></i> ' + value + ' </div>';
                        }
                    }
                }, {
                    text: 'Tên khách hàng',
                    dataField: 'name',
                    width: '150',
                    aggregates: ['count'], align: 'left',
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['count'] == null) {
                            aggregates['count'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;'>" + aggregates['count'] + " khách hàng</div>";
                    },
                }, {
                    text: 'Điện thoại',
                    dataField: 'phone',
                    width: '110',
                    aggregatesrenderer: function (aggregates, column, element) {
                        return "<div style='text-align:right;padding-top: 4px;font-weight: bold;'>Tổng cộng: </div>";
                    }
                }, {
                    text: 'Chi nhánh',
                    dataField: 'id_branch',
                    width: '200',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        var brand_name = app.getNameByCode(value, branches);
                        if (brand_name != null) {
                            return '<div style="font-weight: normal;text-align: left;" class="price_sale-cell price_sale-row-' + row + '">' + brand_name + '</div>';
                        } else {
                            return '<div style="font-weight: normal;text-align: left;" class="price_sale-cell price_sale-row-' + row + '">' + value + ' </div>';
                        }
                    }
                }, {
                    text: 'Lượt mua',
                    dataField: 'hit',
                    width: '90',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'], align: 'right',
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    },
                }, {
                    text: 'Điểm',
                    dataField: 'point',
                    width: '80',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'], align: 'right',
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    },
                }, {
                    text: 'Nợ lại',
                    dataField: 'debt',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'], align: 'right',
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    },

                }, {
                    text: 'Tổng mua',
                    dataField: 'price',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'], align: 'right',
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sum'] == null) {
                            aggregates['sum'] = 0;
                        }
                        return "<div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sum'] + "</div>";
                    },
                }, {
                    text: 'Email',
                    dataField: 'email',
                    width: '150',
                }, {
                    text: 'Địa chỉ',
                    dataField: 'address',
                    width: '150',
                }, {
                    text: 'Ngày sinh',
                    dataField: 'birthday',
                    width: '110',
                }, {
                    text: 'Danh mục',
                    dataField: 'customer_cat_name',
                    width: '90',
                },
                {
                    text: 'Ghi chú',
                    dataField: 'note',
                },
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 30,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };


    CustomerAPP.createEvent = function () {
        //Filter
        var loading = false;

        function request_filter() {
            if (loading) {
                return;
            }
            var branch_f = txt_s_branch.jqxDropDownList('val');
            var cat_f = txt_s_cat.jqxDropDownList('val');
            var debt_f = txt_s_debt.jqxNumberInput('val');
            var hit_f = txt_s_hit.jqxNumberInput('val');
            var code_f = txt_s_code.jqxInput('val');
            var name_f = txt_s_name.jqxInput('val');

            if (branch_f !== 'ALL') {
                branch_f = " AND customer.id_branch LIKE '" + branch_f + "'";
            } else {
                branch_f = '';
            }
            if (cat_f !== 'ALL') {
                cat_f = " AND customer.customer_cat LIKE '" + cat_f + "'";
            } else {
                cat_f = '';
            }
            if (debt_f !== 'ALL') {
                debt_f = " AND customer.debt >= " + debt_f + "";
            } else {
                debt_f = '';
            }

            if (hit_f !== 'ALL') {
                hit_f = " AND customer.hit >= " + hit_f + "";
            } else {
                hit_f = '';
            }
            if (code_f !== '') {
                code_f = " AND customer.phone LIKE '" + code_f + "'";
            } else {
                code_f = '';
            }
            if (name_f !== '') {
                name_f = " AND customer.name_f LIKE '%" + name_f + "%'";
            } else {
                name_f = '';
            }

            var string_where = name_f + code_f + hit_f + debt_f + cat_f + branch_f;
            table.jqxGrid('showloadelement');
            loading = true;
            download_data_where(urls.url_apis.select, {
                table: "customer LEFT JOIN customer_cat ON customer_cat.code=customer.customer_cat",
                select: "WHERE 1 " + string_where + ' ORDER BY customer.id DESC',
                data: "customer.*,customer_cat.name as 'customer_cat_name'"
            }, null, function (result) {
                if (result['success']) {
                    table_source.localdata = result['data'];
                    table.jqxGrid('updatebounddata', 'cells');
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                table.jqxGrid('hideloadelement');
                loading = false;
            });
        }

        //event
        $('#s_name').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#s_code').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });

        $('#s_branch').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#s_cat').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#s_hit').on('keyup', function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#s_debt').on('keyup', function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        //input selected
        $('input').click(function () {
            $(this).select();
        });
        //
        btn_sent_sms.click(function () {
            windows_sent.jqxWindow('open');
            processBar_sent.hide();
            processBar_sent.jqxProgressBar({value: 0});
        });
        btn_submit_sent.click(function () {
            var url_sent = '<?php echo \App\CusstomPHP\CustomURL::route('sent_message'); ?>';

            function sentMessage(index, data, message) {
                var data_row = table.jqxGrid('getrowdatabyid', data[index]);
                processBar_sent.jqxProgressBar({value: parseInt(index / (data.length - 1) * 100)});
                if (windows_sent.jqxWindow('isOpen')) {
                    if (data_row['id_facebook'] != '') {
                        add_data(url_sent, {
                            message: message,
                            messenger_user_id: data_row['id_facebook']
                        }, function (result) {
                            if (index < data.length - 1) {
                                sentMessage(index + 1, data, message);
                            } else {
                                btn_submit_sent.html('<i class="fa fa-send"></i> Gửi ngay');
                            }
                        });
                    } else {
                        if (index < data.length - 1) {
                            sentMessage(index + 1, data, message);
                        } else {
                            btn_submit_sent.html('<i class="fa fa-send"></i> Gửi ngay');
                        }
                    }
                } else {
                    btn_submit_sent.html('<i class="fa fa-send"></i> Gửi ngay');
                }
            }

            //set data
            var data_selected = table.jqxGrid('getselectedrowindexes');
            if (data_selected.length == 0) {
                app.notify("Chưa có khách nào được chọn!", 'warning');
                return;
            }
            btn_submit_sent.html('<i class="fa fa-spin fa-spinner"></i> Đang gửi...');
            processBar_sent.show();
            sentMessage(0, data_selected, content_sent.jqxTextArea('val'));
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
        CustomerAPP.createData();
        CustomerAPP.createUI();
        CustomerAPP.createEvent();
    }
</script>