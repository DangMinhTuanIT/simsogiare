var dataCenter = {};
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
dataCenter.tableConfigs = {
    processing  : true,
    serverSide  : true,
    responsive  : true,
    lengthMenu  : [ 30, 50, 75, 100 ],
    language: {
        paginate: {
            "previous": "<",
            "last": ">>",
            "first":"<<",
            "next":">"
        },
        search: "",
        searchPlaceholder: "Nhận thông tin tìm kiếm",
        info: "Hiển thị _START_ &rarr; _END_ trong _TOTAL_ kết quả",
        infoEmpty: "Không tìm thấy kết quả nào",
        emptyTable: "Chưa có dữ liệu",
        loadingRecords: "Đang tải dữ liệu...",
        lengthMenu: "Hiển thị _MENU_ kết quả",
        infoFiltered: " từ _MAX_ kết quả",
        zeroRecords: "Không tìm thấy",
        processing: "Đang tải dữ liệu..."
    },
    searching: false,
    ordering: false,
    fixedHeader: {
        header: true
    },
    columnDefs:[
        {
            width: '20px',
            targets: [0],
            searchable:  false,
            orderable:   false,
            className: 'item-checkbox dt-body-center',
            render: function (data, type, row){
                return '<input type="checkbox" class="_item_checked" name="_item_checked[]" value="'+ row['id'] +'">';
            }
        },
        {
            // puts a button in the last column
            targets: [-1],
            searchable: false,
            orderable: false,
            className: "cell-center",
            render: function (data, type, row) {
                return '<button type="button" class="btn bg-teal waves-effect info" value="'+ row['id'] +'"><i class="material-icons">mode_edit</i></button>'
                    + '<button type="button" class="btn bg-red waves-effect remove" value="'+ row['id'] +'"><i class="material-icons">delete_forever</i></button>';
            }
        }
    ]
};
dataCenter.hasResponse = 0;
dataCenter.columns = '';
dataCenter.searchRoute = '';
dataCenter.dataWrap = '';
dataCenter.cRow = '';

dataCenter.request = function (cb, that) {
    dataCenter.hasResponse = 0;
    var html = '';
    if(that) {
        var icon = that.find('i');
        if (icon.length) {
            html = '<i class="material-icons">' + that.find('i').text() + '</i>';
        }else{
            html = that.text();
        }
        var _html = '<div class="preloader pl-size-xs"><div class="spinner-layer pl-white"> <div class="circle-clipper left"> <div class="circle"></div> </div> <div class="circle-clipper right"> <div class="circle"></div> </div> </div> </div>';
        that.html(_html);
    }
    if(typeof cb === 'function'){
        cb(html);
    }
    setTimeout(function () {
        if(!dataCenter.hasResponse) {
            if(that) {
                that.html(html);
            }
            sweetAlert.close();
            showNotification('bg-black', 'Có lỗi xảy ra!!! Vui lòng thử lại.', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
        }
    }, 8000);
};
dataCenter.info = function(that, params, cb){
    var row = $("#" + params.parent + params.id);
    var name = row.find('.item_name').text();
    dataCenter.request(function (html) {
        $.ajax({
            type: "GET",
            url: params.url + '/' + params.id
        }).done(function(results) {
            dataCenter.hasResponse = 1;
            that.html(html);
            if(!results['err']){
                if(typeof cb === 'function'){
                    if(results['cates']){
                        results['data']['cates'] = results['cates'];
                    }
                    cb(results['data']);
                }
                $('#mdModal').modal('show');
            }else{
                sweetAlert.close();
                showNotification('bg-black', 'Không thể lấy thông tin của <b>'+name+'</b>. Vui lòng thử lại.', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            }
        });
    }, that);
};
dataCenter.update = function (that, params, box) {
    dataCenter.request(function (html) {
        $.ajax({
            type: "PUT",
            url: params.url + '/' + params.id,
            data: params.data,
            dataType: 'json'
        }).done(function (results) {
            dataCenter.hasResponse = 1;
            that.html(html);
            if (!results['err']) {
                if(dataCenter.cRow && results['data']) {
                    var id = box ? box : '#dataList' ;
                    $(id).DataTable()
                        .row(dataCenter.cRow)
                        .data(results['data'])
                        .draw();
                }
                $('[id*=mdModal]').modal('hide');
                if(!results['message'])
                    showNotification('bg-green', 'Cập nhật thành công', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                else
                    showNotification('bg-green', results['message'], 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            } else {
                var mgs = 'Cập nhật không thành công. Vui lòng thử lại.';
                if(results['message']){
                    mgs = results['message'];
                }
                showNotification('bg-black', mgs , 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            }
        });
    }, that);
};
dataCenter.remove = function(params, list){
    swal({
        title: "Bạn thật sự muốn xóa ?",
        text: "",
        type: "error",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        cancelButtonText: 'Hủy bỏ',
        confirmButtonText: 'Đồng ý',
        confirmButtonColor: '#009688'
    }, function () {
        list = list ? list : '#dataList';
        dataCenter.request(function () {
            $.ajax({
                type: "DELETE",
                url: params.url + '/' + params.id
            }).done(function (results) {
                dataCenter.hasResponse = 1;
                sweetAlert.close();
                var row = $("#" + params.parent + params.id);
                var name = row.find('.item_name').text();
                if (!results['err']) {
                    showNotification('bg-green', 'Xóa thành công <b>' + name + '</b>', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                    $(list).DataTable()
                        .row(row)
                        .remove()
                        .draw();
                } else {
                    showNotification('bg-black', 'Không thể xóa <b>' + name + '</b>. Vui lòng thử lại.', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                }
            });
        });
    });
};

dataCenter.post = function (that, params, success_mes, fail_mes) {
    dataCenter.request(function (html) {
        $.ajax({
            type: "POST",
            url: params.url,
            data: params.data,
            dataType: 'json'
        }).done(function (results) {
            dataCenter.hasResponse = 1;
            that.html(html);
            if (!results['err']) {
                that.closest('.modal').modal('hide');
				success_mes = results['message'] ? results['message'] : success_mes;
                showNotification('bg-green', success_mes, 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            } else {
				fail_mes = results['message'] ? results['message'] : fail_mes;
                showNotification('bg-black', fail_mes, 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            }
        });
    }, that);
};

dataCenter.paging = function (params) {
    if(params) {
        dataCenter.tableConfigs['ajax'] = params['route'];
        dataCenter.tableConfigs['columns'] = params['columns'];
        $('#dataList').DataTable(dataCenter.tableConfigs);
    }
};
dataCenter.getData = function (params, cb, method) {
    $('.wrap_loader').show();
    setTimeout(function () {
        $('.wrap_loader').hide();
    }, 8000);
    dataCenter.request(function(){
        method = method ? method : 'GET';
        $.ajax({
            type: method,
            url: params.url,
            data: params.data
        }).done(function(results) {
            $('.wrap_loader').hide();
            dataCenter.hasResponse = 1;
            if(!results['err']){
                if(typeof cb === 'function'){
                    cb(results['data']);
                }
            }else{
                sweetAlert.close();
                showNotification('bg-black', 'Không thể lấy thông tin. Vui lòng thử lại.', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            }
        });
    });
}

dataCenter.customRequest = function(that, params, cb, method, open){
    method = method ? method : 'POST';
    dataCenter.request(function (html) {
        $.ajax({
            type: method,
            url: params.url,
            data: params.data,
            dataType: 'json'
        }).done(function (results) {
            dataCenter.hasResponse = 1;
            that.html(html);
            if (!results['err']) {
                if(!open) {
                    that.closest('.modal').modal('hide');
                }
                showNotification('bg-green', results['message'], 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                if(typeof cb === 'function'){
                    cb(results);
                }
            } else {
                showNotification('bg-black', results['message'], 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            }
        });
    }, that);
}

$(document).ready(function () {
    var search = $('.search-bar input');
    if(search.length){
        search.on('keypress', function (event) {
            if (event.which == 13) {
                makeSearch(search);
            }
        });
    }
    var module_search_input = $('.module_search  input');
    if(module_search_input.length){
        module_search_input.on('keypress', function (event) {
            if (event.which == 13) {
                makeSearch(module_search_input);
            }
        });
        $('.module_search_btn').click(function () {
            makeSearch(module_search_input);
        });
    }
    function makeSearch(input){
        var listData = $('#dataList');
        if(listData.length && dataCenter.searchRoute && dataCenter.columns){
            dataCenter.tableConfigs['ajax'] = dataCenter.searchRoute + '?q=' + encodeURI(input.val());
            dataCenter.tableConfigs['columns'] = dataCenter.columns;
            if ( $.fn.DataTable.isDataTable('#dataList') ) {
                $('#dataList').DataTable().destroy(true);
            }
            $('.data-wrap').html(dataCenter.dataWrap);
            $('#dataList').DataTable(dataCenter.tableConfigs);
            $('.data-wrap select').selectpicker();
        }
    }
    if($('.filters').length){
        $('.filter_results').on('click', function(){
            var q = [];
            $('[name*=filters]').each(function(){
                var val = $(this).val();
                if(val) {
                    q.push($(this).data('name') + '=' + val);
                }
            });
            window.location.href =  dataCenter.filterRoute + '?' + encodeURI(q.join('&'));
        });
        $('.filter_remove').on('click', function(){
            $('[name*=filters]').val('');
            window.location.href =  dataCenter.filterRoute;
        });
    }
    if($('.remove_all').length){
        var tableId = $(this).closest('table').attr('id');
        tableId = tableId ? '#' + tableId : '';
        $(tableId + ' .remove_all').on('click', function () {
            swal({
                title: "Bạn thật sự muốn xóa ?",
                text: "",
                type: "error",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                cancelButtonText: 'Hủy bỏ',
                confirmButtonText: 'Đồng ý',
                confirmButtonColor: '#009688'
            }, function () {
                dataCenter.request(function () {
                    $.ajax({
                        type: "DELETE",
                        url: dataCenter.truncateRoute
                    }).done(function (results) {
                        dataCenter.hasResponse = 1;
                        sweetAlert.close();
                        if (!results['err']) {
                            showNotification('bg-green', 'Xóa thành công <b>' + name + '</b>', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                            $('#dataList').DataTable()
                                .clear()
                                .draw();
                        } else {
                            showNotification('bg-black', 'Không thể xóa <b>' + name + '</b>. Vui lòng thử lại.', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                        }
                    });
                });
            });
        });
    }
    if($('.remove_selected').length){
        $('.remove_selected').on('click', function () {
            var itemIDs = [];
            var tableId = $(this).closest('table').attr('id');
            tableId = tableId ? '#' + tableId : '';
            $(tableId + ' ._item_checked:checked').each(function () {
                itemIDs.push($(this).val());
            });
            swal({
                title: "Bạn thật sự muốn xóa ?",
                text: "",
                type: "error",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                cancelButtonText: 'Hủy bỏ',
                confirmButtonText: 'Đồng ý',
                confirmButtonColor: '#009688'
            }, function () {
                dataCenter.request(function () {
                    $.ajax({
                        type: "DELETE",
                        url: dataCenter.truncateRoute,
                        data: {'data' : itemIDs}
                    }).done(function (results) {
                        dataCenter.hasResponse = 1;
                        sweetAlert.close();
                        if (!results['err']) {
                            showNotification('bg-green', 'Xóa thành công <b>' + name + '</b>', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                            $('#dataList').DataTable()
                                .clear()
                                .draw();
                        } else {
                            showNotification('bg-black', 'Không thể xóa <b>' + name + '</b>. Vui lòng thử lại.', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
                        }
                    });
                });
            });
        });
    }
    if($('[name=all_items]').length){
        // Handle click on "Select all" control
        $('[id*=_check_all]').on('click', function(){
            // Get all rows with search applied
            var tableId = $(this).closest('table').attr('id');
            var rows = $('#' + tableId).DataTable().rows({ 'search': 'applied' }).nodes();
            // Check/uncheck checkboxes for all rows in the table
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
            if(this.checked){
                $('#' + tableId + ' tbody tr').addClass('row-selected');
            }else{
                $('#' + tableId + ' tbody tr').removeClass('row-selected');
            }
        });

        // Handle click on checkbox to set state of "Select all" control
        $('[id*=_check_all] tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            var tableId = $(this).closest('table').attr('id');
            if(!this.checked){
                var el = $('#' + tableId + ' #_check_all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if(el && el.checked && ('indeterminate' in el)){
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

        $('[id*=List]').on('change', '._item_checked', function () {
            if($(this).prop( "checked" )){
                $(this).closest('tr').addClass('row-selected');
            }else{
                $(this).closest('tr').removeClass('row-selected');
            }
        });
    }
});