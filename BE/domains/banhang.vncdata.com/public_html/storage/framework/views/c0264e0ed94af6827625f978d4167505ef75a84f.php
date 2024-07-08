<div class="view">
    <div id="loader_view"></div>
    <div class="user-role-ct1">
        <div id="table"></div>
    </div>
    <div class="user-role-ct2">
        <div id="table2"></div>
    </div>
</div>

<div id="windows_add" class="windows">
    <div>
        <i class="fa fa-plus-circle"></i>
        Thêm vai trò người dùng
    </div>
    <div>
        <div>
            <div>
                <label>Mã vai trò:</label>
                <input id="ma" class="input">
            </div>
            <div>
                <label>Tên vai trò:</label>
                <input id="ten">
            </div>
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
    var dataAdapter2;
    var source;
    var table = $("#table");
    var table_role = $("#table2");
    var table_source2 = null;
    var container_toolbar;
    var btn_add;
    var btn_edit;
    var btn_save = $('#btn_save');
    var btn_cancel = $('#btn_cancel');
    var lb_table;
    var txt_ma = $('#ma');
    var txt_ten = $('#ten');
    var UserRoleAPP = {};
    var permissions = null;
    var roles = null;
    var windows_add = $('#windows_add');

    UserRoleAPP.download = function download() {
        download_data(urls.url_apis.permissions, function (result) {
            if (result['success']) {
                permissions = result['data'];
                table_source2.localdata = permissions;
                table_role.jqxGrid('updatebounddata', 'cells');
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
        download_data(urls.url_apis.user_roles, function (result) {
            if (result['success']) {
                roles = result['data'];
                source.localdata = roles;
                table.jqxGrid('updatebounddata', 'cells');
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
        });
    };


    UserRoleAPP.createToolbar = function createToolbar(toolbar) {
        // appends buttons to the status bar.
        container_toolbar.append(lb_table);
        container_toolbar.append(btn_edit);
        container_toolbar.append(btn_add);
        toolbar.append(container_toolbar);
    };
    UserRoleAPP.createToolbar2 = function createToolbar(toolbar) {
        // appends buttons to the status bar.
        var container_toolbar2 = $("<div class='container-toolbar clearfix'></div>");
        container_toolbar2.append($("<div class='table-title'><span>Danh sách quyền</span></div>"));
        toolbar.append(container_toolbar2);
    };


    UserRoleAPP.createUI = function () {
        windows_add.jqxWindow({
            position: {x: (($(window).width() - 400) / 2), y: '10%'},
            width: 400,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel,
            autoOpen: false
        });
        txt_ma.jqxInput({width: '100%', height: 30});
        txt_ten.jqxInput({width: '100%', height: 30});
        btn_save.jqxButton({height: 30, template: 'primary'});
        btn_cancel.jqxButton({height: 30, template: 'danger'});
        //Button toolbar
        container_toolbar = $("<div class='container-toolbar clearfix'></div>");
        btn_add = $("<button><i class='fa fa-plus-circle'></i> Thêm</button>");
        btn_edit = $("<button><i class='fa fa-pencil'></i> Cập nhật</button>");
        lb_table = $("<div class='table-title'><span>Danh sách vai trò</span></div>");
        btn_add.jqxButton({height: 16, width: 'auto', template: 'primary'});
        btn_edit.jqxButton({height: 16, width: 'auto', template: 'primary'});

        //Init table
        source = {
            localdata: roles,
            datatype: "array",
            datafields: [
                {name: 'id', type: 'string'},
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'des', type: 'string'},
                {name: 'roles', type: 'string'},
            ]
        };
        table_source2 = {
            localdata: permissions,
            datatype: "array",
            datafields: [
                {name: 'code', type: 'string'},
                {name: 'name', type: 'string'},
                {name: 'des', type: 'string'},
            ]
        };

        dataAdapter = new $.jqx.dataAdapter(source);
        dataAdapter2 = new $.jqx.dataAdapter(table_source2);
        table.jqxGrid({
            pageSize: 20,
            altRows: true,
            rowsheight: 40,
            columnsheight: 40,
            pageable: false,
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
                    width: 30
                },
                {
                    text: 'Mã vai trò',
                    dataField: 'code',
                    width: 150
                }, {
                    text: 'Tên vai trò',
                    dataField: 'name',
                }
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: UserRoleAPP.createToolbar,
        });
        table_role.jqxGrid({
            pageSize: 20,
            altRows: true,
            rowsheight: 33,
            columnsheight: 35,
            pageable: false,
            height: '100%',
            width: '100%',
            filterable: true,
            autoshowfiltericon: true,
            sortable: true,
            columnsResize: true,
            source: dataAdapter2,
            selectionmode: 'checkbox',
            columns: [
                {
                    text: 'Mã quyền',
                    dataField: 'code',
                    width: 150
                }, {
                    text: 'Tên quyền',
                    dataField: 'name',

                }, {
                    text: 'Yêu cầu',
                    dataField: 'des',
                    width: 130
                }
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: UserRoleAPP.createToolbar2,
        });
        table_role.jqxGrid('hidecolumn', 'code');
    };
    UserRoleAPP.createEvent = function createEvent() {
        //Thêm
        btn_add.click(function () {
            windows_add.jqxWindow('open');
        });
        btn_save.click(function () {
            swal({
                title: 'Bạn có chắc muốn thêm?',
                text: "Thêm vai trò người dùng vào hệ thống!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Thêm ngay',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                add_data(urls.url_apis.user_roles, {
                    code: txt_ma.jqxInput('val'),
                    name: txt_ten.jqxInput('val'),
                }, function (result) {
                    if (result['success']) {
                        app.notify("Thêm vai trò người dùng thành công!", 'success');
                        windows_add.jqxWindow('close');
                        UserRoleAPP.download();
                        UserRoleAPP.lamsach();
                    } else {
                        app.notify("Thêm vai trò người dùng lỗi!", 'error');
                    }
                });
            }).catch(swal.noop);

        });
        //Cập nhật quyền cho vai trò
        btn_edit.click(function () {
            //Lấy danh sách
            var quyen_indexs = table_role.jqxGrid('getselectedrowindexes');
            var quyens = [];
            for (var i = 0; i < quyen_indexs.length; i++) {
                var quyen = table_role.jqxGrid('getrowdata', quyen_indexs[i]);
                quyens[quyens.length] = quyen['code'];
            }
            var data = table.jqxGrid('getrowdata', table.jqxGrid('getselectedrowindex'));
            swal({
                title: 'Bạn có chắc muốn cập nhật?',
                text: "Cập nhật quyền người dùng vào hệ thống!",
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Cập nhật',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {
                update_data(urls.url_apis.user_roles, data['id'], {
                    roles: JSON.stringify(quyens),
                    code: data['code'],
                    name: data['name'],
                }, function (result) {
                    if (result['success']) {
                        app.notify("Cập nhật người dùng thành công!", 'success');
                        windows_add.jqxWindow('close');
                        UserRoleAPP.download();
                        UserRoleAPP.lamsach();
                    } else {
                        app.notify("Cập nhật quyền người dùng lỗi!", 'error');
                    }
                });
            }).catch(swal.noop);
        });

        //Hiển thị quyền hiện tại
        $('#table').on('rowselect', function (event) {
            UserRoleAPP.lamsach();
            var args = event.args;
            var rowData = args.row;
            if(rowData['roles']=='' || rowData['roles']==null){
                return;
            }
            var quyens = JSON.parse(rowData['roles']);
            var bang_quyens = table_role.jqxGrid('getrows');
            for (var i = 0; i < quyens.length; i++) {
                for (var j = 0; j < bang_quyens.length; j++) {
                    if (quyens[i] == bang_quyens[j]['code']) {
                        table_role.jqxGrid('selectrow', bang_quyens[j]['uid']);
                    }
                }
            }
        });
    };

    UserRoleAPP.lamsach=function () {
        var bang_quyens = table_role.jqxGrid('getrows');
        var quyens = table.jqxGrid('getrows');
        for(var i=0;i<bang_quyens.length;i++){
            table_role.jqxGrid('unselectrow', bang_quyens[i]['uid']);
        }
        for(i=0;i<quyens.length;i++){
            table.jqxGrid('unselectrow', quyens[i]['uid']);
        }
    };

    function view_start() {
        UserRoleAPP.createUI();
        UserRoleAPP.download();
        UserRoleAPP.createEvent();
    }
</script>