$("#ano").change(function() 
{
	  if($("#ano").val() != 0)
	  {
		  $('#dados').hide();
		  $('#loading-techo').show();
		  oData    = new Object();	
		  oData.id = $('#ano').val();
		  
		  $.ajax({
				type: "POST",
				url: "/tinforme/SearchPais",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadPais').html(resp);
					$('#loadPais').show();
					$("#sedes").val("0");
					$("#indicador").val("0");
					$('#loading-techo').hide();
				}
			});
			
	  }
});

$("#loadPais").change(function() 
{
	  if($("#pais").val() != 0)
	  {
		  $('#dados').hide();
		  $('#loading-techo').show();
		  $("#sedes").val("0");
		  $("#indicador").val("0");
		  oData    = new Object();	
		  oData.cplanificacion = $('#ano').val();
		  oData.idPais         = $('#pais').val();
		  
		  if($("#pais").val() != 0)
		  {
			  $('#loading-techo').show();
			  oData    = new Object();	
			  oData.cplanificacion = $('#ano').val();
			  oData.idPais         = $('#pais').val();
			  
			  $.ajax({
					type: "POST",
					url: "/tinforme/BuscaValoresMonitoreo2",
					dataType: "html",
					data: oData,
					success: function(resp)
					{	
						$('#dados').html(resp);
						$('#dados').show();
						$('#loading-techo').hide();
						
						$('.dataTables-example').dataTable({
					   	   	 "language": {
					   	         "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
					   	     },
					   	  scrollY:        "600px",
					        scrollX:        true,
					        scrollCollapse: true,
					        paging:         false,
					        fixedColumns:   {
					            leftColumns: 1
					        },
					   	        dom: '<"html5buttons"B>lTfgitp',
					   	        buttons: [
					   	            { extend: 'copy'},
					   	            ]

					   	    });
					}
				});
				
		  }
	  }
});

