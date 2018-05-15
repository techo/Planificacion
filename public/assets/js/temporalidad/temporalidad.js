function GuardarTemporalidad()
{
	oData              = new Object();	
	oData.temporalidad = $('#temporalidad').val();
	oData.status       = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/temporalidades/save",
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
				        	location.href = "/temporalidades";
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
				        	location.href = "/temporalidades";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarTemporalidad()
{
	oData              = new Object();	
	oData.id           = $('#id').val();
	oData.temporalidad = $('#temporalidad').val();
	oData.status       = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/temporalidades/edit",
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
				        	location.href = "/temporalidades";
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
				        	location.href = "/temporalidades";
				        }
				    }
				});
			}
		}
	});
}
