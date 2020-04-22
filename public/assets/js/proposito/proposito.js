$( "#guardar" ).click(function() {
	GuardarProposito();
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


