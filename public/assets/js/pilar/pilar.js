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

				$.confirm({
				    content: "Grabado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/pilares";
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
				        	location.href = "/pilares";
				        }
				    }
				});
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
				$.confirm({
				    content: "Grabado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/pilares";
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
				        	location.href = "/pilares";
				        }
				    }
				});
			}
		}
	});
}
