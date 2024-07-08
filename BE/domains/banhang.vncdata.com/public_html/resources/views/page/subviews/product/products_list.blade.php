{{--Chứa danh sách các sản phẩm của công ty--}}

<div class="view">
    <div id="loader_view"></div>
    <div id="sidebar">
        <div class="sidebar-item">
            <div>Tìm kiếm sản phẩm</div>
            <div>
                <div>
                    <label>Mã sản phẩm:</label>
                    <input id="s_code">
                </div>
                <div>
                    <label>Tên sản phẩm:</label>
                    <input id="s_name">
                </div>
                <div>
                    <label>Giá bán từ:</label>
                    <input value="0" id="s_price">
                </div>
                <div>
                    <label>Tồn kho từ:</label>
                    <input value="-999999999" id="s_number">
                </div>
                <div>
                    <label>Danh mục:</label>
                    <div id="s_cat"></div>
                </div>

                <div>
                    <label>Chi nhánh:</label>
                    <div id="s_branch"></div>
                </div>
                <div>
                    <label>Trạng thái:</label>
                    <div id="s_state"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="content-table">
        <div id="table"></div>
    </div>
    <div id="sidebar2"
         style="position: fixed;width: 500px;top:0; height: 100%;right: -500px;background-color: white;z-index: 9999;box-shadow: rgba(0, 0, 0, 0.05) -2px 0px 1px 0px;">
        <div class="sidebar-item">
            <div>Thông tin sản phẩm</div>
            <div>
                <label for="code" class="hide">ID:</label>
                <input id="index" class="hide input-sidebar">
                <input id="id" class="hide input-sidebar">
                <label for="code">Mã sản phẩm:</label>
                <input id="code" class="input-sidebar">

                <label for="name">Tên sản phẩm:</label>
                <input id="name" class="input-sidebar">
                <div style="position: relative;">
                    <label for="product_cat">Danh mục:</label>
                    <i id="btn_add_product_cat" class="fa fa-plus sibar-x-icon"></i>
                    <div id="product_cat" class="input-sidebar"></div>
                </div>


                <label for="price_main">Giá bán:</label>
                <input id="price_main" class="input-sidebar">
                <label for="price_main">Giá nhập:</label>
                <input id="price_import" class="input-sidebar">
                <label for="price_main">Tồn kho:</label>
                <input id="number" class="input-sidebar">
                <label for="state">Trạng thái:</label>
                <select id="state" class="input-sidebar">
                    <option VALUE="ACTIVE">Đang bán</option>
                    <option value="INACTIVE">Hủy bán</option>
                </select>
                <label for="note">Ghi chú:</label>
                <textarea id="note" class="input-sidebar"></textarea>

                <button id="btn_submit"
                        style="border-radius:0;float: left; margin-top: 10px; font-size: 17px;height: 40px;"><i
                            class="fa fa-check-circle"></i> Hoàn thành
                </button>
                <button id="btn_cancel"
                        style="border-radius:0; float: right;margin-top: 10px; font-size: 17px;height: 40px;"><i
                            class="fa fa-ban"></i> Hủy bỏ
                </button>
                <div>

                </div>
            </div>
        </div>
    </div>

    <div id="windows_barcode" class="windows">
        <div><i class="fa fa-barcode"></i> In mã vạch sản phẩm</div>
        <div>
            <div>
                <div>
                    <label>Chọn loại giấy:</label>
                    <select id="kho_barcode">
                        <option value="104">Mẫu giấy cuộn 3 nhãn (Khổ giấy in nhãn 104x22mm/4.2x0.9 Inch)</option>
                        <option value="72">Mẫu giấy cuộn 2 nhãn (Khổ giấy in nhãn 72x22mm)</option>
                    </select>
                </div>
                <div>
                    <label>Xem trước bản in:</label>
                    <div style="width: 100%;padding: 30px 0px;background-color: #9E9E9E;">
                        <div id="preview_barcode"></div>
                    </div>
                </div>
            </div>
            <div>
                <div style="float: right; margin-top: 15px;">
                    <button class="btn" type="button" id="btn_printbarcode"><i class="fa fa-print"></i> In mã vạch ngay
                    </button>
                    <input class="btn" type="button" id="btn_cancel_printbarcode" value="Hủy bỏ"/>
                </div>
            </div>
        </div>
    </div>

    <div id="windows_web" class="windows">
        <div><i class="fa fa-globe"></i> Dữ liệu web</div>
        <div>
            <div>
                <label>Ảnh sản phẩm:</label>
                <div class="container-upload">
                    <div class="pre-upload">
                        <img id="image" src="">
                    </div>
                    <div id="btn_add_image" class="add-upload">
                        <i class="fa fa-plus"></i>
                    </div>

                    <div id="btn_upload" style="display: none;"></div>
                </div>
                <label>Mô tả sản phẩm:</label>
                <textarea id="mota"></textarea>
            </div>

            <div>
                <div style="float: right; margin-top: 15px;">
                    <button class="btn" type="button" id="btn_save_web"><i class="fa fa-save"></i> Lưu lại
                    </button>
                    <input class="btn" type="button" id="btn_cancel_web" value="Hủy bỏ"/>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    /* *
     * Process unit and data price
     * */
    var ProductsListApp = {};
    var txt_mota = $('#mota');
    var img_image = $('#image');
    var btn_add_image = $('#btn_add_image');
    var btn_upload = $('#btn_upload');
    var txt_id = $('#id');
    var txt_index = $('#index');
    var txt_s_code = $('#s_code');
    var txt_s_name = $('#s_name');
    var txt_s_cat = $('#s_cat');
    var txt_s_branch = $('#s_branch');
    var txt_s_state = $('#s_state');
    var txt_s_price = $('#s_price');
    var txt_s_number = $('#s_number');
    var txt_code = $('#code');
    var txt_name = $('#name');
    var txt_price_main = $('#price_main');
    var txt_price_import = $('#price_import');
    var txt_number = $('#number');
    var txt_note = $('#note');
    var cb_product_cat = $('#product_cat');
    var cb_state = $('#state');
    var btn_submit = $('#btn_submit');
    var btn_printbarcode = $('#btn_printbarcode');
    var btn_cancel_printbarcode = $('#btn_cancel_printbarcode');
    var btn_save_web = $('#btn_save_web');
    var btn_cancel_web = $('#btn_cancel_web');
    var btn_cancel = $('#btn_cancel');
    var windows_barcode = $('#windows_barcode');
    var windows_web = $('#windows_web');
    var btn_add_product_cat = $('#btn_add_product_cat');
    var container_toolbar = $("<div class='container-toolbar clearfix'></div>");
    var btn_add = $("<button><i class='fa fa-plus-circle'></i> Thêm</button>");
    var btn_print_barcode = $("<button><i class='fa fa-barcode'></i> In mã vạch</button>");
    var btn_edit = $("<button><i class='fa fa-pencil'></i> Sửa</button>");
    var btn_delete = $("<button><i class='fa fa-trash'></i> Xóa</button>");
    var btn_web = $("<button><i class='fa fa-globe'></i> Dữ liệu web</button>");
    var btn_export_print = $("<button><i class='fa fa-print'></i> In</button>");
    var lb_table = $("<div class='table-title'><span>Quản lý danh sách sản phẩm</span></div>");
    //data source
    var products_cats = null;
    var product_list = null;
    var customer_cats = null;
    var branches = null;
    //table
    var table = $('#table');
    var table_source = null;
    var table_dataAdapter = null;
    var mode_data = 'ADD';
    //winđows
    ProductsListApp.createUI = function () {
        txt_mota.jqxEditor({
            height: "210px",
            width: '100%',
        });
        //
        btn_upload.jqxFileUpload({
            width: 300,
            uploadUrl: urls.url_apis.upload_image,
            autoUpload: true,
            fileInputName: 'image'
        });
        //Windows
        windows_web.jqxWindow({
            position: {x: (($(window).width() - 550) / 2), y: '10%'},
            width: 550,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel_web,
            autoOpen: false
        });
        windows_barcode.jqxWindow({
            position: {x: (($(window).width() - 400) / 2), y: '10%'},
            width: 400,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel_printbarcode,
            autoOpen: false
        });
        //Button
        btn_cancel_printbarcode.jqxButton({height: 30, template: 'danger'});
        btn_cancel_web.jqxButton({height: 30, template: 'danger'});
        btn_save_web.jqxButton({height: 30, template: 'success'});
        btn_printbarcode.jqxButton({height: 30, template: 'success'});
        btn_submit.jqxButton({width: '49%', height: 40, template: 'success'});
        btn_cancel.jqxButton({width: '49%', height: 40, template: 'danger'});
        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        //text box
        txt_s_code.jqxInput({width: '100%', height: 30});
        $('#kho_barcode').jqxDropDownList({width: '100%', height: 30});
        txt_s_name.jqxInput({width: '100%', height: 30});

        txt_code.jqxInput({width: '100%', height: 30});
        txt_name.jqxInput({width: '100%', height: 30});

        txt_price_main.jqxNumberInput({
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
        txt_s_price.jqxNumberInput({
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
        txt_s_number.jqxNumberInput({
            width: '100%',
            height: 30,
            min: -9999999999,
            decimalDigits: 0,
            max: 9999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: "",
            symbolPosition: 'right'
        });
        txt_price_import.jqxNumberInput({
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
        txt_number.jqxNumberInput({
            width: '100%',
            height: 30,
            min: -9999999999,
            decimalDigits: 0,
            max: 9999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " ",
            symbolPosition: 'right'
        });
        txt_note.jqxTextArea({
            width: '100%',
            height: 50,
        });
        //combobox
        txt_s_branch.jqxDropDownList({
            source: branches,
            width: '100%',
            height: 30,
            displayMember: "name",
            valueMember: "code",
            placeHolder: "",
            theme: 'light',
        });
        txt_s_cat.jqxDropDownList({
            source: products_cats,
            width: '100%',
            height: 30,
            displayMember: "name",
            valueMember: "code",
            placeHolder: "",
            theme: 'light',
        });
        cb_product_cat.jqxDropDownList({
            source: products_cats,
            width: '100%',
            height: 30,
            displayMember: "name",
            valueMember: "code",
            placeHolder: "Chọn một danh mục"
        });
        txt_s_state.jqxDropDownList({
            source: null,
            displayMember: "name",
            valueMember: "code",
            width: '100%',
            height: 30,
            placeHolder: "",
            theme: 'light',
        });
        cb_state.jqxDropDownList({
            width: '100%',
            height: 30,
            placeHolder: "",
            theme: 'light',
        });
        //Button
        btn_add.jqxButton({height: 28, template: 'primary'});
        btn_delete.jqxButton({height: 28, template: 'primary'});
        btn_edit.jqxButton({height: 28, template: 'primary'});
        btn_web.jqxButton({height: 28, template: 'primary'});
        btn_export_print.jqxButton({height: 28, template: 'primary'});
        btn_print_barcode.jqxButton({height: 28, template: 'primary'});
        //Popover
        ProductsListApp.createAddProductCat(btn_add_product_cat);

        //Table
        function createToolbar(toolbar) {
            // appends buttons to the status bar.
            container_toolbar.append(lb_table);
            container_toolbar.append(btn_export_print);
            container_toolbar.append(btn_web);
            container_toolbar.append(btn_print_barcode);
            container_toolbar.append(btn_delete);
            container_toolbar.append(btn_edit);
            container_toolbar.append(btn_add);
            toolbar.append(container_toolbar);
        }

        var initrowdetails = function (index, parentElement, gridElement, datarecord) {

            datarecord = table.jqxGrid('getrowdata', index);
            var container_history = null;
            tabsdiv = $($(parentElement).children()[0]);
            if (tabsdiv != null) {
                container_history = tabsdiv.find('.container_history');
                //Danh sách sản phẩm
                $(tabsdiv).jqxTabs({width: (table.find('.jqx-grid-content').width() - 35), height: 310});

                var table_products = $('<div></div>');
                container_history.append(table_products);
                table_products.jqxGrid({
                    width: 'calc(100% - 2px)',
                    height: 'calc(100% - 2px)',
                    selectionmode: 'none',
                    columnsResize: false,
                    columns: [
                        {
                            text: 'TT',
                            dataField: 'id',
                            width: '50'
                        }, {
                            text: 'Mã chứng từ',
                            dataField: 'invoice',
                            width: '150'
                        }, {
                            text: 'Loại chứng từ',
                            dataField: 'type',
                            width: '230',
                            cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                                return '<div style="padding: 5px 0 0 5px;display:block;margin-right: 2px; ">' + type_invoice[value] + '</div>';
                            }
                        }, {
                            text: 'Thời gian',
                            dataField: 'create_at',
                            width: '100'
                        }, {
                            text: 'Giá gốc',
                            dataField: 'price_import_t',
                            width: '100',
                            cellsformat: 'd',
                            cellsalign: 'right', align: 'right'

                        }, {
                            text: 'Số lượng',
                            dataField: 'number',
                            width: '120',
                            cellsformat: 'd', cellsalign: 'right', align: 'right'
                        }, {
                            text: ' ',
                            dataField: 'other'
                        }
                    ]
                });


                table_products.jqxGrid('showloadelement');
                download_data_where(urls.url_apis.select, {
                    table: "product_logs",
                    select: "WHERE 1 AND product_list LIKE '" + datarecord['code'] + "' AND branch LIKE '" + datarecord['branch'] + "'" + ' ORDER BY product_logs.id DESC',
                    data: "*,price_import/number AS 'price_import_t'"
                }, table_products, function (result) {
                    if (result['success']) {
                        var table_x = result['sent'];
                        var data_result = result['data'];
                        table_x.jqxGrid('clear');
                        for (var i = 0; i < data_result.length; i++) {
                            data_result[i]['price_import_t'] = parseInt(data_result[i]['price_import_t']);
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
                {name: 'branch', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'price_main', type: 'float'},
                {name: 'price_import', type: 'float'},
                {name: 'number', type: 'float'},
                {name: 'id', type: 'float'},
                {name: 'update_at', type: 'date'},
                {name: 'note', type: 'string'},
                {name: 'state', type: 'string'},
                {name: 'product_cat', type: 'string'},
                {name: 'product_cat', type: 'string'},
            ]
        };
        table_dataAdapter = new $.jqx.dataAdapter(table_source);
        table.jqxGrid({
            theme: 'light',
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
            rowdetails: true,
//            showrowdetailscolumn:false,
            rowdetailstemplate: {
                rowdetails: "<div class='content-detail-grid'>" +
                "<ul style='margin-left: 30px;'>" +
                "<li>Thẻ kho</li>" +
                "</ul>" +
                "<div class='container_history'></div>" +
                "</div>",
                rowdetailsheight: 330
            },
            initrowdetails: initrowdetails,
            columns: [
                {
                    text: 'ID',
                    dataField: 'id',
                    width: '60',
                    cellsalign: 'center', align: 'center',
                },
                {
                    text: 'Mã',
                    dataField: 'code',
                    width: '100',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (rowdata['state'] == 'ACTIVE') {
                            return '<div class="price_sale-cell" style="text-align: left;"><i class="fa fa-check-circle-o icon-active"></i> ' + value + '</div>';
                        }
                        return '<div class="price_sale-cell" style="text-align: left;"><i class="fa fa-times-circle-o icon-inactive"></i> ' + value + '</div>';
                    }
                }, {
                    text: 'Tên sản phẩm',
                    dataField: 'name',
                    width: '250',
                }, {
                    text: 'Chi nhánh',
                    dataField: 'branch',
                    width: '170',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        return '<div class="price_sale-cell" style="text-align: left">' + app.getNameByCode(value, branches) + '</div>';
                    }
                }, {
                    text: 'Giá bán',
                    dataField: 'price_main',
                    width: '90',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    align: 'right',
                }, {
                    text: 'Giá nhập',
                    dataField: 'price_import',
                    width: '90',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    align: 'right',
                }, {
                    text: 'Tồn kho',
                    dataField: 'number',
                    width: '80',
                    cellsformat: 'd',
                    cellsalign: 'right',
                    align: 'right',
                },
//                {
//                    text: 'Danh mục',
//                    dataField: 'product_cat',
//                    width: '170',
//                    cellsalign: 'right',
//                    align: 'right',
//                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
//                        return '<div class="price_sale-cell" style="font-weight: inherit;text-align: right;">'+app.getNameByCode(value,products_cats)+'</div>';
//                    }
//                },
                {
                    text: 'Cập nhật',
                    dataField: 'update_at',
                    filtertype: 'date',
                    cellsformat: 'HH:mm dd/MM/yyyy',
                    width: '130',
                    cellsalign: 'right',
                    align: 'right',
                }, {
                    text: 'Ghi chú',
                    dataField: 'note',
                    cellsalign: 'center',
                    align: 'center',
                }
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: createToolbar,
        });
        table.jqxGrid('localizestrings', grid_lang);
    };

    ProductsListApp.createAddProductCat = function (selecter) {
        var popover = $('<div></div>');
        var popover_container = $('<div class="clearfix" style="margin-bottom: 32px"></div>');
        var txt_name_cat = $('<input style="padding-left: 5px;" class="f-left"/>');
        var btn_save_cat = $('<button class="f-right"><i class="fa fa-save"></i> Lưu</button>');
        popover_container.append(txt_name_cat);
        popover_container.append(btn_save_cat);
        popover.append(popover_container);
        txt_name_cat.jqxInput({width: 195, height: 27, placeHolder: 'Nhập tên danh mục'});
        btn_save_cat.jqxButton({width: 68, height: 28, template: 'primary'});
        popover.jqxPopover({
            title: 'Thêm danh mục mới',
            position: 'left',
            width: 300,
            selector: selecter,
            showArrow: true,
        });
        //Event local
        $('#' + popover.attr('id')).on('open', function () {
            setTimeout(function () {
                txt_name_cat.jqxInput('focus');
            }, 200);
        });
        btn_save_cat.click(function () {
            if (txt_name_cat.jqxInput('val').trim() == '') {
                app.notify('Tên danh mục không được để trống!', 'warning');
                return;
            }
            btn_save_cat.html('<i class="fa fa-spin fa-spinner"></i> Lưu');
            add_data(urls.url_apis.product_cat, {
                name: txt_name_cat.jqxInput('val'),
                state: 'ACTIVE'
            }, function (result) {
                if (result['success']) {
                    app.notify('Thêm danh mục thành công!', 'success');
                    txt_name_cat.jqxInput('val', '');
                    download_data(urls.url_apis.product_cat, function (result) {
                        if (result['success']) {
                            var data = result['data'];
                            localStorage.setItem(tables.product_cat, JSON.stringify(data));
                            products_cats = JSON.parse(localStorage[tables.product_cat]);
                            cb_product_cat.jqxDropDownList({source: products_cats});
                            btn_save_cat.html('<i class="fa fa-save"></i> Lưu');
                            popover.jqxPopover('close');
                        }
                    });
                } else {
                    app.notify('Danh mục được thêm bị lỗi!', 'error');
                    btn_save_cat.html('<i class="fa fa-save"></i> Lưu');
                    popover.jqxPopover('close');
                }
            });
        });
    };

    ProductsListApp.createEvent = function () {
        $('#kho_barcode').on('change', function (event) {

        });
        //In mã vạch
        btn_print_barcode.click(function () {

            var index = table.jqxGrid('getselectedrowindex');
            if (index >= 0) {
                windows_barcode.jqxWindow('open');
                var data = table.jqxGrid('getrowdata', index);
                $('#preview_barcode').empty();
                dataBarcodeProduct(data['code'], data['name'], data['price_main'], $('#preview_barcode'));
                dataBarcodeProduct(data['code'], data['name'], data['price_main'], $('#preview_barcode'));
            } else {
                app.notify('Chưa chọn sản phẩm!', 'warning')
            }
        });
        btn_printbarcode.click(function () {
            $.print('#preview_barcode');
        });

        //Cancel
        btn_cancel.click(function () {
            ProductsListApp.showSidebar(false);
        });
        //save to server
        btn_submit.click(function () {
            if (txt_code.jqxInput('val').trim() == '') {
                app.notify('Cần nhập mã sản phẩm!', 'warning');
                txt_code.jqxInput('focus');
                return;
            }
            swal({
                title: 'Bạn có chắc?',
                text: "Lưu dữ liệu lên máy chủ!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Thực hiện',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                btn_submit.html('<i class="fa fa-spin fa-spinner"></i> Xử lý');
                var id = txt_id.val();
                var data_sent = {
                    code: txt_code.jqxInput('val'),
                    name: txt_name.jqxInput('val'),
                    product_cat: cb_product_cat.jqxDropDownList('val'),
                    price_main: txt_price_main.jqxNumberInput('val'),
                    price_import: txt_price_import.jqxNumberInput('val'),
                    number: txt_number.jqxNumberInput('val'),
                    state: cb_state.jqxDropDownList('val'),
                    note: txt_note.jqxTextArea('val'),
                };
                if (mode_data === 'ADD') {
                    data_sent['branch'] = me['branch'];
                    add_data(urls.url_apis.product_list, data_sent, function (result) {
                        if (result['success']) {
                            app.notify('Thêm sản phẩm thành công!', 'success');
                            var newdata = result['data'];
                            newdata['product_cat_name'] = app.getNameByCode(newdata['product_cat'], products_cats);
                            newdata['price_main'] = parseFloat(newdata['price_main']);
                            newdata['price_import'] = parseFloat(newdata['price_import']);
                            newdata['number'] = parseFloat(newdata['number']);
                            table.jqxGrid('addrow', null, newdata, 'first');
                            ProductsListApp.showSidebar(false);
                        } else {
                            app.notify('Thêm sản phẩm bị lỗi!', 'error');
                        }
                        btn_submit.html('<i class="fa fa-plus-circle"></i> Thêm vào');
                    })
                } else {
                    update_data(urls.url_apis.product_list, id, data_sent, function (result) {
                        if (result['success']) {
                            app.notify('Cập nhật thông tin sản phẩm thành công!', 'success');
                            var index = txt_index.val();
                            var newdata = result['data'];
                            newdata['product_cat_name'] = app.getNameByCode(newdata['product_cat'], products_cats);
                            newdata['price_main'] = parseFloat(newdata['price_main']);
                            newdata['price_import'] = parseFloat(newdata['price_import']);
                            newdata['number'] = parseFloat(newdata['number']);
                            table.jqxGrid('updaterow', index, newdata);
                            ProductsListApp.showSidebar(false);
                        } else {
                            app.notify('Cập nhật sản phẩm bị lỗi!', 'error');
                        }
                        btn_submit.html('<i class="fa fa-save"></i> Lưu lại');
                    })
                }
            }).catch(swal.noop);
        });
        //mode add
        btn_add.click(function () {
            txt_id.val('');
            txt_code.jqxInput('val', '');
            txt_name.jqxInput('val', '');
            cb_product_cat.jqxDropDownList('val', 'ALL');
            txt_price_main.jqxNumberInput('val', '0');
            txt_price_import.jqxNumberInput('val', '0');
            txt_number.jqxNumberInput('val', '0');
            cb_state.jqxDropDownList('val', 'ACTIVE');
            txt_note.jqxTextArea('val', '');
            btn_submit.html('<i class="fa fa-plus-circle"></i> Thêm vào');
            mode_data = 'ADD';
            ProductsListApp.showSidebar(true);
        });
        //mode edit
        btn_edit.click(function () {
            var index = table.jqxGrid('getselectedrowindex');
            if (index !== -1) {
                ProductsListApp.showSidebar(true);
                var data = table.jqxGrid('getrowdata', index);
                txt_id.val(data['id']);
                txt_index.val(index);
                txt_code.jqxInput('val', data['code']);
                txt_name.jqxInput('val', data['name']);
                cb_product_cat.jqxDropDownList('val', data['product_cat']);
                txt_price_main.jqxNumberInput('val', data['price_main']);
                txt_price_import.jqxNumberInput('val', data['price_import']);
                txt_number.jqxNumberInput('val', data['number']);
                cb_state.jqxDropDownList('val', data['state']);
                txt_note.jqxTextArea('val', data['note']);
                btn_submit.html('<i class="fa fa-save"></i> Lưu lại');
                mode_data = 'EDIT';
            }
        });
        //Delete
        btn_delete.click(function () {
            swal({
                title: 'Bạn có chắc sẽ xóa sản phẩm này?',
                text: "Dữ liệu sẽ bị xóa khỏi máy chủ!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Xóa ngay',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                var indexs = table.jqxGrid('getselectedrowindexes');
                for (var i = 0; i < indexs.length; i++) {
                    var data = table.jqxGrid('getrowdata', indexs[i]);

                    delete_data(urls.url_apis.product_list, data['id'], function (result) {
                        if (result['success']) {
                            app.notify('Xóa sản phẩm thành công!', 'success');
                            table.jqxGrid('deleterow', result['sent']['index']);
                        } else {
                            app.notify('Xóa sản phẩm bị lỗi!', 'error');
                        }
                    }, data['uid']);
                }
            }).catch(swal.noop);
        });
        btn_export_print.click(function () {
            var gridContent = table.jqxGrid('exportdata', 'html');
            print_data(gridContent, 'In danh sách sản phẩm');
        });


        //Bộ lọc
        var loading = false;

        function request_filter() {
            if (loading) {
                return;
            }
            var branch_f = txt_s_branch.jqxDropDownList('val');
            var state_f = txt_s_state.jqxDropDownList('val');
            var cat_f = txt_s_cat.jqxDropDownList('val');
            var pcode_f = txt_s_code.jqxInput('val');
            var pname_f = txt_s_name.jqxInput('val');
            var price_f = txt_s_price.jqxNumberInput('val');
            var number_f = txt_s_number.jqxNumberInput('val');

            if (cat_f !== 'ALL') {
                cat_f = " AND products_list.product_cat LIKE '" + cat_f + "'";
            } else {
                cat_f = '';
            }

            if (branch_f !== 'ALL') {
                branch_f = " AND products_list.branch LIKE '" + branch_f + "'";
            } else {
                branch_f = '';
            }

            if (state_f !== 'ALL') {
                state_f = " AND products_list.state LIKE '" + state_f + "'";
            } else {
                state_f = '';
            }

            if (pcode_f !== '') {
                pcode_f = " AND products_list.code LIKE '%" + pcode_f + "%'";
            } else {
                pcode_f = '';
            }
            if (pname_f !== '') {
                pname_f = " AND products_list.name LIKE '%" + pname_f + "%'";
            } else {
                pname_f = '';
            }
            if (price_f !== '') {
                price_f = " AND products_list.price_main >= " + price_f;
            } else {
                price_f = '';
            }
            if (number_f !== '') {
                number_f = " AND products_list.number >= " + number_f;
            } else {
                number_f = '';
            }

            var string_where = pcode_f + pname_f + branch_f + state_f + cat_f + number_f + price_f;
            table.jqxGrid('showloadelement');
            loading = true;
            download_data_where(urls.url_apis.select, {
                table: "products_list",
                select: "WHERE 1 " + string_where + ' ORDER BY id DESC',
                data: "*"
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
        $('#s_state').on('change', function (event) {
            setTimeout(function () {
                request_filter();
            }, 500);
        });
        $('#s_number').on('keyup', function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });
        $('#s_price').on('keyup', function (e) {
            if (e.keyCode === 13) {
                setTimeout(function () {
                    request_filter();
                }, 500);
            }
        });

        btn_web.click(function () {
            var index = table.jqxGrid('getselectedrowindex');
            if (index >= 0) {
                var data = table.jqxGrid('getrowdata', index);
                download_data_where(urls.url_apis.upload_image, {
                    'code': data['code']
                }, null, function (result) {
                    if (result['success']) {
                        img_image.attr('src', result['data']['encoded']);
                    } else {
                        img_image.attr('src', '');
                    }
                });
                windows_web.jqxWindow('open');
            } else {
                app.notify('Chưa chọn sản phẩm!', 'warning')
            }

        });
        //Upload image
        btn_add_image.click(function () {
            setTimeout(function () {
                btn_upload.jqxFileUpload('browse');
            }, 500);
        });
        btn_upload.on('uploadEnd', function (event) {
            var args = event.args;
            var serverResponce = args.response;
            var data_img = JSON.parse(serverResponce);
            if (data_img['success']) {
                img_image.attr('src', data_img['data']['encoded']);
            } else {
                app.notify('Không đúng định dạng!', 'error');
            }
            btn_add_image.find('i').removeClass('fa-spin fa-spinner');
        });
        btn_upload.on('uploadStart', function (event) {
            btn_add_image.find('i').addClass('fa-spin fa-spinner');
        });
        //SAve data web
        btn_save_web.click(function () {
            btn_save_web.html('<i class="fa fa-spin fa-spinner"></i> Đang lưu');
            var index = table.jqxGrid('getselectedrowindex');
            if (index >= 0) {
                var data = table.jqxGrid('getrowdata', index);
                add_data(urls.url_apis.product_data, {
                    des: txt_mota.jqxEditor('val'),
                    image: img_image.attr('src'),
                    code: data['code']
                }, function (result) {
                    if (result['success']) {
                        windows_web.jqxWindow('close');
                        app.notify('Lưu thông tin thành công!', 'success')
                    } else {
                        app.notify('Lưu thông tin lỗi!', 'warning')
                    }
                    btn_save_web.html('<i class="fa fa-save"></i> Lưu lại');
                });
            } else {
                app.notify('Chưa chọn sản phẩm!', 'warning')
            }
        });
        //input selected
        $('input').click(function () {
            $(this).select();
        });
        //auto set product name
        txt_code.change(function () {
            if (txt_name.jqxInput('val') == '') {
                txt_name.jqxInput('val', txt_code.jqxInput('val'));
            }
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


    ProductsListApp.createData = function () {
        //data from local
        products_cats = JSON.parse(localStorage[tables.product_cat]);
        branches = JSON.parse(localStorage[tables.branches]);
        customer_cats = JSON.parse(localStorage[tables.customer_cat]);
        //data from server
        var states = [
            {code: 'ALL', name: 'Tất cả'},
            {code: 'INACTIVE', name: 'Hủy bán'},
            {code: 'ACTIVE', name: 'Đang bán'}
        ];
        products_cats[products_cats.length] = {
            code: 'ALL',
            name: 'Tất cả'
        };
        branches[branches.length] = {
            code: 'ALL',
            name: 'Tất cả'
        };
        setTimeout(function () {
            txt_s_cat.jqxDropDownList('selectItem', "ALL");
            txt_s_branch.jqxDropDownList('selectItem', me.branch);
            txt_s_state.jqxDropDownList({source: states});
            txt_s_state.jqxDropDownList('selectItem', 'ALL');
        }, 500);
    };

    ProductsListApp.showSidebar = function (is_show) {
        if (is_show) {
            $('#sidebar2').animate({'right': '0px'}, 300, function () {
                // Animation complete.
                txt_code.focus();
                $('#content-table').css({opacity: '0.06'});
            });
        } else {
            $('#sidebar2').animate({'right': '-500px'}, 200);
            $('#content-table').css({opacity: '1'});
        }
    };

    function view_start() {
        ProductsListApp.createData();
        ProductsListApp.createUI();
        ProductsListApp.createEvent();
    }

</script>