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
				alert('Grabado con éxito.');
				location.href = "/temporalidades";
			}
			else
			{
				alert('Erro ao Grabar.');
				location.href = "/temporalidades";
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
				alert('Actualizado  con éxito.');
				location.href = "/temporalidades";
			}
			else
			{
				alert('Erro ao Actualizar.');
				location.href = "/temporalidades";
			}
		}
	});
}
