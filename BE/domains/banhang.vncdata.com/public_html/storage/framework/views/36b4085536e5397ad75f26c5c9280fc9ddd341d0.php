<div class="view">
    <div id="sidebar" style="float: right;width: 26.5%;margin-left: 1%;margin-right: 0;">
        <div class="sidebar-item">
            <div>Thông tin kiểm kho</div>
            <div>
                <div style="margin-top: 10px;" class="div-sale clearfix">
                    <label class="lable_sale" for="Sslhang">Số lượng hàng:</label>
                    <input class="sale-input" id="Sslhang">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Ssltang">Số lượng tăng:</label>
                    <input class="sale-input" style="border-bottom: 1px solid #5cb85c;" id="Ssltang">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Stientang">Giá trị tăng:</label>
                    <input style="border-bottom: 1px solid #5cb85c;" class="sale-input" id="Stientang">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Sslgiam">Số lượng giảm:</label>
                    <input class="sale-input" id="Sslgiam">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Stiengiam">Giá trị giảm:</label>
                    <input style="border-bottom: 1px solid #5cb85c;" class="sale-input" id="Stiengiam">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Ssllech">Số lượng lệch:</label>
                    <input class="sale-input" id="Ssllech">
                </div>
                <div class="div-sale clearfix">
                    <label class="lable_sale" for="Stienlech">Giá trị lệch:</label>
                    <input class="sale-input" id="Stienlech">
                </div>
                <div>
                    <label for="ghichu">Ghi chú:</label>
                    <textarea id="ghichu"></textarea>
                </div>
            </div>
        </div>
        <div style="margin-top: 15px;">
            <button style="font-size: 17px;border-radius: 0;" id="luuhoadon"><i class="fa fa-print"></i> Lưu kiểm kho
                (F9)
            </button>
            <div style="margin-top: 6px;" id="autoprint">In hóa đơn sau khi lưu</div>
        </div>
    </div>
    <div id="content-table" style="float: left;width: 72%;">
        <div class="input-product-top">
            <h2>Kiểm kho</h2>

            <div class="container-xx">
                <i class="fa fa-search"
                   style="position: absolute;left: 0;z-index: 99;top: 0;height: 15px;width: 15px;padding: 12px 9px;"></i>

                <div id="timsanpham" style=""></div>
            </div>
            <div class="container-xx" style="margin-left: 0;">
                <input id="soluong" style="">
            </div>
            <div class="container-xx" style="margin-right: 0;float: right;">
                <button id="mayquet" style=""><i class="fa fa-qrcode"></i> Máy quét</button>
            </div>
        </div>
        <div id="table"></div>
    </div>

</div>


<script>
    var StockAPP = {};
    var table = $('#table');
    var products_list = null;
    var customers = null;
    var table_dataAdapter;
    var table_source;
    var template_bill = null;
    var customer_cats = null;
    var txt_timsanpham = $('#timsanpham');
    var txt_soluong = $('#soluong');
    var btn_mayquet = $('#mayquet');

    var txt_slhang = $('#Sslhang');
    var txt_sltang = $('#Ssltang');
    var txt_tientang = $('#Stientang');
    var txt_slgiam = $('#Sslgiam');
    var txt_tiengiam = $('#Stiengiam');
    var txt_sllech = $('#Ssllech');
    var txt_tienlech = $('#Stienlech');

    var txt_ghichu = $('#ghichu');
    var btn_luuhoadon = $('#luuhoadon');
    var ck_autoprint = $('#autoprint');

    StockAPP.createData = function () {
        app.loadding('open');
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 3) {
                app.loadding('close');
                txt_timsanpham.jqxComboBox({source: products_list});
            }
        }

        //local
        customer_cats = JSON.parse(localStorage.getItem(tables.customer_cat));
        //data from server
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE branch LIKE '" + me.branch + "'",
            data: "code,name AS 'pname',price_main,number AS 'number_max'"
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
                template_bill = result['data'][0]['value'];
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
    };
    StockAPP.createUI = function () {
        //windows
        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        //Input
        txt_ghichu.jqxTextArea({
            width: '100%',
            height: 40
        });
        txt_slgiam.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            digits: 12,
            symbolPosition: 'right',disabled: true
        });
        txt_slhang.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0,
            digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            symbolPosition: 'right', disabled: true
        });
        txt_sllech.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            symbolPosition: 'right',disabled: true
        });
        txt_sltang.jqxNumberInput({
            width: '100%',
            height: 26,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            symbolPosition: 'right',disabled: true
        });
        txt_tiengiam.jqxNumberInput({
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
        txt_tienlech.jqxNumberInput({
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
        txt_tientang.jqxNumberInput({
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
            symbolPosition: 'right',
            theme:'light',
        });
        btn_mayquet.jqxButton({height: 35, template: 'default'});
        txt_timsanpham.jqxComboBox({
            width: '300px',
            dropDownWidth: 325,
            dropDownHeight: 350,
            height: 35,
            source: null,
            theme:'light',
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
        btn_luuhoadon.jqxButton({width: '100%', height: '40px', template: 'success'});
        ck_autoprint.jqxCheckBox({width: '100%'});
        //Combobox

        //Table
        var cellsrenderer_number = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<div class="price_sale-cell price_sale-row-' + row + '">' + parseInt(value).toLocaleString('vi-VN') + ' <i class="fa fa-edit f-grid"></i></div>';
        };
        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'number'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'number', type: 'number'},
                {name: 'number_max', type: 'number'},
                {name: 'number_increase', type: 'number'},
                {name: 'number_decrease', type: 'number'},
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
            theme:'light',
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
                    text: 'Thực tế',
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
                            min: -99999999999,
                            digits: 5,
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
                    width: '70px',
                    cellsformat: 'd',
                    cellsalign: 'right', align: 'right', editable: false
                },  {
                    text: 'Tăng',
                    dataField: 'number_increase',
                    width: '70px',
                    cellsformat: 'd',
                    cellsalign: 'right', align: 'right', editable: false
                }, {
                    text: 'Giảm',
                    dataField: 'number_decrease',
                    width: '70px',
                    cellsformat: 'd',
                    cellsalign: 'right', align: 'right', editable: false
                }, {
                    text: 'Giá trị lệch',
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
    StockAPP.createEvent = function () {
        //Hiển thị đổi giá
        table.on('cellendedit', function (event) {
            var args = event.args;
            setTimeout(function () {
                StockAPP.change_number(0, args.rowindex);
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
                StockAPP.calculate_price();
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
        $('#timsanpham').find('input').keyup(function (e) {
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
        $('#soluong').find('input').keyup(function (e) {
            if (e.keyCode == 13) {
                var deviation=0;
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
                        deviation=parseInt(product_selected['number_max'])-parseInt(txt_soluong.jqxNumberInput('val'));
                        table.jqxGrid('updaterow', product_selected['uid'], {
                            id: product_selected['id'],
                            code: product_selected['code'],
                            name: product_selected['name'],
                            number: parseInt(txt_soluong.jqxNumberInput('val')),
                            number_max: product_selected['number_max'],
                            price_sale: product_selected['price_sale'],
                            number_decrease:(deviation>0)?deviation:0,
                            number_increase:(deviation<0)?-deviation:0,
                            price: product_selected['price_sale'] * parseInt((deviation<0)?-deviation:deviation),
                        });
                    } else {
                        deviation=parseInt(sp['number_max'])-parseInt(txt_soluong.jqxNumberInput('val'));
                        table.jqxGrid('addrow', null, {
                            id: table.jqxGrid('getrows').length,
                            code: sp['code'],
                            name: sp['pname'],
                            number: txt_soluong.jqxNumberInput('val'),
                            number_max: parseInt(sp['number_max']),
                            price_sale: parseInt(sp['price_main']),
                            number_decrease:(deviation>0)?deviation:0,
                            number_increase:(deviation<0)?-deviation:0,
                            price: parseInt(sp['price_main']) * parseInt((deviation<0)?-deviation:deviation),
                        });
                    }
                    txt_timsanpham.jqxComboBox('val', '');
                    txt_timsanpham.jqxComboBox('focus');
                }
                StockAPP.calculate_price();
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
            StockAPP.calculate_price();
        });
        $('#Skhachthanhtoan').on('valueChanged', function () {
            var thanhtoan = txt_thanhtoan.jqxNumberInput('val');
            var khachtra = txt_khachthanhtoan.jqxNumberInput('val');
            txt_nolai.jqxNumberInput('val', parseInt(thanhtoan) - parseInt(khachtra));
        });
        $('#Sthukhac').on('valueChanged', function () {
            StockAPP.calculate_price();
        });

        //Thêm khách hàng mới

        //Save bill
        btn_luuhoadon.click(function () {
            if(table.jqxGrid('getrows').length<=0){
                app.notify("Chưa có sản phẩm nào để lưu!",'warning');
                return;
            }
            StockAPP.save_bill();
        });
    };



    StockAPP.change_number = function (num, row) {
        if ($.isNumeric(num)) {
            var product_selected = table.jqxGrid('getrowdatabyid', row);
            if (parseInt(product_selected['number']) + parseInt(num) >= 0) {
                deviation=parseInt(product_selected['number_max'])-parseInt(parseInt(product_selected['number']) + parseInt(num));
                table.jqxGrid('updaterow', product_selected['uid'], {
                    id: product_selected['id'],
                    code: product_selected['code'],
                    name: product_selected['name'],
                    number: parseInt(product_selected['number']) + parseInt(num),
                    number_max: product_selected['number_max'],
                    price_sale: product_selected['price_sale'],
                    number_decrease:(deviation>0)?deviation:0,
                    number_increase:(deviation<0)?-deviation:0,
                    price: product_selected['price_sale'] * parseInt((deviation<0)?-deviation:deviation),
                });
            }
        }
        StockAPP.calculate_price();
    };


    StockAPP.clear = function () {
        table.jqxGrid('clear');
        StockAPP.calculate_price();
    };

    StockAPP.calculate_price = function (reload) {
        var p_selected = table.jqxGrid('getrows');
        var number_decrease=0;
        var number_increase=0;
        var price_decrease=0;
        var price_increase=0;
        if (p_selected !== null) {
            for (var i = 0; i < p_selected.length; i++) {
                if(parseInt(p_selected[i]['number_decrease'])!==0){
                    number_decrease+=parseInt(p_selected[i]['number_decrease']);
                    price_decrease+=parseInt(p_selected[i]['price']);
                }
                if(parseInt(p_selected[i]['number_increase'])!==0){
                    number_increase+=parseInt(p_selected[i]['number_increase']);
                    price_increase+=parseInt(p_selected[i]['price']);
                }
            }
        }
        txt_sltang.jqxNumberInput('val',number_increase);
        txt_slgiam.jqxNumberInput('val',number_decrease);
        txt_tiengiam.jqxNumberInput('val',price_decrease);
        txt_tientang.jqxNumberInput('val',price_increase);
        txt_sllech.jqxNumberInput('val',Math.abs(number_increase-number_decrease));
        txt_tienlech.jqxNumberInput('val',Math.abs(price_increase-price_decrease));
    };
    StockAPP.save_bill = function () {

        function inhoadon(mahoadon) {

        }

        //save server
        //save bill with state waitting
        add_data(urls.url_apis.sale, {
            code: "HD/",
            branch: me.branch,
            user: me['username']
        }, function (result) {
            if (result['success']) {
                app.notify("Thêm hóa đơn chờ thành công!", 'success');
                var mahoadon = result['data']['code'];
                inhoadon(mahoadon);
                StockAPP.clear();
            } else {
                app.notify("Thêm hóa đơn chờ không thành công!", 'warning');
                return false;
            }
        });

    };

    function view_start() {
        StockAPP.createUI();
        StockAPP.createData();
        StockAPP.createEvent();
    }
</script>