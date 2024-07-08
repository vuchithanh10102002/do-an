<div class="view">
    <div class="container-setting">
        <div class="container-item">
            <div class="item-title">Tài khoản mặc định</div>
            <div class="item-value">
                <div id="acc_default"></div>
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">In hóa đơn sau khi xuất</div>
            <div class="item-value">
                <div id="auto_print"></div>
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Doanh nghiệp tự sản xuất</div>
            <div class="item-value">
                <div id="self_produced"></div>
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Sử dụng máy quét mặc định</div>
            <div class="item-value">
                <div id="auto_scanner"></div>
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Màu sắc phần mềm</div>
            <div class="item-value">
                <input style="border: none;width: 100%;height: 30px;" type="color" id="color_main">
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Màu chữ chính</div>
            <div class="item-value">
                <input id="color_text" style="border: none;width: 100%;height: 30px;" type="color" >
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Quy đổi điểm thưởng</div>
            <div class="item-value">
                <input id="point_to_price" >
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Lượt mua hàng:</div>
            <div class="item-value">
                <input id="hit_use_point" >
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Phần trăm tích thường:</div>
            <div class="item-value">
                <input id="percent_default" >
            </div>
        </div>
        <div class="container-item">
            <div class="item-title">Phần trăm tích đặt biệt:</div>
            <div class="item-value">
                <input id="percent_supper" >
            </div>
        </div>
    </div>
    <div class="container-setting">
        <div class="container-item">
            <div class="item-title">Tích điểm thưởng</div>
            <div class="item-value">
                <div id="auto_check_point"></div>
            </div>
        </div>
        <button id="btn_save"><i class="fa fa-save"></i> Lưu lại</button>
    </div>
</div>


<script>
    SettingAPP = {};

    var settings = {
        'auto_print': true,
        'auto_scanner': true,
        'acc_default': null,
        'color_main': '#4f8cc0',
        'color_text': '#ffffff',
        'self_produced': false,
        'point_to_price': '10000',
        'hit_use_point': '3',
        'percent_default': '10',
        'percent_supper': '20',
        'auto_check_point': true,
    };
    var finance_cat = null;

    var cb_acc_default = $('#acc_default');
    var auto_print = $('#auto_print');
    var self_produced = $('#self_produced');
    var auto_scanner = $('#auto_scanner');
    var color_main = $('#color_main');
    var color_text = $('#color_text');
    var point_to_price = $('#point_to_price');
    var hit_use_point = $('#hit_use_point');
    var percent_default = $('#percent_default');
    var percent_supper = $('#percent_supper');
    var auto_check_point = $('#auto_check_point');

    var btn_save = $('#btn_save');


    SettingAPP.createUI = function () {
        cb_acc_default.jqxDropDownList({
            height: 30,
            width: '100%',
            source: finance_cat,
            displayMember: 'name',
            valueMember: 'code',
            placeHolder: "Chọn tài khoản",
        });
        auto_print.jqxSwitchButton({
            width: '80px',
            height: 30,
            checked: true,
            theme: 'light',
            onLabel:'Bật',
            offLabel:'Tắt'
        });
        auto_scanner.jqxSwitchButton({
            width: '80px',
            height: 30,
            checked: true,
            theme: 'light',
            onLabel:'Bật',
            offLabel:'Tắt'
        });
        auto_check_point.jqxSwitchButton({
            width: '80px',
            height: 30,
            checked: true,
            theme: 'light',
            onLabel:'Bật',
            offLabel:'Tắt'
        });
        point_to_price.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " đ",
            symbolPosition: 'right',
        });
        hit_use_point.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 99999999999,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " ",
            symbolPosition: 'right',
        });
        percent_default.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 100,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " %",
            symbolPosition: 'right',
        });
        percent_supper.jqxNumberInput({
            width: '100%',
            height: 30,
            min: 0, digits: 12,
            decimalDigits: 0,
            max: 100,
            promptChar: ' ',
            groupSeparator: ' ',
            symbol: " %",
            symbolPosition: 'right',
        });
        self_produced.jqxSwitchButton({
            width: '80px',
            height: 30,
            checked: true,
            theme: 'light',
            onLabel:'Bật',
            offLabel:'Tắt'
        });
        btn_save.jqxButton({
            height: 35,
            width: '100%',
            template: 'success'
        });
    };

    SettingAPP.createData = function () {
        //local
        finance_cat = JSON.parse(localStorage.getItem(tables.finance_cat));
        var downloaded = 0;

        function download_completed() {
            downloaded++;
            if (downloaded >= 1) {
                //setup data
                cb_acc_default.jqxDropDownList({source: finance_cat});
                //Setup value
                cb_acc_default.jqxDropDownList('selectItem', settings.acc_default);
                auto_print.jqxSwitchButton('val', settings.auto_print);
                auto_scanner.jqxSwitchButton('val', settings.auto_scanner);
                self_produced.jqxSwitchButton('val', settings.self_produced);
                auto_check_point.jqxSwitchButton('val', settings.auto_check_point);
                color_main.val(settings.color_main);
                color_text.val(settings.color_text);
                point_to_price.jqxNumberInput('val',settings.point_to_price);
                hit_use_point.jqxNumberInput('val',settings.hit_use_point);
                percent_default.jqxNumberInput('val',settings.percent_default);
                percent_supper.jqxNumberInput('val',settings.percent_supper);
            }
        }

        //data from server
        download_data_where(urls.url_apis.select, {
            table: "settings",
            select: "WHERE name LIKE 'settings' AND branch LIKE '" + me.branch + "'",
            data: "value"
        }, null, function (result) {
            if (result['success']) {
                settings = JSON.parse(result['data'][0]['value']);
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
            download_completed();
        });


    };

    SettingAPP.createEvent = function () {
        //save setting
        btn_save.click(function () {
            //get data
            settings = {
                'auto_print': auto_print.jqxSwitchButton('val'),
                'auto_scanner': auto_scanner.jqxSwitchButton('val'),
                'self_produced': self_produced.jqxSwitchButton('val'),
                'auto_check_point': auto_check_point.jqxSwitchButton('val'),
                'acc_default': cb_acc_default.jqxDropDownList('val'),
                'color_main': color_main.val(),
                'color_text': color_text.val(),
                'point_to_price': point_to_price.jqxNumberInput('val'),
                'hit_use_point': hit_use_point.jqxNumberInput('val'),
                'percent_default': percent_default.jqxNumberInput('val'),
                'percent_supper': percent_supper.jqxNumberInput('val'),
            };
            //Save
            update_data(urls.url_apis.settings, 0, {
                branch: me.branch,
                name: 'settings',
                value: JSON.stringify(settings)
            }, function (result) {
                if (result['success']) {
                    app.notify('Lưu cài đặt thành công!', 'success');
                    app.applySetting();
                } else {
                    app.notify('Lưu cài đặt bị lỗi!', 'error');
                }
            });
        });
    };

    function view_start() {
        SettingAPP.createUI();
        SettingAPP.createData();
        SettingAPP.createEvent();
    }
</script>