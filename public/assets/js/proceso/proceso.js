
console.log('procesos internos');

$("#guardar").click(function() {
	GuardarProceso();
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

function GuardarProceso()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.proceso     = $('#proceso').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	
	$.ajax({
		type: "POST",
		url: "/proceso/agregar",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/proceso";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/proceso";
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
		url: "/proceso/filtro",
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

function EliminarProceso(id)
{
	var id = id
    $.confirm({
        content: 'Est\u00E1 seguro de que desea borrar esta proceso?',
        buttons: {
            specialKey: {
                text: 'S\u00ED',
                action: function(){
                	window.location.replace("/proceso/delete/"+id);
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

function EditarProceso(id)
{
	$('#loading-techo').show();
	oData      = new Object();	
	oData.id   = id;
	
	$.ajax({
		type: "POST",
		url: "/proceso/edit",
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

function AtualizarProceso()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.proceso     = $('#proceso').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	oData.id          = $('#id').val();
	
	$.ajax({
		type: "POST",
		url: "/proceso/update",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/proceso";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/proceso";
			}
		}
	});
}

function refreshPage(){
    window.location.reload();
} 
