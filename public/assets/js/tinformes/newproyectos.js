
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

//Metodo pais novo
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
				  
				  $.ajax({
						type: "POST",
						url: "/tinforme/SearchSede",
						dataType: "html",
						data: oData,
						success: function(resp)
						{	
							$('#loadSede').html(resp);
							$('#loadSede').show();
							$('#loading-techo').hide();
						}
					});
					
			  }
		});

$("#loadSede").change(function() 
{
	  if($("#sede").val() != 0)
	  {
		  $('#dados').hide();
		  $('#loading-techo').show();
		  $("#indicador").val("0");
		  oData    = new Object();	
		  oData.cplanificacion = $('#ano').val();
		  oData.idPais         = $('#pais').val();
		  oData.idSede         = $('#sedes').val();
		  
		  if($("#sede").val() != 0)
		  {
			  $('#loading-techo').show();
			  oData    = new Object();	
			  oData.cplanificacion = $('#ano').val();
			  oData.idPais         = $('#pais').val();
			  oData.idSede         = $('#sedes').val();
			  
			  $.ajax({
					type: "POST",
					url: "/tinforme/CarregaProyectos",
					dataType: "html",
					data: oData,
					success: function(resp)
					{	
						$('#proyectos').html(resp);
						$('#proyectos').show();
						$('#loading-techo').hide();
					}
				});
				
		  }
	  }
});

$("#proyectos").change(function() 
		{
			  if($("#pro").val() != 0)
			  {
				  $('#dados').hide();
				  $('#loading-techo').show();
				  $("#indicador").val("0");
				  oData    = new Object();	
				  oData.cplanificacion = $('#ano').val();
				  oData.idPais         = $('#pais').val();
				  oData.idSede         = $('#sedes').val();
				  oData.idproyecto     = $('#pro').val();
				  
				  if($("#sede").val() != 0)
				  {
					  $('#loading-techo').show();
					  oData    = new Object();	
					  oData.cplanificacion = $('#ano').val();
					  oData.idPais         = $('#pais').val();
					  oData.idSede         = $('#sedes').val();
					  oData.idproyecto     = $('#pro').val();
					  
					  $.ajax({
							type: "POST",
							url: "/tinforme/NewValoresProyecto",
							dataType: "html",
							data: oData,
							success: function(resp)
							{	
								$('#dados').html(resp);
								$('#dados').show();
								$('#loading-techo').hide();
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
