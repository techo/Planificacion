$("#ano").change(function() 
{
	  if($("#ano").val() != 0)
	  {
		  oData    = new Object();	
		  oData.id = $('#ano').val();
		  
		  $.ajax({
				type: "POST",
				url: "/tinforme/SearchPais",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadPais').html(resp);
					$('#loadPais').show();
				}
			});
			
	  }
});

$("#loadPais").change(function() 
{
	  if($("#pais").val() != 0)
	  {
		  oData    = new Object();	
		  oData.cplanificacion = $('#ano').val();
		  oData.idPais         = $('#pais').val();
		  
		  $.ajax({
				type: "POST",
				url: "/tinforme/SearchSede",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadSede').html(resp);
					$('#loadSede').show();
				}
			});
			
	  }
});

$("#loadSede").change(function() 
{
	  if($("#sede").val() != 0)
	  {
		  oData    = new Object();	
		  oData.cplanificacion = $('#ano').val();
		  oData.idPais         = $('#pais').val();
		  oData.idSede         = $('#sedes').val();
		  
		  $.ajax({
				type: "POST",
				url: "/tinforme/SearchIndicadores",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#loadIndicador').html(resp);
					$('#loadIndicador').show();
				}
			});
			
	  }
});