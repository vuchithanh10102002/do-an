{{--Chứa danh sách các sản phẩm của công ty--}}

<div class="view" xmlns="http://www.w3.org/1999/html">
    <div id="loader_view"></div>
    <div id="sidebar" style="float:right;margin-left: 1%;margin-right: 0;width: 350px;">
        <div class="sidebar-item">
            <div>Thông tin nhập hàng</div>
            <div>
                <div>
                    <div style="position: relative;margin: 10px 0;">
                        <i class="fa fa-search icon-customer-s"></i>
                        <div style="border: 1px solid rgb(92, 184, 92);;padding-left: 35px;"
                             id="timnhacungcap"></div>
                        <i  id="add_supplier" class="fa fa-plus ic-find"></i>
                    </div>
                </div>

                <div class="div-sale">
                    <label class="lable_sale">Tổng tiền nhập:</label>
                    <input class="sale-input sale-input-green" id="tienhang">
                </div>
                <div class="div-sale">
                    <label class="lable_sale">Khuyến mãi:</label>
                    <input class="sale-input sale-input-active" id="tienkhuyenmai">
                </div>
                <div class="div-sale">
                    <label class="lable_sale">Chi phí khác:</label>
                    <input class="sale-input sale-input-active" id="tienkhac">
                </div>
                <div class="div-sale">
                    <label class="lable_sale">Tổng thanh toán:</label>
                    <input class="sale-input" id="tienthanhtoan">
                </div>
                <div class="div-sale">
                    <label class="lable_sale">Trả nhà cung cấp:</label>
                    <input class="sale-input sale-input-active sale-input-yellow" id="tientraNCC">
                </div>
                <div class="div-sale">
                    <label class="lable_sale">Thêm vào công nợ:</label>
                    <input class="sale-input" id="tienno">
                </div>

                <div class="div-sale">
                    <label class="lable_sale">Chọn tài khoản:</label>
                    <div class="sale-select sale-input-active" id="account_type"></div>
                </div>
                <div >
                    <label  style="margin-top: 0;">Ghi chú:</label>
                    <textarea class="" id="import_note"></textarea>
                </div>
            </div>
        </div>
        <button style="font-size: 16px;margin-top: 5px;border-radius: 0;" id="btn_luumaychu">
            <i class='fa fa-cloud-upload'></i> Lưu nhập hàng (F9)
        </button>

    </div>
    <div id="content-table" style="float: left;width: calc(100% - 370px);">
        <div class="input-product-top">
            <h2>Nhập hàng</h2>
            <div class="container-xx">
                <i class="fa fa-search icon-product-s"></i>
                <div style="padding-left: 33px;border-color: white;" id="products"></div>
                <i id="btn_add_productlist" class="fa fa-plus icon-right"></i>
            </div>
            <input class="im-number sale-input-green" id="number">
            <input class="im-price_import sale-input-green" id="price_import">
            {{--<input class="im-expiry_at" id="expiry_at">--}}
            {{--<button style="margin: 10px 0;display: inline-block;float: right;border-radius: 0;" id="btn_print_qr"><i--}}
                        {{--class="fa fa-qrcode"></i> In mã--}}
            {{--</button>--}}
        </div>
        <div id="table"></div>
    </div>


    <div id="windows_add" class="windows">
        <div>
            <i class="fa fa-plus-circle"></i>
            Thêm sản phẩm mới
        </div>
        <div>
            <div>
                <label for="code_p">Mã sản phẩm:</label>
                <input id="code_p" class="input-sidebar">
                <label for="name_p">Tên sản phẩm:</label>
                <input id="name_p" class="input-sidebar">
                <label for="product_cat_p">Danh mục sản phẩm:</label>
                <div id="product_cat_p" class="input-sidebar"></div>

                <div class="input-50-window f-left">
                    <label for="price_main_p">Giá bán:</label>
                    <input id="price_main_p" class="input-sidebar">
                </div>
                <div class="input-50-window f-right">
                    <label for="price_import_p">Giá nhập:</label>
                    <input id="price_import_p" class="input-sidebar">
                </div>

                <label for="number_p">Tồn kho:</label>
                <input id="number_p" class="input-sidebar">
                <label for="state_p">Trạng thái:</label>
                <select id="state_p" class="input-sidebar">
                    <option VALUE="ACTIVE">Đang bán</option>
                    <option value="INACTIVE">Hủy bán</option>
                </select>
                <label for="note_p">Ghi chú:</label>
                <textarea id="note_p" class="input-sidebar"></textarea>
            </div>
            <div>
                <div style="float: right; margin-top: 15px;">
                    <button class="btn" id="btn_submit_p">Thêm sản phẩm mới</button>
                    <input class="btn" type="button" id="btn_cancel_p" value="Hủy bỏ"/>
                </div>
            </div>
        </div>
    </div>
    <div id="windows_add_s" class="windows">
        <div>
            <i class="fa fa-plus-circle"></i>
            Thêm nhà cung cấp mới
        </div>
        <div>
            <div>
                <label for="code_s">Mã nhà cung cấp:</label>
                <input id="code_s" placeholder="Thêm tự động" class="input-sidebar">
                <label for="name_s">Tên nhà cung cấp:</label>
                <input id="name_s" class="input-sidebar">
                <label for="phone_s">Số điện thoại:</label>
                <input id="phone_s" class="input-sidebar">
                <label for="email_s">Email:</label>
                <input id="email_s" class="input-sidebar">
                <label for="address_s">Địa chỉ:</label>
                <input id="address_s" class="input-sidebar">

                <label for="note_s">Ghi chú:</label>
                <textarea id="note_s" class="input-sidebar"></textarea>
            </div>
            <div>
                <div style="float: right; margin-top: 15px;">
                    <button class="btn" id="btn_submit_s">Thêm ngay</button>
                    <input class="btn" type="button" id="btn_cancel_s" value="Hủy bỏ"/>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var ProductImportAPP = {};
    var products_save = null;
    var cb_products = $('#products');
    var txt_price_import = $('#price_import');
    var txt_number = $('#number');
    //var txt_expiry_at = $('#expiry_at');
    var txt_tienhang = $('#tienhang');
    var txt_tientraNCC = $('#tientraNCC');
    var txt_tienno = $('#tienno');
    var txt_tienkhac = $('#tienkhac');
    var txt_tienkhuyenmai = $('#tienkhuyenmai');
    var txt_tienthanhtoan = $('#tienthanhtoan');
    var txt_import_note = $('#import_note');
    var cb_account_type = $('#account_type');
    var table = $('#table');
    var btn_add_productlist = $('#btn_add_productlist');
    var btn_save_server = $("#btn_luumaychu");
    var add_supplier = $("#add_supplier");
    //var btn_print_qr = $("#btn_print_qr");
    var cb_timnhacungcap = $('#timnhacungcap');
    var windows_add = $('#windows_add');
    var windows_add_s = $('#windows_add_s');

    var txt_code_p = $('#code_p');
    var txt_name_p = $('#name_p');
    var txt_price_main_p = $('#price_main_p');
    var txt_price_import_p = $('#price_import_p');
    var txt_number_p = $('#number_p');
    var txt_note_p = $('#note_p');
    var cb_product_cat_p = $('#product_cat_p');
    var cb_state_p = $('#state_p');
    var btn_submit_p = $('#btn_submit_p');
    var btn_cancel_p = $('#btn_cancel_p');

    var txt_code_s = $('#code_s');
    var txt_name_s = $('#name_s');
    var txt_email_s = $('#email_s');
    var txt_phone_s = $('#phone_s');
    var txt_address_s = $('#address_s');
    var txt_note_s = $('#note_s');
    var btn_submit_s = $('#btn_submit_s');
    var btn_cancel_s = $('#btn_cancel_s');

    //Source
    var branches = null;
    var suppliers = null;
    var finance_cat = null;
    var products_list = null;
    var products_cats = null;
    var table_source;
    var table_dataAdapter;
    var template_bill = "";

    ProductImportAPP.createData = function () {
        app.loadding('open');
        //local
        branches = JSON.parse(localStorage.getItem(tables.branches));
        suppliers = JSON.parse(localStorage.getItem(tables.suppliers));
        finance_cat = JSON.parse(localStorage.getItem(tables.finance_cat));
        products_cats = JSON.parse(localStorage.getItem(tables.product_cat));

        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 2) {
                cb_products.jqxComboBox({source: products_list});
                cb_product_cat_p.jqxDropDownList({source: products_cats});
                cb_account_type.jqxDropDownList({source: finance_cat});
                cb_timnhacungcap.jqxComboBox({source:suppliers});
                app.loadding('close');
                //setup default
                cb_account_type.jqxDropDownList('selectItem',settings.acc_default);
            }
        }

        //data from server
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE branch LIKE '" + me.branch + "'",
            data: "*"
        }, null, function (result) {
            if (result['success']) {
                products_list = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });

        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE name LIKE 'import_template' AND branch LIKE '" + me.branch + "'",
            data: "value"
        }, null, function (result) {
            if (result['success']) {
                template_bill = result['data'][0]['value'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
    };

    ProductImportAPP.createUI = function () {
        windows_add.jqxWindow({
            position: {x: (($(window).width() - 400) / 2), y: '10%'},
            width: 400,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel_p,
            autoOpen: false
        });
        windows_add_s.jqxWindow({
            position: {x: (($(window).width() - 400) / 2), y: '10%'},
            width: 400,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel_s,
            autoOpen: false
        });
        //add supplier
        txt_code_s.jqxInput({width: '100%', height: 30,});
        txt_name_s.jqxInput({width: '100%', height: 30,});
        txt_email_s.jqxInput({width: '100%', height: 30,});
        txt_phone_s.jqxInput({width: '100%', height: 30,});
        txt_address_s.jqxInput({width: '100%', height: 30,});
        txt_note_s.jqxTextArea({
            width: '100%',
            height: 50,
        });
        btn_submit_s.jqxButton({height: 35, template: 'success'});
        btn_cancel_s.jqxButton({height: 35, template: 'danger'});
        //Add product
        txt_code_p.jqxInput({width: '100%', height: 30,});
        txt_name_p.jqxInput({width: '100%', height: 30});
        txt_price_main_p.jqxNumberInput({
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
        txt_price_import_p.jqxNumberInput({
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
        txt_number_p.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0,
            decimalDigits: 0,
            max: 9999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " ",
            symbolPosition: 'right'
        });
        txt_note_p.jqxTextArea({
            width: '100%',
            height: 50,
        });
        cb_product_cat_p.jqxDropDownList({
            source: products_cats,
            width: '100%',
            height: 30,
            displayMember: "name",
            valueMember: "code",
            placeHolder: "Chọn một danh mục"
        });
        cb_state_p.jqxDropDownList({
            width: '100%',
            height: 30,
            placeHolder: ""
        });
        btn_submit_p.jqxButton({height: 35, template: 'success'});
        btn_cancel_p.jqxButton({height: 35, template: 'danger'});

        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        //TextBox
        txt_import_note.jqxTextArea({height: 50, width: '100%'});
        txt_tienthanhtoan.jqxNumberInput({
            width: '100%',
            height: 25,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right',
            disabled: true
        });
        txt_tienkhac.jqxNumberInput({
            width: '100%',
            height: 25,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_tienkhuyenmai.jqxNumberInput({
            width: '100%',
            height: 25,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_tienno.jqxNumberInput({
            width: '100%',
            height: 25,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right',
            disabled: true
        });
        txt_tientraNCC = txt_tientraNCC.jqxNumberInput({
            width: '100%',
            height: 25,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_tienhang.jqxNumberInput({
            width: '100%',
            height: 25,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right',
            disabled: true
        });
        txt_price_import.jqxNumberInput({
            width: '120px',
            height: 35,
            min: 0,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right'
        });
        txt_number.jqxNumberInput({
            width: '90px',
            height: 35,
            min: 0,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbolPosition: 'right'
        });
        var date_start = new Date(new Date().getFullYear() + 2, new Date().getMonth(), new Date().getDate());
//        txt_expiry_at.jqxDateTimeInput({height: 33, width: '100px', value: date_start});
        //cbobox
        cb_products.jqxComboBox({
            source: products_list,
            height: 35,
            scrollBarSize: 25,
            searchMode: "containsignorecase",
            placeHolder: "Tìm kiếm sản phẩm",
            dropDownWidth: 315,
            dropDownHeight: 300,
            width: 282,
            displayMember: 'name', showArrow: false,
            valueMember: 'code',
            renderer: function (index, label, value) {
                var product = products_list[index];
                return '<div class="dp">' +
                    '<div class="dp-title">' + product['name'] + '</div>' +
                    '<div class="dp-line">' +
                    '<span class="dp-line1">Mã: ' + product['code'] + '</span>' +
                    '<span class="dp-line2">Giá nhập: ' +  parseInt(product['price_import']).toLocaleString('vi-VN') + '</span>' +
                    '</div></div>';
            }
        });
        cb_timnhacungcap.jqxComboBox({
            height: 35,
            width: 'calc(100% - 35px)',
            source: suppliers,
            displayMember: 'name',
            valueMember: 'code',
            theme:'light',
            placeHolder: "Tìm kiếm nhà cung cấp",
            showArrow: false,
            searchMode: "containsignorecase",
            renderSelectedItem: function (index, item) {
                if (item['value'] !== '') {
                    return item['label'] + ' - ' + item['value'];
                }
                return "";
            }
        });
        cb_account_type.jqxDropDownList({
            height: 30, width: '100%',
            source: finance_cat,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: "Chọn tài khoản",
        });
        //Button
        btn_save_server.jqxButton({height: 55, width: '100%', template: 'success'});

        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'string'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'price_import', type: 'number'},
                {name: 'number', type: 'number'},
                {name: 'price', type: 'number'},
//                {name: 'expiry_at', type: 'string'},
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            altRows: true,
            rowsheight: 40,
            columnsheight: 40,
            editable: true,
            height: 'calc(100% - 70px)',
            width: '100%',
            filterable: true,
            autoshowfiltericon: true,
            sortable: true,
            columnsResize: true,
            source: table_dataAdapter,
            selectionmode: 'none',
            statusbarheight: 25,
            columns: [
                {
                    text: 'ID', dataField: 'id', width: '50px', align: "center",
                    cellsalign: 'center', editable: false,
                },
                {text: 'Mã SP', editable: false, dataField: 'code', width: '110px'},
                {text: 'Tên sản phẩm', editable: false, dataField: 'name'},
                {
                    text: 'Đơn giá',
                    dataField: 'price_import',
                    width: '120px',
                    cellsalign: 'right', align: 'right',
                    columntype: 'custom',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        return '<div class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i class="fa fa-edit f-grid"></i></div>';
                    },
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
                },
                {
                    text: 'SL nhập',
                    dataField: 'number',
                    width: '100px',
//                    cellsalign: 'right',
                    align: 'right',
                    columntype: 'custom',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        return '<div class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i class="fa fa-edit f-grid"></i></div>';
                    },
                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
                        // construct the editor.
                        editor.jqxNumberInput({
                            width: width,
                            height: height,
                            min: 0, digits: 5,
                            decimalDigits: 0,
                            max: 99999,
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
                    text: 'Thành tiền',
                    dataField: 'price',
                    width: '120px',
                    cellsformat: 'd', align: 'right',
                    cellsalign: 'right', editable: false
                },
//                {
//                    text: 'Hạn sử dụng',
//                    dataField: 'expiry_at',
//                    width: '120px',
//                    datafield: 'date',
//                    cellsalign: 'right', align: 'right',
//                    columntype: 'custom',
//                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
//                        return '<div class="price_sale-cell price_sale-row-' + row + '">' + value + ' <i class="fa fa-edit f-grid"></i></div>';
//                    },
//                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
//                        editor.jqxDateTimeInput({
//                            height: height,
//                            width: width,
//                            textAlign: "center"
//                        });
//                        editor.find('input').css({'font-size': '14px', 'font-weight': '500'});
//                    },
//                    initeditor: function (row, cellvalue, editor, celltext, pressedkey) {
//                        //editor.jqxDateTimeInput('val', value);
//                        setTimeout(function () {
//                            editor.find('input').focus();
//                        }, 100);
//                    },
//                    geteditorvalue: function (row, cellvalue, editor) {
//                        return editor.jqxDateTimeInput('val');
//                    }
//                },
                {
                    text: ' ',
                    dataField: 'btn_remove',
                    width: '30px', editable: false,
                    cellsrenderer: function () {
                        return "<div style='color: #d60f01;padding: 7px;font-size: 16px;'><i class='fa fa-times'></i></div>"
                    }
                }
            ]
        });
        table.jqxGrid('localizestrings', grid_lang);
    };

    ProductImportAPP.createEvent = function () {
        //add supplier
        btn_submit_s.click(function () {
            if (txt_name_s.jqxInput('val').trim() == '') {
                app.notify('Cần nhập tên nhà cung cấp!', 'warning');
                txt_name_s.jqxInput('focus');
                return;
            }
            if (txt_phone_s.jqxInput('val').trim() == '') {
                app.notify('Cần nhập số điện thoại nhà cung cấp!', 'warning');
                txt_phone_s.jqxInput('focus');
                return;
            }
            swal({
                title: 'Bạn có chắc?',
                text: "Thêm nhà cung cấp mới!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Thực hiện',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                btn_submit_s.html('<i class="fa fa-spin fa-spinner"></i> Đang thêm...');
                var data_sent = {
                    code: txt_code_s.jqxInput('val'),
                    name: txt_name_s.jqxInput('val'),
                    phone: txt_phone_s.jqxInput('val'),
                    email: txt_email_s.jqxInput('val'),
                    address: txt_address_s.jqxInput('val'),
                    note: txt_note_s.jqxTextArea('val'),
                };

                add_data(urls.url_apis.suppliers, data_sent, function (result) {
                    if (result['success']) {
                        app.notify('Thêm nhà cung cấp thành công!', 'success');
                        suppliers[suppliers.length]=result['data'];
                        cb_timnhacungcap.jqxComboBox({source:null});
                        cb_timnhacungcap.jqxComboBox({source:suppliers});
                        cb_timnhacungcap.jqxComboBox('selectItem',result['data']['code']);
                        windows_add_s.jqxWindow('close');
                    } else {
                        app.notify('Thêm nhà cung cấp bị lỗi!', 'error');
                    }
                    btn_submit_s.html('Thêm nhà cung cấp');
                })

            }).catch(swal.noop);
        });
        //save to server
        btn_submit_p.click(function () {
            if (txt_code_p.jqxInput('val').trim() == '') {
                app.notify('Cần nhập mã sản phẩm!', 'warning');
                txt_code_p.jqxInput('focus');
                return;
            }
            swal({
                title: 'Bạn có chắc?',
                text: "Thêm sản phẩm mới!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Thực hiện',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                btn_submit_p.html('<i class="fa fa-spin fa-spinner"></i> Đang thêm...');
                var data_sent = {
                    code: txt_code_p.jqxInput('val'),
                    name: txt_name_p.jqxInput('val'),
                    product_cat: cb_product_cat_p.jqxDropDownList('val'),
                    price_main: txt_price_main_p.jqxNumberInput('val'),
                    price_import: txt_price_import_p.jqxNumberInput('val'),
                    number: txt_number_p.jqxNumberInput('val'),
                    state: cb_state_p.jqxDropDownList('val'),
                    note: txt_note_p.jqxTextArea('val'),
                    branch:me['branch'],
                };

                add_data(urls.url_apis.product_list, data_sent, function (result) {
                    if (result['success']) {
                        app.notify('Thêm sản phẩm thành công!', 'success');
                        products_list[products_list.length]=result['data'];
                        cb_products.jqxComboBox({source:null});
                        cb_products.jqxComboBox({source:products_list});
                        console.log(result['data']);
                        cb_products.jqxComboBox('selectItem',result['data']['code']);
                        windows_add.jqxWindow('close');
                       setTimeout(function () {
                           $('#number').find('input').select();
                           txt_number.jqxNumberInput('focus');
                       },500);
                    } else {
                        app.notify('Thêm sản phẩm bị lỗi!', 'error');
                    }
                    btn_submit_p.html('Thêm sản phẩm mới');
                })

            }).catch(swal.noop);
        });

        //Hiển thị đổi giá
        table.on('cellendedit', function (event) {
            var args = event.args;
            setTimeout(function () {
                ProductImportAPP.change_number(0, args.rowindex);
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
                table.jqxGrid('deleterow', args['row']['bounddata']['uid']);
                popup_xoa.jqxPopover('close');
                ProductImportAPP.calculate_price();
            });
            btn_no.click(function () {
                popup_xoa.jqxPopover('close');
            });
        }

        table.on("cellclick", function (event) {
            var args = event.args;
            if (args.datafield === 'btn_remove') {
                click_remove(args);
            }
        });
        //Thêm sản phẩm
        btn_add_productlist.click(function () {
            windows_add.jqxWindow('open');
        });
        //Thêm nhà cung cấp
        add_supplier.click(function () {
            windows_add_s.jqxWindow('open');
        });
        //Lưu lên bảng
        function add_to_table() {
            var price_pay_avg = 0;
            if (parseInt(txt_number.jqxNumberInput('val')) <= 0) {
                app.notify('Số lượng nhập không đúng!', 'warning');
                txt_number.jqxNumberInput('focus');
                return;
            }
            var product_selected = app.getDataByCode(cb_products.jqxComboBox('val'), table.jqxGrid('getrows'));
            if (product_selected != null) {
                table.jqxGrid('updaterow', product_selected['uid'], {
                    id: product_selected['id'],
                    code: product_selected['code'],
                    name: product_selected['name'],
                    price_import: parseInt((parseInt(txt_price_import.jqxNumberInput('val'))+parseInt(product_selected['price_import']))/2),
                    number: parseInt(txt_number.jqxNumberInput('val')) + parseInt(product_selected['number']),
                    price: parseInt(txt_price_import.jqxNumberInput('val'))*parseInt(txt_number.jqxNumberInput('val')) + parseInt(product_selected['price']),
//                    expiry_at: txt_expiry_at.jqxDateTimeInput('val')
                });
            } else {
                table.jqxGrid('addrow', null, {
                    id: table.jqxGrid('getrows').length,
                    code: cb_products.jqxComboBox('val'),
                    name: app.getNameByCode(cb_products.jqxComboBox('val'), products_list),
                    price_import: parseInt(txt_price_import.jqxNumberInput('val')),
                    number: txt_number.jqxNumberInput('val'),
                    price: parseInt(txt_price_import.jqxNumberInput('val'))*parseInt(txt_number.jqxNumberInput('val')),
//                    expiry_at: txt_expiry_at.jqxDateTimeInput('val')
                });
            }
            ProductImportAPP.clean();
            ProductImportAPP.calculate_price();
        }


        //Xác thực lưu
        btn_save_server.click(function () {
            if (table.jqxGrid('getrows').length <= 0) {
                app.notify('Chưa có sản phẩm để lưu!', 'warning');
                return;
            }
            if (cb_timnhacungcap.jqxComboBox('val').trim() == '') {
                app.notify('Chưa chọn nhà cung cấp!', 'warning');
                cb_timnhacungcap.jqxComboBox('focus');
                return;
            }

            function inhoadon(mahoadon) {
                var noidung = template_bill;
                var date_now = '{!! \App\CusstomPHP\Time::Datenow() !!}';
                var products = table.jqxGrid('getrows');
                var table_print = "";
                var sum_number = 0;
                for (var i = 0; i < products.length; i++) {
                    table_print += "<tr>";
                    table_print += "<td>" + products[i]['id'] + "</td>";
                    table_print += "<td>" + products[i]['code'] + "</td>";
                    table_print += "<td>" + products[i]['name'] + "</td>";
                    table_print += "<td style='text-align: right;'>" + products[i]['number'] + "</td>";
                    table_print += "<td style='text-align: right;'>" + parseInt(parseInt(products[i]['price_import']) / parseInt(products[i]['number'])).toLocaleString() + "</td>";
                    table_print += "<td style='text-align: right;'>" + 0 + "</td>";
                    table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price_import']).toLocaleString() + "</td>";
                    table_print += "</tr>";
                    sum_number += parseInt(products[i]['number'])
                }
                var supppiler_x=app.getDataByCode(cb_timnhacungcap.jqxComboBox('val'), suppliers);
                noidung = noidung.replace("{Ma_Nhap_Hang}", mahoadon);
                noidung = noidung.replace("{Dia_Chi_NCC}", supppiler_x.address);
                noidung = noidung.replace("{So_Dien_Thoai}", supppiler_x.phone);
                noidung = noidung.replace("{Chi_Nhanh_Nhap}", app.getNameByCode(me.branch, branches));
                noidung = noidung.replace("{Nguoi_Tao}", me.name);
                noidung = noidung.replace("{Ngay_Thang_Nam}", date_now);
                noidung = noidung.replace("{Nha_Cung_Cap}", cb_timnhacungcap.jqxComboBox('val') + " - " + app.getNameByCode(cb_timnhacungcap.jqxComboBox('val'), suppliers));

                noidung = noidung.replace("{Tong_So_Luong_Hang}", sum_number);
                noidung = noidung.replace("{Tong_Tien_Hang}", parseInt(txt_tienhang.jqxNumberInput('val')).toLocaleString());
                noidung = noidung.replace("{Chiet_Khau_Hoa_Don}", parseInt(txt_tienkhuyenmai.jqxNumberInput('val')).toLocaleString());
                noidung = noidung.replace("{Tong_Cong}", parseInt(txt_tienthanhtoan.jqxNumberInput('val')).toLocaleString());
                noidung = noidung.replace("{Thu_Khac}", parseInt(txt_tienkhac.jqxNumberInput('val')).toLocaleString());

                noidung = noidung.replace("<!--{Du_Lieu}-->", table_print);
                print_data(noidung, 'In hóa đơn nhập hàng');
            }

            if (table.jqxGrid('getrows').length > 0) {
                var products_import = table.jqxGrid('getrows');
                if (products_import.length == 0) {
                    app.notify('Chưa có sản phẩm để để lưu!!!', 'warning');
                    return;
                }
                if (cb_timnhacungcap.jqxComboBox('val')=='') {
                    app.notify('Chưa chọn nhà cung cấp!!!', 'warning');
                    cb_timnhacungcap.jqxComboBox('focus');
                    return;
                }
                //Save import
                GUI.disable(btn_save_server);
                btn_save_server.html('Đang lưu...');
                products_save = null;
                add_data(urls.url_apis.product_import, {
                    code: "PN/",
                    branch: me['branch'],
                    customer: cb_timnhacungcap.jqxComboBox('val'),
                    customer_name: app.getNameByCode(cb_timnhacungcap.jqxComboBox('val'), suppliers),
                    type: "IMPORT",
                    products: JSON.stringify(table.jqxGrid('getrows')),
                    total_price: txt_tienhang.jqxNumberInput('val'),
                    total_pay: txt_tientraNCC.jqxNumberInput('val'),
                    other_price: txt_tienkhac.jqxNumberInput('val'),
                    discount: txt_tienkhuyenmai.jqxNumberInput('val'),
                    state: 'SUCCESS',
                    note: txt_import_note.jqxTextArea('val'),
                    user: me['username'],
                    finance_cat: cb_account_type.jqxDropDownList('val')
                }, function (result) {
                    if (result['success']) {
                        app.notify('Lưu nhập hàng thành công!', 'success');
                        products_save = result['data']['products'];
                        inhoadon(result['data']['code']);
                    } else {
                        app.notify('Lỗi khi lưu hàng nhập!', 'error');
                    }
                    GUI.able(btn_save_server);
                    btn_save_server.html("<i class='fa fa-cloud-upload'></i> Lưu nhập hàng (F9)");
                })
            } else {
                app.notify('Chưa có gói hàng để lưu!!!', 'warning');
            }
        });
        //Tính lại tiền trả
        $('#tientraNCC').on('valueChanged', function (event) {
            ProductImportAPP.calculate_price();
        });
        $('#tienkhac').on('valueChanged', function (event) {
            ProductImportAPP.calculate_price();
        });
        $('#tienkhuyenmai').on('valueChanged', function (event) {
            ProductImportAPP.calculate_price();
        });

        //Lựa chọn tất cả các input
        $('input').click(function () {
            $(this).select();
        });


        //In mã vạch gói
//        btn_print_qr.click(function () {
//            if (products_save === null) {
//                app.notify('Lưu hóa đơn nhập hàng trước!', 'warning');
//                return;
//            }
//            var container_data = $('<div></div>');
//            products_save = JSON.parse(products_save);
//            for (var i in products_save) {
//                container_data.append(dataqrProduct(i, products_save[i], app.getDataByCode(products_save[i], products_list)['name']));
//            }
//            print_data(container_data.html(), 'In mã vạch gói');
//            products_save = JSON.stringify(products_save);
//            hoiXoadulieu();
//        });

        //Xử lý chọn nhà cung cấp
        function chonNCC() {
            if (app.getDataByCode(cb_timnhacungcap.jqxComboBox('val'), suppliers) != null) {
                cb_timnhacungcap.addClass('input-search-selected');
                //cb_timnhacungcap.jqxComboBox('selectItem',cb_timnhacungcap.jqxComboBox('val'));
            } else {
                cb_timnhacungcap.removeClass('input-search-selected');
            }
        }

        //Chọn form nhà cung cấp
        $('#timnhacungcap').on('unselect', function (event) {
            chonNCC();
        });
        $('#timnhacungcap').on('change', function (event) {
            chonNCC();
        });
        $('#timnhacungcap').find('input').click(function () {
            $(this).select();
        });
        $('#timnhacungcap').find('input').keyup(function (e) {
            chonNCC();
            if (e.keyCode == 13) {
                txt_tientraNCC.jqxNumberInput('focus');
            }
        });
        $('#timnhacungcap').focusout(function () {
            if ($('#timnhacungcap').find('input').val().trim() == '') {
                $('#timnhacungcap').jqxComboBox('selectIndex', -1);
            }
            chonNCC();
        });

        //Hỏi có xóa dữ liệu để nhập hàng khác không?
        function hoiXoadulieu() {
            swal({
                title: 'Tạo nhập hàng mới?',
                text: "Xóa dữ liệu hiện tại và mở nhập hàng mới!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Tạo mới',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                ProductImportAPP.clean();
                cb_timnhacungcap.jqxComboBox('val','');
                table.jqxGrid('clear');
                ProductImportAPP.calculate_price();
            }).catch(swal.noop);
        }
        //Phím trên chọn sản phẩm
        $('#products').find('input').keyup(function (e) {
            if (e.keyCode == 13) {
                if (cb_products.jqxComboBox('val').trim() != '') {
                    txt_number.jqxNumberInput('focus');
                    $('#number').find('input').select();
                }else {
                    app.notify('Sản phẩm không tồn tại!','warning');
                }
            }
        });
        $('#price_import').find('input').keyup(function (e) {
            if (e.keyCode == 13) {
//                txt_expiry_at.jqxDateTimeInput('focus');
//                $('#price_import').find('> input').select();
                add_to_table();
            }
        });
        $('#number').find('input').keyup(function (e) {
            if (e.keyCode == 13) {
                if (txt_number.jqxNumberInput('val') > 0) {
                    var pt = app.getDataByCode(cb_products.jqxComboBox('val'), products_list);
                    var number_t = txt_number.jqxNumberInput('val');
                    txt_price_import.jqxNumberInput('val', parseInt(pt['price_import']));
                    txt_price_import.jqxNumberInput('focus');
                    $('#price_import').find('input').select();
                }else {
                    app.notify("Số lượng nhập phải lớn hơn không!",'warning');
                }
            }
        });
//        $('#inputexpiry_at').keyup(function (e) {
//            if (e.keyCode == 13) {
//                add_to_table();
//            }
//        });
    };

    ProductImportAPP.calculate_price=function () {
        var products_import = table.jqxGrid('getrows');
        var sum_price = 0;
        for (var i = 0; i < products_import.length; i++) {
            sum_price += products_import[i]['price'];
        }
        txt_tienhang.jqxNumberInput('val', sum_price);
        sum_price = 0;
        var a = txt_tienhang.jqxNumberInput('val');
        var b = txt_tientraNCC.jqxNumberInput('val');
        var c = txt_tienkhac.jqxNumberInput('val');
        var d = txt_tienkhuyenmai.jqxNumberInput('val');
        sum_price = parseFloat(a) + parseFloat(c) - parseFloat(d);
        var sum_pay = parseFloat(b);
        txt_tienno.jqxNumberInput('val', parseFloat(sum_price - sum_pay));
        txt_tienthanhtoan.jqxNumberInput('val', sum_price);
    };

    ProductImportAPP.change_number = function (num, row) {
        if ($.isNumeric(num)) {
            var product_selected = table.jqxGrid('getrowdatabyid', row);
            if (parseInt(product_selected['number']) + parseInt(num) >= 0) {
                table.jqxGrid('updaterow', product_selected['uid'], {
                    id: product_selected['id'],
                    code: product_selected['code'],
                    name: product_selected['name'],
                    price_import: parseInt(product_selected['price_import']),
                    number: parseInt(product_selected['number']) + parseInt(num),
                    price: product_selected['price_import'] * (parseInt(product_selected['number']) + parseInt(num)),
                });
            }
        }
        ProductImportAPP.calculate_price();
    };

    ProductImportAPP.clean = function () {
        cb_products.jqxComboBox('val', '');
        txt_number.jqxNumberInput('val', 0);
        txt_price_import.jqxNumberInput('val', 0);
        cb_products.jqxComboBox('open');
        $('#dropdownlistContentproducts').find('input').focus();
    };

    function view_start() {
        ProductImportAPP.createUI();
        ProductImportAPP.createData();
        ProductImportAPP.createEvent();
        $('#dropdownlistContentproducts').find('input').focus();
    }
</script>