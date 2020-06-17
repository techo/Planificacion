
console.log('propuestas de valor');

$("#guardar").click(function() {
	GuardarPropuesta();
});

$("#filtropais" ).change(function() {
	var pais = '';
	var ano  = '';
	
	$("#filtropais option:selected").each(function() {
		   pais = $(this).val();
		}); 
	
	$("#filtroano option:selected").each(function() {
		   ano = $(this).val();
		});
	
	  Filtro(pais, ano);
});

$("#filtroano" ).change(function() {
	var pais = '';
	var ano  = '';
	
	$("#filtroano option:selected").each(function() {
		   ano = $(this).val();
		});
	
	$("#filtropais option:selected").each(function() {
		   pais = $(this).val();
		}); 
	
	  Filtro(pais, ano);
});

function GuardarPropuesta()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.propuesta   = $('#propuesta').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	
	$.ajax({
		type: "POST",
		url: "/propuesta/agregar",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/propuesta";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/propuesta";
			}
		}
	});
}

function Filtro(pais=0, ano=0)
{
	$('#loading-techo').show();
	oData        = new Object();	
	oData.pais   = pais;
	oData.ano    = ano;
	
	$.ajax({
		type: "POST",
		url: "/propuesta/filtro",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				$('#load').empty();
				$('#load').html(oData['results']);
			}
			else
			{
				$('#loading-techo').hide();
				$('#load').empty();
				$('#load').html(oData['results']);
			}
		}
	});
}

function EliminarPropuesta(id)
{
	var id = id
    $.confirm({
        content: 'Est\u00E1 seguro de que desea borrar esta propuesta?',
        buttons: {
            specialKey: {
                text: 'S\u00ED',
                action: function(){
                	window.location.replace("/propuesta/delete/"+id);
                }
            },
            alphabet: {
                text: 'No',
                action: function(){
                    return;
                }
            }
        }
    });
}

function EditarPropuesta(id)
{
	$('#loading-techo').show();
	oData      = new Object();	
	oData.id   = id;
	
	$.ajax({
		type: "POST",
		url: "/propuesta/edit",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				$('#add').empty();
				$('#add').html(oData['results']);
			}
			else
			{
				$('#loading-techo').hide();
				$('#add').empty();
				$('#add').html(oData['results']);
			}
		}
	});
}

function AtualizarPropuesta()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.propuesta   = $('#propuesta').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	oData.id          = $('#id').val();
	
	$.ajax({
		type: "POST",
		url: "/propuesta/update",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/propuesta";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/propuesta";
			}
		}
	});
}

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
	
	if(total < 100)
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
	
	aDados.proposito  = $('#idproposito').val();
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
		url: "/proposito/relacion",
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
				        	location.href = "/proposito";
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
				        	location.href = "/proposito";
				        }
				    }
				});
			}
		}
	});
});


