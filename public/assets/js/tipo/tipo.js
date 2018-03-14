function GuardarTipo()
{
	oData          = new Object();	
	oData.tipo     = $('#tipo').val();
	
	$.ajax({
		type: "POST",
		url: "/tipos/save",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				alert('Grabado con éxito.');
				location.href = "/tipos";
			}
			else
			{
				alert('Erro ao Grabar.');
				location.href = "/tipos";
			}
		}
	});
}

function ActualizarTipo()
{
	oData          = new Object();	
	oData.id       = $('#id').val();
	oData.tipo     = $('#tipo').val();
	
	$.ajax({
		type: "POST",
		url: "/tipos/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				alert('Actualizado  con éxito.');
				location.href = "/tipos";
			}
			else
			{
				alert('Erro ao Actualizar.');
				location.href = "/tipos";
			}
		}
	});
}
