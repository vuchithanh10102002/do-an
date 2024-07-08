<div class="view">
    <div style="height: 100%;">
        <div class="input-product-top">
            <h2>Giao nhận hàng</h2>
            <div class="container-xx step1">
                <input placeholder="Nhập mã hóa đơn" id="invoice" style="padding-left: 10px;text-transform: uppercase;">
                <i id="btn_getinvoice" class="fa fa-arrow-circle-right icon-right-z"></i>
            </div>
            <div class="container-xx step2">
                <i class="fa fa-search icon-left"></i>
                <input id="search" placeholder="Nhập mã vạch sản phẩm"
                       style="text-transform: uppercase;padding-left: 30px;">
                <i class="fa fa-qrcode icon-right-z" onclick="txt_search.focus();"></i>
            </div>
            <div class="container-xx">
                <button id="btn_hoanthanh">
                    <i class="fa fa-check-circle"></i> Hoàn thành (F9)
                </button>
                <button id="btn_mobile">
                    <i class="fa fa-mobile-phone"></i> Kết nối điện thoại
                </button>
            </div>
        </div>
        <div id="table1" style="float: left;"></div>
        <div id="table2" style="float: right;"></div>
    </div>

</div>


<script>
    var DeliveryAPP = {};
    var table1 = $('#table1');
    var table2 = $('#table2');
    var step1 = $('.step1');
    var step2 = $('.step2');
    var txt_search = $('#search');
    var txt_invoice = $('#invoice');
    var btn_getinvoice = $('#btn_getinvoice');
    var btn_hoanthanh = $('#btn_hoanthanh');
    var btn_mobile = $('#btn_mobile');
    var package_list = null;
    var invoice = null;
    var key_public = "";
    var source_connect;

    DeliveryAPP.createUI = function () {

        txt_invoice.jqxInput({width: '200px', height: 33});
        txt_search.jqxInput({width: '230px', height: 33, displayMember: 'code', valueMember: 'code'});
        btn_hoanthanh.jqxButton({height: 33, template: 'success', disabled: true});
        btn_mobile.jqxButton({height: 33, template: 'success'});


        table1.jqxGrid({
            pageSize: 20,
            rowsheight: 33,
            columnsheight: 35,
            altRows: true,
            pageable: false,
            height: 'calc(100% - 60px)',
            width: '49%',
            filterable: false,
            autoshowfiltericon: true,
            sortable: false,
            columnsResize: true,
            enablehover: false,
            selectionmode: 'none',
            columns: [
                {
                    text: 'TT',
                    dataField: 'id',
                    width: '40',
                    align: 'center', cellsalign: 'center'
                },
                {
                    text: 'Mã SP',
                    dataField: 'code',
                    width: '100'
                },
                {
                    text: 'Tên sản phẩm',
                    dataField: 'name'
                },
                {
                    text: 'Số lượng',
                    dataField: 'number',
                    width: '70',
                    align: 'center', cellsalign: 'center'
                },
                {
                    text: 'Đã chọn',
                    dataField: 'sel',
                    width: '70',
                    align: 'center', cellsalign: 'center'
                }
            ]
        });

        table2.jqxGrid({
            rowsheight: 33,
            columnsheight: 35,
            pageSize: 20,
            altRows: true,
            pageable: false,
            height: 'calc(100% - 60px)',
            width: '50%',
            filterable: false,
            autoshowfiltericon: true,
            sortable: false,
            columnsResize: true,
            enablehover: false,
            selectionmode: 'none',
            columns: [
                {
                    text: 'TT',
                    dataField: 'id',
                    width: '40',
                    align: 'center', cellsalign: 'center'
                },
                {
                    text: 'Mã QR',
                    dataField: 'code',
                    width: '120',
                }, {
                    text: 'Mã SP',
                    dataField: 'pcode',
                    width: '100',
                },
                {
                    text: 'Tên sản phẩm',
                    dataField: 'name',
                }
            ]
        });
    };
    DeliveryAPP.createData = function () {

    };
    DeliveryAPP.createEvent = function () {
        //Setup default
        if (localStorage.getItem(tables.cache_data_delivery) != undefined) {
            var mahoadon = localStorage.getItem(tables.cache_data_delivery);
            localStorage.removeItem(tables.cache_data_delivery);
            txt_invoice.jqxInput('val', mahoadon);
            setTimeout(function () {
                btn_getinvoice.click();
            }, 1000)
        }


        $('#invoice').keyup(function (e) {
            if (e.keyCode == 13) {
                btn_getinvoice.click();
            }
        });

        //get invoice
        btn_getinvoice.click(function () {
            btn_getinvoice.removeClass('fa-arrow-circle-right');
            btn_getinvoice.addClass('fa-spinner');
            btn_getinvoice.addClass('fa-spin');
            app.loadding('open');
            download_data_where(urls.url_apis.select, {
                table: "invoices",
                select: "WHERE code LIKE '" + txt_invoice.jqxInput('val') + "'",
                data: "products,customer,id"
            }, null, function (result) {
                if (result['success']) {
                    if (result['data'][0] != null) {
                        //data
                        var data = JSON.parse(result['data'][0]['products']);
                        invoice = result['data'][0];
                        var list_sp = "AND products.pcode IN (";
                        for (var i = 0; i < data.length; i++) {
                            table1.jqxGrid('addrow', null, {
                                id: i,
                                code: data[i]['code'],
                                name: data[i]['name'],
                                number: data[i]['number'],
                                sel: '0'
                            });
                            if (i == data.length - 1) {
                                list_sp += "'" + data[i]['code'] + "')";
                            } else {
                                list_sp += "'" + data[i]['code'] + "',";
                            }
                        }
                        //
                        download_data_where(urls.url_apis.select, {
                            table: "products,products_list",
                            select: "WHERE products.branch LIKE '"+me.branch+"' AND products.pcode=products_list.code AND products.state LIKE '0' " + list_sp+" GROUP BY products.id",
                            data: "products.id,products.pcode,products_list.name"
                        }, null, function (result) {
                            if (result['success']) {
                                //gui
                                step1.hide();
                                step2.show();
                                btn_hoanthanh.jqxButton({disabled: false});
                                app.notify("Hãy sử dụng máy quét mã vạch để thêm sản phẩm vào hóa đơn!", 'success');
                                txt_search.focus();
                                package_list = result['data'];
                                for (var i = 0; i < package_list.length; i++) {
                                    package_list[i]['code'] = 'BAS/' + package_list[i]['pcode'] + "/" + package_list[i]['id'];
                                }
                                txt_search.jqxInput({source: package_list});
                            } else {
                                app.notify("Sản phẩm không thể tải xuống!", 'warning');
                            }
                            app.loadding('close');
                        });
                    } else {
                        app.notify("Mã hóa đơn không tồn tại!", 'warning');
                        app.loadding('close');
                    }
                } else {
                    app.notify("Lỗi kết nối tới máy chủ!", 'error');
                    app.loadding('close');
                }
                btn_getinvoice.addClass('fa-arrow-circle-right');
                btn_getinvoice.removeClass('fa-spinner');
                btn_getinvoice.removeClass('fa-spin');
            })
        });
        //add to table
        $('#search').keyup(function (e) {
            if (e.keyCode == 13) {
                var value = txt_search.jqxInput('val')['value'].toUpperCase();
                DeliveryAPP.selectProduct(value);
            }
        });
        //btn save
        btn_hoanthanh.click(function () {
            //đổi trạng thái hóa đơn
            update_data_raw(urls.url_apis.update_product_invoice, {
                'id_invoice': invoice['id'],
                list_products: JSON.stringify(table2.jqxGrid('getrows'))
            }, function (result) {
                if (result['success']) {
                    app.notify("Quá trình bàn giao hàng cho khách thành công!", 'success');
                } else {
                    app.notify("Lưu máy chủ lỗi!", 'error');
                }
            })
        });
        //Conect mobile
        btn_mobile.click(function () {
            swal({
                title: 'Thông báo',
                text: "Chức năng được sử dụng trên smartphone!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ngắt kết nối',
                cancelButtonText: 'Hủy bỏ',
            }).then(function () {

            }).catch(swal.noop);
        });
    };


    DeliveryAPP.selectProduct = function (value) {
        var data = app.getDataByCode(value, package_list);
        var data_x = table2.jqxGrid('getrows');
        if (data_x != null) {
            if (app.getDataByCode(value, data_x) != null) {
                app.notify("Sản phẩm đã tồn tại!", 'warning');
                txt_search.jqxInput('val', '');
                txt_search.jqxInput('focus');
                return;
            }
        }
        if (data != null) {
            var products_x = table1.jqxGrid('getrows');
            for (var i = 0; i < products_x.length; i++) {
                if (products_x[i]['code'] == data['pcode']) {
                    if (parseInt(products_x[i]['number']) > parseInt(products_x[i]['sel'])) {
                        table2.jqxGrid('addrow', null, {
                            id: table2.jqxGrid('getrows').length,
                            code: data['code'],
                            pcode: data['pcode'],
                            name: data['name']
                        });
                        table1.jqxGrid('updaterow', products_x[i]['uid'], {
                            id: products_x[i]['id'],
                            code: products_x[i]['code'],
                            name: products_x[i]['name'],
                            number: products_x[i]['number'],
                            sel: parseInt(products_x[i]['sel']) + 1
                        });
                        beep();
                    } else {
                        app.notify("Sản phẩm đã đủ số lượng!", 'warning');
                    }
                }
            }
        }
        txt_search.jqxInput('val', '');
        txt_search.jqxInput('focus');
    };

    function view_start() {
        key_public = "/" + Date.now() + me['username'];
        DeliveryAPP.createUI();
        DeliveryAPP.createData();
        DeliveryAPP.createEvent();
        txt_invoice.jqxInput('focus');
        step2.hide();
    }
</script>