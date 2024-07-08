<div class="view">
    <div id="loader_view"></div>
    <div id="sidebar">
        <div class="sidebar-item">
            <div>Tìm kiếm thông tin</div>
            <div>
                <div>
                    <label>Mã phiếu:</label>
                    <input id="s_code">
                </div>
                <div>
                    <label>Theo mã, tên khách hàng:</label>
                    <input id="s_name">
                </div>
                <div>
                    <label>Loại thu chi:</label>
                    <input id="s_type">
                </div>
                <div>
                    <label>Chi nhánh:</label>
                    <div id="s_branch"></div>
                </div>
                <div>
                    <label>Tài khoản:</label>
                    <div id="s_acc"></div>
                </div>
                <div>
                    <label>Người tạo:</label>
                    <div id="s_user"></div>
                </div>
                <label>Từ ngày:</label>
                <div id="date_create1"></div>
                <label>Tới ngày:</label>
                <div id="date_create2" style="margin-bottom: 10px;margin-bottom: 50px;"></div>
            </div>
        </div>
    </div>
    <div id="content-table">
        <div id="table"></div>
    </div>
    <div id="window_phieuthuchi">
        <div>
            <div id="title_thuchi">Thêm phiếu thu chi</div>
        </div>
        <div>
            <div>
                <label>Loại phiếu:</label>
                <div id="loaiphieu"></div>
                <label>Chọn loại đối tượng:</label>
                <select id="loaidt">
                    <option value="KH">Khách hàng</option>
                    <option value="NCC">Nhà cung cấp</option>
                    <option value="KHAC">Khác</option>
                </select>
                <label>Đối tượng áp dụng:</label>
                <div id="dt"></div>
                <label>Giá trị thanh toán:</label>
                <input id="giatri">
                <label>Đã thanh toán:</label>
                <input id="giatri_pay">
                <label>Tài khoản:</label>
                <div id="taikhoan"></div>
                <label>Ghi chú:</label>
                <textarea id="ghichu"></textarea>

                <button id="btn_submit" style="border-radius:0;float: left; margin-top: 10px;"><i
                            class="fa fa-check-circle"></i> Lưu phiếu
                </button>
                <button id="btn_cancel" style="border-radius:0; float: right;margin-top: 10px;"><i
                            class="fa fa-ban"></i> Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    var FinanceAPP = {};
    var invoices = null;
    var invoices_type = null;
    var customers_cat = null;
    var customers = null;
    var users = null;
    var finance_cat = null;
    var suppliers = null;
    var branches = null;
    var loaiphieu = $('#loaiphieu');
    var loaidt = $('#loaidt');
    var dt = $('#dt');
    var giatri = $('#giatri');
    var giatri_pay = $('#giatri_pay');
    var taikhoan = $('#taikhoan');
    var s_acc = $('#s_acc');
    var ghichu = $('#ghichu');
    var txt_date_create1 = $('#date_create1');
    var txt_date_create2 = $('#date_create2');

    var window_phieuthuchi = $('#window_phieuthuchi');
    var CHEDO = "THU";

    var txt_s_code = $('#s_code');
    var txt_s_name = $('#s_name');
    var txt_s_branch = $('#s_branch');
    var txt_s_user = $('#s_user');
    var txt_s_type = $('#s_type');
    var table = $('#table');
    var table_dataAdapter;
    var table_source;
    var btn_submit = $('#btn_submit');
    var btn_cancel = $('#btn_cancel');
    var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
    var btn_themphieuthu = $("<button><i class='fa fa-plus'></i> Thêm phiếu thu</button>");
    var btn_themphieuchi = $("<button><i class='fa fa-plus'></i> Thêm phiếu chi</button>");
    var btn_export_excel = $("<button><i class='fa fa-file-excel-o'></i> Xuất Excel</button>");
    var btn_export_print = $("<button><i class='fa fa-print'></i> In</button>");
    var lb_table = $("<div class='table-title'><span>Quản lý danh sách tài chính</span></div>");


    FinanceAPP.createData = function () {
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 5) {
                txt_s_branch.jqxDropDownList({source: branches});
                loaiphieu.jqxComboBox({source: invoices_type});

                txt_s_user.jqxDropDownList({source: users});
                taikhoan.jqxDropDownList({source: finance_cat});
                s_acc.jqxDropDownList({source: finance_cat});

                txt_s_user.jqxDropDownList('selectItem', me.username);
                txt_s_branch.jqxDropDownList('selectItem', me.branch);
                taikhoan.jqxDropDownList('selectItem', settings.acc_default);
                s_acc.jqxDropDownList('selectItem', settings.acc_default);
            }
        }

        branches = JSON.parse(localStorage.getItem(tables.branches));
        finance_cat = JSON.parse(localStorage.getItem(tables.finance_cat));
        //Server
        download_data_where(urls.url_apis.select, {
            table: "invoices",
            select: "WHERE 1 GROUP BY type",
            data: "type AS 'code',type AS 'name'"
        }, null, function (result) {
            if (result['success']) {
                invoices_type = result['data'];
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
            download_completed();
        });
        download_data_where(urls.url_apis.select, {
            table: "customer",
            select: "WHERE 1",
            data: "code,name"
        }, null, function (result) {
            if (result['success']) {
                customers = result['data'];
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
            download_completed();
        });
        download_data_where(urls.url_apis.select, {
            table: "supplier",
            select: "WHERE 1",
            data: "code,name"
        }, null, function (result) {
            if (result['success']) {
                suppliers = result['data'];
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
            download_completed();
        });
        download_data(urls.url_apis.customer_cat, function (result) {
            if (result['success']) {
                customers_cat = result['data'];
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

    FinanceAPP.createUI = function () {
        window_phieuthuchi.jqxWindow({
            position: {x: (($(window).width() - 500) / 2), y: '1%'},
            width: 500,
            isModal: true,
            cancelButton: btn_cancel,
            autoOpen: false,
        });
        //Button
        btn_submit.jqxButton({width: '49%', height: 35, template: 'success'});
        btn_cancel.jqxButton({width: '49%', height: 35, template: 'danger'});
        //Input
        ghichu.jqxTextArea({
            width: '100%',
            height: 60,
        });
        loaiphieu.jqxComboBox({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: 488,
            height: 30,
            placeHolder: '',
            searchMode: 'containsignorecase',
            theme: 'light'
        });
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
        taikhoan.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: 488,
            height: 30,
            placeHolder: '',
            theme: 'light'
        });
        s_acc.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            placeHolder: '',
            theme: 'light'
        });
        loaidt.jqxDropDownList({
            width: 488,
            height: 30,
            placeHolder: '',
            theme: 'light'
        });
        dt.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: 488,
            height: 30,
            placeHolder: '',
            filterable: true,
            filterPlaceHolder: 'Tìm kiếm...',
            searchMode: 'containsignorecase',
            theme: 'light'
        });


        $(".sidebar-item").jqxExpander({width: '100%'});
        txt_s_code.jqxInput({width: '100%', height: 30});
        txt_s_name.jqxInput({width: '100%', height: 30});
        giatri.jqxNumberInput({
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
        giatri_pay.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0,
            theme: 'light',
            decimalDigits: 0,
            max: 9999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });

        txt_s_type.jqxInput({width: '100%', height: 30,});

        txt_s_branch.jqxDropDownList({
            source: branches,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            placeHolder: ''
        });
        txt_s_user.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "username",
            width: '100%',
            height: 30,
            placeHolder: ''
        });
        btn_themphieuthu.jqxButton({height: 28, template: 'primary'});
        btn_themphieuchi.jqxButton({height: 28, template: 'primary'});
        btn_export_excel.jqxButton({height: 28, template: 'primary'});
        btn_export_print.jqxButton({height: 28, template: 'primary'});

        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            container_toolbar.append(lb_table);
            container_toolbar.append(btn_export_print);
            container_toolbar.append(btn_export_excel);
            container_toolbar.append(btn_themphieuchi);
            container_toolbar.append(btn_themphieuthu);
            toolbar.append(container_toolbar);
        }

        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'string'},
                {name: 'code', type: 'string'},
                {name: 'create_at', type: 'string'},
                {name: 'type', type: 'string'},
                {name: 'customer_name', type: 'string'},
                {name: 'price', type: 'number'},
                {name: 'total_pay', type: 'number'},
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
            selectionmode: 'singlerow',
            showaggregates: true,
            showstatusbar: true,
            statusbarheight: 50,
            columns: [
                {
                    text: 'ID',
                    dataField: 'id',
                    width: '60',
                },
                {
                    text: 'Mã phiếu',
                    dataField: 'code',
                    width: '100',
                }, {
                    text: 'Thời gian',
                    dataField: 'create_at',
                    width: '120',
                }, {
                    text: 'Loại thu chi',
                    dataField: 'type',
                    width: '170',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (type_invoice[value] !== undefined) {
                            return '<div style="padding: 10px 0 0 5px;display:block;margin-right: 2px; ">' + type_invoice[value] + '</div>';
                        } else {
                            return '<div style="padding: 10px 0 0 5px;display:block;margin-right: 2px; ">' + value + '</div>';
                        }
                    }
                }, {
                    text: 'Khách hàng',
                    dataField: 'customer_name',
                    width: '200',
                }, {
                    text: 'Tổng tiền',
                    dataField: 'price',
                    width: '130',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    align: 'right',
                    aggregates: [{
                        'sumx':
                            function (aggregatedValue, currentValue, column, record) {
                                if (currentValue >= 0) {
                                    return currentValue + aggregatedValue;
                                } else {
                                    return aggregatedValue;
                                }
                            }
                    }],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sumx'] == null) {
                            aggregates['sumx'] = 0;
                        }
                        return "<div><h3 style='margin: 0;'>Tổng thu</h3></div><div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sumx'] + "</div>";
                    }
                }, {
                    text: 'Thanh toán',
                    dataField: 'total_pay',
                    width: '130',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    align: 'right',
                    aggregates: [{
                        'sumy':
                            function (aggregatedValue, currentValue, column, record) {
                                if (record.price < 0) {
                                    return record.price + aggregatedValue;
                                } else {
                                    return aggregatedValue;
                                }
                            }
                    }],
                    aggregatesrenderer: function (aggregates, column, element) {
                        if (aggregates['sumy'] == null) {
                            aggregates['sumy'] = 0;
                        }
                        return "<div><h3 style='margin: 0;'>Tổng chi</h3></div><div style='padding-top: 4px;font-weight: bold;color: #d60f01'>" + aggregates['sumy'] + "</div>";
                    }
                }, {
                    text: 'Ghi chú',
                    dataField: 'note',
                }
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };


    FinanceAPP.createEvent = function () {
        //THay đổi đồi tượng
        $('#loaidt').on('change', function (event) {
            if (loaidt.jqxDropDownList('val') == 'KH') {
                dt.jqxDropDownList({source: customers});
            }
            if (loaidt.jqxDropDownList('val') == 'NCC') {
                dt.jqxDropDownList({source: suppliers});
            }
            dt.jqxDropDownList('clearSelection');
        });

        //Lưu máy chủ
        btn_submit.click(function () {
            var data_form = {
                code: "",
                branch: me.branch,
                customer: dt.jqxDropDownList('val'),
                customer_name: dt.jqxDropDownList('getSelectedItem')['label'],
                type: loaiphieu.jqxComboBox('val'),
                products: '[]',
                total_price: giatri.jqxNumberInput('val'),
                total_pay: giatri_pay.jqxNumberInput('val'),
                other_price: 0,
                discount: 0,
                state: "SUCCESS",
                note: ghichu.jqxTextArea('val'),
                user: me['username']
            };
            //Kiểm tra chế độ
            if (CHEDO == 'THU') {
                data_form['code'] = 'PHT/';
            } else {
                data_form['code'] = 'PHC/';
                data_form['total_price'] = -data_form['total_price'];
            }

            btn_submit.jqxButton({disabled: true});
            add_data(urls.url_apis.finance, data_form, function (result) {
                if (result['success']) {
                    app.notify("Thêm phiếu thu chi thành công!", 'success');
                    //var mahoadon = result['data']['code'];
                    FinanceAPP.createData();
                    window_phieuthuchi.jqxWindow('close');
                } else {
                    app.notify("Thêm phiếu thu chi không thành công!", 'warning');
                    return false;
                }
                btn_submit.jqxButton({disabled: false});
            });
        });

        btn_themphieuthu.click(function () {
            window_phieuthuchi.jqxWindow('open');
            CHEDO = 'THU';
            $('#title_thuchi').text('Thêm phiếu thu');
            btn_submit.html("<i class='fa fa-save'></i> Lưu phiếu thu");
        });
        btn_themphieuchi.click(function () {
            window_phieuthuchi.jqxWindow('open');
            CHEDO = 'CHI';
            $('#title_thuchi').text('Thêm phiếu chi');
            btn_submit.html("<i class='fa fa-save'></i> Lưu phiếu chi")
        });

        btn_cancel.click(function () {
            FinanceAPP.showSidebar(false);
        });


        //Filter
        function request_filter() {
            var branch_f = txt_s_branch.jqxDropDownList('val');
            var acc_f = s_acc.jqxDropDownList('val');
            var customer_f = txt_s_name.jqxInput('val');
            var type_f = txt_s_type.jqxInput('val');
            var user_f = txt_s_user.jqxDropDownList('val');
            var dateS_f = txt_date_create1.jqxDateTimeInput('val');
            var dateE_f = txt_date_create2.jqxDateTimeInput('val');
            var code_f = txt_s_code.jqxInput('val');

            if (branch_f !== 'ALL') {
                branch_f = " AND branch LIKE '" + branch_f + "'";
            } else {
                branch_f = '';
            }
            if (customer_f !== 'ALL') {
                customer_f = " AND (customer LIKE '%" + customer_f + "%' OR customer_name LIKE '%" + customer_f + "%')";
            } else {
                customer_f = '';
            }
            if (user_f !== 'ALL') {
                user_f = " AND user LIKE '" + user_f + "'";
            } else {
                user_f = '';
            }

            if (code_f !== '') {
                code_f = " AND code LIKE '" + code_f + "'";
            } else {
                code_f = '';
            }

            if (type_f !== '') {
                type_f = " AND type LIKE '%" + type_f + "%'";
            } else {
                type_f = '';
            }
            if (acc_f !== '') {
                acc_f = " AND finance_cat LIKE '" + acc_f + "'";
            } else {
                acc_f = '';
            }

            dateS_f = " AND STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y')>=STR_TO_DATE('00:00" + txt_date_create1.jqxDateTimeInput('val') + "','%H:%i %d/%m/%Y')";
            dateE_f = " AND STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y')<=STR_TO_DATE('23:59" + txt_date_create2.jqxDateTimeInput('val') + "','%H:%i %d/%m/%Y')";

            var string_where = acc_f + code_f + dateE_f + dateS_f + customer_f + branch_f + user_f + type_f;
            table.jqxGrid('showloadelement');
            download_data_where(urls.url_apis.select, {
                table: "invoices",
                select: "WHERE 1 " + string_where + ' ORDER BY id DESC',
                data: "*,total_price-discount+other_price AS 'price'"
            }, null, function (result) {
                if (result['success']) {
                    invoices = result['data'];
                    for (var i = 0; i < invoices.length; i++) {
                        if (invoices[i]['type'] == 'IMPORT') {
                            invoices[i]['price'] = -parseInt(invoices[i]['price']);
                            invoices[i]['total_pay'] = -parseInt(invoices[i]['total_pay']);
                        }
                    }
                    table_source.localdata = invoices;
                    table.jqxGrid('updatebounddata', 'cells');
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                table.jqxGrid('hideloadelement');
            });
        }

        $('#s_code').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#s_name').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#s_type').keyup(function (e) {
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
        $('#s_branch').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#s_user').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#s_acc').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
    };

    FinanceAPP.showSidebar = function (is_show) {
        if (is_show) {
            $('#sidebar2').animate({'right': '0px'}, 300, function () {
                // Animation complete.
                $('#content-table').css({opacity: '0.06'});
            });
        } else {
            $('#sidebar2').animate({'right': '-350px'}, 200);
            $('#content-table').css({opacity: '1'});
        }
    };


    function view_start() {
        FinanceAPP.createData();
        FinanceAPP.createUI();
        FinanceAPP.createEvent();
    }
</script>