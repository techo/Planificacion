function GuardarPilar()
{
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
