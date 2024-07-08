<div class="view">
    <div id="sidebar" style="float: right;width: 26.5%;margin-left: 1%;margin-right: 0;">
        <div class="sidebar-item">
            <div>Thông tin chuyển hàng</div>
            <div>
                <div>
                    <div style="position: relative;margin-top: 15px;">
                        <i class="fa fa-search icon-customer-s"></i>
                        <div id="chondailygui"
                             style="border-radius: 3px;border: 1px solid #5cb85c;padding-left: 35px;"></div>
                    </div>
                </div>
                <div style="text-align: center">
                    <i style="font-size: 25px;margin: 10px;color: #ccc;" class="fa fa-arrow-down"
                       aria-hidden="true"></i>
                </div>
                <div>
                    <div style="position: relative;margin-bottom: 20px;">
                        <i class="fa fa-search icon-customer-s"></i>
                        <div id="chondailynhan"
                             style="border-radius: 3px;border: 1px solid #5cb85c;padding-left: 35px;"></div>
                    </div>
                </div>

                <div style="margin-top: 10px;" class="div-sale clearfix">
                    <label class="lable_sale" for="Ssoluong">Số lượng hàng:</label>
                    <input class="sale-input sale-input-green" id="Ssoluong">
                </div>

                <div style="margin-top: 10px;" class="div-sale clearfix">
                    <label class="lable_sale" for="Stienhang">Tổng tiền hàng:</label>
                    <input class="sale-input sale-input-yellow" id="Stienhang">
                </div>
                <div>
                    <label for="ghichu">Ghi chú:</label>
                    <textarea id="ghichu"></textarea>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px;">
            <button style="font-size: 17px;border-radius: 0;" id="luuhoadon"><i class="fa fa-print"></i> Lưu chuyển hàng
                (F9)
            </button>
        </div>
    </div>
    <div id="content-table" style="float: left;width: 72%;">
        <div class="input-product-top">
            <h2>Chuyển hàng</h2>

            <div class="container-xx">
                <i class="fa fa-search icon-product-s"></i>

                <div id="timsanpham" style=""></div>
            </div>
            <div class="container-xx" style="margin-left: 0;">
                <input id="soluong" style="">
            </div>
            <div class="container-xx" style="margin-right: 0;float: right;">
                <button id="btn_quetma" style="">
                    <i class="fa fa-qrcode"></i>
                    Máy quét
                </button>
            </div>
        </div>
        <div id="table"></div>
    </div>
</div>


<script>
    var productMoveAPP = {};
    var table = $('#table');
    var products_list = null;
    var branches = null;
    var table_dataAdapter;
    var table_source;
    var me = null;
    var template_bill = null;
    var customer_cats = null;
    var txt_timsanpham = $('#timsanpham');
    var txt_soluong = $('#soluong');
    var txt_chondailynhan = $('#chondailynhan');
    var txt_chondailygui = $('#chondailygui');
    var txt_tienhang = $('#Stienhang');
    var txt_tongsoluong = $('#Ssoluong');
    var txt_ghichu = $('#ghichu');
    var btn_luuhoadon = $('#luuhoadon');
    var btn_quetma = $('#btn_quetma');
    var chedomayquet = false;

    productMoveAPP.createData = function () {
        app.loadding('open');
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 1) {
                app.loadding('close');
                txt_timsanpham.jqxComboBox({source: products_list});
                txt_chondailynhan.jqxDropDownList({source: branches});
                txt_chondailygui.jqxDropDownList({source: branches});
                txt_chondailygui.jqxDropDownList('selectItem', me.branch);
            }
        }

        //local
        customer_cats = JSON.parse(localStorage.getItem(tables.customer_cat));
        me = JSON.parse(localStorage.getItem(tables.me));
        //data from server
//        download_data_where(urls.url_apis.select, {
//            table: "products_list",
//            select: "WHERE branch LIKE '" + me.branch + "'",
//            data: "code,name AS 'pname',price_main,number AS 'numbermax'"
//        }, null, function (result) {
//            if (result['success']) {
//                products_list = result['data'];
//            } else {
//                app.notify('Tải dữ liệu bị lỗi!', 'error');
//            }
//            download_completed();
//            app.loadding('close');
//        });
        download_data(urls.url_apis.branches, function (result) {
            if (result['success']) {
                branches = result['data'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE name LIKE 'move_template' AND branch LIKE '" + me.branch + "'",
            data: "value"
        }, null, function (result) {
            if (result['success']) {
                template_bill = result['data'][0]['value'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
    };
    productMoveAPP.createUI = function () {
        //Popup
        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        //Input

        txt_ghichu.jqxTextArea({
            width: '100%',
            height: 40
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
        txt_tongsoluong.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " ",
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
        btn_quetma.jqxButton({height: 35, template: 'default'});
        txt_timsanpham.jqxComboBox({
            width: '300px',
            height: 35,
            source: null,
            dropDownWidth: 325,
            dropDownHeight: 350,
            displayMember: 'pname',
            valueMember: 'code',
            showArrow: false,
            theme: 'light',
            searchMode: 'containsignorecase',
            placeHolder: "Tìm kiếm sản phẩm",
            renderer: function (index, label, value) {
                var product = products_list[index];
                return '<div style="margin: 3px 0;">' +
                    '<div style="font-weight: bold;width: 100%;">' + product['pname'] + '</div>' +
                    '<div style="width: 100%;margin-top: 3px;font-size: 11px">' +
                    '<span style="width: 50%;display: inline-block;font-size: 13px;">Mã: ' + product['code'] + '</span>' +
                    '<span style="width: 50%;display: inline-block;font-size: 13px;">Giá: ' + '<span style="font-weight: 300;font-size: 13px;">' + parseInt(product['price_main']).toLocaleString('vi-VN') + '</span></span>' +
                    '</div></div>';
            }
        });
        txt_chondailynhan.jqxDropDownList({
            width: 'calc(100% - 35px)',
            height: 35,
            source: null,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: "Chọn đại lý nhận hàng",
            searchMode: 'containsignorecase'
        });
        txt_chondailygui.jqxDropDownList({
            width: 'calc(100% - 35px)',
            height: 35,
            source: null,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: "Chọn đại lý gửi hàng",
            searchMode: 'containsignorecase'
        });
        btn_luuhoadon.jqxButton({width: '100%', height: '55px', template: 'success'});

        //Table
        var cellsrenderer_number = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            if(parseInt(rowdata['number_max'])>=parseInt(value)){
                return '<div class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i class="fa fa-edit f-grid"></i></div>';
            }else {
                return '<div title="Tồn kho không đủ" style="color: red !important;" class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i style="color: red !important;" class="fa fa-exclamation-triangle f-grid"></i></div>';
            }
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
                            symbol: " ",
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
        table.jqxGrid('localizestrings', grid_lang);
    };
    productMoveAPP.createEvent = function () {
        //Hiển thị đổi giá
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
                'title': 'Xóa khỏi danh sách?',
                selector: args['originalEvent']['target']
            });

            btn_yes.click(function () {
                table.jqxGrid('deleterow', args['row']['bounddata']['uid']);
                popup_xoa.jqxPopover('close');
                productMoveAPP.calculate_price();
            });
            btn_no.click(function () {
                popup_xoa.jqxPopover('close');
            });
        }

        table.on("cellclick", function (event) {
            if (args.datafield == 'btn_remove') {
                click_remove(args);
            }
        });
        table.on('cellendedit', function (event) {
            var args = event.args;
            setTimeout(function () {
                productMoveAPP.change_number(0, args.rowindex);
            }, 100)
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
                    if (product_selected != null) {
                        table.jqxGrid('updaterow', product_selected['uid'], {
                            id: product_selected['id'],
                            code: product_selected['code'],
                            name: product_selected['name'],
                            number: parseInt(product_selected['number']) + parseInt(txt_soluong.jqxNumberInput('val')),
                            number_max: product_selected['number_max'],
                            price_sale: product_selected['price_sale'],
                            price: product_selected['price_sale'] * (parseInt(product_selected['number']) + parseInt(txt_soluong.jqxNumberInput('val'))),
                        });
                    } else {
                        table.jqxGrid('addrow', null, {
                            id: table.jqxGrid('getrows').length,
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
                productMoveAPP.calculate_price();
            }
        });


        //Save bill
        btn_luuhoadon.click(function () {
            if (table.jqxGrid('getrows').length <= 0) {
                app.notify('Chưa có sản phẩm nào để lưu!', 'warning');
                return;
            }
            var branch_re = txt_chondailynhan.jqxDropDownList('val');
            if (branch_re.trim() == '' || branch_re == txt_chondailygui.jqxDropDownList('val')) {
                app.notify('Đại lý nhận hàng không hợp lệ!', 'warning');
                return;
            }
            //Check number
            var datas=table.jqxGrid('getrows');
            for(var i=0;i<datas.length;i++){
                if(parseInt(datas[i]['number'])>parseInt(datas[i]['number_max'])){
                    app.notify('Tồn kho không đủ!','warning');
                    return;
                }
            }

            productMoveAPP.save_bill();
        });

        //Chế độ quét mã
        btn_quetma.click(function () {
            if (chedomayquet) {
                app.notify('Chế độ máy quét được tắt!', 'success');
                txt_soluong.jqxNumberInput({disabled: false});
                txt_timsanpham.jqxComboBox({searchMode: 'containsignorecase'})
            } else {
                app.notify('Chế độ máy quét được bật!', 'success');
                txt_soluong.jqxNumberInput({disabled: true});
                txt_timsanpham.jqxComboBox({searchMode: 'equals'});
            }
            setTimeout(function () {
                txt_timsanpham.jqxComboBox('val', '');
                txt_timsanpham.jqxComboBox('focus');
            }, 200);
            chedomayquet = !chedomayquet;
        });

        //Change branch
        $('#chondailygui').on('change', function (event) {
            app.loadding('open');
            txt_timsanpham.jqxComboBox('clear');
            download_data_where(urls.url_apis.select, {
                table: "products_list",
                select: "WHERE branch LIKE '" + txt_chondailygui.jqxDropDownList('val') + "' ORDER BY products_list.id DESC",
                data: "code,name AS 'pname',price_main,number AS 'numbermax'"
            }, null, function (result) {
                if (result['success']) {
                    if (result['data'].length > 0) {
                        products_list = result['data'];
                        txt_timsanpham.jqxComboBox({source: products_list});
                    } else {
                        app.notify('Đại lý này chưa có sản phẩm nào!', 'warning');
                    }
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                app.loadding('close');
            });
        });
    };

    productMoveAPP.change_number = function (num, row) {
        if ($.isNumeric(num)) {
            var product_selected = table.jqxGrid('getrowdatabyid', row);

            if (parseInt(product_selected['number']) + parseInt(num) >= 0) {
                table.jqxGrid('updaterow', product_selected['uid'], {
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
        productMoveAPP.calculate_price();
    };

    productMoveAPP.clear = function () {
        table.jqxGrid('clear');
        productMoveAPP.calculate_price();
        txt_chondailynhan.jqxDropDownList('clearSelection');
    };

    productMoveAPP.calculate_price = function (reload) {
        var p_selected = table.jqxGrid('getrows');
        var sum_price = 0;
        var sum_number = 0;
        if (p_selected != null) {
            for (var i = 0; i < p_selected.length; i++) {
                sum_price += parseInt(p_selected[i]['price']);
                sum_number += parseInt(p_selected[i]['number']);
            }
        }

        txt_tienhang.jqxNumberInput('val', sum_price);
        txt_tongsoluong.jqxNumberInput('val', sum_number);

    };
    productMoveAPP.save_bill = function () {
        btn_luuhoadon.attr('disabled', true);

        function inhoadon(mahoadon) {
            var noidung = template_bill;
            var date_now = '<?php echo \App\CusstomPHP\Time::Datenow(); ?>';
            var products = table.jqxGrid('getrows');
            var table_print = "";
            for (var i = 0; i < products.length; i++) {
                table_print += "<tr>";
                table_print += "<td>" + products[i]['id'] + "</td>";
                table_print += "<td>" + products[i]['code'] + "</td>";
                table_print += "<td>" + products[i]['name'] + "</td>";
                table_print += "<td style='text-align: right;'>" + products[i]['number'] + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price_sale']).toLocaleString() + "</td>";
                table_print += "<td style='text-align: right;'>" + parseInt(products[i]['price']).toLocaleString() + "</td>";
                table_print += "</tr>";
            }
            noidung = noidung.replace("{Ma_Chuyen_Hang}", mahoadon);

            noidung = noidung.replace("{Ngay_Thang_Nam_Chuyen}", date_now);
            noidung = noidung.replace("{Chi_Nhanh_Nhan}", app.getNameByCode(txt_chondailynhan.jqxDropDownList('val'), branches));
            noidung = noidung.replace("{Nguoi_Nhan}", 'Chưa rõ');
            noidung = noidung.replace("{Nguoi_Chuyen}", me.name);
            noidung = noidung.replace("<!--{Du_Lieu}-->", table_print);
            print_data(noidung, 'In hóa đơn chuyển hàng');
        }

        //save server
        //save bill with state waitting
        add_data(urls.url_apis.product_move, {
            code: "PC/",
            branch: txt_chondailygui.jqxDropDownList('val'),
            customer: txt_chondailynhan.jqxDropDownList('val'),
            customer_name: app.getNameByCode(txt_chondailynhan.jqxDropDownList('val'), branches),
            type: "MOVE",
            products: JSON.stringify(table.jqxGrid('getrows')),
            total_price: txt_tienhang.jqxNumberInput('val'),
            total_pay: txt_tienhang.jqxNumberInput('val'),
            other_price: 0,
            discount: 0,
            state: "SUCCESS",
            note: txt_ghichu.jqxTextArea('val'),
            user: me['username']
        }, function (result) {
            if (result['success']) {
                app.notify("Thêm hóa đơn chuyển hàng thành công!", 'success');
                var mahoadon = result['data']['code'];
                inhoadon(mahoadon);
                productMoveAPP.clear();
            } else {
                app.notify("Thêm hóa đơn không thành công!", 'warning');
            }
            btn_luuhoadon.attr('disabled', false);
        });
    };


    function view_start() {
        productMoveAPP.createUI();
        productMoveAPP.createData();
        productMoveAPP.createEvent();
        txt_timsanpham.jqxComboBox('focus');
    }
</script>