<div class="view">
    <div id="sidebar" style="float: right;width: 26.5%;margin-left: 1%;margin-right: 0;">
        <div class="sidebar-item">
            <div>Thông tin trả hàng</div>
            <div>
                <div>
                    <div style="position: relative;margin-top: 10px;margin-bottom: 5px;">
                        <i class="fa fa-search icon-customer-s"></i>
                        <div id="timkhachhang" class="sale-input-active"
                             style="padding-left: 35px;"></div>
                        <i id="btn_hienthithemKH" class="fa fa-plus ic-find"></i>
                    </div>
                </div>

                <div style="margin-top: 10px;" class="div-sale clearfix">
                    <label class="lable_sale" for="Stienhang">Tổng tiền hàng:</label>
                    <input class="sale-input sale-input-green" id="Stienhang">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Skhuyenmai">Tiền khuyến mãi:</label>
                    <input class="sale-input sale-input-active" id="Skhuyenmai">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Sthukhac">Tiền thu khác:</label>
                    <input class="sale-input sale-input-active" id="Sthukhac">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Stientra">Tiền trả hàng:</label>
                    <input class="sale-input sale-input-red" id="Stientra">
                </div>
                <div style="display: none;" class="div-sale clearfix">
                    <label class="lable_sale" for="Smuamoi">Tổng mua mới:</label>
                    <input class="sale-input" id="Smuamoi">
                </div>
                <div class="div-sale clearfix">
                    <label id="lb_thanhtoan" class="lable_sale" for="Sthanhtoan">Tổng thanh toán:</label>
                    <input class="sale-input" id="Sthanhtoan">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Skhachthanhtoan">Khách thanh toán:</label>
                    <input class="sale-input sale-input-active sale-input-yellow" id="Skhachthanhtoan">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Snolai">Khách nợ lại:</label>
                    <input class="sale-input" id="Snolai">
                </div>
                <div>
                    <label for="ghichu">Ghi chú:</label>
                    <textarea id="ghichu"></textarea>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px;">
            <button style="font-size: 17px;border-radius: 0;" id="luuhoadon"><i class="fa fa-print"></i> Lưu hóa đơn
                (F9)
            </button>
        </div>
    </div>
    <div id="content-table" style="float: left;width: 72%;">
        <div class="input-product-top">
            <h2>Trả hàng</h2>

            <div class="container-xx">
                <i class="fa fa-search"
                   style="position: absolute;left: 0;z-index: 99;top: 0;height: 15px;width: 15px;padding: 12px 9px;"></i>

                <div id="timsanpham" style=""></div>
            </div>
            <div class="container-xx" style="margin-left: 0;">
                <input id="soluong" style="">
            </div>
            <div class="container-xx" style="margin-right: 0;float: right;">
                <button id="dongbo" style=""><i class="fa fa-cloud"></i> Đồng bộ</button>
            </div>
        </div>
        <div id="table1"></div>
        <div id="table2"></div>
    </div>


    <div id="popthemkhachhang">
        <div>
            <span>Thông tin khách hàng</span>
        </div>
        <div>
            <div>
                <div style="width: 48%;float: left;display: inline;">
                    <div>
                        <label>Họ tên:</label>
                        <input id="hoten_kh">
                    </div>
                    <div>
                        <label>Số điện thoại:</label>
                        <div id="sdt_kh"></div>
                    </div>
                    <div>
                        <label>Dư nợ:</label>
                        <input id="no_kh">
                    </div>
                    <div>
                        <label>Địa chỉ:</label>
                        <input id="diachi_kh">
                    </div>
                    <div>
                        <label>Đối tượng:</label>
                        <div id="danhmuc_kh"></div>
                    </div>
                </div>
                <div style="width: 48%;float: right;display: inline;">
                    <div>
                        <label>Email:</label>
                        <input id="email_kh">
                    </div>
                    <div>
                        <label>Ngày sinh:</label>
                        <input id="ngaysinh_kh">
                    </div>
                    <div>
                        <label>Facebook:</label>
                        <input id="facebook_kh">
                    </div>
                    <div>
                        <label>Lượt mua:</label>
                        <input id="hit_kh">
                    </div>
                    <div>
                        <label>Điểm tích:</label>
                        <input id="point_kh">
                    </div>
                </div>
            </div>
            <div style="width: 100%;float: left;">
                <label>Ghi chú:</label>
                <textarea id="ghichu_kh"></textarea>
            </div>
            <div style="margin-top: 10px;text-align: right;width: 100%;float: left;">
                <button id="btn_themkhachhang">Lưu lại</button>
                <button id="btn_huythemkhachhang">Hủy bỏ</button>
            </div>
        </div>
    </div>

    <div id="pophoadon">
        <div>
            <span>Chọn hóa đơn trả hàng</span>
        </div>
        <div>
            <div>
                <div style="width: 210px;float: left;border: 1px solid rgba(211,211,211,0.48);">
                    <div class="sidebar-item">
                        <div>Tìm kiếm hóa đơn</div>
                        <div>
                            <label>Mã hóa đơn:</label>
                            <input id="search_code" class="input-sidebar">
                            <label>Tên/mã hàng:</label>
                            <input id="search_pname" class="input-sidebar">
                            <label>Chi nhánh:</label>
                            <div id="search_branch" class="input-sidebar"></div>
                            <label>Khách hàng:</label>
                            <div id="search_customer" class="input-sidebar"></div>
                            <label>Nhân viên:</label>
                            <div id="search_user" class="input-sidebar"></div>
                            <label>Từ ngày:</label>
                            <div id="search_date_create1"></div>
                            <label>Tới ngày:</label>
                            <div id="search_date_create2" style="margin-bottom: 10px;"></div>
                        </div>
                    </div>
                </div>
                <div style="float: right;width: calc(100% - 220px)">
                    <div id="table_hoadon"></div>
                    <button style="margin-top: 10px; font-size: 15px;float: right" id="btn_chonhoadon">
                        <i class="fa fa-check-circle"></i> Lựa chọn
                    </button>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>


</div>


<script>
    var ReturnApp = {};
    var table1 = $('#table1');
    var table2 = $('#table2');
    var table_hoadon = $('#table_hoadon');
    var products_list = null;
    var customers = null;
    var table_dataAdapter;
    var table_dataAdapter2;
    var table_hoadon_dataAdapter;
    var table_source;
    var table_source2;
    var table_hoadon_source;
    var template_bill1 = null;
    var template_bill2 = null;
    var customer_cats = null;
    var branches = null;
    var users = null;
    var txt_timsanpham = $('#timsanpham');
    var txt_soluong = $('#soluong');
    var txt_timkhachhang = $('#timkhachhang');
    var txt_tienhang = $('#Stienhang');
    var txt_khuyenmai = $('#Skhuyenmai');
    var txt_thukhac = $('#Sthukhac');
    var txt_muamoi = $('#Smuamoi');
    var txt_thanhtoan = $('#Sthanhtoan');
    var txt_tientra = $('#Stientra');
    var txt_khachthanhtoan = $('#Skhachthanhtoan');
    var txt_nolai = $('#Snolai');
    var txt_ghichu = $('#ghichu');
    var txt_hoten_kh = $('#hoten_kh');
    var txt_no_kh = $('#no_kh');
    var txt_sdt_kh = $('#sdt_kh');
    var txt_diachi_kh = $('#diachi_kh');
    var txt_danhmuc_kh = $('#danhmuc_kh');
    var txt_email_kh = $('#email_kh');
    var txt_point_kh = $('#point_kh');
    var txt_hit_kh = $('#hit_kh');
    var txt_ngaysinh_kh = $('#ngaysinh_kh');
    var txt_facebook_kh = $('#facebook_kh');
    var txt_ghichu_kh = $('#ghichu_kh');
    var btn_luuhoadon = $('#luuhoadon');
    var btn_dongbo = $('#dongbo');
    var btn_chonhoadon = $('#btn_chonhoadon');
    var btn_themkhachhang = $('#btn_themkhachhang');
    var btn_huythemkhachhang = $('#btn_huythemkhachhang');
    var btn_hienthithemKH = $('#btn_hienthithemKH');
    var popthemkhachhang = $('#popthemkhachhang');
    var pophoadon = $('#pophoadon');

    var txt_search_pname = $('#search_pname');
    var txt_search_code = $('#search_code');
    var txt_search_date_create1 = $('#search_date_create1');
    var txt_search_date_create2 = $('#search_date_create2');
    var cb_search_branch = $('#search_branch');
    var cb_search_customer = $('#search_customer');
    var cb_search_user = $('#search_user');

    ReturnApp.createData = function () {
        app.loadding('open');
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 5) {
                app.loadding('close');
                txt_timsanpham.jqxComboBox({source: products_list});
                txt_timkhachhang.jqxComboBox({source: customers});
                txt_sdt_kh.jqxComboBox({source: customers});

                customers[customers.length] = {
                    code: 'ALL',
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


                cb_search_branch.jqxDropDownList({source: branches});
                cb_search_customer.jqxDropDownList({source: customers});
                cb_search_user.jqxDropDownList({source: users});

                cb_search_user.jqxDropDownList('selectItem', 'ALL');
                cb_search_customer.jqxDropDownList('selectItem', 'ALL');
                cb_search_branch.jqxDropDownList('selectItem', me['branch']);
            }
        }

        //local
        customer_cats = JSON.parse(localStorage.getItem(tables.customer_cat));
        txt_danhmuc_kh.jqxDropDownList({source: customer_cats});
        branches = JSON.parse(localStorage.getItem(tables.branches));
        //data from server
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE branch LIKE '" + me.branch + "'",
            data: "code,name AS 'pname',price_main,number AS 'numbermax'"
        }, null, function (result) {
            if (result['success']) {
                products_list = result['data'];
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
        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE name LIKE 'bill_template' AND branch LIKE '" + me.branch + "'",
            data: "value"
        }, null, function (result) {
            if (result['success']) {
                template_bill1 = result['data'][0]['value'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE name LIKE 'return_template' AND branch LIKE '" + me.branch + "'",
            data: "value"
        }, null, function (result) {
            if (result['success']) {
                template_bill2 = result['data'][0]['value'];
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


    ReturnApp.createUI = function () {
        //pop hoa dơn
        txt_search_code.jqxInput({width: '100%', height: 30});
        txt_search_pname.jqxInput({width: '100%', height: 30});
        var date_start = null;
        if (new Date().getMonth() === 0) {
            date_start = new Date(new Date().getFullYear() - 1, 11, new Date().getDate());
        } else {
            date_start = new Date(new Date().getFullYear(), new Date().getMonth() - 1, new Date().getDate());
        }
        txt_search_date_create1.jqxDateTimeInput({
            width: '100%', height: 30,
            value: date_start,
            dropDownVerticalAlignment: "top"
        });
        txt_search_date_create2.jqxDateTimeInput({
            width: '100%', height: 30,
            dropDownVerticalAlignment: "top"
        });
        cb_search_branch.jqxDropDownList({
            source: branches,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            theme: 'light',
            placeHolder: ''
        });
        cb_search_customer.jqxDropDownList({
            source: customers,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            theme: 'light',
            placeHolder: '',
            filterable: true,
            filterPlaceHolder: 'Tìm kiếm...',
            searchMode: 'containsignorecase'
        });
        cb_search_user.jqxDropDownList({
            source: users,
            displayMember: "name",
            valueMember: "username",
            width: '100%',
            height: 30,
            placeHolder: '',
            theme: 'light',
        });
        //windows
        popthemkhachhang.jqxWindow({
            position: {x: (($(window).width() - 550) / 2), y: '10%'},
            width: 550,
            resizable: false,
            isModal: true,
            modalOpacity: 0.3,
            cancelButton: btn_huythemkhachhang,
            autoOpen: false,
        });
        pophoadon.jqxWindow({
            position: {x: (($(window).width() - 800) / 2), y: '10%'},
            width: 800,
            resizable: true,
            isModal: true,
            modalOpacity: 0.5,
            autoOpen: true,
        });

        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        //Input
        txt_hoten_kh.jqxInput({width: '100%', height: 25});
        txt_diachi_kh.jqxInput({width: '100%', height: 25});
        txt_email_kh.jqxInput({width: '100%', height: 25});
        txt_facebook_kh.jqxInput({width: '100%', height: 25});
        txt_hit_kh.jqxInput({width: '100%', height: 25});
        txt_point_kh.jqxInput({width: '100%', height: 25});
        txt_ngaysinh_kh.jqxInput({width: '100%', height: 25});
        txt_sdt_kh.jqxComboBox({
            width: '260px',
            height: 25,
            displayMember: 'phone',
            valueMember: 'phone',
            source: null,
            showArrow: false
        });
        txt_ghichu.jqxTextArea({
            width: '100%',
            height: 40
        });
        txt_ghichu_kh.jqxTextArea({
            width: '100%',
            height: 40
        });
        txt_no_kh.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ", digits: 12,
            symbolPosition: 'right'
        });
        txt_khachthanhtoan.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ", digits: 12,
            symbolPosition: 'right'
        });
        txt_nolai.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0,
            digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right', disabled: true
        });
        txt_khuyenmai.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_thukhac.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_muamoi.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right', disabled: true
        });
        txt_thanhtoan.jqxNumberInput({
            width: '100%',
            height: 26,
            min: -99999999999,
            digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right', disabled: true
        });
        txt_tientra.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right', disabled: true
        });
        txt_tienhang.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right', disabled: true
        });
        txt_soluong.jqxNumberInput({
            width: '70px',
            height: 35,
            min: 0,
            decimalDigits: 0,
            max: 99999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            symbolPosition: 'right'
        });
        btn_dongbo.jqxButton({height: 35, template: 'default'});
        btn_chonhoadon.jqxButton({height: 35, width: 250, template: 'success'});
        txt_timsanpham.jqxComboBox({
            width: '300px',
            dropDownWidth: 325,
            dropDownHeight: 350,
            height: 35,
            source: null,
            theme: 'light',
            displayMember: 'pname',
            valueMember: 'code',
            showArrow: false,
            searchMode: 'containsignorecase',
            placeHolder: "Tìm kiếm sản phẩm",
            renderer: function (index, label, value) {
                var product = products_list[index];
                return '<div style="margin: 3px 0;">' +
                    '<div style="font-weight: bold;width: 100%;">' + product['pname'] + '</div>' +
                    '<div style="width: 100%;margin-top: 3px;font-size: 11px">' +
                    '<span style="width: 50%;display: inline-block;">Mã: ' + product['code'] + '</span>' +
                    '<span style="width: 50%;display: inline-block;">Giá: ' + '<span style="font-weight: 300;">' + parseInt(product['price_main']).toLocaleString('vi-VN') + '</span></span>' +
                    '</div></div>';
            }
        });
        txt_timkhachhang.jqxComboBox({
            width: 'calc(100% - 35px)',
            height: 35,
            source: null,
            theme: 'light',
            displayMember: 'name',
            showArrow: false,
            valueMember: 'code',
            placeHolder: "Tìm kiếm khách hàng",
            searchMode: 'containsignorecase',
            renderSelectedItem: function (index, item) {
                if (item['value'] !== '') {
                    return item['label'] + ' - ' + item['value'];
                }
                return "";
            }
        });
        btn_luuhoadon.jqxButton({width: '100%', height: '55px', template: 'success'});
        btn_themkhachhang.jqxButton({height: '33', template: 'primary'});
        btn_huythemkhachhang.jqxButton({height: '33', template: 'danger'});
        //Combobox
        txt_danhmuc_kh.jqxDropDownList({
            source: null,
            width: '100%',
            height: 25,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: ''
        });
        //Table
        var cellsrenderer_number = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<div class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i class="fa fa-edit f-grid"></i></div>';
        };
        var cellsrenderer_price_sale = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<div class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i class="fa fa-edit f-grid"></i></div>';
        };
        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'number'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'number', type: 'number'},
                {name: 'number_max', type: 'number'},
                {name: 'price_sale', type: 'number'},
                {name: 'price', type: 'number'},
                {name: 'btn_remove', type: 'string'},
            ]
        };
        table_source2 = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'number'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'number', type: 'number'},
                {name: 'number_max', type: 'number'},
                {name: 'price_sale', type: 'number'},
                {name: 'price', type: 'number'},
                {name: 'btn_remove', type: 'string'},
            ]
        };
        table_hoadon_source = {
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
        table_dataAdapter2 = new $.jqx.dataAdapter(table_source2);
        table_hoadon_dataAdapter = new $.jqx.dataAdapter(table_hoadon_source);
        table1.jqxGrid({
            pageSize: 20,
            altRows: true,
            pageable: false,
            height: 'calc(50% - 75px)',
            width: '100%',
            filterable: false,
            autoshowfiltericon: true,
            sortable: false,
            columnsResize: true,
            enablehover: false,
            source: table_dataAdapter,
            selectionmode: 'none',
            rowsheight: 40,
            columnsheight: 40,
            editable: true,
            columns: [
                {
                    text: 'TT',
                    dataField: 'id',
                    width: '50',
                    align: 'center', cellsalign: 'center', editable: false
                },
                {
                    text: 'Mã sản phẩm',
                    dataField: 'code',
                    width: '120', editable: false
                }, {
                    text: 'Tên sản phẩm',
                    dataField: 'name', editable: false
                }, {
                    text: 'Số lượng',
                    dataField: 'number',
                    cellsalign: 'right', align: 'right',
                    width: '100px',
                    cellsrenderer: cellsrenderer_number,
                    columntype: 'custom',
                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
                        // construct the editor.
                        editor.jqxNumberInput({
                            width: width,
                            height: height,
                            min: 0, digits: 5,
                            decimalDigits: 0,
                            max: 99999999999,
                            promptChar: ' ',
                            groupSeparator: ' ',
                            symbol: "",
                            symbolPosition: 'right'
                        });
                        editor.find('input').css({'font-size': '14px', 'font-weight': '500'});
                    },
                    initeditor: function (row, cellvalue, editor, celltext, pressedkey) {
                        // set the editor's current value. The callback is called each time the editor is displayed.
                        var value = parseInt(cellvalue);
                        if (isNaN(value)) value = 0;
                        editor.jqxNumberInput('val', value);
                        setTimeout(function () {
                            editor.find('input').select();
                            editor.find('input').focus();
                        }, 100);
                    },
                    geteditorvalue: function (row, cellvalue, editor) {
                        // return the editor's value.
                        return editor.jqxNumberInput('val');
                    }
                }, {
                    text: 'Tồn',
                    dataField: 'number_max',
                    width: '100px',
                    cellsformat: 'd',
                    cellsalign: 'right', align: 'right', editable: false
                }, {
                    text: 'Giá bán',
                    dataField: 'price_sale',
                    width: '120px',
                    cellsalign: 'right', align: 'right',
                    columntype: 'custom',
                    cellsrenderer: cellsrenderer_price_sale,
                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
                        // construct the editor.
                        editor.jqxNumberInput({
                            width: width,
                            height: height,
                            min: 0, digits: 12,
                            decimalDigits: 0,
                            max: 99999999999,
                            promptChar: ' ',
                            groupSeparator: ' ',
                            symbol: " đ",
                            symbolPosition: 'right'
                        });
                        editor.find('input').css({'font-size': '14px', 'font-weight': '500'});
                    },
                    initeditor: function (row, cellvalue, editor, celltext, pressedkey) {
                        // set the editor's current value. The callback is called each time the editor is displayed.
                        var value = parseInt(cellvalue);
                        if (isNaN(value)) value = 0;
                        editor.jqxNumberInput('val', value);
                        setTimeout(function () {
                            editor.find('input').select();
                            editor.find('input').focus();
                        }, 100);
                    },
                    geteditorvalue: function (row, cellvalue, editor) {
                        // return the editor's value.
                        return editor.jqxNumberInput('val');
                    }
                }, {
                    text: 'Thành tiền',
                    dataField: 'price',
                    width: '120px',
                    cellsformat: 'd', align: 'right',
                    cellsalign: 'right', editable: false
                }, {
                    text: ' ',
                    dataField: 'btn_remove',
                    width: '30', editable: false,
                    cellsrenderer: function () {
                        return "<div style='color: #d60f01;padding: 7px;font-size: 16px;'><i class='fa fa-times'></i></div>"
                    }
                }
            ],
        });
        table1.jqxGrid('localizestrings', grid_lang);
        table2.jqxGrid({
            pageSize: 20,
            altRows: true,
            pageable: false,
            height: '50%',
            width: '100%',
            filterable: false,
            autoshowfiltericon: true,
            sortable: false,
            columnsResize: true,
            enablehover: false,
            source: table_dataAdapter2,
            selectionmode: 'none',
            rowsheight: 33,
            columnsheight: 35,
            editable: true,
            columns: [
                {
                    text: 'TT',
                    dataField: 'id',
                    width: '50',
                    align: 'center', cellsalign: 'center', editable: false
                },
                {
                    text: 'Mã sản phẩm',
                    dataField: 'code',
                    width: '120', editable: false
                }, {
                    text: 'Tên sản phẩm',
                    dataField: 'name', editable: false
                }, {
                    text: 'SL trả',
                    dataField: 'number',
                    cellsalign: 'right', align: 'right',
                    width: '100px',
                    cellsrenderer: cellsrenderer_number,
                    columntype: 'custom',
                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
                        // construct the editor.
                        editor.jqxNumberInput({
                            width: width,
                            height: height,
                            min: 0, digits: 5,
                            decimalDigits: 0,
                            max: 99999999999,
                            promptChar: ' ',
                            groupSeparator: ' ',
                            symbol: "",
                            symbolPosition: 'right'
                        });
                        editor.find('input').css({'font-size': '14px', 'font-weight': '500'});
                    },
                    initeditor: function (row, cellvalue, editor, celltext, pressedkey) {
                        // set the editor's current value. The callback is called each time the editor is displayed.
                        var value = parseInt(cellvalue);
                        if (isNaN(value)) value = 0;
                        editor.jqxNumberInput('val', value);
                        setTimeout(function () {
                            editor.find('input').select();
                            editor.find('input').focus();
                        }, 100);
                    },
                    geteditorvalue: function (row, cellvalue, editor) {
                        // return the editor's value.
                        return editor.jqxNumberInput('val');
                    }
                }, {
                    text: 'Đã mua',
                    dataField: 'number_max',
                    width: '100px',
                    cellsformat: 'd',
                    cellsalign: 'right', align: 'right', editable: false
                }, {
                    text: 'Giá trả',
                    dataField: 'price_sale',
                    width: '120px',
                    cellsalign: 'right', align: 'right',
                    columntype: 'custom',
                    cellsrenderer: cellsrenderer_price_sale,
                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
                        // construct the editor.
                        editor.jqxNumberInput({
                            width: width,
                            height: height,
                            min: 0, digits: 12,
                            decimalDigits: 0,
                            max: 99999999999,
                            promptChar: ' ',
                            groupSeparator: ' ',
                            symbol: " đ",
                            symbolPosition: 'right'
                        });
                        editor.find('input').css({'font-size': '14px', 'font-weight': '500'});
                    },
                    initeditor: function (row, cellvalue, editor, celltext, pressedkey) {
                        // set the editor's current value. The callback is called each time the editor is displayed.
                        var value = parseInt(cellvalue);
                        if (isNaN(value)) value = 0;
                        editor.jqxNumberInput('val', value);
                        setTimeout(function () {
                            editor.find('input').select();
                            editor.find('input').focus();
                        }, 100);
                    },
                    geteditorvalue: function (row, cellvalue, editor) {
                        // return the editor's value.
                        return editor.jqxNumberInput('val');
                    }
                }, {
                    text: 'Thành tiền',
                    dataField: 'price',
                    width: '120px',
                    cellsformat: 'd', align: 'right',
                    cellsalign: 'right', editable: false
                }, {
                    text: ' ',
                    dataField: 'btn_remove',
                    width: '30', editable: false,
                    cellsrenderer: function () {
                        return ""
                    }
                }
            ],
        });
        table2.jqxGrid('localizestrings', grid_lang);
        table_hoadon.jqxGrid({
            pageSize: 20,
            altRows: true,
            pageable: false,
            height: '470px',
            width: '100%',
            filterable: false,
            autoshowfiltericon: true,
            sortable: false,
            columnsResize: true,
            enablehover: false,
            source: table_hoadon_dataAdapter,
            selectionmode: 'singlerow',
            rowsheight: 33,
            columnsheight: 35,
            editable: false,
            columns: [
                {
                    text: 'Ngày HD', dataField: 'ngayhd', width: '100',
                    aggregates: ['count'],
                    filtertype: 'date', cellsformat: 'dd/MM/yyyy',
                },
                {text: 'Mã HD', dataField: 'mahd', width: 110},
                {text: 'Mã KH', dataField: 'makh', width: 110},
                {text: 'Tên khách hàng', dataField: 'tenkh'},
                {
                    text: 'Tổng tiền',
                    dataField: 'tongtien',
                    width: '100',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    aggregates: ['sum'], align: 'right',
                }
            ],
        });
        table_hoadon.jqxGrid('localizestrings', grid_lang);
    };


    ReturnApp.createEvent = function () {
        //Hiển thị đổi giá
        table1.on('cellendedit', function (event) {
            var args = event.args;
            setTimeout(function () {
                ReturnApp.change_number(0, args.rowindex);
            }, 100)
        });
        table2.on('cellendedit', function (event) {
            var args = event.args;
            setTimeout(function () {
                ReturnApp.change_number2(0, args.rowindex);
            }, 100)
        });

        function click_remove(args) {
            var popup_xoa = $('<div></div>');
            var btn_yes = $('<button class="f-right">Có</button>');
            var btn_no = $('<button class="f-right" style="margin-left: 5px;">Không</button>');
            popup_xoa.append(btn_no);
            popup_xoa.append(btn_yes);
            btn_yes.jqxButton({height: 25, template: 'success'});
            btn_no.jqxButton({height: 25, template: 'danger'});
            popup_xoa.jqxPopover({
                position: "left",
                width: 180,
                height: 80,
                'title': 'Xóa khỏi giỏ hàng?',
                selector: args['originalEvent']['target']
            });

            btn_yes.click(function () {
                table1.jqxGrid('deleterow', args['row']['bounddata']['uid']);
                popup_xoa.jqxPopover('close');
                ReturnApp.calculate_price();
            });
            btn_no.click(function () {
                popup_xoa.jqxPopover('close');
            });
        }

        table1.on("cellclick", function (event) {
            var args = event.args;
            if (args.datafield == 'btn_remove') {
                click_remove(args);
            }
        });

        //Chọn giá trị
        $('#timsanpham').keyup(function (e) {
            if (e.keyCode == 13) {
                var sp = app.getDataByCode(txt_timsanpham.jqxComboBox('val'), products_list);
                if (sp != null) {
                    txt_soluong.jqxNumberInput('val', '1');
                    var id_number = $('#soluong').find('> input');
                    id_number.focus();
                    id_number.select();
                }
            }
        });
        //
        $('#soluong').find('> input').keyup(function (e) {
            if (e.keyCode == 13) {
                var sp = app.getDataByCode(txt_timsanpham.jqxComboBox('val'), products_list);
                if (sp != null) {
                    var data = table1.jqxGrid('getrows');
                    var index = data.findIndex(x => x.code === sp['code']);
                    var product_selected;
                    if (index >= 0) {
                        product_selected = data[index];
                    } else {
                        product_selected = null;
                    }
                    if (product_selected != null) {
                        table1.jqxGrid('updaterow', product_selected['uid'], {
                            id: product_selected['id'],
                            code: product_selected['code'],
                            name: product_selected['name'],
                            number: parseInt(product_selected['number']) + parseInt(txt_soluong.jqxNumberInput('val')),
                            number_max: product_selected['number_max'],
                            price_sale: product_selected['price_sale'],
                            price: product_selected['price_sale'] * (parseInt(product_selected['number']) + parseInt(txt_soluong.jqxNumberInput('val'))),
                        });
                    } else {
                        table1.jqxGrid('addrow', null, {
                            id: table1.jqxGrid('getrows').length,
                            code: sp['code'],
                            name: sp['pname'],
                            number: txt_soluong.jqxNumberInput('val'),
                            number_max: parseInt(sp['numbermax']),
                            price_sale: parseInt(sp['price_main']),
                            price: parseInt(sp['price_main']) * parseInt(txt_soluong.jqxNumberInput('val')),
                        });
                    }
                    txt_timsanpham.jqxComboBox('val', '');
                    txt_timsanpham.jqxComboBox('focus');
                }
                ReturnApp.calculate_price();
            }
        });
        //Tính tiền sau mỗi lần đổi số
        var input_km = $('#Skhuyenmai');
        input_km.click(function () {
            var popphantram = $('<div></div>');
            var inputphantram = $('<input class="f-left">');
            popphantram.append(inputphantram);
            inputphantram.jqxNumberInput({
                width: '100%',
                height: 26,
                min: 0,
                decimalDigits: 0,
                max: 100,
                promptChar: ' ',
                groupSeparator: ' ',
                symbol: " %",
                symbolPosition: 'right'
            });
            popphantram.jqxPopover({
                position: "left",
                width: 170,
                height: 80,
                'title': 'Điền phần trăm %:',
                selector: $(this)
            });
            $('#' + popphantram.attr('id')).on('close', function () {
                popphantram.jqxPopover('destroy');
                $(this).remove();
            });
            var dt = $(this);
            var id_input = inputphantram.attr('id').replace('_jqxNumberInput', '');
            $('#' + id_input).find('input').keyup(function (e) {
                if (e.keyCode == 13) {
                    var goc = txt_tienhang.jqxNumberInput('val');
                    var pt = inputphantram.jqxNumberInput('val');
                    dt.jqxNumberInput('val', parseInt(parseInt(goc) / 100 * pt));
                }
            });
            popphantram.jqxPopover('open');
            $(this).select();
        });
        input_km.on('valueChanged', function () {
            ReturnApp.calculate_price();
        });
        $('#Skhachthanhtoan').on('valueChanged', function () {
            var thanhtoan = txt_thanhtoan.jqxNumberInput('val');
            var khachtra = txt_khachthanhtoan.jqxNumberInput('val');
            txt_nolai.jqxNumberInput('val', parseInt(thanhtoan) - parseInt(khachtra));
        });
        $('#Sthukhac').on('valueChanged', function () {
            ReturnApp.calculate_price();
        });

        //Thêm khách hàng mới
        btn_themkhachhang.click(function () {
            if (txt_sdt_kh.jqxComboBox('val') === '') {
                app.notify('Số điện thoại khách hàng là bắt buộc!', 'warning');
                txt_sdt_kh.jqxComboBox('focus');
                return;
            }
            if (txt_hoten_kh.jqxInput('val') === '') {
                app.notify('Họ tên khách hàng là bắt buộc!', 'warning');
                txt_hoten_kh.focus();
                return;
            }
            btn_themkhachhang.text('Đang lưu...');
            add_data(urls.url_apis.customers, {
                address: txt_diachi_kh.jqxInput('val'),
                id_branch: me['branch'],
                customer_cat: txt_danhmuc_kh.jqxDropDownList('val'),
                phone: txt_sdt_kh.jqxComboBox('val'),
                note: txt_ghichu_kh.jqxTextArea('val'),
                name: txt_hoten_kh.jqxInput('val'),
                debt: txt_no_kh.jqxNumberInput('val'),
                email: txt_email_kh.jqxInput('val'),
                birthday: txt_ngaysinh_kh.jqxInput('val')
            }, function (result) {
                if (result['success']) {
                    app.notify("Thêm khách hàng thành công!", 'success');
                    var index = customers.findIndex(x => x.code === result['data']['code']);
                    if (index !== null) {
                        customers[index] = result['data'];
                    } else {
                        customers[customers.length] = result['data'];
                    }
                    txt_timkhachhang.jqxComboBox({source: null});
                    txt_timkhachhang.jqxComboBox({source: customers});
                    txt_sdt_kh.jqxComboBox({source: null});
                    txt_sdt_kh.jqxComboBox({source: customers});
                    btn_themkhachhang.text('Lưu lại');
                    popthemkhachhang.jqxWindow('close');
                    txt_timkhachhang.jqxComboBox('focus');
                } else {
                    app.notify("Thêm khách hàng không thành công!", 'warning');
                }
            })
        });

        function loadDataKH() {
            var code = txt_timkhachhang.jqxComboBox('val');
            var kh = app.getDataByCode(code, customers);
            if (kh != null) {
                //tìm đúng
                txt_timkhachhang.addClass('input-search-selected');
                btn_hienthithemKH.removeClass('fa-plus');
                btn_hienthithemKH.addClass('fa-address-book');
                txt_hoten_kh.jqxInput('val', kh['name']);
                txt_diachi_kh.jqxInput('val', kh['address']);
                txt_danhmuc_kh.jqxDropDownList('val', kh['customer_cat']);
                txt_ghichu_kh.jqxTextArea('val', kh['note']);
                txt_sdt_kh.jqxComboBox('val', kh['phone']);
                txt_no_kh.jqxNumberInput('val', kh['debt']);
                txt_ngaysinh_kh.jqxInput('val', kh['birthday']);
                txt_point_kh.jqxInput('val', kh['point']);
                txt_hit_kh.jqxInput('val', kh['hit']);
                txt_facebook_kh.jqxInput('val', kh['id_facebook']);
                txt_email_kh.jqxInput('val', kh['email']);
            } else {
                txt_hoten_kh.jqxInput('val', '');
                txt_diachi_kh.jqxInput('val', '');
                txt_danhmuc_kh.jqxDropDownList('val', '');
                txt_ghichu_kh.jqxTextArea('val', '');
                txt_sdt_kh.jqxComboBox('val', '');
                txt_no_kh.jqxNumberInput('val', 0);
                txt_ngaysinh_kh.jqxInput('val', '');
                txt_point_kh.jqxInput('val', '0');
                txt_hit_kh.jqxInput('val', '0');
                txt_facebook_kh.jqxInput('val', '');
                txt_email_kh.jqxInput('val', '');
                txt_timkhachhang.removeClass('input-search-selected');
                btn_hienthithemKH.removeClass('fa-address-book');
                btn_hienthithemKH.addClass('fa-plus');
            }
        }

        $('#timkhachhang').on('unselect', function (event) {
            loadDataKH();
        });
        $('#timkhachhang').on('change', function (event) {
            loadDataKH();
        });

        btn_hienthithemKH.click(function () {
            popthemkhachhang.jqxWindow('open');
            loadDataKH();
            setTimeout(function () {
                txt_hoten_kh.focus();
            }, 500);
        });

        $('#dropdownlistContenttimkhachhang').find('input').click(function () {
            $(this).select();
        });
        $('#dropdownlistContenttimkhachhang').find('input').keyup(function () {
            loadDataKH();
        });
        //Save bill
        btn_luuhoadon.click(function () {
            if (txt_tientra.jqxNumberInput('val') <= 0) {
                app.notify("Chưa có sản phẩm nào để lưu!", 'warning');
                return;
            }
            ReturnApp.save_bill();
        });

        //
        function request_filter() {
            var branch_f = cb_search_branch.jqxDropDownList('val');
            var customer_f = cb_search_customer.jqxDropDownList('val');
            var user_f = cb_search_user.jqxDropDownList('val');
            var dateS_f = txt_search_date_create1.jqxDateTimeInput('val');
            var dateE_f = txt_search_date_create2.jqxDateTimeInput('val');
            var code_f = txt_search_code.jqxInput('val');
            var pname_f = txt_search_pname.jqxInput('val');

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
            if (code_f !== '') {
                code_f = " AND code LIKE '" + code_f + "'";
            } else {
                code_f = '';
            }
            if (pname_f !== '') {
                pname_f = " AND products LIKE '%" + pname_f + "%'";
            } else {
                pname_f = '';
            }
            dateS_f = " AND STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y')>=STR_TO_DATE('00:00" + dateS_f + "','%H:%i %d/%m/%Y')";
            dateE_f = " AND STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y')<=STR_TO_DATE('23:59" + dateE_f + "','%H:%i %d/%m/%Y')";

            var string_where = pname_f + code_f + dateE_f + dateS_f + customer_f + branch_f + user_f;
            table_hoadon.jqxGrid('showloadelement');
            download_data_where(urls.url_apis.select, {
                table: "invoices",
                select: "WHERE 1 AND type LIKE 'INVOICE'" + string_where + ' ORDER BY id DESC',
                data: "invoices.id AS 'id',DATE_FORMAT(STR_TO_DATE(invoices.create_at, '%H:%i %d/%m/%Y'),'%d/%m/%Y') AS 'ngayhd', invoices.code AS 'mahd',invoices.customer AS 'makh', invoices.customer_name as 'tenkh',invoices.total_price AS 'tongtien', invoices.discount AS 'tienkm', invoices.other_price AS 'tienkhac', invoices.total_pay AS 'tientra', invoices.state AS 'trangthai',invoices.note AS 'ghichu'"
            }, null, function (result) {
                if (result['success']) {
                    table_hoadon_source.localdata = result['data'];
                    table_hoadon.jqxGrid('updatebounddata', 'cells');
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                table_hoadon.jqxGrid('hideloadelement');
            });
        }

        txt_search_code.keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#search_pname').keyup(function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#search_date_create1').on('valueChanged', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#search_date_create2').on('valueChanged', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#search_branch').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#search_customer').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#search_user').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });

        //Chọn hóa đơn
        btn_chonhoadon.click(function () {
            var hoadon = table_hoadon.jqxGrid('getrowdata', table_hoadon.jqxGrid('selectedrowindex'));
            if (hoadon == undefined) {
                app.notify('Chưa có hóa đơn được chon!', 'warning');
                return;
            }

            btn_chonhoadon.html("<i class='fa fa-spin fa-spinner'></i> Đang tải...");
            var mahd = hoadon['mahd'];
            download_data_where(urls.url_apis.select, {
                table: "invoices",
                select: "WHERE code LIKE '" + mahd + "'",
                data: "*"
            }, null, function (result) {
                if (result['success']) {
                    var invoice = result['data'][0];
                    txt_timkhachhang.jqxComboBox('val', invoice['customer']);
                    //Add to table
                    invoice = JSON.parse(invoice['products']);
                    for (var i = 0; i < invoice.length; i++) {
                        table2.jqxGrid('addrow', null, {
                            id: i,
                            code: invoice[i]['code'],
                            name: invoice[i]['name'],
                            number: 0,
                            number_max: invoice[i]['number'],
                            price_sale: invoice[i]['price_sale'],
                            price: 0,
                        });
                    }
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                btn_chonhoadon.html("<i class='fa fa-check-circle'></i> Lựa chọn");
                pophoadon.jqxWindow('close');
            });
        });
    };


    ReturnApp.change_number = function (num, row) {
        if ($.isNumeric(num)) {
            var product_selected = table1.jqxGrid('getrowdatabyid', row);
            if (parseInt(product_selected['number']) + parseInt(num) >= 0) {
                table1.jqxGrid('updaterow', product_selected['uid'], {
                    id: product_selected['id'],
                    code: product_selected['code'],
                    name: product_selected['name'],
                    number: parseInt(product_selected['number']) + parseInt(num),
                    number_max: product_selected['number_max'],
                    price_sale: product_selected['price_sale'],
                    price: product_selected['price_sale'] * (parseInt(product_selected['number']) + parseInt(num)),
                });
            }
        }
        ReturnApp.calculate_price();
    };
    ReturnApp.change_number2 = function (num, row) {
        if ($.isNumeric(num)) {
            var product_selected = table2.jqxGrid('getrowdatabyid', row);
            if (parseInt(product_selected['number']) > parseInt(product_selected['number_max'])) {
                app.notify('Số lượng lớn hơn trong hóa đơn!', 'warning');
                product_selected['number'] = product_selected['number_max'];
            }
            if (parseInt(product_selected['number']) + parseInt(num) >= 0) {
                table2.jqxGrid('updaterow', product_selected['uid'], {
                    id: product_selected['id'],
                    code: product_selected['code'],
                    name: product_selected['name'],
                    number: parseInt(product_selected['number']) + parseInt(num),
                    number_max: product_selected['number_max'],
                    price_sale: product_selected['price_sale'],
                    price: product_selected['price_sale'] * (parseInt(product_selected['number']) + parseInt(num)),
                });
            }
        }
        ReturnApp.calculate_price();
    };


    ReturnApp.clear = function () {
        table1.jqxGrid('clear');
        table2.jqxGrid('clear');
        ReturnApp.calculate_price();
        txt_timkhachhang.jqxComboBox('val', '');
        pophoadon.jqxWindow('open');
    };

    ReturnApp.calculate_price = function (reload) {
        var p_selected = table1.jqxGrid('getrows');
        var sum_price = 0;
        if (p_selected !== null) {
            for (var i = 0; i < p_selected.length; i++) {
                sum_price += parseInt(p_selected[i]['price']);
            }
        }
        p_selected = table2.jqxGrid('getrows');
        var sum_price2 = 0;
        if (p_selected !== null) {
            for (var i = 0; i < p_selected.length; i++) {
                sum_price2 += parseInt(p_selected[i]['price']);
            }
        }
        var khachtra = txt_khachthanhtoan.jqxNumberInput('val');
        var khuyenmai = txt_khuyenmai.jqxNumberInput('val');
        var thukhac = txt_thukhac.jqxNumberInput('val');
        txt_tienhang.jqxNumberInput('val', sum_price);
        txt_tientra.jqxNumberInput('val', sum_price2);
        var tong_tt = parseInt(sum_price) + parseInt(thukhac) - parseInt(khuyenmai);
        var khachcantra = tong_tt - sum_price2;
        if (khachcantra < 0) {
            //khachcantra=-khachcantra;
            khachtra = 0;
            $('#lb_thanhtoan').text('Cần trả khách:');
        } else {
            $('#lb_thanhtoan').text('Khách cần trả:');
        }
        txt_muamoi.jqxNumberInput('val', tong_tt);
        txt_thanhtoan.jqxNumberInput('val', khachcantra);
        var thanhtoan = txt_thanhtoan.jqxNumberInput('val');
        khachtra = txt_thanhtoan.jqxNumberInput('val');
        txt_khachthanhtoan.jqxNumberInput('val', khachtra);
        if (khachcantra < 0) {
            txt_khachthanhtoan.jqxNumberInput('val', 0);
            txt_nolai.jqxNumberInput('val', 0);
        } else {
            txt_nolai.jqxNumberInput('val', parseInt(thanhtoan) - parseInt(khachtra));
        }
    };


    ReturnApp.save_bill = function () {
        function inhoadon1(mahoadon) {
            var noidung = template_bill1;
            var date_now = '<?php echo \App\CusstomPHP\Time::Datenow(); ?>';
            var hoten_kh = txt_hoten_kh.jqxInput('val');
            var no_kh = txt_no_kh.jqxNumberInput('val');
            var sdt_kh = txt_sdt_kh.jqxComboBox('val');
            var diachi_kh = txt_diachi_kh.jqxInput('val');
            var products = table1.jqxGrid('getrows');
            var table_print = "";
            for (var i = 0; i < products.length; i++) {
                table_print += "<tr>";
                table_print += "<td>" + products[i]['id'] + "</td>";
                table_print += "<td>" + products[i]['code'] + "</td>";
                table_print += "<td>" + products[i]['name'] + "</td>";
                table_print += "<td style='text-align: right;'>" + products[i]['number'] + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price_sale']).toLocaleString() + "</td>";
                table_print += "<td style='text-align: right;'>" + 0 + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price']).toLocaleString() + "</td>";
                table_print += "</tr>";
            }
            noidung = noidung.replace("{Ma_Don_Hang}", mahoadon);
            noidung = noidung.replace("{Khach_Hang}", hoten_kh);
            noidung = noidung.replace("{Ngay_Thang_Nam}", date_now);
            noidung = noidung.replace("{Dia_Chi_Khach_Hang}", diachi_kh);
            noidung = noidung.replace("{Nhan_Vien_Ban_Hang}", me.name);
            noidung = noidung.replace("{Tong_Tien_Hang}", parseInt(txt_tienhang.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Chiet_Khau_Hoa_Don}", parseInt(txt_khuyenmai.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Tong_Cong}", parseInt(txt_thanhtoan.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Thu_Khac}", parseInt(txt_thukhac.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace(" {So_Dien_Thoai}", sdt_kh);
            noidung = noidung.replace("<!--{Du_Lieu}-->", table_print);
            print_data(noidung, 'In hóa đơn bán hàng');
        }

        function inhoadon2(mahoadon) {
            var noidung = template_bill2;
            var date_now = '<?php echo \App\CusstomPHP\Time::Datenow(); ?>';
            var hoten_kh = txt_hoten_kh.jqxInput('val');
            var no_kh = txt_no_kh.jqxNumberInput('val');
            var sdt_kh = txt_sdt_kh.jqxComboBox('val');
            var diachi_kh = txt_diachi_kh.jqxInput('val');
            var products = table2.jqxGrid('getrows');
            var table_print = "";
            for (var i = 0; i < products.length; i++) {
                table_print += "<tr>";
                table_print += "<td>" + products[i]['id'] + "</td>";
                table_print += "<td>" + products[i]['code'] + "</td>";
                table_print += "<td>" + products[i]['name'] + "</td>";
                table_print += "<td style='text-align: right;'>" + products[i]['number'] + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price_sale']).toLocaleString() + "</td>";
                table_print += "<td style='text-align: right;'>" + 0 + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price']).toLocaleString() + "</td>";
                table_print += "</tr>";
            }
            noidung = noidung.replace("{Ma_Don_Hang}", mahoadon);
            noidung = noidung.replace("{Khach_Hang}", hoten_kh);
            noidung = noidung.replace("{Ngay_Thang_Nam}", date_now);
            noidung = noidung.replace("{Dia_Chi_Khach_Hang}", diachi_kh);
            noidung = noidung.replace("{Nhan_Vien_Ban_Hang}", me.name);
            noidung = noidung.replace("{Tong_Tien_Hang}", parseInt(txt_tienhang.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Chiet_Khau_Hoa_Don}", parseInt(txt_khuyenmai.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Tong_Cong}", parseInt(txt_thanhtoan.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Thu_Khac}", parseInt(txt_thukhac.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace(" {So_Dien_Thoai}", sdt_kh);
            noidung = noidung.replace("<!--{Du_Lieu}-->", table_print);
            print_data(noidung, 'In hóa đơn trả hàng');
        }


        //loại bỏ sản phẩm không trừ
        var data_selectx = table2.jqxGrid('getrows');
        var rowIDs = new Array();
        for (var i = 0; i < data_selectx.length; i++) {
            if (data_selectx[i]['number'] <= 0) {
                rowIDs.push(data_selectx[i]['uid']);

            }
        }
        table2.jqxGrid('deleterow', rowIDs);

        add_data(urls.url_apis.product_return, {
            code: "TH/",
            branch: me.branch,
            customer: txt_timkhachhang.jqxComboBox('val'),
            customer_name: txt_hoten_kh.jqxInput('val'),
            type: "RETURN",
            products1: JSON.stringify(table1.jqxGrid('getrows')),
            products2: JSON.stringify(table2.jqxGrid('getrows')),
            total_price: txt_tienhang.jqxNumberInput('val'),
            total_pay: txt_khachthanhtoan.jqxNumberInput('val'),
            other_price: txt_thukhac.jqxNumberInput('val'),
            discount: txt_khuyenmai.jqxNumberInput('val'),
            return_price: txt_tientra.jqxNumberInput('val'),
            state: "SUCCESS",
            note: txt_ghichu.jqxTextArea('val'),
            user: me['username'],
            finance_cat: settings.acc_default
        }, function (result) {
            if (result['success']) {
                app.notify("Thêm hóa đơn trả hàng thành công!", 'success');
                //Hóa đơn bán hàng
                var mahoadon1 = null;
                if (result['data'][1] != undefined) {
                    mahoadon1 = result['data'][1]['code'];
                }
                //Hóa đơn trả hàng
                var mahoadon2 = result['data'][2]['code'];
                if (mahoadon1 != null) {
                    inhoadon1(mahoadon1);
                }
                inhoadon2(mahoadon2);
                ReturnApp.clear();
            } else {
                app.notify("Thêm hóa đơn trả hàng không thành công!", 'warning');
                return false;
            }
        });
    };


    function view_start() {
        ReturnApp.createUI();
        ReturnApp.createData();
        ReturnApp.createEvent();
        txt_timsanpham.jqxComboBox('focus');
    }
</script>