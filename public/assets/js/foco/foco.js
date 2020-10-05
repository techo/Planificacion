//Listado de Sedes
$("#pais").change(function() 
{
	$('#loading-techo').show();
	  if($("#pais").val() != 0)
	  {
		  oData    = new Object();	
		  oData.id = $('#pais').val();
		  
		  $.ajax({
				type: "POST",
				url: "/foco/SearchSede",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadSede').html(resp);
					$('#loadSede').show();
					$('#loading-techo').hide();
				}
			});
			
	  }
	  else
	  {
		  $('#loadSede').hide();
	  }	  
});

function GuardarFoco(indicadores)
{
	//$("#guardar-foco").attr("disabled", true);
	//$('#loading-techo').show();
	var markupStr   = $('#pasos').summernote('code');
	var markupStr1  = $('#obs').summernote('code');
	oData          = new Object();	
	oData.nombre   = $('#nombre').val();
	oData.descripcion = $('#descripcion').val();
	oData.id_ano  = $('#ano').val();
	oData.id_pais = $('#pais').val();
	oData.id_sede = $('#sede').val();
	oData.obs     = markupStr1;
	oData.pasos   = markupStr;
	
	//Criar um Array com os Indicadores a serem gravados
	$(indicadores).each(function(index) 
	{
		/*Indicadores*/
		oData.indicadores += indicadores[index][1] + ',';
		oData.indicadores = oData.indicadores.replace('undefined','');
		
		/*Ponderacion*/
		var valor = 0;
    	valor = SetaPonderacion(this[1])
    	
    	if(valor == '')
    	{
    		valor = '0.00';
    	}	
    	oData.ponderacion += valor + ',';
    	oData.ponderacion = oData.ponderacion.replace('undefined','');
		
	});
	
	$.ajax({
		type: "POST",
		url: "/foco/save",
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
				        	location.href = "/foco";
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
				        	location.href = "/foco";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarFoco(indicadores)
{
	$("#actualizar-foco").attr("disabled", true);
	$('#loading-techo').show();
	var markupStr  = $('#pasos').summernote('code');
	var markupStr1  = $('#obs').summernote('code');
	oData          = new Object();	
	oData.nombre   = $('#nombre').val();
	oData.descripcion = $('#descripcion').val();
	oData.id_ano  = $('#ano').val();
	oData.id_pais = $('#pais').val();
	oData.id_sede = $('#sede').val();
	oData.obs     = markupStr1;
	oData.id      = $('#idfoco').val();
	oData.pasos   = markupStr;
	
	//Criar um Array com os Indicadores a serem gravados
	$(indicadores).each(function(index) 
	{
		oData.indicadores += indicadores[index][2] + ',';
		oData.indicadores  = oData.indicadores.replace('undefined','');
		
		/*Ponderacion*/
		var valor = 0;
    	valor = SetaPonderacion(this[2])
    	console.log(valor);
    	
    	if(valor == '')
    	{
    		valor = '0.00';
    	}	
    	oData.ponderacion += valor + ',';
    	oData.ponderacion = oData.ponderacion.replace('undefined','');
		
	});
	
	$.ajax({
		type: "POST",
		url: "/foco/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				$.confirm({
				    content: "Actualizado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/foco";
				        }
				    }
				});
			}
			else
			{
				$('#loading-techo').hide();
				$.confirm({
				    content: "Erro ao Actualizar.",
				    buttons: {
				        ok: function(){
				        	location.href = "/foco";
				        }
				    }
				});
			}
		}
	});
}

function SetaPonderacion(id)
{		
	 var dados      = [""];
	 dados['valor'] = $('#'+id).val();
	 
	 return dados['valor'];
}