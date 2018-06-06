
var pais = '';

$("#pais").click(function() 
{
	if($('#c1').prop('checked')) 
	{
		pais = 'true';
	}
	else
	{
		pais = 'false';
	}
});

$("#ano").change(function() 
{
		if(pais == 'true')
		{
			if($("#ano").val() != 0)
			  {
				  $('#loading-techo').show();
				  oData    = new Object();	
				  oData.id = $('#ano').val();
				  
				  $.ajax({
						type: "POST",
						url: "/generador/SearchPais",
						dataType: "html",
						data: oData,
						success: function(resp)
						{	
							$('#Listpaises').html(resp);
							
							 //Paises
				             $('#example').DataTable( {
				            	 "language": {
				                     "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				                 },
				                columnDefs: [ {
				                    className: 'select-checkbox',
				                    targets:   0, 
				                    checkboxes: {selectRow: true}
				                } ],
				                select: {
				                    style:    'multi',
				                    selector: 'td:first-child'
				                },
				                order: [[ 1, 'asc' ]]
				            } );

				             var table = $('#example').DataTable();

				             $('#example tbody').on( 'click', 'tr', function () {
				                 $(this).toggleClass('selected');
				             } );
				             
							$('#Listpaises').show();
						}
					});
				  
				  //Listagem Indicadores
				  $.ajax({
						type: "POST",
						url: "/generador/SearchIndicadores",
						dataType: "html",
						data: oData,
						success: function(resp)
						{	
							$('#Listindicadores').html(resp);
							
							 //Paises
				             $('#example1').DataTable( {
				            	 "language": {
				                     "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				                 },
				                columnDefs: [ {
				                    className: 'select-checkbox',
				                    targets:   0, 
				                    checkboxes: {selectRow: true}
				                } ],
				                select: {
				                    style: 'single'
				                },
				                order: [[ 1, 'asc' ]]
				            } );

				             var table1 = $('#example1').DataTable();

				             $('#example1 tbody').on( 'click', 'tr', function () {
				                 $(this).toggleClass('selected');
				             } );
				             
							$('#Listindicadores').show();
							$('#loading-techo').hide();
						}
					});
				  
			  }
			
			
		}
	});

function GeneraResultado(paises, indicadores)
{
	oData = new Object();	
	console.log(paises);
	
	if( $('#c1').prop('checked') ) {
		oData.pais = 'true';
	}
	
	if( $('#c2').prop('checked') ) {
		oData.sede = 'true';
	}
	
	if(oData.pais == 'true' && oData.sede == 'true')
	{
		$.confirm({
		    content: "Elejir solamente Pais o Sede.",
		    buttons: {
		        ok: function(){
		        	
		        }
		    }
		});
	}
	
}