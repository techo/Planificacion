//Listado de Sedes
$("#pais").change(function() 
{
	  if($("#pais").val() != 0)
	  {
		  oData    = new Object();	
		  oData.id = $('#pais').val();
		  
		  $.ajax({
				type: "POST",
				url: "/indicadores/SearchSede",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadSede').html(resp);
					$('#loadSede').show();
				}
			});
			
	  }
});

//Validacion Campos
$("#indicador").blur(function()
{
	if($('#indicador').val() == '')
	{
		 $("#indicador").removeClass("erroindicador");
		 $("#indicador").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#indicador" ).focus();
	     $("#indicador").addClass("erroindicador");
	     $(".erroindicador").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#indicador").removeClass("erroindicador");
		$("#indicador").attr("style", "");
		$(".errorC").remove();
	}
});

$("#formato").blur(function()
{
	if($('#formato').val() == '0')
	{
		 $("#formato").removeClass("errostatus");
		 $("#formato").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#formato" ).focus();
	     $("#formato").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#formato").removeClass("errostatus");
		$("#formato").attr("style", "");
		$(".errorC").remove();
	}
});

$("#temporalidad").blur(function()
{
	if($('#temporalidad').val() == '0')
	{
		 $("#temporalidad").removeClass("errostatus");
		 $("#temporalidad").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#temporalidad" ).focus();
	     $("#temporalidad").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#temporalidad").removeClass("errostatus");
		$("#temporalidad").attr("style", "");
		$(".errorC").remove();
	}
});

$("#tipo").blur(function()
{
	if($('#tipo').val() == '0')
	{
		 $("#tipo").removeClass("errostatus");
		 $("#tipo").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#tipo" ).focus();
	     $("#tipo").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#tipo").removeClass("errostatus");
		$("#tipo").attr("style", "");
		$(".errorC").remove();
	}
});

$("#pilar").blur(function()
{
	if($('#pilar').val() == '0')
	{
		 $("#pilar").removeClass("errostatus");
		 $("#pilar").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#pilar" ).focus();
	     $("#pilar").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#pilar").removeClass("errostatus");
		$("#pilar").attr("style", "");
		$(".errorC").remove();
	}
});

$("#area").blur(function()
{
	if($('#area').val() == '0')
	{
		 $("#area").removeClass("errostatus");
		 $("#area").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#area" ).focus();
	     $("#area").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#area").removeClass("errostatus");
		$("#area").attr("style", "");
		$(".errorC").remove();
	}
});

$("#status").blur(function()
{
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
});


function GuardarIndicador()
{
	//Indicador
	if($('#indicador').val() == '')
	{
		 $("#indicador").removeClass("erroindicador");
		 $("#indicador").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#indicador" ).focus();
	     $("#indicador").addClass("erroindicador");
	     $(".erroindicador").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#indicador").removeClass("erroindicador");
		$("#indicador").attr("style", "");
		$(".errorC").remove();
	}
	
	//Formato
	if($('#formato').val() == '0')
	{
		 $("#formato").removeClass("errostatus");
		 $("#formato").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#formato" ).focus();
	     $("#formato").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#formato").removeClass("errostatus");
		$("#formato").attr("style", "");
		$(".errorC").remove();
	}
	
	//Temporalidad
	if($('#temporalidad').val() == '0')
	{
		 $("#temporalidad").removeClass("errostatus");
		 $("#temporalidad").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#temporalidad" ).focus();
	     $("#temporalidad").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#temporalidad").removeClass("errostatus");
		$("#temporalidad").attr("style", "");
		$(".errorC").remove();
	}
	
	//Tipo
	if($('#tipo').val() == '0')
	{
		 $("#tipo").removeClass("errostatus");
		 $("#tipo").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#tipo" ).focus();
	     $("#tipo").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#tipo").removeClass("errostatus");
		$("#tipo").attr("style", "");
		$(".errorC").remove();
	}
	
	//Pilar
	if($('#pilar').val() == '0')
	{
		 $("#pilar").removeClass("errostatus");
		 $("#pilar").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#pilar" ).focus();
	     $("#pilar").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#pilar").removeClass("errostatus");
		$("#pilar").attr("style", "");
		$(".errorC").remove();
	}
	
	//Area
	if($('#area').val() == '0')
	{
		 $("#area").removeClass("errostatus");
		 $("#area").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#area" ).focus();
	     $("#area").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#area").removeClass("errostatus");
		$("#area").attr("style", "");
		$(".errorC").remove();
	}
	
	//Status
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
	oData.indicador    = $('#indicador').val();
	oData.temporalidad = $('#temporalidad').val();
	oData.tipo         = $('#tipo').val();
	oData.pilar        = $('#pilar').val();
	oData.pais         = $('#pais').val();
	oData.area         = $('#area').val();
	oData.sede         = $('#sede').val();
	oData.status       = $('#status').val();
	oData.formato      = $('#formato').val();
	oData.descripcion  = $('#descripcion').val();
	
	//Caso seja para todos os paises, tbm e para todas as sedes
	if($("#pais").val() == 0)
	{
		oData.sede = 0;
	}
	
	$.ajax({
		type: "POST",
		url: "/indicadores/save",
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
				        	location.href = "/indicadores/redirect";
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
				        	location.href = "/indicadores";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarIndicador()
{
	$('#loading-techo').show();
	oData              = new Object();	
	oData.id           = $('#id').val();
	oData.indicador    = $('#indicador').val();
	oData.temporalidad = $('#temporalidad').val();
	oData.tipo         = $('#tipo').val();
	oData.pilar        = $('#pilar').val();
	oData.pais         = $('#pais').val();
	oData.area         = $('#area').val();
	oData.sede         = $('#sede').val();
	oData.status       = $('#status').val();
	oData.formato      = $('#formato').val();
	oData.descripcion  = $('#descripcion').val();
	
	//Caso seja para todos os paises, tbm e para todas as sedes
	if($("#pais").val() == 0)
	{
		oData.sede = 0;
	}
	
	$.ajax({
		type: "POST",
		url: "/indicadores/edit",
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
				        	location.href = "/indicadores/redirect";
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
				        	location.href = "/indicadores";
				        }
				    }
				});
			}
		}
	});
}
