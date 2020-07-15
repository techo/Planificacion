$('#ponderaciones').hide();
$('#p1').mask('##0,00', {reverse: true});
$('#p2').mask('##0,00', {reverse: true});
$('#p3').mask('##0,00', {reverse: true});
$('#p4').mask('##0,00', {reverse: true});
$('#p5').mask('##0,00', {reverse: true});

//Se la ponderacion 1 hay valor exibe los inputs con valores

if($('#retornop1').val() != 0.00)
{
	 $('#ponderaciones').show();
	 $("#tipo option[value=ponderacion]").attr("selected",true);
	 
	 //Calcula el total en tiempo de ejecucion
	 var p1 = $('#p1').val();
	 var p2 = $('#p2').val();
	 var p3 = $('#p3').val();
	 var p4 = $('#p4').val();
	 var p5 = $('#p5').val();
	 
	 // trasnforma de string em valor float
	 var p1 = +(p1.replace(/,/,'.'));
	 var p2 = +(p2.replace(/,/,'.'));
	 var p3 = +(p3.replace(/,/,'.'));
	 var p4 = +(p4.replace(/,/,'.'));
	 var p5 = +(p5.replace(/,/,'.'));
	 
	 var total = p1 + p2 + p3 + p4 + p5;
	 
	 $('#total').val(total);
	// $('#total').mask('##0,00', {reverse: true});
}	

//Exibe as Ponderacoes
$("#tipo").change(function() {
	 if($('#tipo').val() == 'ponderacion')
	 {
		 $('#ponderaciones').show();
	 }	 
	 else
     {
		 $('#ponderaciones').hide();
     }		  
});

//faz calculos
$( "#p1" ).keyup(function() {
	var num = parseFloat($('#p1').val().replace(',', '.'));
	
	if(isNaN(num))
	{
		num = 0.00;
		$('#p1').val(0.00)
	}	
	
	var parcial = num + parseFloat($('#p2').val().replace(',', '.')) + parseFloat($('#p3').val().replace(',', '.')) + parseFloat($('#p4').val().replace(',', '.')) + parseFloat($('#p5').val().replace(',', '.'));
	
	if(parcial > 100)
	{
		$.confirm({
		    content: "Porcentaje no puede ser maior que 100.",
		    buttons: {
		        ok: function(){
		        }
		    }
		});
		
		parcial =  parcial - num;
		
		$('#p1').val(0.00)
	}	
	
	$('#total').val(parcial);
});

$( "#p2" ).keyup(function() {
	var num = parseFloat($('#p2').val().replace(',', '.'));
	
	if(isNaN(num))
	{
		num = 0.00;
		$('#p2').val(0.00)
	}	
	
	var parcial = parseFloat($('#p1').val().replace(',', '.')) + num + parseFloat($('#p3').val().replace(',', '.')) + parseFloat($('#p4').val().replace(',', '.')) + parseFloat($('#p5').val().replace(',', '.'));
	
	if(parcial > 100)
	{
		$.confirm({
		    content: "Porcentaje no puede ser maior que 100.",
		    buttons: {
		        ok: function(){
		        }
		    }
		});
		parcial =  parcial - num;
		
		$('#p2').val(0.00);
	}	
	
	$('#total').val(parcial);
});

$( "#p3" ).keyup(function() {
	var num = parseFloat($('#p3').val().replace(',', '.'));
	
	if(isNaN(num))
	{
		num = 0.00;
		$('#p3').val(0.00)
	}	
	
	var parcial = parseFloat($('#p1').val().replace(',', '.')) + parseFloat($('#p2').val().replace(',', '.')) + num + parseFloat($('#p4').val().replace(',', '.')) + parseFloat($('#p5').val().replace(',', '.'));
	
	if(parcial > 100)
	{
		$.confirm({
		    content: "Porcentaje no puede ser maior que 100.",
		    buttons: {
		        ok: function(){
		        }
		    }
		});
		
		parcial =  parcial - num;
		
		$('#p3').val(0.00)
	}	
	
	$('#total').val(parcial);
});

$( "#p4" ).keyup(function() {
	var num = parseFloat($('#p4').val().replace(',', '.'));
	
	if(isNaN(num))
	{
		num = 0.00;
		$('#p4').val(0.00)
	}	
	
	var parcial = parseFloat($('#p1').val().replace(',', '.')) + parseFloat($('#p2').val().replace(',', '.')) + parseFloat($('#p3').val().replace(',', '.')) + num + parseFloat($('#p5').val().replace(',', '.'));
	
	if(parcial > 100)
	{
		$.confirm({
		    content: "Porcentaje no puede ser maior que 100.",
		    buttons: {
		        ok: function(){
		        }
		    }
		});
		
		parcial =  parcial - num;
		
		$('#p4').val(0.00)
	}	
	
	
	$('#total').val(parcial);
});

$( "#p5" ).keyup(function() {
	var num = parseFloat($('#p5').val().replace(',', '.'));
	
	if(isNaN(num))
	{
		num = 0.00;
		$('#p5').val(0.00)
	}	
	
	var parcial = parseFloat($('#p1').val().replace(',', '.')) + parseFloat($('#p2').val().replace(',', '.')) + parseFloat($('#p3').val().replace(',', '.')) + parseFloat($('#p4').val().replace(',', '.')) + num;
	
	if(parcial > 100)
	{
		$.confirm({
		    content: "Porcentaje no puede ser mayor que 100.",
		    buttons: {
		        ok: function(){
		        }
		    }
		});
		parcial =  parcial - num;
		
		$('#p5').val(0.00)
	}	
	
	
	$('#total').val(parcial);
});


aDados = new Object();	

// SelectBox com ids de kpis
$( "#kpi1" ).change(function() {
	
	aDados['K'+1] =  $('#kpi1').val();
	console.log(aDados);
});

$( "#kpi2" ).change(function() {
	
	aDados['K'+2] =  $('#kpi2').val();
	console.log(aDados);
});

$( "#kpi3" ).change(function() {
	
	aDados['K'+3] =  $('#kpi3').val();
	console.log(aDados);
});

$( "#kpi4" ).change(function() {
	
	aDados['K'+4] =  $('#kpi4').val();
	console.log(aDados);
});

$( "#kpi5" ).change(function() {
	
	aDados['K'+5] =  $('#kpi5').val();
	console.log(aDados);
});

$("#guardarrelacion").click(function() 
{
	var total = parseFloat($('#p1').val().replace(',', '.')) + parseFloat($('#p2').val().replace(',', '.')) + parseFloat($('#p3').val().replace(',', '.')) + parseFloat($('#p4').val().replace(',', '.')) + parseFloat($('#p5').val().replace(',', '.'));
	
	if(total < 100 && $('#tipo').val() == 'ponderacion')
	{
		$.confirm({
		    content: "Para guardar la relacion la suma de toda procentaje tiene que ser 100.",
		    buttons: {
		        ok: function(){
		        }
		    }
		});
		
		return false;
	}	
	
	var procesos = [];
	var aprendizajes = [];
	 
	$("#procesoschk option:selected").each(function() {
			procesos.push($(this).val());
		}); 
	
	aDados.ids_proceso = procesos;
	
	$("#aprendizajeschk option:selected").each(function() {
			aprendizajes.push($(this).val());
		}); 
	
	 aDados.ids_aprendizaje = aprendizajes;
	
	aDados.aprendizaje  = $('#idaprendizaje').val();
	aDados.idrelacion = $('#idrelacion').val();
	
	//Relacion de Indicadores
	aDados['K'+1] =  $('#kpi1').val();
	aDados['K'+2] =  $('#kpi2').val();
	aDados['K'+3] =  $('#kpi3').val();
	aDados['K'+4] =  $('#kpi4').val();
	aDados['K'+5] =  $('#kpi5').val();
	
	//Ponderaciones
	aDados['P1'] = $('#p1').val();
	aDados['P2'] = $('#p2').val();
	aDados['P3'] = $('#p3').val();
	aDados['P4'] = $('#p4').val();
	aDados['P5'] = $('#p5').val();
	
	$.ajax({
		type: "POST",
		url: "/aprendizaje/relacion",
		dataType: "json",
		data: aDados,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				$.confirm({
				    content: "Grabado con éxito.",
				    buttons: {
				        ok: function(){
				        	location.href = "/aprendizaje";
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
				        	location.href = "/aprendizaje";
				        }
				    }
				});
			}
		}
	});
});


