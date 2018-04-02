function GuardarAno()
{
	oData          = new Object();	
	oData.ano      = $('#ano').val();
	
	$.ajax({
		type: "POST",
		url: "/anos/save",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				alert('Grabado con éxito.');
				location.href = "/anos";
			}
			else
			{
				alert('Erro ao Grabar.');
				location.href = "/anos";
			}
		}
	});
}

function ActualizarAno()
{
	oData          = new Object();	
	oData.id       = $('#id').val();
	oData.ano      = $('#ano').val();
	
	$.ajax({
		type: "POST",
		url: "/anos/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				alert('Actualizado  con éxito.');
				location.href = "/anos";
			}
			else
			{
				alert('Erro ao Actualizar.');
				location.href = "/anos";
			}
		}
	});
}
