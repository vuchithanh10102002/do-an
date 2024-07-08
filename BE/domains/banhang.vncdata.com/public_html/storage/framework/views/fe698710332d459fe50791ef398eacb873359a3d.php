<?php /*Chứa danh sách các sản phẩm của công ty*/ ?>

<div class="view">
    <div id="loader_view"></div>
    <div id="sidebar">
        <div class="sidebar-item">
            <div>Thay đổi mẫu in</div>
            <div>
                <div style="margin-top: 10px"></div>
                <label for="mauin">Chọn mấu in:</label>
                <div id="mauin"></div>
                <label for="chinhanh">Chi nhánh:</label>
                <div id="chinhanh"></div>
                <div style="margin-bottom: 10px"></div>
                <button style="margin-bottom: 5px;display: none;" id="load_data"><i class="fa fa-check"></i> Tải mẫu</button>

                <div style="margin-bottom: 10px"></div>
            </div>
        </div>
        <button style="border-radius: 0;" id="btn_submit"><i class="fa fa-save"></i> Lưu lại</button>
    </div>
    <div id="content-table">
        <textarea id="editor"></textarea>
    </div>
</div>


<script>
    /* *
     * Process unit and data price
     * */
    var PrintChangeApp = {};
    var editer = $('#editor');
    var cb_mauin = $('#mauin');
    var cb_chinhanh = $('#chinhanh');
    var prints = null;
    var btn_load_data = $('#load_data');
    var btn_submit = $('#btn_submit');
    var me = null;

    PrintChangeApp.createUI = function () {
        //Sidebar
        $(".sidebar-item").jqxExpander({width: '100%'});
        btn_submit.jqxButton({width:'100%',height:'40px',template:'success'});
        btn_load_data.jqxButton({width:'100%',height:'30px'});
        editer.jqxEditor({
            height: "100%",
            width: '100%'
        });
        cb_mauin.jqxDropDownList({
            width: '100%',
            height: 25,
            displayMember: 'title',
            valueMember: 'name',
            source: null,
            placeHolder: " "
        });
        cb_chinhanh.jqxDropDownList({
            width: '100%',
            height: 25,
            disabled:true,
            displayMember: 'name',
            valueMember: 'code',
            source: null,
            placeHolder: " "
        });
    };


    PrintChangeApp.createEvent = function () {

        btn_load_data.click(function () {
            app.loadding('open');
            download_data_where(urls.url_apis.select, {
                table: "settings",
                select: "WHERE name='" + cb_mauin.jqxDropDownList('val') + "' AND branch='"+cb_chinhanh.jqxDropDownList('val')+"'",
                data: "value"
            }, null, function (result) {
                if (result['success']) {
                    editer.jqxEditor('val', result['data'][0]['value']);
                } else {
                    app.notify('Tải dữ liệu bị lỗi!', 'error');
                }
                app.loadding('close');
            });
        });
        $('#mauin').on('change', function (event)
        {
            btn_load_data.click();
        });
        //Lưu
        btn_submit.click(function () {
            if(cb_mauin.jqxDropDownList('val')!=''){
                app.loadding('open');
                update_data(urls.url_apis.settings,0, {
                    name: cb_mauin.jqxDropDownList('val'),
                    value: editer.jqxEditor('val'),
                    branch: me.branch
                }, function (result) {
                    if (result['success']) {
                        app.notify('Lưu mẫu in thành công!', 'success');
                    } else {
                        app.notify('Lưu mẫu in lỗi!', 'error');
                    }
                    app.loadding('close');
                })
            }else{
                app.notify("Chọn tải mẫu in trước!",'warning');
            }
        });
    };


    PrintChangeApp.createData = function () {
        //data from local
        me = JSON.parse(localStorage[tables.me]);
        cb_chinhanh.jqxDropDownList({source:JSON.parse(localStorage[tables.branches])});
        cb_chinhanh.jqxDropDownList('val',me.branch);
        //data from server
        app.loadding('open');
        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE 1 AND branch LIKE '"+me.branch+"'",
            data: "name,title"
        }, null, function (result) {
            if (result['success']) {
                prints = result['data'];
                cb_mauin.jqxDropDownList({'source': prints})
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            app.loadding('close');
        });
    };

    function view_start() {
        PrintChangeApp.createUI();
        PrintChangeApp.createData();
        PrintChangeApp.createEvent();
    }

</script>