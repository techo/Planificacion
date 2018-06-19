//Validacion Campos
$("#temporalidad").blur(function()
{
	if($('#temporalidad').val() == '')
	{
		 $("#temporalidad").removeClass("errotemp");
		 $("#temporalidad").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#temporalidad" ).focus();
	     $("#temporalidad").addClass("errotemp");
	     $(".errotemp").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#temporalidad").removeClass("errotemp");
		$("#temporalidad").attr("style", "");
		$(".errorC").remove();
	}
});

function GuardarTemporalidad()
{
	if($('#temporalidad').val() == '')
	{
		 $("#temporalidad").removeClass("errotemp");
		 $("#temporalidad").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#temporalidad" ).focus();
	     $("#temporalidad").addClass("errotemp");
	     $(".errotemp").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#temporalidad").removeClass("errotemp");
		$("#temporalidad").attr("style", "");
		$(".errorC").remove();
	}
	
	if($('#status').val() == '0')
	{
		 $("#status").removeClass("errostatus");
		 $("#status").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#status" ).focus();
	     $("#status").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#status").removeClass("errostatus");
		$("#status").attr("style", "");
		$(".errorC").remove();
	}
	
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
