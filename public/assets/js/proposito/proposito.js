$("#guardar").click(function() {
	GuardarProposito();
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

function GuardarProposito()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.proposito   = $('#proposito').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	
	$.ajax({
		type: "POST",
		url: "/proposito/agregar",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/proposito";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/proposito";
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
		url: "/proposito/filtro",
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

function EliminarProposito(id)
{
	var id = id
    $.confirm({
        content: 'Est\u00E1 seguro de que desea borrar esta prop\u00F3sito?',
        buttons: {
            specialKey: {
                text: 'S\u00ED',
                action: function(){
                	window.location.replace("/proposito/delete/"+id);
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

function EditarProposito(id)
{
	$('#loading-techo').show();
	oData      = new Object();	
	oData.id   = id;
	
	$.ajax({
		type: "POST",
		url: "/proposito/edit",
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

function AtualizarProposito()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.proposito   = $('#proposito').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	oData.id          = $('#id').val();
	
	$.ajax({
		type: "POST",
		url: "/proposito/update",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/proposito";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/proposito";
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

$("#guardarrelacion").click(function() {
	
	aDados.proposito = $('#idproposito').val();
	
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


