//Aceptar solamente numericos
$('#ano').keyup(function() {
  $(this).val(this.value.replace(/\D/g, ''));
});

//Validacion Campos
$("#ano").blur(function()
{
	if($('#ano').val() == '')
	{
		 $("#ano").removeClass("erroano");
		 $("#ano").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#ano" ).focus();
	     $("#ano").addClass("erroano");
	     $(".erroano").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#ano").removeClass("erroano");
		$("#ano").attr("style", "");
		$(".errorC").remove();
	}
});

function GuardarAno()
{
	//Validacion Campos
	if($('#ano').val() == '')
	{
		 $("#ano").removeClass("erroano");
		 $("#ano").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#ano" ).focus();
	     $("#ano").addClass("erroano");
	     $(".erroano").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#ano").removeClass("erroano");
		$("#ano").attr("style", "");
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
