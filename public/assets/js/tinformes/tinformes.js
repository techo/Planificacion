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
			  
			  oData    = new Object();	
			  oData.cplanificacion = $('#ano').val();
			  oData.idPais         = $('#pais').val();
			  oData.idSede         = $('#sedes').val();
			  oData.idIndicador    = $('#indicador').val();
			  
			  $.ajax({
					type: "POST",
					url: "/tinforme/CarregaTrimestre",
					dataType: "json",
					data: oData,
					success: function(resp)
					{
						plan = resp['plan'];
						
						//Plan
						var res = plan.split(",");
						
						console.log(res);
						
						
						var plan1 = res[0];
						var plan2 = res[1];
						var plan3 = res[2];
						var plan4 = res[3];
						
						//Real
						var real1 = res[4];
						var real2 = res[5];
						var real3 = res[6];
						var real4 = res[7];
						
						//Dados do Grid
						  var MONTHS = ['1T', '2T', '3T', '4T'];
						  var color = Chart.helpers.color;
						  var barChartData = {
						  	labels: ['1T', '2T', '3T', '4T'],
						  	datasets: [{
						  		label: 'Plan',
						  		backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
						  		borderColor: window.chartColors.red,
						  		borderWidth: 1,
						  		data: [
						  			plan1, plan2, plan3, plan4
						  		]
						  	}, {
						  		label: 'Real',
						  		backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
						  		borderColor: window.chartColors.blue,
						  		borderWidth: 1,
						  		data: [
						  			real1, real2, real3, real4
						  		]
						  	}]

						  };
						  
						  //Carrega e mostra os dados
						   var ctx = document.getElementById('canvas').getContext('2d');
						  	window.myBar = new Chart(ctx, {
						  		type: 'bar',
						  		data: barChartData,
						  		options: {
						  			responsive: true,
						  			legend: {
						  				position: 'top',
						  			},
						  			title: {
						  				display: true,
						  				text: 'Resultado Trismestral'
						  			}
						  		}
						  	});
					}
				});
		  }
	});

