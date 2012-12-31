// $.extend( $.fn.dataTableExt.oStdClasses, {
//     "sSortAsc": "header headerSortDown",
//     "sSortDesc": "header headerSortUp",
//     "sSortable": "header"
// } );

// $.extend( $.fn.dataTableExt.oStdClasses, {
//     	"sWrapper": "dataTables_wrapper form-inline"
// 	} );

$(document).ready(function() {
	$('.textarea').wysihtml5({
		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": false, //Button which allows you to edit the generated HTML. Default false
		"link": true, //Button to insert a link. Default true
		"image": true, //Button to insert an image. Default true,
		"color": false //Button to change color of font
	});
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