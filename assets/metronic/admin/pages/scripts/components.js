var $ = $ || {},
    Components;
Components =  (function () {
    "use strict";
    var handleWysihtml5,
        handleDatePickers,
        handleTable;

    /**
     * Function to init the wysiwyg
     *
     * @returns {jQuery|HTMLElement|*}
     */
    handleWysihtml5 = function () {
        var $wysihtml5 = $('.wysihtml5');
        if (!jQuery().wysihtml5) {
            return;
        }

        if ($wysihtml5.size() > 0) {
            $wysihtml5.wysihtml5({
                "stylesheets": ["../../assets/metronic/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
        return $wysihtml5;
    };

    /**
     * Function to init datepicker (must be named with the class "date-picker")
     */
    handleDatePickers = function () {
        var $datePicker = $('.date-picker');
        if ($.datepicker) {
            $datePicker.datepicker({
                rtl: false,
                orientation: "left",
                autoclose: true
            });
        }

    };

    /**
     * Handle table Doc https://www.datatables.net/
     *
     * ObjectDOM table (Table object)
     * JSON      columns (json columns)
     * String    url (to post)
     * Function  createdRow (Function to process the rows)
     * Boolean   searching (true|false for show searching form)
     * Boolean   paging (true|false for using pagination)
     * Function  drawCallback (Function callback after draw)
     */
    handleTable = function () {
        var table        = arguments[0] || {},
            columns      = arguments[1] || {},
            urlAjax      = arguments[2] || '',
            createdRow   = arguments[3] || function () {
                },
            searching    = arguments[4] || false,
            paging       = arguments[5] || false,
            drawCallback = arguments[6] || function () {
                },
            info         = arguments[7] || false,
            filter       = arguments[8] || 0;

        // begin first table
        var tablePagination = table.dataTable({
            /*AJAX*/
            "processing": urlAjax !== '' ? true : false,
            "serverSide": urlAjax !== '' ? true : false,
            "ajax": info ? {
                "url": urlAjax,
                "data": function ( d ) {
                    d.filter = filter;
                }
            } : urlAjax !== '' ? urlAjax : '',
            /*END AJAX*/
            "createdRow": createdRow,
            "drawCallback" : drawCallback,
            "destroy": true,
            "searching": searching,
            "paging": paging,

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                processing: "Procesando...",
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": info ? "Mostrando _START_ al _END_ de _TOTAL_ entradas" : "",
                "infoEmpty": "No se encontraron entradas",
                "infoFiltered": "(filtered1 de _MAX_ entradas totales)",
                "search": "",
                "zeroRecords": "No se encontraron registros coincidentes",
                "lengthMenu": "_MENU_",
                "paginate": {
                    "previous": "Previo",
                    "next": "Siguiente",
                    "last": "Ultimo",
                    "first": "Primero"
                },
                searchPlaceholder: "Buscar... "
            },
            "dom": info ? "<<'col-md-3 col-sm-12 bordered'f><'#filter-customers.col-md-3 col-sm-12 bordered'><'col-md-3 col-sm-12 bordered'><'col-md-3 col-sm-12 bordered'l>r>t<'row'<'col-md-4 col-sm-12'i><'col-md-4 col-sm-12'p>>"
            : "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

            "columns": columns,
            "lengthMenu": [
                [5, 15, 20, -1],
                [
                    "Mostrar de 5 en 5",
                    "Mostrar de 15 en 15",
                    "Mostrar de 20 en 20",
                    "Todos"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "pagingType": "bootstrap_full_number",
            "order": [
                /*[1, "asc"]*/
            ] // set first column as a default sort by asc
        });

        /*var tableWrapper = jQuery('#' + table.attr('id') + '_wrapper');
        tableWrapper.find('.dataTables_length select').removeClass("input-xsmall");*/

        return tablePagination;
    };


    return {
        //main function to initiate the module
        /*wysihtml5: function () {
            return handleWysihtml5();
        },
        datePickers: function () {
            handleDatePickers();
        },*/
        table: function (objTable, columns, url, rowFunction, searching, paging, drawCallback, info, filter) {
            return handleTable(objTable, columns, url, rowFunction, searching, paging, drawCallback, info, filter);
        }
    };
}());
