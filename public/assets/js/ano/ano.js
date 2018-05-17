//Aceptar solamente numericos
$('#ano').keyup(function() {
  $(this).val(this.value.replace(/\D/g, ''));
});

function GuardarAno()
{
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
