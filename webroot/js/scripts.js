// $.extend( $.fn.dataTableExt.oStdClasses, {
//     "sSortAsc": "header headerSortDown",
//     "sSortDesc": "header headerSortUp",
//     "sSortable": "header"
// } );

// $.extend( $.fn.dataTableExt.oStdClasses, {
//     	"sWrapper": "dataTables_wrapper form-inline"
// 	} );

$(document).ready(function() {
	$('.textarea').wysihtml5();
	$('.datepicker').datepicker({
				format: 'yyyy-mm-dd'
			});
	// $('.dataTable').dataTable({
 //        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
 //        "sPaginationType": "bootstrap"
 //    });
});
// "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
// "sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>"