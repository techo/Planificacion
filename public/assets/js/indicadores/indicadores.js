//Listado de Sedes
$("#pais").change(function() 
{
	  if($("#pais").val() != 0)
	  {
		  oData    = new Object();	
		  oData.id = $('#pais').val();
		  
		  $.ajax({
				type: "POST",
				url: "/indicadores/SearchSede",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadSede').html(resp);
					$('#loadSede').show();
				}
			});
			
	  }
});

function GuardarIndicador()
{
	oData              = new Object();	
	oData.indicador    = $('#indicador').val();
	oData.temporalidad = $('#temporalidad').val();
	oData.tipo         = $('#tipo').val();
	oData.pilar        = $('#pilar').val();
	oData.pais         = $('#pais').val();
	oData.area         = $('#area').val();
	oData.sede         = $('#sede').val();
	oData.status       = $('#status').val();
	
	//Caso seja para todos os paises, tbm e para todas as sedes
	if($("#pais").val() == 0)
	{
		oData.sede = 0;
	}
	
	$.ajax({
		type: "POST",
		url: "/indicadores/save",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$.confirm({
				    content: "Grabado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/indicadores";
				        }
				    }
				});
			}
			else
			{
				$.confirm({
				    content: "Erro ao Grabar.",
				    buttons: {
				        ok: function(){
				        	location.href = "/indicadores";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarIndicador()
{
	oData              = new Object();	
	oData.id           = $('#id').val();
	oData.indicador    = $('#indicador').val();
	oData.temporalidad = $('#temporalidad').val();
	oData.tipo         = $('#tipo').val();
	oData.pilar        = $('#pilar').val();
	oData.pais         = $('#pais').val();
	oData.area         = $('#area').val();
	oData.sede         = $('#sede').val();
	oData.status       = $('#status').val();
	
	//Caso seja para todos os paises, tbm e para todas as sedes
	if($("#pais").val() == 0)
	{
		oData.sede = 0;
	}
	
	$.ajax({
		type: "POST",
		url: "/indicadores/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$.confirm({
				    content: "Grabado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/indicadores";
				        }
				    }
				});
			}
			else
			{
				$.confirm({
				    content: "Erro ao Grabar.",
				    buttons: {
				        ok: function(){
				        	location.href = "/indicadores";
				        }
				    }
				});
			}
		}
	});
}
