<div class="view">
    <div id="loader_view"></div>
    <div id="table"></div>
</div>


<div id="windows_add" class="windows">
    <div>
        <i class="fa fa-plus-circle"></i>
        Thêm mới người dùng
    </div>
    <div>
        <div>
            <p class="text-muted font-13 m-b-30"></p>
            <label style="display: none;">ID:</label>
            <input style="display: none;" id="id" readonly class="input">

            <div class="container-form-100 clearfix">
                <div class="container-form-50">
                    <label>Tên đăng nhập:</label>
                    <input id="username" class="input">
                </div>
                <div class="container-form-50">
                    <label>Mật khẩu:</label>
                    <input id="password" type="password" class="input">
                </div>
            </div>

            <div class="container-form-100 clearfix">
                <div class="container-form-50">
                    <label>Họ và tên:</label>
                    <input id="name" class="input">
                </div>
                <div class="container-form-50">
                    <label>Chi nhánh:</label>
                    <select id="branch"></select>
                </div>
            </div>
            <div class="container-form-100 clearfix">
                <div class="container-form-50">
                    <label>Email:</label>
                    <input id="email" class="input">
                </div>
                <div class="container-form-50">
                    <label>Điện thoại:</label>
                    <input id="phone" class="input">
                </div>
            </div>
            <div class="container-form-100 clearfix">
                <div class="container-form-50">
                    <label>Cấp độ:</label>
                    <select id="level"></select>
                </div>

                <div class="container-form-50">
                    <label>Trạng thái:</label>
                    <select id="state" class="select">
                        <option value="ACTIVE">Kích hoạt</option>
                        <option value="INACTIVE">Hủy hoạt</option>
                    </select>
                </div>
            </div>
            <label>Quản lý đa chi nhánh:</label>
            <select id="mutil_branch" class="select">
                <option value="true">Đúng</option>
                <option value="false">Sai</option>
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
    var loader_view = $('#loader_view');
    var container_toolbar;
    var btn_add;
    var btn_edit;
    var btn_logout;
    var btn_delete;
    var btn_reload;
    var btn_save = $('#btn_save');
    var btn_cancel = $('#btn_cancel');
    var lb_table;
    var btn_export_excel;
    var btn_export_print;
    var user_txt = {
        id: $('#id'),
        username: $('#username'),
        password: $('#password'),
        name: $('#name'),
        email: $('#email'),
        level: $('#level'),
        branch: $('#branch'),
        note: $('#note'),
        phone: $('#phone'),
        state: $('#state'),
        mutil_branch: $('#mutil_branch'),
    };
    var usersAPP = {};

    usersAPP.download = function download() {
        loader_view.jqxLoader('open');
        download_data(urls.url_apis.users, function (result) {
            if (result['success']) {
                var users = result['data'];
                for (var i = 0; i < users.length; i++) {
                    users[i]['level_name'] = app.getNameByCode(users[i]['level'], JSON.parse(localStorage.getItem('levels_user')));
                    users[i]['branch_name'] = app.getNameByCode(users[i]['branch'], JSON.parse(localStorage.getItem('branches')));
                    if (users[i]['state'].trim() == 'ACTIVE') {
                        users[i]['state_name'] = 'Kích hoạt';
                    } else {
                        users[i]['state_name'] = 'Vô hiệu hóa';
                    }
                    //console.log(users[i]['access_token']);
                    if (users[i]['access_token'].trim() != '') {
                        users[i]['online'] = 'Đang hoạt động';
                    } else {
                        users[i]['online'] = 'Đã đăng xuất';
                    }
                }
                source.localdata = users;
                dataAdapter = new $.jqx.dataAdapter(source);
                table.jqxGrid('updatebounddata', 'cells');
                table.jqxGrid('clearselection');
            } else {
                app.notify("Tải dữ liệu bị lỗi!", 'error');
            }
            loader_view.jqxLoader('close');
        });
    };


    usersAPP.createToolbar = function createToolbar(toolbar) {
        // appends buttons to the status bar.
        container_toolbar.append(lb_table);
        container_toolbar.append(btn_export_print);
        container_toolbar.append(btn_export_excel);
        container_toolbar.append(btn_delete);
        container_toolbar.append(btn_logout);
        container_toolbar.append(btn_edit);
        container_toolbar.append(btn_add);
        toolbar.append(container_toolbar);
    };

    usersAPP.add_user = function add_user() {
        var data_form = {
            username: user_txt.username.jqxInput('val'),
            email: user_txt.email.jqxInput('val'),
            name: user_txt.name.jqxInput('val'),
            password: user_txt.password.jqxPasswordInput('val'),
            level: user_txt.level.jqxDropDownList('val'),
            phone: user_txt.phone.jqxInput('val'),
            branch: user_txt.branch.jqxDropDownList('val'),
            state: user_txt.state.jqxDropDownList('val'),
            mutil_branch: user_txt.mutil_branch.jqxDropDownList('val'),
            note: user_txt.note.jqxTextArea('val'),
        };
        swal({
            title: 'Bạn có chắc muốn thêm?',
            text: "Thêm người dùng vào hệ thống!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Thêm ngay',
            cancelButtonText: 'Hủy bỏ',
        }).then(function () {
            add_data(urls.url_apis.users, data_form, function (result) {
                if (result['success']) {
                    app.notify("Thêm người dùng thành công!", 'success');
                    usersAPP.download();
                    windows_add.jqxWindow('close');
                } else {
                    app.notify("Thêm người dùng lỗi!", 'error');
                }
            });
        }).catch(swal.noop);

    };
    usersAPP.edit_user = function() {
        var data_form = {
            id:user_txt.id.val(),
            username: user_txt.username.jqxInput('val'),
            email: user_txt.email.jqxInput('val'),
            name: user_txt.name.jqxInput('val'),
            password: user_txt.password.jqxPasswordInput('val'),
            level: user_txt.level.jqxDropDownList('val'),
            phone: user_txt.phone.jqxInput('val'),
            branch: user_txt.branch.jqxDropDownList('val'),
            state: user_txt.state.jqxDropDownList('val'),
            mutil_branch: user_txt.mutil_branch.jqxDropDownList('val'),
            note: user_txt.note.jqxTextArea('val'),
        };
        swal({
            title: 'Bạn có chắc?',
            text: "Cập nhật thông tin người dùng!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Cập nhật',
            cancelButtonText: 'Hủy bỏ',
        }).then(function () {
            update_data(urls.url_apis.users, data_form.id, data_form, function (result) {
                if (result['success']) {
                    app.notify("Cập nhật thông tin người dùng thành công!", 'success');
                    usersAPP.download();
                    windows_add.jqxWindow('close');
                    //Cập nhật dữ liệu
                    app.download_and_save();
                } else {
                    app.notify("Cập nhật thông tin người dùng lỗi!", 'error');
                }
            });
        }).catch(swal.noop);
    };
    usersAPP.logout_user = function (id) {
        swal({
            title: 'Bạn có chắc muốn đăng xuất?',
            text: "Đăng xuất người dùng khỏi hệ thống!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Đăng xuất',
            cancelButtonText: 'Hủy bỏ',
        }).then(function () {
            update_data(urls.url_apis.users, id,{logout:true,id:id}, function (result) {
                if (result['success']) {
                    app.notify("Đăng xuất người dùng thành công!", 'success');
                    usersAPP.download();
                    //Cập nhật dữ liệu
                    app.download_and_save();
                } else {
                    app.notify("Đăng xuất người dùng lỗi!", 'error');
                }
            });
        }).catch(swal.noop);
    };
    usersAPP.delete_user = function(id) {
        swal({
            title: 'Bạn có chắc muốn xóa?',
            text: "Xóa người dùng khỏi hệ thống!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy bỏ',
        }).then(function () {
            delete_data(urls.url_apis.users, id, function (result) {
                if (result['success']) {
                    app.notify("Xóa thông tin người dùng thành công!", 'success');
                    usersAPP.download();
                    //Cập nhật dữ liệu
                    app.download_and_save();
                } else {
                    app.notify("Xóa thông tin người dùng lỗi!", 'error');
                }
            });
        }).catch(swal.noop);

    };

    usersAPP.createUI = function createUI() {
        loader_view.jqxLoader({text: "Đang tải dữ liệu...", width: 120, height: 60, imagePosition: 'top'});

        windows_add.jqxWindow({
            position: {x: (($(window).width() - 500) / 2), y: '10%'},
            width: 500,
            resizable: false, isModal: true, modalOpacity: 0.3,
            cancelButton: btn_cancel,
            autoOpen: false
        });
        
        btn_save.jqxButton({height: 30,template:'primary'});
        btn_cancel.jqxButton({height: 30,template:'danger'});
        user_txt.id.jqxInput({width: '100%', height: 30, disabled: true});
        user_txt.username.jqxInput({width: '100%', height: 30});
        user_txt.email.jqxInput({width: '100%', height: 30});
        user_txt.name.jqxInput({width: '100%', height: 30});
        user_txt.password.jqxPasswordInput({width: '100%', height: 30});
        user_txt.phone.jqxInput({width: '100%', height: 30});
        user_txt.branch.jqxDropDownList({width: '100%', height: 30});
        var branches = JSON.parse(localStorage.getItem('branches'));
        var levels = JSON.parse(localStorage.getItem('levels_user'));
        user_txt.level.jqxDropDownList({width: '100%', height: 30, source: null});
        for (var i = 0; i < branches.length; i++) {
            user_txt.branch.jqxDropDownList('addItem', {
                value: branches[i]['code'],
                label: branches[i]['name'],
            });
        }
        for (i = 0; i < levels.length; i++) {
            user_txt.level.jqxDropDownList('addItem', {
                value: levels[i]['code'],
                label: levels[i]['name'],
            });
        }
        user_txt.state.jqxDropDownList({width: '100%', height: 30});
        user_txt.mutil_branch.jqxDropDownList({width: '100%', height: 30});
        user_txt.note.jqxTextArea({width: '100%', height: 50});
        //Button toolbar
        container_toolbar = $("<div class='container-toolbar clearfix'></div>");
        btn_add = $("<button><i class='fa fa-plus-circle'></i> Thêm</button>");
        btn_logout = $("<button><i class='fa fa-power-off'></i> Đăng xuất</button>");
        btn_edit = $("<button><i class='fa fa-pencil'></i> Sửa</button>");
        btn_delete = $("<button><i class='fa fa-trash'></i> Xóa</button>");
        btn_export_excel = $("<button><i class='fa fa-file-excel-o'></i> Xuất Excel</button>");
        btn_export_print = $("<button><i class='fa fa-print'></i> In</button>");
        lb_table = $("<div class='table-title'><span>Quản lý người dùng</span></div>");
        btn_add.jqxButton({height: 16, width: 'auto',template:'primary'});
        btn_edit.jqxButton({height: 16, width: 'auto',template:'primary'});
        btn_logout.jqxButton({height: 16, width: 'auto',template:'primary'});
        btn_delete.jqxButton({height: 16, width: 'auto',template:'primary'});
        btn_export_excel.jqxButton({height: 16, width: 'auto',template:'primary'});
        btn_export_print.jqxButton({height: 16, width: 'auto',template:'primary'});
        //Init table
        source =
        {
            localdata: {},
            datatype: "array"
        };
        dataAdapter = new $.jqx.dataAdapter(source);
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
                    width:30
                },
                {
                    text: 'Tên người dùng',
                    dataField: 'username',
                    width:150,
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (rowdata['state'] == 'ACTIVE') {
                            return '<div class="price_sale-cell" style="text-align: left;"><i class="fa fa-check-circle-o icon-active"></i> ' + value + '</div>';
                        }
                        return '<div class="price_sale-cell" style="text-align: left;"><i class="fa fa-times-circle-o icon-inactive"></i> ' + value + '</div>';
                    }
                }, {
                    text: 'Họ tên người dùng',
                    dataField: 'name',
                    width:180
                }, {
                    text: 'Điện thoại',
                    dataField: 'phone',
                    width:100
                }, {
                    text: 'Chi nhánh',
                    dataField: 'branch_name',
                    width:150
                }, {
                    text: 'Chức vụ',
                    dataField: 'level_name',
                    width:180
                },{
                    text: 'Đa chi nhánh',
                    dataField: 'mutil_branch',
                    width:125,
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (rowdata['mutil_branch'] == 'true') {
                            return '<div class="price_sale-cell" style="text-align: left;font-weight: normal"><i class="fa fa-check-circle-o icon-active"></i> Có</div>';
                        }
                        return '<div class="price_sale-cell" style="text-align: left;font-weight: normal"><i class="fa fa-times-circle-o icon-inactive"></i> Không</div>';
                    }
                }, {
                    text: 'Hoạt động',
                    dataField: 'online',
                    width:120,
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (rowdata['online'] == 'Đang hoạt động') {
                            return '<div class="price_sale-cell" style="text-align: left; font-weight: normal"><i class="fa fa-check-circle-o icon-active"></i> Online</div>';
                        }
                        return '<div class="price_sale-cell" style="text-align: left; font-weight: normal"><i class="fa fa-times-circle-o icon-inactive"></i> Offline</div>';
                    }
                }, {
                    text: 'Trạng thái',
                    dataField: 'state_name',
                    width:110,
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
                        if (rowdata['state_name'] == 'Kích hoạt') {
                            return '<div class="price_sale-cell" style="text-align: left; font-weight: normal"><i class="fa fa-check-circle-o icon-active"></i> '+value+'</div>';
                        }
                        return '<div class="price_sale-cell" style="text-align: left; font-weight: normal"><i class="fa fa-times-circle-o icon-inactive"></i> '+value+'</div>';
                    }
                }, {
                    text: 'Thời gian tạo',
                    dataField: 'created_at',
                    filtertype: 'date',
                    cellsformat: 'HH:mm dd/MM/yyyy'
                }
            ],
            showtoolbar: true,
            toolbarheight: 40,
            rendertoolbar: usersAPP.createToolbar,
        });
    };
    usersAPP.createEvent = function createEvent() {
        btn_add.click(function () {
            windows_add.jqxWindow('open');
            windows_add.jqxWindow({title: "<i class='fa fa-plus-circle'></i> Thêm mới người dùng"});
            btn_save.off('click');
            btn_save.click(usersAPP.add_user);
            btn_save.val('Thêm mới');
        });
        btn_edit.click(function () {
            windows_add.jqxWindow({title: "<i class='fa fa-pencil'></i> Sửa thông tin người dùng"});
            btn_save.off('click');
            btn_save.click(usersAPP.edit_user);
            btn_save.val('Lưu lại');
            //init data windows
            var rowindex = table.jqxGrid('getselectedrowindex');
            if (rowindex >= 0) {
                var data = table.jqxGrid('getrowdata', rowindex);
                user_txt.id.val(data['id']);
                user_txt.username.jqxInput('val',data['username']);
                user_txt.email.jqxInput('val',data['email']);
                user_txt.name.jqxInput('val',data['name']);
                user_txt.password.jqxPasswordInput('val','');
                user_txt.level.jqxDropDownList('val',data['level']);
                user_txt.phone.jqxInput('val',data['phone']);
                user_txt.branch.jqxDropDownList('val',data['branch']);
                user_txt.state.jqxDropDownList('val',data['state']);
                user_txt.mutil_branch.jqxDropDownList('val',data['mutil_branch']);
                user_txt.note.jqxTextArea('val',data['note']);
                windows_add.jqxWindow('open');
            }
        });
        btn_delete.click(function () {
            var rowindexes = table.jqxGrid('getselectedrowindexes');
            for (var i = 0; i < rowindexes.length; i++) {
                var user = table.jqxGrid('getrowdata', rowindexes[i]);
                usersAPP.delete_user(user.id);
            }
        });
        btn_logout.click(function () {
            var rowindexes = table.jqxGrid('getselectedrowindexes');
            for (var i = 0; i < rowindexes.length; i++) {
                var user = table.jqxGrid('getrowdata', rowindexes[i]);
                usersAPP.logout_user(user.id);
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
                            '<title>In danh sách người dùng</title>\n' +
                            '</head>\n' +
                            '<body>\n' + gridContent + '\n</body>\n</html>';
            document.write(pageContent);
            document.close();
            newWindow.print();
        });
        btn_export_excel.click(function () {
            table.jqxGrid('exportdata', 'xls', 'users');
        });
    };

    function view_start() {
        usersAPP.createUI();
        usersAPP.download();
        usersAPP.createEvent();
    }
</script>