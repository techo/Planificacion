$( "#guardar" ).click(function() {
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


