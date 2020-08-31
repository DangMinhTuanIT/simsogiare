
const language = {
    searchPlaceholder: 'Nhập từ khóa',
    processing: 'Đang xử lý...',
    loadingRecords: 'Đang tải...',
    emptyTable: 'Không có dữ liệu hiển thị',
    lengthMenu: 'Hiển thị: _MENU_ dòng mỗi trang',
    zeroRecords: 'Không tìm thấy dữ liệu',
    info: 'Hiển thị từ _START_ đến _END_ trong tổng _TOTAL_ dòng',
    infoEmpty: 'Hiển thị từ 0 đến 0 trong tổng 0 dòng',
    infoFiltered: '(lọc từ tổng số _MAX_ dòng)',
    search: 'Tìm kiếm:',
    paginate: {
        previous: '<i class="fa fa-angle-double-left"></i>',
        next: '<i class="fa fa-angle-double-right"></i>'
    }
};
const initDatatable = function (select, tableOptions) {
    const table = $(`#${select}`).DataTable(tableOptions);
    $(table.table().header()).addClass('text-center');
    //reload click handle
    $(`.${select}`).click(function (event) {
        // $(event.target).addClass('fa-spin');
        // $(`.${select}-container`).addClass('is-loading').block({
        //     overlayCSS: {
        //         backgroundColor: '#ccc',
        //         opacity: 0.8,
        //         zIndex: 1,
        //         cursor: 'wait'
        //     },
        //     message: null
        // });
        $(`#${select}`).DataTable().ajax.reload(() => {
            $(`#${select}`).removeClass("is-loading");
            $(`#${select} .dataTables_empty`).text("").addClass("empty-state");
        });
    })
    return table;
};
$(document).ready(function () {

    initDatatable(
        'pageSpeed', {
            ajax: {
                url: `https://thietkeweb5s.net/api/Example/pagespeed`,
                dataSrc: function (res) {
                    // trId: ele.blockType
                    // console.log(res.data)
                    var columns = [];
                    var stt = 1;
                    $.each(res.data, function (k, v) {
                        var output = {};
                        domainWithIcon = '<div><img class="mr-2" src="'+v.favicon+'">'+v.name+'</div>';
                        output.rootUrl = domainWithIcon;
                        output.pc_score = v.pc_score;
                        output.mobile_score = v.mobile_score;
                         output.total_size = v.total_size;
                        output.created_at = v.created_at;
                        output.url = v.url;
                        output.stt = stt;
                        stt += 1;
                        columns.push(output);

                    })
                    return columns;
                },
            },
            columns: [{
                    title: "STT",
                    "data": "stt"
                },
                {
                    title: "Time", 
                    "data": data => {
                        return moment(data.created_at,"YYYY-MM-DD h:mm:ss").format('H:mm DD/MM/YYYY');
                    }
                },
                {
                    title: "Website",
                    "data": data => {
                        return `<div style="white-space: nowrap">${data.rootUrl}</div>`
                    }
                },
                {
                    title: "url",
                    "data": data => {
                        return `
                            <a target="_blank" href="kham-benh-website?domain=${data.url}">${data.url}</a>
                        `
                    }
                },
                {
                    title: "Mobile  Score",
                    "data": data => {
                        return `
                        <div class="average display-6 font-gg" style="width: 150px;">
                            <div class="d-flex w-100 m-auto no-block">
                                <div class="font-13 text-muted font-gg pb-1">
                                    Mobi 
                                </div>
                                <div class="ml-auto font-13 text-muted font-gg">
                                ${data.mobile_score}%
                                </div>
                            </div>
                            <div class="progress w-100 m-auto" >
                                <div class="progress-bar bg-info" style="height: 8px; width: ${data.mobile_score}%;" role="progressbar" aria-valuenow="${data.mobile_score}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> 
                        </div>
                        `
                    }
                },
                {
                    title: "PC  Score",
                    "data": data => {
                        return `
                        <div class="average display-6 font-gg" style="width: 150px;">
                            <div class="d-flex w-100 m-auto no-block">
                                <div class="font-13 text-muted font-gg pb-1">
                                    Pc
                                </div>
                                <div class="ml-auto font-13 text-muted font-gg">
                                ${data.pc_score}%
                                </div>
                            </div>
                            <div class="progress w-100 m-auto" >
                                <div class="progress-bar bg-success" style="height: 8px; width: ${data.pc_score}%;" role="progressbar" aria-valuenow="${data.pc_score}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> 
                        </div>
                        `
                    }
                },
                {
                    title: "Total Size",
                    "data": data => {
                        return `
                            ${data.total_size}
                        `
                    }
                },
            ],
            "ordering": true,
            language,
            info: false,
            autoWidth: false,
            rowId: 'trId',
            // searching: false,
            "scrollX": true,
            // scrollY: '350px', 
            // scrollCollapse: true,
            // paging: false,
            // responsive: true,
            processing: true,
            pageLength: 30,
            "lengthChange": false,
            initComplete: function (settings, json) {
                $(`#pageSpeed`).attr('style', 'margin-top:0!important')
                    .find('thead').addClass('bg-primary-2')
                    .find('th').each(function (i) {
                        $(this).addClass('text-dark text-left font-gg border-0 font-11')
                    });
                $('table.dataTable thead').attr('style', 'text-align: left!important; text-transform: uppercase;')
                $('table.dataTable thead .sorting_asc').attr('style', 'padding: 0 10px !important;white-space: nowrap;')
                // $('table.dataTable thead .sorting').attr('style', '')
                $('.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody>table>tbody>tr>td').attr('style', 'padding: 10px 18px')
            }
        }
    )
})