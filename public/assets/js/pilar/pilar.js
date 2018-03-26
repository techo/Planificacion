function GuardarPilar()
{
	oData          = new Object();	
	oData.pilar    = $('#pilar').val();
	oData.status   = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/pilares/save",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				alert('Grabado con éxito.');
				location.href = "/pilares";
			}
			else
			{
				alert('Erro ao Grabar.');
				location.href = "/pilares";
			}
		}
	});
}

function ActualizarPilar()
{
	oData          = new Object();	
	oData.id       = $('#id').val();
	oData.pilar    = $('#pilar').val();
	oData.status   = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/pilares/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				alert('Actualizado  con éxito.');
				location.href = "/pilares";
			}
			else
			{
				alert('Erro ao Actualizar.');
				location.href = "/pilares";
			}
		}
	});
}
