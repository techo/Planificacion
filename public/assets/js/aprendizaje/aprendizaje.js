
console.log('Aprendizaje');

$("#guardar").click(function() {
	GuardarAprendizaje();
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

function GuardarAprendizaje()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.aprendizaje = $('#aprendizaje').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	
	$.ajax({
		type: "POST",
		url: "/aprendizaje/agregar",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/aprendizaje";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/aprendizaje";
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
		url: "/aprendizaje/filtro",
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

function EliminarAprendizaje(id)
{
	var id = id
    $.confirm({
        content: 'Est\u00E1 seguro de que desea borrar esta Aprendizaje?',
        buttons: {
            specialKey: {
                text: 'S\u00ED',
                action: function(){
                	window.location.replace("/aprendizaje/delete/"+id);
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

function EditarAprendizaje(id)
{
	$('#loading-techo').show();
	oData      = new Object();	
	oData.id   = id;
	
	$.ajax({
		type: "POST",
		url: "/aprendizaje/edit",
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

function AtualizarAprendizaje()
{
	$('#loading-techo').show();
	oData             = new Object();	
	oData.aprendizaje = $('#aprendizaje').val();
	oData.descripcion = $('#descripcion').val();
	oData.pais        = $('#pais').val();
	oData.ano         = $('#ano').val();
	oData.id          = $('#id').val();
	
	$.ajax({
		type: "POST",
		url: "/aprendizaje/update",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['results'])
			{
				$('#loading-techo').hide();
				location.href = "/aprendizaje";
			}
			else
			{
				$('#loading-techo').hide();
				location.href = "/aprendizaje";
			}
		}
	});
}
