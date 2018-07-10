function GuardarProyecto(indicadores)
{
	var MyArray = [""];
	var oFinal = new Object();
	
	//Criar um Array com os Indicadores e ponderacao a serem gravados
	$(indicadores).each(function(index, indicador) 
	{
		var oData = new Object();
		oData.proyecto    = $('#nombre').val();
		oData.responsable = $('#responsable').val();
		
		oData.indicador     =  indicador[1];
		oData.ponderacion   =  indicador[6];
		oData.planificacion =  indicador[7];
		
		oFinal[index] = {proyecto: oData.proyecto, responsable: oData.responsable, indicador: oData.indicador, ponderacion: oData.ponderacion, planificacion: oData.planificacion};
	});
	
	$('#loading-techo').show();
	$.ajax({
		type: "POST",
		url: "/proyecto/save",
		dataType: "json",
		data: oFinal,
		success: function(resp)
		{	
			if(resp)
			{
				$('#loading-techo').hide();
				$.confirm({
				    content: "Grabado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/planificacion";
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
				        	location.href = "/planificacion";
				        }
				    }
				});
			}
		}
	});
}