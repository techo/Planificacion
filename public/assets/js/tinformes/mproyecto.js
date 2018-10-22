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
					url: "/tinforme/BuscaValoresProyecto",
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
					   	        responsive: true,
					   	        "scrollX": true,
					   	        order: [2, 'asc'],
					   	       "paging": false
					   	    });
					}
				});
				
		  }
	  }
});

function mostrar(id) {
	var unaTabla, mostrar;
	unaTabla = document.getElementById("DataTables_Table_"+id+"_wrapper");
	if(unaTabla.style.visibility == "hidden") {
		unaTabla.style.visibility = "visible";
		mostrar = document.getElementById("mostrar"+id).childNodes[0];
		mostrar.data = "Ocultar";
	}
	else {
		unaTabla.style.visibility = "hidden";
		mostrar = document.getElementById("mostrar"+id).childNodes[0];
		mostrar.data = "Mostrar";
	}

}
