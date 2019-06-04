var App = (function () {
  'use strict';
        //console.log("entro");
  App.dataTables = function( ){

    //We use this to apply style to certain elements
    $.extend( true, $.fn.dataTable.defaults, {
      dom:
        "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row be-datatable-body'<'col-sm-12'tr>>" +
        "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    } );

    $("#tableperfiles").dataTable({
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 2, "desc" ]],
        "bPaginate": false,
    });

    $("#table1").dataTable({
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 2, "desc" ]],
    });

    $("#tablecupones").dataTable({
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 3, "asc" ]],
    });
    $("#tableprecios").dataTable({
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 6, "asc" ]],
    });


    $("#tableclientes").dataTable({
        "lengthMenu": [[1000, 2000, -1], [1000, 2000, "All"]],
    });


    $("#tablereporte").dataTable({
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        "ordering": false,
        "bLengthChange" : false,
        "bPaginate": false  
    });

    //Remove search & paging dropdown
    $("#table2").dataTable({
      pageLength: 6,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    //Enable toolbar button functions
    $("#table3").dataTable({
      buttons: [
        'copy', 'excel', 'pdf', 'print'
      ],
      "lengthMenu": [[6, 10, 25, 50, -1], [6, 10, 25, 50, "All"]],
      dom:  "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6 text-right'B>>" +
            "<'row be-datatable-body'<'col-sm-12'tr>>" +
            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });


    $('.listajax #tfactura').dataTable({
        order : [[ 1, "desc" ]],
        responsive: {
            details: {
                type: 'column',
                target: -1
            }
        },
        columnDefs: [ 
            {
                className: 'control',
                orderable: false,
                targets:   -1
            },
            { orderable: false, targets: -11 }
        ],
    } );


    var oTable=$('.listajax #thorario').dataTable({
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        "columnDefs": [
            { "targets": [ 0 ], "visible": false },
            { "targets": [ 1 ], "visible": false },            
            //{ "orderable": false, "targets": 1 },
         { 
          orderData: [[0, 'asc'], [1, 'desc']]//sort by age then by salary 
         },
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 3 },
            { "orderable": false, "targets": 4 },
            { "orderable": false, "targets": 5 },
            { "orderable": false, "targets": 6 },
            { "orderable": false, "targets": 7 }, 
            { "orderable": false, "targets": 8 },
            { "orderable": false, "targets": 9 }                                         
        ]


    } );

    oTable.fnSort([[0,"asc"], [1,"asc"]]); 



    $('.listajax #rfactura').dataTable({
        order : [[ 3, "desc" ]],
        responsive: {
            details: {
                type: 'column',
                target: -1
            }
        },
        columnDefs: [ 
            {
                className: 'control',
                orderable: false,
                targets:   -1
            },
            { orderable: false, targets: -11 }
        ],


    } );





  };

  return App;
})(App || {});
