<div class="view">
    <div id="sidebar" style="float: right;width: 26.5%;margin-left: 1%;margin-right: 0;">
        <div class="sidebar-item">
            <div>Thông tin trả hàng nhập</div>
            <div>
                <div>
                    <div style="position: relative;margin-top: 10px;margin-bottom: 5px;">
                        <i class="fa fa-search icon-customer-s"></i>
                        <div class="sale-input-active" style="padding-left: 35px;" id="timnhacungcap"></div>
                        <i id="add_supplier" class="fa fa-plus ic-find"></i>
                    </div>
                </div>

                <div style="margin-top: 10px;" class="div-sale clearfix">
                    <label class="lable_sale" for="Stienhang">Tổng tiền hàng:</label>
                    <input class="sale-input sale-input-green" id="Stienhang">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Skhuyenmai">Tiền khuyến mãi:</label>
                    <input class="sale-input sale-input-active"  id="Skhuyenmai">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Sthukhac">Tiền thu khác:</label>
                    <input class="sale-input sale-input-active" id="Sthukhac">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Sthanhtoan">Tổng thanh toán:</label>
                    <input class="sale-input" id="Sthanhtoan">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="StienNCCtra">NCC thanh toán:</label>
                    <input class="sale-input sale-input-active sale-input-yellow" id="StienNCCtra">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Snolai">NCC nợ lại:</label>
                    <input class="sale-input" id="Snolai">
                </div>
                <div class="div-sale">
                    <label class="lable_sale">Chọn tài khoản:</label>
                    <div class="sale-select sale-input-active" id="account_type"></div>
                </div>

                <div>
                    <label style="margin-top: 0;" class="">Ghi chú:</label>
                    <textarea class="" id="ghichu"></textarea>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px;">
            <button style="font-size: 17px;border-radius: 0;" id="btn_save_server"><i class="fa fa-print"></i> Lưu hóa đơn
                (F9)
            </button>
        </div>
    </div>
    <div id="content-table" style="float: left;width: 72%;">
        <div class="input-product-top">
            <h2>Trả hàng nhập</h2>

            <div class="container-xx">
                <i class="fa fa-search icon-product-s"></i>

                <div id="timsanpham" style=""></div>
            </div>
            <div class="container-xx" style="margin-left: 0;">
                <input id="soluong" style="">
            </div>
        </div>
        <div id="table"></div>
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
    var ReturnImportAPP = {};
    var table = $('#table');
    var products_list = null;
    var branches  = null;
    var finance_cat = null;
    var suppliers = null;
    var table_dataAdapter;
    var table_source;
    var template_bill = null;
    var customer_cats = null;
    var txt_timsanpham = $('#timsanpham');
    var txt_soluong = $('#soluong');
    var cb_timnhacungcap = $('#timnhacungcap');
    var txt_tienhang = $('#Stienhang');
    var txt_khuyenmai = $('#Skhuyenmai');
    var txt_thukhac = $('#Sthukhac');
    var txt_thanhtoan = $('#Sthanhtoan');
    var txt_tienNCCtra = $('#StienNCCtra');
    var txt_nolai = $('#Snolai');
    var txt_ghichu = $('#ghichu');
    var btn_save_server = $('#btn_save_server');

    var cb_account_type = $('#account_type');
    var add_supplier = $("#add_supplier");
    var windows_add_s = $('#windows_add_s');

    var txt_code_s = $('#code_s');
    var txt_name_s = $('#name_s');
    var txt_email_s = $('#email_s');
    var txt_phone_s = $('#phone_s');
    var txt_address_s = $('#address_s');
    var txt_note_s = $('#note_s');
    var btn_submit_s = $('#btn_submit_s');
    var btn_cancel_s = $('#btn_cancel_s');

    ReturnImportAPP.createData = function () {
        app.loadding('open');
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 3) {
                app.loadding('close');
                txt_timsanpham.jqxComboBox({source: products_list});
                cb_timnhacungcap.jqxComboBox({source: suppliers});
                cb_account_type.jqxDropDownList({source: finance_cat});
                //setup default
                cb_account_type.jqxDropDownList('selectItem',settings.acc_default);
            }
        }

        //local
        customer_cats = JSON.parse(localStorage.getItem(tables.customer_cat));
        finance_cat = JSON.parse(localStorage.getItem(tables.finance_cat));
        branches  = JSON.parse(localStorage.getItem(tables.branches));
        //data from server
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE branch LIKE '" + me.branch + "'",
            data: "code,name AS 'pname',price_import"
        }, null, function (result) {
            if (result['success']) {
                products_list = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });

        download_data(urls.url_apis.suppliers, function (result) {
            if (result['success']) {
                suppliers = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });

        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE name LIKE 'return_import_template' AND branch LIKE '" + me.branch + "'",
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
    ReturnImportAPP.createUI = function () {
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

        windows_add_s.jqxWindow({
            position: {x: (($(window).width() - 400) / 2), y: '10%'},
            width: 400,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel_s,
            autoOpen: false
        });
        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        //Input
        txt_ghichu.jqxTextArea({
            width: '100%',
            height: 50
        });

        txt_tienNCCtra.jqxNumberInput({
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
        txt_thanhtoan.jqxNumberInput({
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

        txt_timsanpham.jqxComboBox({
            dropDownWidth: 315,
            dropDownHeight: 300,
            width: 290,
            height: 35,
            source: null,
            displayMember: 'pname',
            valueMember: 'code',
            showArrow: false,
            theme:'light',
            searchMode: 'containsignorecase',
            placeHolder: "Tìm kiếm sản phẩm",
            renderer: function (index, label, value) {
                var product = products_list[index];
                return '<div style="margin: 3px 0;">' +
                    '<div style="font-weight: bold;width: 100%;">' + product['pname'] + '</div>' +
                    '<div style="width: 100%;margin-top: 3px;font-size: 11px">' +
                    '<span style="width: 50%;display: inline-block;font-size: 13px;">Mã: ' + product['code'] + '</span>' +
                    '<span style="width: 50%;display: inline-block;font-size: 13px;">Giá nhập: ' + '<span style="font-weight: 300;font-size: 13px;">' + parseInt(product['price_import']).toLocaleString('vi-VN') + '</span></span>' +
                    '</div></div>';
            }
        });

        cb_account_type.jqxDropDownList({height: 30, width: '100%',
            source:finance_cat,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: "Chọn tài khoản",
        });
        cb_timnhacungcap.jqxComboBox({
            height: 35,
            width: 'calc(100% - 35px)',
            source: suppliers,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: "Tìm kiếm nhà cung cấp",
            showArrow: false,
            theme:'light',
            searchMode: "containsignorecase",
            renderSelectedItem: function (index, item) {
                if (item['value'] !== '') {
                    return item['label'] + ' - ' + item['value'];
                }
                return "";
            }
        });
        btn_save_server.jqxButton({width: '100%', height: '55px', template: 'success'});

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
                {name: 'price_import', type: 'number'},
                {name: 'price_sale', type: 'number'},
                {name: 'price', type: 'number'},
                {name: 'btn_remove', type: 'string'},
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            pageSize: 20,
            altRows: true,
            pageable: false,
            height: 'calc(100% - 70px)',
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
                    text: 'Giá nhập',
                    dataField: 'price_import',
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
                        return "<div style='color: #d60f01;padding: 7px;font-size: 16px;'><i class='fa fa-times'></i></div>"
                    }
                }
            ],
        });
        table.jqxGrid('localizestrings', grid_lang);
    };
    ReturnImportAPP.createEvent = function () {
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
        //Thêm nhà cung cấp
        add_supplier.click(function () {
            windows_add_s.jqxWindow('open');
        });
        //Hiển thị đổi giá
        table.on('cellendedit', function (event) {
            var args = event.args;
            setTimeout(function () {
                ReturnImportAPP.change_number(0, args.rowindex);
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
                ReturnImportAPP.calculate_price();
            });
            btn_no.click(function () {
                popup_xoa.jqxPopover('close');
            });
        }

        table.on("cellclick", function (event) {
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
                    var data = table.jqxGrid('getrows');
                    var index = data.findIndex(x => x.code === sp['code']);
                    var product_selected;
                    if (index >= 0) {
                        product_selected = data[index];
                    } else {
                        product_selected = null;
                    }
                    if (product_selected !== null) {
                        table.jqxGrid('updaterow', product_selected['uid'], {
                            id: product_selected['id'],
                            code: product_selected['code'],
                            name: product_selected['name'],
                            number: parseInt(product_selected['number']) + parseInt(txt_soluong.jqxNumberInput('val')),
                            price_import: product_selected['price_import'],
                            price_sale: product_selected['price_import'],
                            price: product_selected['price_import'] * (parseInt(product_selected['number']) + parseInt(txt_soluong.jqxNumberInput('val'))),
                        });
                    } else {
                        table.jqxGrid('addrow', null, {
                            id: table.jqxGrid('getrows').length,
                            code: sp['code'],
                            name: sp['pname'],
                            number: txt_soluong.jqxNumberInput('val'),
                            price_import: parseInt(sp['price_import']),
                            price_sale: parseInt(sp['price_import']),
                            price: parseInt(sp['price_import']) * parseInt(txt_soluong.jqxNumberInput('val')),
                        });
                    }
                    txt_timsanpham.jqxComboBox('val', '');
                    txt_timsanpham.jqxComboBox('focus');
                }
                ReturnImportAPP.calculate_price();
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
            ReturnImportAPP.calculate_price();
        });
        $('#StienNCCtra').on('valueChanged', function () {
            var thanhtoan = txt_thanhtoan.jqxNumberInput('val');
            var khachtra = txt_tienNCCtra.jqxNumberInput('val');
            txt_nolai.jqxNumberInput('val', parseInt(thanhtoan) - parseInt(khachtra));
        });
        $('#Sthukhac').on('valueChanged', function () {
            ReturnImportAPP.calculate_price();
        });

        //Save bill
        btn_save_server.click(function () {
            if(table.jqxGrid('getrows').length<=0){
                app.notify("Chưa có sản phẩm nào để lưu!",'warning');
                return;
            }
            ReturnImportAPP.save_bill();
        });
        //Xử lý chọn nhà cung cấp
        function chonNCC() {
            if(app.getDataByCode(cb_timnhacungcap.jqxComboBox('val'),suppliers)!=null){
                cb_timnhacungcap.addClass('input-search-selected');
            }else {
                cb_timnhacungcap.removeClass('input-search-selected');
            }
        }
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
                txt_tienNCCtra.jqxNumberInput('focus');
            }
        });
        $('#timnhacungcap').focusout(function () {
            if ($('#timnhacungcap').find('input').val().trim() == '') {
                $('#timnhacungcap').jqxComboBox('selectIndex', -1);
            }
            chonNCC();
        });
    };


    ReturnImportAPP.change_number = function (num, row) {
        if ($.isNumeric(num)) {
            var product_selected = table.jqxGrid('getrowdatabyid', row);
            if (parseInt(product_selected['number']) + parseInt(num) >= 0) {
                table.jqxGrid('updaterow', product_selected['uid'], {
                    id: product_selected['id'],
                    code: product_selected['code'],
                    name: product_selected['name'],
                    number: parseInt(product_selected['number']) + parseInt(num),
                    price_import: product_selected['price_import'],
                    price_sale: product_selected['price_sale'],
                    price: product_selected['price_sale'] * (parseInt(product_selected['number']) + parseInt(num)),
                });
            }
        }
        ReturnImportAPP.calculate_price();
    };
    ReturnImportAPP.clear = function () {
        table.jqxGrid('clear');
        ReturnImportAPP.calculate_price();
        cb_timnhacungcap.jqxComboBox('val', '');
    };

    ReturnImportAPP.calculate_price = function (reload) {
        var p_selected = table.jqxGrid('getrows');
        var sum_price = 0;
        if (p_selected != null) {
            for (var i = 0; i < p_selected.length; i++) {
                sum_price += parseInt(p_selected[i]['price']);
            }
        }
        var khachtra = txt_tienNCCtra.jqxNumberInput('val');
        var khuyenmai = txt_khuyenmai.jqxNumberInput('val');
        var thukhac = txt_thukhac.jqxNumberInput('val');
        txt_tienhang.jqxNumberInput('val', sum_price);
        txt_thanhtoan.jqxNumberInput('val', parseInt(sum_price) + parseInt(thukhac) - parseInt(khuyenmai));
        var thanhtoan = txt_thanhtoan.jqxNumberInput('val');
        khachtra = txt_thanhtoan.jqxNumberInput('val');
        txt_tienNCCtra.jqxNumberInput('val', khachtra);
        txt_nolai.jqxNumberInput('val', parseInt(thanhtoan) - parseInt(khachtra));
    };
    
    
    ReturnImportAPP.save_bill = function () {
        if(table.jqxGrid('getrows').length<=0){
            app.notify('Chưa có sản phẩm để lưu!','warning');
            return;
        }
        if(cb_timnhacungcap.jqxComboBox('val').trim()==''){
            app.notify('Chưa chọn nhà cung cấp!','warning');
            cb_timnhacungcap.jqxComboBox('focus');
            return;
        }

        function inhoadon(mahoadon) {
            var noidung = template_bill;
            var date_now = '<?php echo \App\CusstomPHP\Time::Datenow(); ?>';
            var products = table.jqxGrid('getrows');
            var table_print = "";
            var sum_number=0;
            for (var i = 0; i < products.length; i++) {
                table_print += "<tr>";
                table_print += "<td>" + products[i]['id'] + "</td>";
                table_print += "<td>" + products[i]['code'] + "</td>";
                table_print += "<td>" + products[i]['name'] + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(parseInt(products[i]['price_import'])/parseInt(products[i]['number'])).toLocaleString() + "</td>";
                table_print += "<td style='text-align: right;'>" + products[i]['number'] + "</td>";
                table_print += "<td style='text-align: right;'>" + 0 + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price_import']).toLocaleString() + "</td>";
                table_print += "</tr>";
                sum_number+=parseInt(products[i]['number'])
            }
            noidung = noidung.replace("{Ma_Nhap_Hang}", mahoadon);
            noidung = noidung.replace("{Chi_Nhanh_Nhap}", app.getNameByCode(me.branch,branches));
            noidung = noidung.replace("{Nguoi_Tao}", me.name);
            noidung = noidung.replace("{Ngay_Thang_Nam}", date_now);
            noidung = noidung.replace("{Nha_Cung_Cap}", cb_timnhacungcap.jqxComboBox('val')+" - "+app.getNameByCode(cb_timnhacungcap.jqxComboBox('val'),suppliers));

            noidung = noidung.replace("{Tong_So_Luong_Hang}",sum_number);
            noidung = noidung.replace("{Tong_Tien_Hang}", parseInt(txt_tienhang.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Chiet_Khau_Hoa_Don}", parseInt(txt_khuyenmai.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Tong_Cong}", parseInt(txt_thanhtoan.jqxNumberInput('val')).toLocaleString());
            noidung = noidung.replace("{Thu_Khac}", parseInt(txt_thukhac.jqxNumberInput('val')).toLocaleString());

            noidung = noidung.replace("<!--{Du_Lieu}-->", table_print);
            print_data(noidung, 'In hóa đơn trả nhập hàng');
        }

        if (table.jqxGrid('getrows').length > 0) {
            var products_import = table.jqxGrid('getrows');
            if (products_import.length == 0) {
                app.notify('Chưa có gói hàng để lưu!!!', 'warning');
                return;
            }
            //Save import
            GUI.disable(btn_save_server);
            btn_save_server.html('Đang lưu...');
            products_save=null;
            add_data(urls.url_apis.product_return_import,{
                code: "PTN/",
                branch: me['branch'],
                customer: cb_timnhacungcap.jqxComboBox('val'),
                customer_name: app.getNameByCode(cb_timnhacungcap.jqxComboBox('val'),suppliers),
                type: "RETURNIMPORT",
                products: JSON.stringify(table.jqxGrid('getrows')),
                total_price: txt_tienhang.jqxNumberInput('val'),
                total_pay: txt_tienNCCtra.jqxNumberInput('val'),
                other_price: txt_thukhac.jqxNumberInput('val'),
                discount: txt_khuyenmai.jqxNumberInput('val'),
                state: 'SUCCESS',
                note: txt_ghichu.jqxTextArea('val'),
                user: me['username'],
                finance_cat:cb_account_type.jqxDropDownList('val')
            },function (result) {
                if(result['success']){
                    app.notify('Lưu trả nhập hàng thành công!','success');
                    products_save=result['data']['products'];
                    inhoadon(result['data']['code']);
                    ReturnImportAPP.clear();
                }else {
                    app.notify('Lỗi khi lưu trả hàng nhập!','error');
                }
                GUI.able(btn_save_server);
                btn_save_server.html("<i class='fa fa-cloud-upload'></i> Lưu nhập hàng (F9)");
            })
        } else {
            app.notify('Chưa có gói hàng để lưu!!!', 'warning');
        }
    };

    function view_start() {
        ReturnImportAPP.createUI();
        ReturnImportAPP.createData();
        ReturnImportAPP.createEvent();
        txt_timsanpham.jqxComboBox('focus');
    }
</script>