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
					url: "/tinforme/CarregaMensal",
					dataType: "json",
					data: oData,
					success: function(resp)
					{
						plan = resp['plan'];
						
						//Plan
						var res = plan.split(",");
						
						console.log(res);
						
						
						var plan1  = res[0];
						var plan2  = res[1];
						var plan3  = res[2];
						var plan4  = res[3];
						var plan5  = res[4];
						var plan6  = res[5];
						var plan7  = res[6];
						var plan8  = res[7];
						var plan9  = res[8];
						var plan10 = res[9];
						var plan11 = res[10];
						var plan12 = res[11];
						
						//Real
						var real1  = res[12];
						var real2  = res[13];
						var real3  = res[14];
						var real4  = res[15];
						var real5  = res[16];
						var real6  = res[17];
						var real7  = res[18];
						var real8  = res[19];
						var real9  = res[20];
						var real10 = res[21];
						var real11 = res[22];
						var real12 = res[23];
						
						//Dados do Grid
						  var MONTHS = ['Enero', 'Febrero', 'Marzo', 'Abril','Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
						  var color = Chart.helpers.color;
						  var barChartData = {
						  	labels: ['Enero', 'Febrero', 'Marzo', 'Abril','Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
						  	datasets: [{
						  		label: 'Plan',
						  		backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
						  		borderColor: window.chartColors.red,
						  		borderWidth: 1,
						  		data: [
						  			plan1, plan2, plan3, plan4, plan5, plan6, plan7, plan8, plan9, plan10, plan11, plan12
						  		]
						  	}, {
						  		label: 'Real',
						  		backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
						  		borderColor: window.chartColors.blue,
						  		borderWidth: 1,
						  		data: [
						  			real1, real2, real3, real4, real5, real6, real7, real8, real9, real10, real11, real12
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
						  				text: 'Resultado Mensual'
						  			}
						  		}
						  	});
					}
				});
		  }
	});

