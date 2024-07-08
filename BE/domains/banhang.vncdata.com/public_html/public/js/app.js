/**
 * Created by Hoang Dai on 23/06/2017.
 */
//Ajax data
function download_data(url, callback) {
    var access_token = localStorage.getItem('access_token');
    if (access_token != null) {
        $.ajax({
            method: 'GET',
            url: url,
            data: {
                access_token: access_token
            },
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                callback(e);
            },
            progress: function (e) {
                if (e.lengthComputable) {
                    NProgress.set(e.loaded / e.total);
                }
            }
        });
    } else {

    }
}

function download_data_where(url, data, sent, callback) {
    var access_token = localStorage.getItem('access_token');
    data['access_token'] = access_token;
    if (access_token != null) {
        $.ajax({
            method: 'GET',
            url: url,
            data: data,
            data_sent: sent,
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    result['sent'] = this.data_sent;
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                e['data'] = "Not connect!";
                callback(e);
            },
            progress: function (e) {
                if (e.lengthComputable) {
                    NProgress.set(e.loaded / e.total);
                }
            }
        });
    } else {

    }
}

function get_view(url, viewname, callback) {
    var access_token = localStorage.getItem('access_token');
    if (access_token != null) {
        $.ajax({
            method: 'GET',
            url: url,
            data: {
                access_token: access_token,
                viewname: viewname
            },
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                callback(e);
            }
        });
    } else {

    }
}

function add_data(url, data, callback) {
    var access_token = localStorage.getItem('access_token');
    if (access_token != null) {
        data['access_token'] = access_token;
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            data_sent: data,
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    result['sent'] = this.data_sent;
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                e['data'] = "Not connect!";
                callback(e);
            },
            progress: function (e) {
                if (e.lengthComputable) {
                    NProgress.set(e.loaded / e.total);
                }
            }
        });
    }
}

function delete_data(url, id, callback, index) {
    var access_token = localStorage.getItem('access_token');
    if (access_token != null) {
        $.ajax({
            url: (url + '/' + id),
            method: 'DELETE',
            data: {
                access_token: access_token
            },
            data_sent: {
                id: id,
                index: index
            },
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    result['sent'] = this.data_sent;
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                e['data'] = "Not connect!";
                callback(e);
            },
            progress: function (e) {
                if (e.lengthComputable) {
                    NProgress.set(e.loaded / e.total);
                }
            }
        });
    }
}

function update_data(url, id, data, callback) {
    var access_token = localStorage.getItem('access_token');
    if (access_token != null) {
        data['access_token'] = access_token;
        $.ajax({
            url: (url + '/' + id),
            method: 'PUT',
            data: data,
            data_sent: data,
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                e['data'] = "Not connect!";
                callback(e);
            },
            progress: function (e) {
                if (e.lengthComputable) {
                    NProgress.set(e.loaded / e.total);
                }
            }
        });
    }
}

function update_data_raw(url, data, callback) {
    var access_token = localStorage.getItem('access_token');
    if (access_token != null) {
        data['access_token'] = access_token;
        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            data_sent: data,
            dataType: 'json',
            success: function (result) {
                if (typeof callback == 'function') {
                    callback(result);
                }
            },
            error: function (e) {
                e['success'] = false;
                e['data'] = "Not connect!";
                callback(e);
            },
            progress: function (e) {
                if (e.lengthComputable) {
                    NProgress.set(e.loaded / e.total);
                }
            }
        });
    }
}

var GUI = {};

GUI.inputPrice = function (selecter) {
    return selecter.jqxNumberInput({
        width: '100%',
        spinButtons: false,
        digits: 9,
        decimalDigits: 0,
        max: 999999999,
        min: 0,
        promptChar: ' ',
        groupSeparator: ' ',
        symbol: " đ",
        symbolPosition: 'right'
    });
};
GUI.windows = function (selecter, cancel) {
    return selecter.jqxWindow({
        position: {x: "40%", y: '10%'},
        width: 500,
        resizable: false, isModal: true, modalOpacity: 0.3,
        cancelButton: cancel,
        autoOpen: false
    });
};
GUI.windows = function (selecter, cancel, width) {
    return selecter.jqxWindow({
        position: {x: "40%", y: '10%'},
        width: width,
        resizable: false, isModal: true, modalOpacity: 0.3,
        cancelButton: cancel,
        autoOpen: false
    });
};


GUI.disable = function (selecter) {
    selecter.prop("disabled", true);
};
GUI.able = function (selecter) {
    selecter.prop("disabled", false);
};


function print_data(data, title) {
    var window_p=$('<div></div>');
    var window_title=$('<div><i class="fa fa-print"></i> In '+title+'</div>');
    var window_container=$('<div></div>');
    var window_body=$('<div class="body-print"></div>');
    var window_print=$('<div></div>');
    var window_footer=$('<div style="margin-top: 15px;"></div>');
    var btn_print=$('<button style="width: 170px; margin-right: 5px;"> <i class="fa fa-print"></i> In ngay</button>');
    var btn_close=$('<button style="width: 165px;"> <i class="fa fa-ban"></i> Đóng</button>');
    window_footer.append(btn_print);
    window_footer.append(btn_close);
    window_container.append(window_body);
    window_body.append(window_print);
    window_container.append(window_footer);
    window_p.append(window_title);
    window_p.append(window_container);
    window_p.jqxWindow({
        position: {x: 0, y: 0},
        width: 720,
        resizable: false, isModal: true, modalOpacity: 0.3,
        autoOpen: true,
        closeButtonAction:'close',
        cancelButton:btn_close
    });
    btn_print.jqxButton({
        height:35,
        template:'success'
    });
    btn_close.jqxButton({
        height:35,
        template:'danger'
    });
    window_print.addClass('container-print');
    window_print.html(data);
    btn_print.click(function () {
        window_print.print();
        window_p.jqxWindow('close');
    });
    btn_print.click();
    window_p.on('close', function (event) {
        window_p.remove();
    });

    // var newWindow = window.open('', '', 'width=800, height=500'),
    //     document = newWindow.document.open(),
    //     pageContent =
    //         '<!DOCTYPE html>' +
    //         '<html>' +
    //         '<head>' +
    //         '<meta charset="utf-8" />' +
    //         '<title>' + title + '</title>' +
    //         '<style media="print">' +
    //         'p,span{font-size:10px!important;margin:0!important;line-height:12px}td,th{font-size:11px;padding:2px 3px}.table-product td,.table-product th,.table-product{border:1px solid}' +
    //         '        @page {' +
    //         '            size: auto;' +
    //         '            margin: 0;' +
    //         '            -webkit-print-color-adjust: exact;' +
    //         '        }' +
    //         '    </style>'+
    //         '</head>' +
    //         '<body>' + data + '</body></html>';
    // document.write(pageContent);
    // document.close();
    // setTimeout(function () {
    //     newWindow.print();
    //     //newWindow.close();
    // }, 500);
}

function beep() {
    var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");
    snd.play();
}

//Thêm số 0
function pad0(str, max) {
    str = str.toString();
    return str.length < max ? pad0("0" + str, max) : str;
}

function dataBarcodeProduct(code, name, price, container) {
    setTimeout(function () {
        var container_item = $('<div style="background-color: white;font-family: Arial; color: #000000;text-align: center; width: 34mm;height: 20mm;padding:1mm;display: inline-block;"></div>');
        var p_item = $('<p style="font-size: 3mm;font-weight: bold; margin: 0;font-family: Arial; color: #000000;height: 3mm;">Giá: ' + parseInt(price).toLocaleString() + ' VNĐ</p>');
        var n_item = $('<p style="margin: 0;font-family: Arial; color: #000000;font-size: 3mm;height: 7mm;">' + name + '</p>');
        var c_item = $('<p style="margin: 0;font-size: 3mm;font-family: Arial; color: #000000;width: 100%;height: 3mm;">' + code + '</p>');
        var barcode = $("<div class='barcode-x' style='width: 100%;height: 6mm;'></div>");
        container_item.append(n_item);
        container_item.append(barcode);
        container_item.append(c_item);
        container_item.append(p_item);
        container.append(container_item);
        //barcode.barcode(code, "code128", {output: 'bmp', });
        barcode.kendoBarcode({
            value: code,
            type: "code128",
            width: 128,
            height: 50
        });
    }, 500);
    //return container;
}

function dataqrProduct(id, code, name) {
    var container = $('<div style="width: 360px;position: relative;"></div>');
    var background = $('<img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEBLAEsAAD/4RDcRXhpZgAATU0AKgAAAAgABAE7AAIAAAAGAAAISodpAAQAAAABAAAIUJydAAEAAAAMAAAQyOocAAcAAAgMAAAAPgAAAAAc6gAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGFkbWluAAAFkAMAAgAAABQAABCekAQAAgAAABQAABCykpEAAgAAAAMzMQAAkpIAAgAAAAMzMQAA6hwABwAACAwAAAiSAAAAABzqAAAACAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA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MS4xLyI+PGRjOmNyZWF0b3I+PHJkZjpTZXEgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj48cmRmOmxpPmFkbWluPC9yZGY6bGk+PC9yZGY6U2VxPg0KCQkJPC9kYzpjcmVhdG9yPjwvcmRmOkRlc2NyaXB0aW9uPjwvcmRmOlJERj48L3g6eG1wbWV0YT4NCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgPD94cGFja2V0IGVuZD0ndyc/Pv/bAEMAAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAf/bAEMBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAf/AABEIAIkBaAMBIgACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS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" width="360" height="137">');
    var container_QR = $('<div style="position: absolute;top: 6px;left: 6px;width: 125px;height:125px;"></div>');
    container_QR.qrcode(
        {
            render: 'image',
            minVersion: 6,
            maxVersion: 40,
            ecLevel: 'H',
            left: 0,
            top: 0,
            size: 125,
            fill: '#000',
            background: null,
            text: 'BAS/' + code + '/' + id,
            radius: 0,
            quiet: 3,
            mode: 2,
            mSize: 0.09,
            mPosX: 0.5,
            mPosY: 0.5,
            label: 'BinhAnSi',
            fontname: 'segoe ui',
            fontcolor: '#ffc955',
            image: null
        }
    );
    var name_product = $('<div style="font-family: Arial, Arial, Helvetica, Verdana, Sans Serif,serif;font-weight: bold;font-size: 20px;display:block;color: #000000;line-height: 1.1;position: absolute;top: 15px;/* right: 6px; */width: 222px;left: 130px;">' + name + '</div>');
    var branch_product = $('<div style="font-family: Arial, Arial, Helvetica, Verdana, Sans Serif,serif;font-size: 16px;display:block;color: #000000;line-height: 1.1;position: absolute;top: 68px;left: 130px;">Công ty TNHH BinhANSI</div>');
    var id_product = $('    <div style="font-family: Arial, Arial, Helvetica, Verdana, Sans Serif,serif;font-size: 40px;display:block;color: #000000;line-height: 1;position: absolute;bottom: 13px;left: 130px;">' + pad0(id, 8) + '</div>');
    container.append(background);
    container.append(container_QR);
    container.append(name_product);
    container.append(branch_product);
    container.append(id_product);
    return container;
}