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
		
		oData.sede = $('#sede1').val();
		oData.pais = $('#pais1').val();	
		
		console.log(oData);
					
		oFinal[index] = {proyecto: oData.proyecto, responsable: oData.responsable, indicador: oData.indicador, ponderacion: oData.ponderacion, planificacion: oData.planificacion, pais: oData.pais, sede: oData.sede};
	});
	
//	$('#loading-techo').show();
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

function EditarProyecto(indicadores, id)
{
	var oData = new Object();
	oData.id = id;
	
	$.ajax({
		type: "POST",
		url: "/proyecto/edit",
		dataType: "json",
		data: oData,
		success: function(resp)
		{	
			if(resp)
			{
				GuardarProyecto(indicadores);
			}
			else
			{
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