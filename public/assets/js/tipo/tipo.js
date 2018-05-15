function GuardarTipo()
{
	oData          = new Object();	
	oData.tipo     = $('#tipo').val();
	oData.status   = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/tipos/save",
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
				        	location.href = "/tipos";
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
				        	location.href = "/tipos";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarTipo()
{
	oData          = new Object();	
	oData.id       = $('#id').val();
	oData.tipo     = $('#tipo').val();
	oData.status   = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/tipos/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$.confirm({
				    content: "Erro ao Grabar.",
				    buttons: {
				        ok: function(){
				        	location.href = "/tipos";
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
				        	location.href = "/tipos";
				        }
				    }
				});
			}
		}
	});
}
