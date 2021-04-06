$(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search":"سرچ:"
                },
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "اطلاعاتی یافت نشد",
                    "info": "نمایش صفحه _PAGE_ از _PAGES_",
                    "infoEmpty": "اطلاعاتی یافت نشد",
                    "infoFiltered": "(فیلتر شده از _MAX_ مجموع رکوردها)",
                    "paginate": {
                        "first":      "اولین",
                        "last":       "آخرین",
                        "next":       "بعد",
                        "previous":   "قبل"
                    },
                    "search":"جستجو: "
        },
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ]
    });
