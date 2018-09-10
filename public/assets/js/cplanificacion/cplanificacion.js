//Validacion Campos
$("#ano").blur(function()
{
	if($('#ano').val() == '0')
	{
		 $("#ano").removeClass("errostatus");
		 $("#ano").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#ano" ).focus();
	     $("#ano").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#ano").removeClass("errostatus");
		$("#ano").attr("style", "");
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

function GuardarPlanificacion(indicadores, sedes)
{
	//Ano
	if($('#ano').val() == '0')
	{
		 $("#ano").removeClass("errostatus");
		 $("#ano").attr("style", "");
		 $(".errorC").remove();
		 var msg = 'Campo Obligatorio.';
		 $( "#ano" ).focus();
	     $("#ano").addClass("errostatus");
	     $(".errostatus").css("border", "1px solid red").after('<p class="errorC" style="color:red;">' + msg + '</p>');
	     return false;
	}
	else
	{
		$("#ano").removeClass("errostatus");
		$("#ano").attr("style", "");
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
	oData.ano          = $('#ano').val();
	oData.status       = $('#status').val();
	
	//Criar um Array com as Sedes a serem gravados
	$(sedes).each(function(index) 
	{
		oData.sedes += sedes[index][1] + ',';
		
		oData.sedes = oData.sedes.replace('undefined','');
		
	});
	
	//Criar um Array com os Indicadores a serem gravados
	$(indicadores).each(function(index) 
	{
		oData.indicadores += indicadores[index][1] + ',';
		
		oData.indicadores = oData.indicadores.replace('undefined','');
		
	});
	
	//Prazos
	oData.eneroplan      = $('#enero-plan').val();
	oData.eneroreal      = $('#enero-real').val();
	oData.febreroplan    = $('#febrero-plan').val();
	oData.febreroreal    = $('#febrero-real').val();
	oData.marzoplan      = $('#marzo-plan').val();
	oData.marzoreal      = $('#marzo-real').val();
	oData.abrilplan      = $('#abril-plan').val();
	oData.abrilreal      = $('#abril-real').val();
	oData.mayoplan       = $('#mayo-plan').val();
	oData.mayoreal       = $('#mayo-real').val();
	oData.junioplan      = $('#junio-plan').val();
	oData.junioreal      = $('#junio-real').val();
	oData.julioplan      = $('#julio-plan').val();
	oData.julioreal      = $('#julio-real').val();
	oData.agostoplan     = $('#agosto-plan').val();
	oData.agostoreal     = $('#agosto-real').val();
	oData.septiembreplan = $('#septiembre-plan').val();
	oData.septiembrereal = $('#septiembre-real').val();
	oData.octubreplan    = $('#octubre-plan').val();
	oData.octubrereal    = $('#octubre-real').val();
	oData.noviembreplan  = $('#noviembre-plan').val();
	oData.noviembrereal  = $('#noviembre-real').val();
	oData.deciembreplan  = $('#deciembre-plan').val();
	oData.deciembrereal  = $('#deciembre-real').val();
	
	$.ajax({
		type: "POST",
		url: "/cplanificacion/save",
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
				        	location.href = "/cplanificacion";
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
				        	location.href = "/cplanificacion";
				        }
				    }
				});
			}
		}
	});
}

function ActualizarPlanificacion(indicadores, sedes)
{
	$('#loading-techo').show();
	
	oData          = new Object();	
	oData.id       = $('#id').val();
	oData.ano      = $('#ano').val();
	oData.status   = $('#status').val();
	
	//Criar um Array com as Sedes a serem gravados
	$(sedes).each(function(index) 
	{
		oData.sedes += sedes[index][1] + ',';
		
		oData.sedes = oData.sedes.replace('undefined','');
		
	});
	
	//Criar um Array com os Indicadores a serem gravados
	$(indicadores).each(function(index) 
	{
		oData.indicadores += indicadores[index][1] + ',';
		
		oData.indicadores = oData.indicadores.replace('undefined','');
		
	});
	
	//Prazos
	oData.eneroplan      = $('#enero-plan').val();
	oData.eneroreal      = $('#enero-real').val();
	oData.febreroplan    = $('#febrero-plan').val();
	oData.febreroreal    = $('#febrero-real').val();
	oData.marzoplan      = $('#marzo-plan').val();
	oData.marzoreal      = $('#marzo-real').val();
	oData.abrilplan      = $('#abril-plan').val();
	oData.abrilreal      = $('#abril-real').val();
	oData.mayoplan       = $('#mayo-plan').val();
	oData.mayoreal       = $('#mayo-real').val();
	oData.junioplan      = $('#junio-plan').val();
	oData.junioreal      = $('#junio-real').val();
	oData.julioplan      = $('#julio-plan').val();
	oData.julioreal      = $('#julio-real').val();
	oData.agostoplan     = $('#agosto-plan').val();
	oData.agostoreal     = $('#agosto-real').val();
	oData.septiembreplan = $('#septiembre-plan').val();
	oData.septiembrereal = $('#septiembre-real').val();
	oData.octubreplan    = $('#octubre-plan').val();
	oData.octubrereal    = $('#octubre-real').val();
	oData.noviembreplan  = $('#noviembre-plan').val();
	oData.noviembrereal  = $('#noviembre-real').val();
	oData.deciembreplan  = $('#deciembre-plan').val();
	oData.deciembrereal  = $('#deciembre-real').val();
	
	$.ajax({
		type: "POST",
		url: "/cplanificacion/edit",
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
				        	location.href = "/cplanificacion";
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
				        	location.href = "/cplanificacion";
				        }
				    }
				});
			}
		}
	});
}


function Desmarcar()
{
	$(".form-control option[value="+ 100 +"]").attr("selected",true);
	
	var table = $('#example-sede');
	table.find('tbody').each(function(indice){
	    $(this).find('tr').each(function(indice){
	    	$(this).removeClass();
	    });
	});
}

function DesmarcarKpis()
{
	$(".form-control option[value="+ 100 +"]").attr("selected",true);
	
	var table = $('#example');
	table.find('tbody').each(function(indice){
	    $(this).find('tr').each(function(indice){
	    	$(this).removeClass();
	    });
	});
}