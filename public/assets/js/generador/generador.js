//Mudou o Ano, gera os campos de ano e botao buscar sede de acordo com o radio selecionado
$("#ano").change(function() 
{
	var tipo = '';
	
	if($("#ano").val() != 0)
	{
		$.each(($("input[type=radio]:checked")), function(index, obj){
	        tipo = obj.value;
	    });
		
		$('#loading-techo').show();
		  oData    = new Object();	
		  oData.id = $('#ano').val();
		  
		  $.ajax({
				type: "POST",
				url: "/generador/SearchPais",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#Listpaises').html(resp);
					
					//Multi select
				    var config = {
				            '.chosen-select'           : {},
				            '.chosen-select-deselect'  : {allow_single_deselect:true},
				            '.chosen-select-no-single' : {disable_search_threshold:10},
				            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
				            '.chosen-select-width'     : {width:"95%"}
				            }
				        for (var selector in config) {
				            $(selector).chosen(config[selector]);
				        }
				    
					$('#Listpaises').show();
				}
		  });
		  
		  $.ajax({
				type: "POST",
				url: "/generador/SearchIndicador",
				dataType: "html",
				data: oData,
				success: function(resp)
				{	
					$('#ListIndicador').html(resp);
					
					//Multi select
				    var config = {
				            '.chosen-select'           : {},
				            '.chosen-select-deselect'  : {allow_single_deselect:true},
				            '.chosen-select-no-single' : {disable_search_threshold:10},
				            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
				            '.chosen-select-width'     : {width:"95%"}
				            }
				        for (var selector in config) {
				            $(selector).chosen(config[selector]);
				        }
				    
					$('#ListIndicador').show();
				}
		  });
		  
		  if(tipo == 'sedes')
		  {
			  $('#buscaSede').show();
		  }
	}
});

function GeneraResultado()
{
	var tipo = '';
	$.each(($("input[type=radio]:checked")), function(index, obj){
        tipo = obj.value;
    });
	
	oData = new Object();	
	oData.ano = $('#ano').val();
	if(tipo == 'paises')
	{
		var paises = '';
		var cont = 0;
		//paises
		$( ".search-choice" ).each(function( index ) {
			var elemento = $(this);
			elemento.each(function(i) {
				if(cont == 0)
				{
					paises += $(this)[0].value;
					cont++;
				}
				else
				{
					paises += ',' + $(this)[0].value;
				}
			})
			});
		
		oData.paises = paises;
		
		//indicador
		var qtd = $(".combo2").length / 2;
		var n = 0;
		var indicador = 0;
		while (n < qtd) 
		{
			if($(".combo2")[n].selected == true)
			{
				oData.indicador = $(".combo2")[n].value;
			}
			n++;
		}
		
		//Manda paises pro php
		$.ajax({
			type: "POST",
			url: "/generador/GeraPais",
			dataType: "json",
			data: oData,
			success: function(resp)
			{	
				//Essa parte e para nao bugar o charts com varios graficos
				document.getElementById("container").innerHTML = '&nbsp;';
				document.getElementById("container").innerHTML = '<canvas id="canvas"></canvas>';
				var ctx = document.getElementById("canvas").getContext("2d");
				
				 dados = resp['data'];
				 
				  var max    = 0;	
				  
				  //Dados do Grid
				  var MONTHS = ['Plan Anual', 'Real Anual', '% RP Anual', 'Plan T1', 'Real T1', '% RP T1','Plan T2', 'Real T2', '%RP T2', 'Plan T3', 'Real T3', '% RP T3', 'Plan T4', 'Real T4', '% RP T4', 'Plan S1', 'Real S1', '% RP S1', 'Plan S2', 'Real S2', '% RP S2'];
				  var color = Chart.helpers.color;
				  //Comeca a varrer os paises
				  var qtd = dados.length;
				  var valores = [];
				  var cores = ['rgba(234,60,7,1)', 'rgba(7,182,234,1)', 'rgba(234,91,7,1)', 'rgba(76,175,80,1)', 'rgba(234,7,196,1)', 'rgba(210,234,7,1)', 'rgba(188,25,25,1)', 'rgba(155,99,211,1)', 'rgba(31,28,206,1)', 'rgba(171,32,127,1)'];
				  var random = 0;
				  
				  while (max < qtd) 
				  {
					  random = Math.floor((Math.random() * 10) + 1) -1;
					  
					  valores.splice(0, 0, {label: dados[max].pais,backgroundColor: color(cores[random]).alpha(0.5).rgbString(),borderColor: cores[random],borderWidth: 1,data: [dados[max].Plan_anual, dados[max].Real_anual, dados[max].RP_anual, dados[max].Plan_t1, dados[max].Real_t1, dados[max].RP_t1, dados[max].Plan_t2, dados[max].Real_t2, dados[max].RP_t2, dados[max].Plan_t3, dados[max].Real_t3, dados[max].RP_t3, dados[max].Plan_t4, dados[max].Real_t4, dados[max].RP_t4, dados[max].Plan_s1, dados[max].Real_s1, dados[max].RP_s1, dados[max].Plan_s2, dados[max].Real_s2, dados[max].RP_s2]});
					  
					  max++;
				  }
				  
				  var myJSON = JSON.stringify(valores);
				  
				  var barChartData = {
				  	labels: ['Plan Anual', 'Real Anual', '% RP Anual', 'Plan T1', 'Real T1', '% RP T1', 'Plan T2', 'Real T2', '% RP T2', 'Plan T3', 'Real T3', '% RP T3', 'Plan T4', 'Real T4', '% RP T4', 'Plan S1', 'Real S1', '% RP S1', 'Plan S2', 'Real S2', '% RP S2'],
				  	datasets: JSON.parse(myJSON)
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
				  				text: 'Resultado'
				  			}
				  		}
				  	});
			}
	  });
	}
	else
	{
		console.log('sedes');
	}
	
}