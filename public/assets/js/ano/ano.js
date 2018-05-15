//Aceptar solamente numericos
$('#ano').keyup(function() {
  $(this).val(this.value.replace(/\D/g, ''));
});

function GuardarAno()
{
	oData          = new Object();	
	oData.ano      = $('#ano').val();
	oData.status   = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/anos/save",
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
				        	location.href = "/anos";
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
				        	location.href = "/anos";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarAno()
{
	oData          = new Object();	
	oData.id       = $('#id').val();
	oData.ano      = $('#ano').val();
	oData.status   = $('#status').val();
	
	$.ajax({
		type: "POST",
		url: "/anos/edit",
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
				        	location.href = "/anos";
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
				        	location.href = "/anos";
				        }
				    }
				});
			}
		}
	});
}
