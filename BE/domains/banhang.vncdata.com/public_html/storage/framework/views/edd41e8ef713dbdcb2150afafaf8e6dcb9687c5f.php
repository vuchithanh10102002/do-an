<div class="view">
    <div id="loader_view"></div>
    <div id="table"></div>
</div>


<div id="windows_add" class="windows">
    <div>
        <i class="fa fa-plus-circle"></i>
        Thêm mới chi nhánh
    </div>
    <div>
        <div>
            <p class="text-muted font-13 m-b-30"></p>
            <label style="display: none;">ID:</label>
            <input style="display: none;" id="id" readonly class="input">
            <label>Mã chi nhánh:</label>
            <input id="code" class="input">
            <label>Tên chi nhánh:</label>
            <input id="name" class="input">
            <label>Địa chỉ:</label>
            <input id="address" class="input">
            <label>Điện thoại:</label>
            <input id="phone" class="input">
            <label>Trạng thái:</label>
            <select id="state" class="select">
                <option value="<?php echo \App\CusstomPHP\State::$tt_Active; ?>"><?php echo \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Active); ?></option>
                <option value="<?php echo \App\CusstomPHP\State::$tt_Inactive; ?>"><?php echo \App\CusstomPHP\State::getTxtState(\App\CusstomPHP\State::$tt_Inactive); ?></option>
            </select>
            <label>Ghi chú:</label>
            <textarea id="note" class="textarea"></textarea>
        </div>
        <div>
            <div style="float: right; margin-top: 15px;">
                <input class="btn" type="button" id="btn_save" value="Lưu lại"/>
                <input class="btn" type="button" id="btn_cancel" value="Hủy bỏ"/>
            </div>
        </div>
    </div>
</div>


<script>
    var dataAdapter;
    var source;
    var table = $("#table");
    var windows_add = $('#windows_add');
    var container_toolbar;
    var btn_add;
    var btn_edit;
    var btn_delete;
    var btn_dongbo;
    var btn_save = $('#btn_save');
    var btn_cancel = $('#btn_cancel');
    var lb_table;
    var btn_export_excel;
    var btn_export_print;
    var branch_txt = {
        id: $('#id'),
        code: $('#code'),
        name: $('#name'),
        address: $('#address'),
        phone: $('#phone'),
        state: $('#state'),
        note: $('#note')
    };
    var branchAPP = {};

    branchAPP.download = function download() {
        app.loadding('open');
        download_data(urls.url_apis.branches, function (result) {
            if (result['success']) {
                source.localdata = result['data'];
                table.jqxGrid('updatebounddata', 'cells');
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
            app.loadding('close');
        });
    };


    branchAPP.createToolbar = function createToolbar(toolbar) {
        // appends buttons to the status bar.
        container_toolbar.append(lb_table);
        container_toolbar.append(btn_export_print);
        container_toolbar.append(btn_export_excel);
        container_toolbar.append(btn_delete);
        container_toolbar.append(btn_edit);
        container_toolbar.append(btn_add);
        container_toolbar.append(btn_dongbo);
        toolbar.append(container_toolbar);
    };

    branchAPP.add_branch = function add_branch() {
        var data_form = {
            code: branch_txt.code.val(),
            name: branch_txt.name.val(),
            address: branch_txt.address.val(),
            phone: branch_txt.phone.val(),
            state: branch_txt.state.val(),
            note: branch_txt.note.val()
        };
        add_data(urls.url_apis.branches, data_form, function (result) {
            if (result['success']) {
                app.notify("Thêm chi nhánh thành công!", 'success');
                branchAPP.download();
                windows_add.jqxWindow('close');
            } else {
                app.notify("Thêm chi nhánh lỗi!", 'error');
            }
        });
    };
    branchAPP.edit_branch = function edit_branch() {
        var data_form = {
            id: branch_txt.id.val(),
            code: branch_txt.code.val(),
            name: branch_txt.name.val(),
            address: branch_txt.address.val(),
            phone: branch_txt.phone.val(),
            state: branch_txt.state.val(),
            note: branch_txt.note.val()
        };
        update_data(urls.url_apis.branches, data_form.id, data_form, function (result) {
            if (result['success']) {
                app.notify("Cập nhật thông tin chi nhánh thành công!", 'success');
                branchAPP.download();
                windows_add.jqxWindow('close');
            } else {
                app.notify("Cập nhật thông tin chi nhánh lỗi!", 'error');
            }
        });
    };
    branchAPP.delete_branch = function delete_branch(id) {
        delete_data(urls.url_apis.branches, id, function (result) {
            if (result['success']) {
                app.notify("Xóa thông tin chi nhánh thành công!", 'success');
                branchAPP.download();
                windows_add.jqxWindow('close');
            } else {
                app.notify("Xóa thông tin chi nhánh lỗi!", 'error');
            }
        });
    };

    branchAPP.createUI = function createUI() {
        windows_add.jqxWindow({
            position: {x: (($(window).width() - 500) / 2), y: '10%'},
            width: 500,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel,
            autoOpen: false,

        });
        btn_save.jqxButton({height: 30, template: 'primary'});
        btn_cancel.jqxButton({height: 30});
        branch_txt.id.jqxInput({width: '100%', height: 25, disabled: true});
        branch_txt.code.jqxInput({width: '100%', height: 25});
        branch_txt.name.jqxInput({width: '100%', height: 25});
        branch_txt.address.jqxInput({width: '100%', height: 25});
        branch_txt.phone.jqxInput({width: '100%', height: 25});
        branch_txt.state.jqxComboBox({width: '100%', height: 25});
        branch_txt.note.jqxTextArea({width: '100%', height: 50});
        //Button toolbar
        container_toolbar = $("<div class='container-toolbar clearfix'></div>");
        btn_add = $("<button><i class='fa fa-plus-circle'></i> Thêm</button>");
        btn_edit = $("<button><i class='fa fa-pencil'></i> Sửa</button>");
        btn_delete = $("<button><i class='fa fa-trash'></i> Xóa</button>");
        btn_export_excel = $("<button><i class='fa fa-file-excel-o'></i> Xuất Excel</button>");
        btn_export_print = $("<button><i class='fa fa-print'></i> In</button>");
        btn_dongbo = $("<button><i class='fa fa-copy'></i> Đồng bộ dữ liệu</button>");
        lb_table = $("<div class='table-title'><span>Quản lý chi nhánh & kho</span></div>");
        btn_dongbo.jqxButton({height: 16, width: 'auto', template: 'primary'});
        btn_add.jqxButton({height: 16, width: 'auto', template: 'primary'});
        btn_edit.jqxButton({height: 16, width: 'auto', template: 'primary'});
        btn_delete.jqxButton({height: 16, width: 'auto', template: 'primary'});
        btn_export_excel.jqxButton({height: 16, width: 'auto', template: 'primary'});
        btn_export_print.jqxButton({height: 16, width: 'auto', template: 'primary'});
        //Init table
        source =
            {
                localdata: {},
                datatype: "array"
            };
        dataAdapter = new $.jqx.dataAdapter(source);
        table.jqxGrid({
            pageSize: 20,
            pageable: false,
            rowsheight: 40,
            columnsheight: 40,
            altRows: true,
            height: '100%',
            width: '100%',
            filterable: true,
            autoshowfiltericon: true,
            sortable: true,
            columnsResize: true,
            source: dataAdapter,
            selectionmode: 'singlerow',
            columns: [
                {
                    text: 'ID',
                    dataField: 'id',
                    cellsalign: 'center', align: 'center',
                },
                {
                    text: 'Mã',
                    dataField: 'code'
                }, {
                    text: 'Tên chi nhánh',
                    dataField: 'name'
                }, {
                    text: 'Điện thoại',
                    dataField: 'phone'
                }, {
                    text: 'Địa chỉ',
                    dataField: 'address'
                }, {
                    text: 'Ghi chú',
                    dataField: 'note'
                }, {
                    text: 'Thời gian tạo',
                    dataField: 'create_at',
                    filtertype: 'date',
                    cellsformat: 'HH:mm dd/MM/yyyy'
                }
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: branchAPP.createToolbar,
        });
    };
    branchAPP.createEvent = function createEvent() {
        btn_add.click(function () {
            windows_add.jqxWindow('open');
            windows_add.jqxWindow({title: "<i class='fa fa-plus-circle'></i> Thêm mới chi nhánh"});
            btn_save.off('click');
            btn_save.click(branchAPP.add_branch);
            btn_save.val('Thêm mới');
        });
        btn_edit.click(function () {
            windows_add.jqxWindow({title: "<i class='fa fa-pencil'></i> Sửa thông tin chi nhánh"});
            btn_save.off('click');
            btn_save.click(branchAPP.edit_branch);
            btn_save.val('Lưu lại');
            //init data windows
            var rowindex = table.jqxGrid('getselectedrowindex');
            if (rowindex >= 0) {
                var data = table.jqxGrid('getrowdata', rowindex);
                branch_txt.id.val(data.id);
                branch_txt.name.val(data.name);
                branch_txt.code.val(data.code);
                branch_txt.address.val(data.address);
                branch_txt.phone.val(data.phone);
                branch_txt.state.val(data.state);
                branch_txt.note.val(data.note);
                branch_txt.code.focus();
                windows_add.jqxWindow('open');
            }
        });
        btn_delete.click(function () {
            var rowindexes = table.jqxGrid('getselectedrowindexes');
            for (var i = 0; i < rowindexes.length; i++) {
                var data = table.jqxGrid('getrowdata', rowindexes[i]);
                branchAPP.delete_branch(data.id);
            }
        });
        btn_export_print.click(function () {
            var gridContent = table.jqxGrid('exportdata', 'html');
            var newWindow = window.open('', '', 'width=800, height=500'),
                document = newWindow.document.open(),
                pageContent =
                    '<!DOCTYPE html>\n' +
                    '<html>\n' +
                    '<head>\n' +
                    '<meta charset="utf-8" />\n' +
                    '<title>In danh sách chi nhánh</title>\n' +
                    '</head>\n' +
                    '<body>\n' + gridContent + '\n</body>\n</html>';
            document.write(pageContent);
            document.close();
            newWindow.print();
        });
        btn_export_excel.click(function () {
            table.jqxGrid('exportdata', 'xls', 'Branches');
        });
        //Đồng bộ dữ liệu 2 chi nhánh
        btn_dongbo.click(function () {
            swal({
                title: 'Bạn muốn đồng bộ?',
                text: "Dữ liệu của chi nhánh bạn chọn sẽ được đồng bộ dữ liệu với chi nhánh của bạn!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng bộ ngay',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                var chinhanh = table.jqxGrid('getrowdata', table.jqxGrid('getselectedrowindex'))['code'];
                loader.jqxLoader('open');
                loader.jqxLoader({width: '200px'});
                loader.jqxLoader({text: 'Đang chuẩn bị dữ liệu...'});
                loader.jqxLoader({text: 'Đang tải sản phẩm...'});
                //Tải danh sách sản phẩm bên A có bên B không có
                download_data_where(urls.url_apis.select, {
                    table: "products_list",
                    select: "WHERE code NOT IN (SELECT code FROM products_list WHERE branch LIKE '" + chinhanh + "') AND branch LIKE '" + me.branch + "'",
                    data: "*"
                }, null, function (result) {
                    if (result['success']) {
                        var products_list = result['data'];
                        var dongbo_xong = 0;
                        var sl_dongbo = parseInt(products_list.length);
                        loader.jqxLoader({text: 'Đồng bộ sản phẩm (0/' + products_list.length + ')...'});

                        function dongbosanpham() {
                            dongbo_xong += 1;
                            loader.jqxLoader({text: 'Đồng bộ sản phẩm (' + dongbo_xong + '/' + sl_dongbo + ')...'});
                            if (dongbo_xong >= sl_dongbo) {
                                loader.jqxLoader({text: 'Đồng bộ sản phẩm hoàn thành!'});
                                loader.jqxLoader({text: 'Đang tải cấu hình...'});
                                download_data_where(urls.url_apis.select, {
                                    table: "settings",
                                    select: "WHERE name NOT IN (SELECT name FROM settings WHERE branch LIKE '" + chinhanh + "') AND branch LIKE '" + me.branch + "'",
                                    data: "*"
                                }, null, function (result) {
                                    var cauhinhs = result['data'];
                                    var dongbo_xong = 0;
                                    var sl_dongbo2 = parseInt(cauhinhs.length);

                                    function dongbocauhinh() {
                                        dongbo_xong += 1;
                                        loader.jqxLoader({text: 'Đồng bộ cấu hình (' + dongbo_xong + '/' + sl_dongbo2 + ')...'});
                                        if (dongbo_xong >= sl_dongbo2) {
                                            loader.jqxLoader('close');
                                            loader.jqxLoader({width: '100px'});
                                            loader.jqxLoader({text: 'Đang tải...'});
                                            swal(
                                                'Hoàn thành!',
                                                'Việc đồng bộ dữ liệu đã thành công!',
                                                'success'
                                            );
                                        }
                                    }

                                    function dongboch_start(i) {
                                        if(cauhinhs[i]!=undefined){
                                            cauhinhs[i]['branch'] = chinhanh;
                                            cauhinhs[i]['id'] = null;
                                            if (sl_dongbo2 > i) {
                                                add_data(urls.url_apis.settings, cauhinhs[i], function (result) {
                                                    dongbocauhinh();
                                                    dongboch_start(dongbo_xong);
                                                });
                                            }
                                        }else {
                                            dongbocauhinh();
                                        }
                                    }
                                    dongboch_start(0);
                                });
                            }
                        }

                        function dongbosp_start(i) {
                            if (products_list[i] != undefined) {
                                products_list[i]['branch'] = chinhanh;
                                products_list[i]['number'] = 0;
                                products_list[i]['id'] = null;
                                if (sl_dongbo > i) {
                                    add_data(urls.url_apis.product_list, products_list[i], function (result) {
                                        dongbosanpham();
                                        dongbosp_start(dongbo_xong);
                                    });
                                }
                            }else {
                                dongbosanpham();
                            }
                        }

                        dongbosp_start(0);
                    } else {
                        app.notify('Tải dữ liệu bị lỗi!', 'error');
                    }
                });
            }).catch(swal.noop);
        });
    };

    function view_start() {
        branchAPP.createUI();
        branchAPP.download();
        branchAPP.createEvent();
    }
</script>