$("#ano").change(function() 
{
	  if($("#ano").val() != 0)
	  {
		  $('#container').hide();
		  $('#loading-techo').show();
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
					$("#sedes").val("0");
					$("#indicador").val("0");
					$('#loading-techo').hide();
				}
			});
			
	  }
});

$("#loadPais").change(function() 
{
	  if($("#pais").val() != 0)
	  {
		  $('#container').hide();
		  $('#loading-techo').show();
		  $("#sedes").val("0");
		  $("#indicador").val("0");
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
					$('#loading-techo').hide();
				}
			});
			
	  }
});

$("#loadSede").change(function() 
{
	  if($("#sede").val() != 0)
	  {
		  $('#container').hide();
		  $('#loading-techo').show();
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
					$('#loading-techo').hide();
				}
			});
			
	  }
});

$("#loadIndicador").change(function() 
	{
		//Essa parte e para nao bugar o charts com varios graficos
		document.getElementById("container").innerHTML = '&nbsp;';
		document.getElementById("container").innerHTML = '<canvas id="canvas"></canvas>';
		var ctx = document.getElementById("canvas").getContext("2d");
	
		if($("#indicador").val() != 0)
		  {
			  var plan = 0;
			  var real = 0;
			  
			  $('#loading-techo').show();
			  
			  oData    = new Object();	
			  oData.cplanificacion = $('#ano').val();
			  oData.idPais         = $('#pais').val();
			  oData.idSede         = $('#sedes').val();
			  oData.idIndicador    = $('#indicador').val();
			  
			  $.ajax({
					type: "POST",
					url: "/tinforme/CarregaAnual",
					dataType: "json",
					data: oData,
					success: function(resp)
					{
						plan = resp['plan'];
						
						//Plan
						var res = plan.split(",");
						
						var plan  = res[0];
												
						//Real
						var real  = res[1];
						
						$('#loading-techo').hide();
						$('#container').show();
						
						//Dados do Grid
						  var MONTHS = ['Anual'];
						  var color = Chart.helpers.color;
						  var barChartData = {
						  	labels: ['Anual'],
						  	datasets: [{
						  		label: 'Plan',
						  		backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
						  		borderColor: window.chartColors.red,
						  		borderWidth: 1,
						  		data: [
									plan,
									real
								],
								backgroundColor: [
									window.chartColors.blue,
									window.chartColors.red,
								],
								label: 'Dataset 1'
							}],
							labels: [
								'Planificado',
								'Real',
							]

						  };
						  
						  //Carrega e mostra os dados
						   var ctx = document.getElementById('canvas').getContext('2d');
						  	window.myBar = new Chart(ctx, {
						  		type: 'pie',
						  		data: barChartData,
						  		options: {
						  			responsive: true,
						  			legend: {
						  				position: 'top',
						  			},
						  			title: {
						  				display: true,
						  				text: 'Resultado Anual'
						  			}
						  		}
						  	});
					}
				});
		  }
	});

