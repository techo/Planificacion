//Validacion Campos
$("#pilar").blur(function()
{
	if($('#pilar').val() == '')
	{
		 $("#pilar").removeClass("erropilar");
		 $("#pilar").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#pilar" ).focus();
	     $("#pilar").addClass("erropilar");
	     $(".erropilar").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#pilar").removeClass("erropilar");
		$("#pilar").attr("style", "");
		$(".errorC").remove();
	}
});

function GuardarPilar()
{
	if($('#pilar').val() == '')
	{
		 $("#pilar").removeClass("erropilar");
		 $("#pilar").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#pilar" ).focus();
	     $("#pilar").addClass("erropilar");
	     $(".erropilar").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#pilar").removeClass("erropilar");
		$("#pilar").attr("style", "");
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
