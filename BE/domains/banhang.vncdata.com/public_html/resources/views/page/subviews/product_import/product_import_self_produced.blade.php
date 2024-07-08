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
                             id="cb_search_products"></div>
                        <i id="btn_change_mode" class="fa fa-list-ul ic-find"></i>
                    </div>
                </div>
                <div id="data_input">
                    <div class="div-sale">
                        <label class="lable_sale">Mã sản phẩm:</label>
                        <input style="text-transform: uppercase;" class="sale-input sale-input-active sale-input-green"
                               id="pcode">
                    </div>
                    <div class="div-sale">
                        <label class="lable_sale">Tên sản phẩm:</label>
                        <input class="sale-input sale-input-active" id="pname">
                    </div>
                    <div class="div-sale">
                        <label class="lable_sale">Giá vốn:</label>
                        <input class="sale-input sale-input-active" id="price_import">
                    </div>
                    <div class="div-sale">
                        <label class="lable_sale">Giá bán:</label>
                        <input class="sale-input sale-input-active" id="price_main">
                    </div>
                    <div class="div-sale">
                        <label class="lable_sale">Số lượng:</label>
                        <input class="sale-input sale-input-active sale-input-yellow" id="number">
                    </div>
                    <div class="div-sale">
                        <label class="lable_sale">Phân loại nhanh:</label>
                        <input style="text-transform: uppercase" class="sale-input sale-input-active" id="auto_type">
                    </div>
                    <div>
                        <label style="margin-top: 0;">Ghi chú:</label>
                        <textarea class="" id="note"></textarea>
                    </div>
                </div>
                <div id="data_select" style="display: none;">
                    <div id="table2"></div>
                </div>

            </div>
        </div>
        <button style="font-size: 16px;margin-top: 5px;border-radius: 0;" id="btn_add_table">
            <i class='fa fa-plus-circle'></i> Thêm vào bảng
        </button>

    </div>
    <div id="content-table" style="float: left;width: calc(100% - 370px);">
        <div class="input-product-top">
            <h2>Nhập hàng vào kho</h2>
            <div class="container-xx" style="margin-right: 0;float: right;">
                <button id="btn_save_server" style="">
                    <i class="fa fa-cloud-upload"></i> Lưu máy chủ
                </button>
            </div>
        </div>
        <div id="table"></div>
    </div>
</div>

<script>
    var ProductImportSelfProducedtAPP = {};
    var table_source;
    var table_source2;
    var table_dataAdapter;
    var table_dataAdapter2;
    var table = $('#table');
    var table2 = $('#table2');
    var products_list = null;
    var branches = null;
    var data_mode = 'SELECT';

    var btn_change_mode = $('#btn_change_mode');
    var cb_search_products = $('#cb_search_products');
    var pcode = $('#pcode');
    var pname = $('#pname');
    var price_import = $('#price_import');
    var price_main = $('#price_main');
    var number = $('#number');
    var auto_type = $('#auto_type');
    var note = $('#note');
    var btn_add_table = $('#btn_add_table');
    var btn_save_server = $('#btn_save_server');

    ProductImportSelfProducedtAPP.createUI = function () {
        btn_add_table.jqxButton({height: 55, width: '100%', template: 'success'});
        btn_save_server.jqxButton({height: 35, template: 'success'});
        note.jqxTextArea({
            width: '100%',
            height: 50,
        });
        pcode.jqxInput({width: '100%', height: 30,});
        pname.jqxInput({width: '100%', height: 30});
        auto_type.jqxInput({width: '100%', height: 30});
        number.jqxNumberInput({
            width: '100%',
            height: 25,
            min: -99999999999,
            decimalDigits: 0,
            digits: 10,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " ",
            symbolPosition: 'right',
        });
        price_main.jqxNumberInput({
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
        });
        price_import.jqxNumberInput({
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
        });
        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        cb_search_products.jqxComboBox({
            width: 'calc(100% - 35px)',
            height: 35,
            dropDownWidth: 330,
            dropDownHeight: 350,
            source: products_list,
            displayMember: 'name_raw',
            valueMember: 'code',
            theme: 'light',
            placeHolder: "Nhập mã hoặc tên sản phẩm",
            showArrow: false,
            searchMode: "containsignorecase",
            renderSelectedItem: function (index, item) {
                if (item['value'] !== '') {
                    return item['label'] + ' - ' + item['value'];
                }
                return "";
            }
        });

        table_source = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'number'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'price', type: 'number'},
                {name: 'price_import', type: 'number'},
                {name: 'number', type: 'number'},
                {name: 'number_max', type: 'number'},
                {name: 'price_main', type: 'number'},
                {name: 'state_save', type: 'string'},
//                {name: 'expiry_at', type: 'string'},
            ]
        };
        table_source2 = {
            localdata: null, datatype: "array", datafields: [
                {name: 'id', type: 'number'},
                {name: 'code', type: 'string'},
                {name: 'pname', type: 'string'},
                {name: 'number_max', type: 'number'},
                {name: 'price_import', type: 'number'},
                {name: 'price_main', type: 'number'},
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table_dataAdapter2 = new $.jqx.dataAdapter(table_source2);

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
                {text: 'Mã SP', editable: false, dataField: 'code', width: '150px'},
                {
                    text: 'Tên sản phẩm',
                    dataField: 'name',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        return '<div style="font-weight: normal; text-align: left;" class="price_sale-cell price_sale-row-' + row + '">' + value + ' <i class="fa fa-edit f-grid"></i></div>';
                    },
                    createeditor: function (row, cellvalue, editor, cellText, width, height) {
                        // construct the editor.
                        editor.jqxInput({
                            width: width,
                            height: height,
                        });
                        editor.css({'font-size': '14px', 'font-weight': '500'});
                    },
                    initeditor: function (row, cellvalue, editor, celltext, pressedkey) {
                        // set the editor's current value. The callback is called each time the editor is displayed.
                        editor.jqxInput('val', cellvalue);
                        setTimeout(function () {
                            editor.select();
                            editor.focus();
                        }, 100);
                    },
                    geteditorvalue: function (row, cellvalue, editor) {
                        // return the editor's value.
                        return editor.jqxInput('val');
                    }
                },
                {
                    text: 'Giá vốn',
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
                    text: 'Giá bán',
                    dataField: 'price_main',
                    width: '120px',
                    cellsformat: 'd', align: 'right',
                    cellsalign: 'right', editable: false
                },
                {
                    text: 'Số lượng',
                    dataField: 'number',
                    width: '100px',
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
                },
                {
                    text: 'Trạng thái',
                    cellsalign: 'right',
                    align: 'right',
                    editable: false,
                    dataField: 'state_save',
                    width: 100
                },
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
        table2.jqxGrid({
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
            source: table_dataAdapter2,
            selectionmode: 'singlerow',
            statusbarheight: 25,
            columns: [
                {text: 'Mã SP', editable: false, dataField: 'code', width: '80px'},
                {text: 'Tên sản phẩm', editable: false, dataField: 'pname'},
                {
                    text: 'SL',
                    dataField: 'number_max',
                    width: '40px',
                },
            ]
        });
        table2.jqxGrid('localizestrings', grid_lang);
        table.jqxGrid('localizestrings', grid_lang);
    };

    ProductImportSelfProducedtAPP.createData = function () {
        app.loadding('open');
        var downloaded = 0;
        branches = JSON.parse(localStorage.getItem(tables.branches));

        function download_completed() {
            downloaded++;
            if (downloaded >= 1) {
                app.loadding('close');
                cb_search_products.jqxComboBox({source: products_list});
                table_source2.localdata = products_list;
                table2.jqxGrid('updatebounddata', 'cells');
            }
        }

        //data from server
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE branch LIKE '" + me.branch + "' ORDER BY id DESC",
            data: "code,name AS 'pname',price_main,price_import,number AS 'number_max'"
        }, null, function (result) {
            if (result['success']) {
                products_list = result['data'];
                var len_p = products_list.length;
                for (var i = 0; i < len_p; i++) {
                    products_list[i]['name_raw'] = products_list[i]['pname'] + " - " + products_list[i]['code'];
                }
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });
    };

    ProductImportSelfProducedtAPP.createEvents = function () {
        cb_search_products.find('input').on('keyup', function (event) {
            if (event.keyCode == 13) {
                var code_product = cb_search_products.jqxComboBox('val');
                var product_selected = app.getDataByCode(code_product, products_list);
                if (product_selected != null) {
                    pcode.jqxInput('val', product_selected['code']);
                    pname.jqxInput('val', product_selected['pname']);
                    price_import.jqxNumberInput('val', product_selected['price_import']);
                    price_main.jqxNumberInput('val', product_selected['price_main']);
                    pcode.focus();
                } else {
                    cb_search_products.jqxComboBox('val', "Thêm sản phẩm mới");
                    pcode.focus();
                }
            }
            applyFilter($('#cb_search_products').find('input').val());
        });

        pcode.on('keyup', function (event) {
            if (event.keyCode == 13) {
                pname.focus();
                pname.select();
            } else {
                pname.jqxInput('val', pcode.jqxInput('val').toUpperCase());
            }
        });

        pname.on('keyup', function (event) {
            if (event.keyCode == 13) {
                price_import.jqxNumberInput('focus');
                $('#price_import').find('input').select();

            }
        });
        $('#price_import').find('input').on('keyup', function (event) {
            if (event.keyCode == 13) {
                price_main.jqxNumberInput('focus');
                $('#price_main').find('input').select();
            }
        });
        $('#price_main').find('input').on('keyup', function (event) {
            if (event.keyCode == 13) {
                number.jqxNumberInput('focus');
                $('#number').find('input').select();
            }
        });
        $('#number').find('input').on('keyup', function (event) {
            if (event.keyCode == 13) {
                auto_type.focus();
                auto_type.select();
            }
        });
        auto_type.on('keyup', function (event) {
            if (event.keyCode == 13) {
                btn_add_table.click();
            }
        });

        //add to table
        btn_add_table.click(function () {
            function addtotable(data) {
                if(data['code']==''){
                    app.notify('Chưa có mã sản phẩm!','warning');
                    return;
                }
                if(data['name']==''){
                    app.notify('Chưa có tên sản phẩm!','warning');
                    return;
                }
                var code_product = data['code'];
                var product_selected = app.getDataByCode(code_product, products_list);
                var state_save = 'Lưu mới';
                if (product_selected != null) {
                    state_save = 'Cập nhật'
                }
                table.jqxGrid('addrow', null, {
                    id: data['id'],
                    code: data['code'],
                    name: data['name'],
                    price: data['price_import'],
                    price_import: data['price_import'],
                    price_main: data['price_main'],
                    number_max: product_selected == null ? 0 : product_selected['number_max'],
                    number: data['number'],
                    state_save: state_save,
                });
            }

            var data;
            if (auto_type.jqxInput('val') != '') {
                var code_default = pcode.jqxInput('val').toUpperCase();
                var name_default = pname.jqxInput('val');
                var arr_types = auto_type.jqxInput('val').toUpperCase().split(',');
                var arr_types_length = arr_types.length;
                for (var i = 0; i < arr_types_length; i++) {
                    arr_types[i] = arr_types[i].toUpperCase().trim();
                    pcode.jqxInput('val', code_default + '.' + arr_types[i]);
                    pname.jqxInput('val', name_default + '.' + arr_types[i]);
                    data = {
                        id: table.jqxGrid('getrows').length,
                        code: pcode.jqxInput('val').toUpperCase(),
                        name: pname.jqxInput('val'),
                        price_import: parseInt(price_import.jqxNumberInput('val')),
                        price_main: parseInt(price_main.jqxNumberInput('val')),
                        number: parseInt(number.jqxNumberInput('val')),
                    };
                    addtotable(data);
                }
            } else {
                data = {
                    id: table.jqxGrid('getrows').length,
                    code: pcode.jqxInput('val').toUpperCase().trim(),
                    name: pname.jqxInput('val').trim(),
                    price_import: parseInt(price_import.jqxNumberInput('val')),
                    price_main: parseInt(price_main.jqxNumberInput('val')),
                    number: parseInt(number.jqxNumberInput('val')),
                };
                addtotable(data);
            }

            clearDataInput();
        });

        //clear data input
        function clearDataInput() {
            cb_search_products.jqxComboBox('val', '');
            cb_search_products.jqxComboBox('clearSelection', '');
            price_main.jqxNumberInput('val', 0);
            price_import.jqxNumberInput('val', 0);
            number.jqxNumberInput('val', 0);
            pcode.jqxInput('val', '');
            pname.jqxInput('val', '');
            auto_type.jqxInput('val', '');
            cb_search_products.jqxComboBox('focus');
        }

        //Tư động chọn
        $('input').click(function () {
            $(this).select();
        });

        function click_remove(args) {
            var popup_xoa = $('<div></div>');
            var btn_yes = $('<button class="f-right">@lang('lang.Yes')</button>');
            var btn_no = $('<button class="f-right" style="margin-left: 5px;">@lang('lang.No')</button>');
            popup_xoa.append(btn_no);
            popup_xoa.append(btn_yes);
            btn_yes.jqxButton({height: 25, template: 'success'});
            btn_no.jqxButton({height: 25, template: 'danger'});
            popup_xoa.jqxPopover({
                position: "left",
                width: 180,
                height: 80,
                'title': '@lang('lang.Remove from cart?')',
                selector: args['originalEvent']['target']
            });

            btn_yes.click(function () {
                table2.jqxGrid('addrow', null, {
                    id: args['row']['bounddata']['uid'],
                    code: args['row']['bounddata']['code'],
                    pname: args['row']['bounddata']['name'],
                    price_main: args['row']['bounddata']['price_main'],
                    price_import: args['row']['bounddata']['price_import'],
                    number_max: args['row']['bounddata']['number_max'],
                });
                table.jqxGrid('deleterow', args['row']['bounddata']['uid']);
                popup_xoa.jqxPopover('close');
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

        //select
        table2.on("cellclick", function (event) {
            var args = event.args;
            var data_selected = args.row.bounddata;
            pcode.jqxInput('val', data_selected['code']);
            pname.jqxInput('val', data_selected['pname']);
            price_import.jqxNumberInput('val', data_selected['price_import']);
            price_main.jqxNumberInput('val', data_selected['price_main']);
            number.jqxNumberInput('val', 0);
            table2.jqxGrid('deleterow', data_selected['uid']);
            btn_add_table.click();
        });

        //Change mode
        btn_change_mode.click(function () {
            if (data_mode == 'INPUT') {
                $('#data_select').hide();
                $('#data_input').show();
                data_mode = 'SELECT';
                cb_search_products.jqxComboBox({searchMode: 'containsignorecase'});
            } else {
                cb_search_products.jqxComboBox({searchMode: 'equals'});
                $('#data_select').show();
                $('#data_input').hide();
                data_mode = 'INPUT'
            }
        });

        btn_save_server.click(function () {
            swal({
                title: 'Bạn có chắc?',
                text: "Lưu dữ liệu lên máy chủ!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Thực hiện',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                var products_import = table.jqxGrid('getrows');
                if (products_import.length == 0) {
                    app.notify('Chưa có sản phẩm để để lưu!!!', 'warning');
                    return;
                }
                var products_sent = table.jqxGrid('getrows');
                var total_price = 0;
                for (var i = 0; i < products_sent.length; i++) {
                    total_price += parseInt(products_sent[i]['price_import']);
                }
                //Save import
                GUI.disable(btn_save_server);
                btn_save_server.html('Đang lưu...');
                products_save = null;
                add_data(urls.url_apis.product_import_self_produced, {
                    code: "PNN/",
                    branch: me['branch'],
                    customer: me['branch'],
                    customer_name: app.getNameByCode(me['branch'], branches),
                    type: "IMPORT",
                    products: JSON.stringify(table.jqxGrid('getrows')),
                    total_price: total_price,
                    total_pay: total_price,
                    other_price: 0,
                    discount: 0,
                    state: 'SUCCESS',
                    note: note.jqxTextArea('val'),
                    user: me['username'],
                    finance_cat: settings.acc_default
                }, function (result) {
                    if (result['success']) {
                        app.notify('Lưu nhập hàng thành công!', 'success');
                    } else {
                        app.notify('Lỗi khi lưu hàng nhập!', 'error');
                    }
                    GUI.able(btn_save_server);
                    btn_save_server.html("<i class='fa fa-cloud-upload'></i> Lưu nhập hàng (F9)");
                })

            }).catch(swal.noop);


        });

        //Create filter product
        var applyFilter = function (string_query) {
            table2.jqxGrid('clearfilters');
            var filtertype = 'stringfilter';
            var datafield = 'pname';
            var filtergroup = new $.jqx.filter();
            var filter_or_operator = 0;
            var filtervalue = string_query;
            var filtercondition = 'CONTAINS';
            var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
            filtergroup.addfilter(filter_or_operator, filter);

            // add the filters.
            table2.jqxGrid('addfilter', datafield, filtergroup);
            // apply the filters.
            table2.jqxGrid('applyfilters');
        }
    };

    function view_start() {
        ProductImportSelfProducedtAPP.createUI();
        ProductImportSelfProducedtAPP.createData();
        ProductImportSelfProducedtAPP.createEvents();
        //
        cb_search_products.jqxComboBox('focus');
    }
</script>