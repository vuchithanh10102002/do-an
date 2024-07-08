<div class="view">
    <div class="clearfix">
        <div class="box">
            <div class="box-icon">
                <i class="fa fa-product-hunt"></i>
            </div>
            <div class="box-content">
                <p class="box-title"><?php echo app('translator')->get('lang.All products'); ?></p>
                <p id="count_product" class="box-value">0</p>
            </div>
        </div>
        <div class="box">
            <div class="box-icon">
                <i class="fa fa-shopping-basket"></i>
            </div>
            <div class="box-content">
                <p class="box-title"><?php echo app('translator')->get('lang.Sales today'); ?></p>
                <p id='price_pay_today' class="box-value">0</p>
            </div>
        </div>
        <div class="box">
            <div class="box-icon">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="box-content">
                <p class="box-title"><?php echo app('translator')->get('lang.Money imported today'); ?></p>
                <p id='price_import_today' class="box-value">0</p>
            </div>
        </div>
        <div class="box">
            <div class="box-icon">
                <i class="fa fa-cloud-upload"></i>
            </div>
            <div class="box-content">
                <p class="box-title"><?php echo app('translator')->get('lang.Interest today'); ?></p>
                <p id="price_Interest_today" class="box-value">0</p>
            </div>
        </div>
        <div class="box">
            <div class="box-icon">
                <i class="fa fa-undo"></i>
            </div>
            <div class="box-content">
                <p class="box-title"><?php echo app('translator')->get('lang.Payment today'); ?></p>
                <p id="price_return_today" class="box-value">0</p>
            </div>
        </div>
    </div>
    <div>
        <div class="widget widget-7">
            <div class="widget-title">
                <h5>Thông tin bán hàng trong 30 ngày qua</h5>
            </div>
            <canvas id="myChart" width="100" height="42"></canvas>
        </div>

        <div class="widget widget-3">
            <div class="widget-title">
                <h5>Top sản phẩm bán chạy nhất</h5>
            </div>
            <div id='topProduct'></div>
        </div>
    </div>
</div>

<script>
    var homeApp = {};
    var table_source = null;
    var max_load=0;

    homeApp.loadChart = function (datax) {
        Chart.defaults.global.legend.display = false;
        var ctx = document.getElementById("myChart");
        var data = {
            labels: [],
            datasets: []
        };
        for (var i = 0; i < datax.length; i++) {
            //data.labels.push(datax[i]['day']);
            data.datasets[i] =
                {
                    label: 'Ngày ' + datax[i]['day'],
                    data: [datax[i]['sum_number']],
                    backgroundColor: [
                        'rgba(92, 184, 92, 0.99)',
                    ],
                };
        }
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        });
    };

    homeApp.createData = function () {
        download_data_where(urls.url_apis.select, {
            table: "product_logs LEFT JOIN products_list ON products_list.code=product_logs.product_list",
            select: "WHERE 1 GROUP BY product_logs.product_list ORDER BY sum_number DESC LIMIT 10",
            data: " COUNT(product_logs.number) as sum_number,product_logs.product_list AS 'code',products_list.name, products_list.price_main"
        }, null, function (result) {
            if (result['success']) {
                table_source = result['data'];
                homeApp.topProducts();
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE 1",
            data: "COUNT(id) AS num"
        }, null, function (result) {
            if (result['success']) {
                $('#count_product').text(parseInt(result['data'][0]['num']).toLocaleString());
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "products_list",
            select: "WHERE 1",
            data: "COUNT(id) AS num"
        }, null, function (result) {
            if (result['success']) {
                $('#count_product').text(parseInt(result['data'][0]['num']).toLocaleString());
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs",
            select: "WHERE DATE_FORMAT(STR_TO_DATE(create_at, '%d/%m/%Y'),'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') AND `type`='INVOICE'",
            data: "SUM(price) AS price"
        }, null, function (result) {
            if (result['success']) {
                if (result['data'][0]['price'] == null) {
                    result['data'][0]['price'] = 0;
                }
                $('#price_pay_today').text(parseInt(result['data'][0]['price']).toLocaleString());
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs",
            select: "WHERE DATE_FORMAT(STR_TO_DATE(create_at, '%d/%m/%Y'),'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') AND `type`='INVOICE'",
            data: " SUM(price)-SUM(`price_import`) AS 'price'"
        }, null, function (result) {
            if (result['success']) {
                if (result['data'][0]['price'] == null) {
                    result['data'][0]['price'] = 0;
                }
                $('#price_Interest_today').text(parseInt(result['data'][0]['price']).toLocaleString());
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs",
            select: "WHERE DATE_FORMAT(STR_TO_DATE(create_at, '%d/%m/%Y'),'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') AND `type`='IMPORT'",
            data: "SUM(price) AS price"
        }, null, function (result) {
            if (result['success']) {
                if (result['data'][0]['price'] == null) {
                    result['data'][0]['price'] = 0;
                }
                $('#price_import_today').text(parseInt(result['data'][0]['price']).toLocaleString());
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs",
            select: "WHERE DATE_FORMAT(STR_TO_DATE(create_at, '%d/%m/%Y'),'%d/%m/%Y')=DATE_FORMAT(NOW(),'%d/%m/%Y') AND `number`>=0",
            data: "SUM(price) AS price"
        }, null, function (result) {
            if (result['success']) {
                if (result['data'][0]['price'] == null) {
                    result['data'][0]['price'] = 0;
                }
                $('#price_return_today').text(parseInt(result['data'][0]['price']).toLocaleString());
            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
        download_data_where(urls.url_apis.select, {
            table: "product_logs",
            select: "WHERE 1 GROUP BY create_at",
            data: "SUM(ABS(number)) AS 'sum_number', DATE_FORMAT(STR_TO_DATE(create_at, '%d/%m/%Y'),'%d') AS 'day'"
        }, null, function (result) {
            if (result['success']) {
                var data_chart = [];
                var data_result = result['data'];
                for (var i = 0; i < 32; i++) {
                    data_chart[i] = {
                        day: i,
                        sum_number: 0
                    }
                }
                for (i = 0; i < data_result.length; i++) {
                    data_chart[parseInt(data_result[i]['day'])] = {
                        day: parseInt(data_result[i]['day']),
                        sum_number: parseInt(data_result[i]['sum_number'])
                    }
                }
                homeApp.loadChart(data_chart);

            } else {
                app.notify('Tải dữ liệu bị lỗi!', 'error');
            }
        });
    };
    homeApp.topProducts = function () {
        var html = "";
        var container_top = $('#topProduct');
        function loadproduct_data(index, max) {
            download_data_where(urls.url_apis.upload_image, {
                'code': table_source[index]['code']
            }, null, function (result) {
                var container = $('<div title="" class="container-top"></div>');
                var img = $('<img class="img-top" src="">');
                var price = $('<div class="price-top"></div>');
                var title = $('<div class="title-top"></div>');
                var sum_number = $('<div class="sum_number-top"></div>');
                container.append(img);
                container.append(title);
                container.append(price);
                price.text('Giá bán: '+parseInt(table_source[index]['price_main']).toLocaleString());
                title.text(table_source[index]['name']);
                sum_number.text(table_source[index]['sum_number']);
                if (result['success']) {
                    img.attr('src', result['data']['encoded']);
                } else {
                    img.attr('src', default_image);
                }
                container_top.append(container);
                //check load next?
                if (index < max) {
                    loadproduct_data(index + 1, max);
                }
            });
        }

        loadproduct_data(0, max_load);
    };

    homeApp.UI= function () {
        var max_width=$(document).width()-70;
        var max_height=$(document).height()-360;
        $('.widget-7').width(max_width-$('.widget-3').width());
        $('.widget-7').height(max_height);
        $('.widget-3').height(max_height);
        max_load=parseInt(max_height/70);
        var height=parseInt(max_height/$('.widget-7').width()*100)-2;
        console.log(height);
        $('#myChart').attr('height',height);
    };

    function view_start() {
        homeApp.UI();
        homeApp.createData();
    }

</script>