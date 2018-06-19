//Validacion Campos
$("#tipo").blur(function()
{
	if($('#tipo').val() == '')
	{
		 $("#tipo").removeClass("errotipo");
		 $("#tipo").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#tipo" ).focus();
	     $("#tipo").addClass("errotipo");
	     $(".errotipo").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#tipo").removeClass("errotipo");
		$("#tipo").attr("style", "");
		$(".errorC").remove();
	}
});

function GuardarTipo()
{
	if($('#tipo').val() == '')
	{
		 $("#tipo").removeClass("errotipo");
		 $("#tipo").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#tipo" ).focus();
	     $("#tipo").addClass("errotipo");
	     $(".errotipo").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#tipo").removeClass("errotipo");
		$("#tipo").attr("style", "");
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
	$('#loading-techo').show();
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
				$('#loading-techo').hide();
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
				$('#loading-techo').hide();
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
