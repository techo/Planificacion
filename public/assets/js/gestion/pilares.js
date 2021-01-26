window.onload = function() 
{
	var Global_idPais = 0;
	
	/*Ocultar Textos*/
	$('#loading-techo').hide();
	$('#processar').css('display','none');
	/*Ocultar Grids*/
	$('#config').css('display','none');
}

/* Config dos SelectBox*/
$("#agrupar").change(function() {
	
	let selecionado = $('#agrupar').val();
	
	/* Exibr o Botao de Processar Dados*/
	if(selecionado != 0)
	{
		$('#processar').css('display','block');
	}	
	
	//Pais
	if(selecionado == 'Pais')
	{
		$('#loading-techo').show();
		$('#text-pais').css('display','block');
		$('#text-region').css('display','none');
		$('#tipo').css('display','none');
		$('#selectbox-sede').css('display','none');
		$('#regiones').css('display','none');
		//Ajax que monta SelectBox de paises
		$.ajax({
			type: "POST",
			url: "/selectbox/paises",
			dataType: "html",
			success: function(resp)
			{	
				if(resp)
				{
					$('#tipo').html(resp);
					$('#tipo').show();
					$('#loading-techo').hide();
				}
			}
		});
	}
	//Sedes
	else if(selecionado == 'Sede')
	{
		$('#text-pais').css('display','block');
		$('#text-region').css('display','none');
		$('#tipo').css('display','none');
		$('#selectbox-sede').css('display','none');
		$('#regiones').css('display','none');
		//Ajax que monta SelectBox de paises
		$.ajax({
			type: "POST",
			url: "/selectbox/paises",
			dataType: "html",
			success: function(resp)
			{	
				if(resp)
				{
					$('#tipo').html(resp);
					$('#tipo').show();
					$('#loading-techo').hide();
				}
			}
		});
	}
	//Regiones
	else if(selecionado == 'Region')
	{
		$('#text-region').css('display','block');
		$('#regiones').css('display','block');
		$('#text-pais').css('display','none');
		$('#tipo').css('display','none');
		$('#selectbox-sede').css('display','none');
	}
	//Latam
	else if(selecionado == 'Latam')
	{
		$('#text-pais').css('display','none');
		$('#text-region').css('display','none');
		$('#tipo').css('display','none');
		$('#selectbox-sede').css('display','none');
		$('#regiones').css('display','none');
	}
	//Selecionar
	else if(selecionado == '0')
	{
		$('#text-pais').css('display','none');
		$('#text-region').css('display','none');
		$('#tipo').css('display','none');
		$('#sedes').css('display','none');
	}
});

/*Change do SelectBox de Paises*/
$('#tipo').on('change',(event) => 
{
	if($('#agrupar').val() == 'Sede')
	{
		$('#loading-techo').show();
		let idPais = event.target.value;
		Global_idPais = idPais;
		//Ajax que monta SelectBox de Sedes
		$.ajax({
			type: "POST",
			url: "/selectbox/sedes/"+idPais,
			dataType: "html",
			success: function(resp)
			{	
				if(resp)
				{
					$('#selectbox-sede').html(resp);
					$('#selectbox-sede').show();
					$('#loading-techo').hide();
				}
			}
		});
	}
	else if($('#agrupar').val() == 'Pais')
	{
		Global_idPais = event.target.value;
	}
});

/* Mostra Grid com Dados de Sedes */
$( "#processar" ).click(function() {
	let tipo = $('#agrupar').val();
	$("#anual").prop('checked', false); 
	$("#1").prop('checked', false); 
	$("#2").prop('checked', false);
	$("#3").prop('checked', false);
	$("#4").prop('checked', false);
	Processar(tipo);
});

function Processar(tipo)
{
	let idAno = $('#ano').val();
	
	if(tipo == 'Sede')
	{
		let idPais = Global_idPais;
		let idSede = $( "#sedes" ).val();
		
		$.ajax({
			type: "POST",
			url: "/visual/pilares/pais/"+idPais+"/ano/"+idAno+"/sede/"+idSede,
			dataType: "json",
			success: function(resposta)
			{
				
				var headerMenu = [
					{
						label:"<i class='fas fa-eye-slash'></i> Ocultar Columna",
						action:function(e, column){
							column.hide();
						}
					}
				]
				
				var tabledata = [];
				
				tabledata = resposta['resultado'];
				
				$('#config').css('display','block');
				
				var table = new Tabulator("#example-table", {
				    height:"500px",
				    data:tabledata,
				    movableRows:true,
				    movableColumns:true,
				    groupBy:"pilar",
				    groupValues:[["Desarrollo Comunitario", "Promoción de la Conciencia y Acción Social", "Desarrollo Institucional", "Incidencia en Política"]],
				    columns:[
				        {rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
				        {title:"Indicador", field:"indicador", width:560, editor:false,frozen:true},
				        {title:"Tipo", field:"tipo", width:100, editor:false, headerMenu:headerMenu},
				        {title:"Pilar", field:"pilar", width:250, editor:false, visible:false},
				        {// Anual
							title:"Anual", field:"anual",
							columns:[
							{title:"Plan", field:"AnualP", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"AnualR", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"AnualC", hozAlign:"left", editor:false},
							],
						},
						{// 1 Trimestre
							title:"1 Trimestre", field:"1trimestre",
							columns:[
							{title:"Plan", field:"T1P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T1R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T1C", hozAlign:"left", editor:false},
							],
						},
						{// 2 Trimestre
							title:"2 Trimestre", field:"anual",
							columns:[
							{title:"Plan", field:"T2P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T2R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T2C", hozAlign:"left", editor:false},
							],
						},
						{// 3 Trimestre
							title:"3 Trimestre", field:"anual",
							columns:[
							{title:"Plan", field:"T3P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T3R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T3C", hozAlign:"left", editor:false},
							],
						},
						{// 4 Trimestre
							title:"4 Trimestre", field:"anual",
							columns:[
							{title:"Plan", field:"T4P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T4R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T4C", hozAlign:"left", editor:false},
							],
						},
						],
				});
				
				document.getElementById("anual").addEventListener("click", function()
				{
					table.toggleColumn('AnualP');
					table.toggleColumn('AnualR');
					table.toggleColumn('AnualC');
				});
				
				document.getElementById("1").addEventListener("click", function()
				{
					table.toggleColumn('T1P');
					table.toggleColumn('T1R');
					table.toggleColumn('T1C');
				});
				
				document.getElementById("2").addEventListener("click", function()
				{
					table.toggleColumn('T2P');
					table.toggleColumn('T2R');
					table.toggleColumn('T2C');
				});
				
				document.getElementById("3").addEventListener("click", function()
				{
					table.toggleColumn('T3P');
					table.toggleColumn('T3R');
					table.toggleColumn('T3C');
				});
				
				document.getElementById("4").addEventListener("click", function()
				{
					table.toggleColumn('T4P');
					table.toggleColumn('T4R');
					table.toggleColumn('T4C');
				});
			}
		});
		
	}
	else if(tipo == 'Pais')
	{
		let idPais = Global_idPais;
		//Ajax que manda dados para back-end
		$.ajax({
			type: "POST",
			url: "/visual/pilares/pais/"+idPais+"/ano/"+idAno,
			dataType: "json",
			success: function(resposta)
			{
				
				var headerMenu = [
					{
						label:"<i class='fas fa-eye-slash'></i> Ocultar Columna",
						action:function(e, column){
							column.hide();
						}
					}
				]
				
				var tabledata = [];
				
				tabledata = resposta['resultado'];
				
				$('#config').css('display','block');
				
				var table = new Tabulator("#example-table", {
				    height:"500px",
				    data:tabledata,
				    movableRows:true,
				    movableColumns:true,
				    groupBy:"pilar",
				    groupValues:[["Desarrollo Comunitario", "Promoción de la Conciencia y Acción Social", "Desarrollo Institucional", "Incidencia en Política"]],
				    columns:[
				        {rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
				        {title:"Indicador", field:"indicador", width:560, editor:false,frozen:true},
				        {title:"Tipo", field:"tipo", width:100, editor:false, headerMenu:headerMenu},
				        {title:"Pilar", field:"pilar", width:250, editor:false, visible:false},
				        {// Anual
							title:"Anual", field:"anual",
							columns:[
							{title:"Plan", field:"AnualP", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"AnualR", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"AnualC", hozAlign:"left", editor:false},
							],
						},
						{// 1 Trimestre
							title:"1 Trimestre", field:"1trimestre",
							columns:[
							{title:"Plan", field:"T1P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T1R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T1C", hozAlign:"left", editor:false},
							],
						},
						{// 2 Trimestre
							title:"2 Trimestre", field:"anual",
							columns:[
							{title:"Plan", field:"T2P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T2R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T2C", hozAlign:"left", editor:false},
							],
						},
						{// 3 Trimestre
							title:"3 Trimestre", field:"anual",
							columns:[
							{title:"Plan", field:"T3P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T3R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T3C", hozAlign:"left", editor:false},
							],
						},
						{// 4 Trimestre
							title:"4 Trimestre", field:"anual",
							columns:[
							{title:"Plan", field:"T4P", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"Real", field:"T4R", hozAlign:"left", editor:false, formatter:"money",validator:["numeric"], 
								formatterParams:
								{
								    decimal:".",
								    thousand:",",
								    precision:2,
								}
							},
							{title:"% (R/P)", field:"T4C", hozAlign:"left", editor:false},
							],
						},
						],
				});
				
				document.getElementById("anual").addEventListener("click", function()
				{
					table.toggleColumn('AnualP');
					table.toggleColumn('AnualR');
					table.toggleColumn('AnualC');
				});
				
				document.getElementById("1").addEventListener("click", function()
				{
					table.toggleColumn('T1P');
					table.toggleColumn('T1R');
					table.toggleColumn('T1C');
				});
				
				document.getElementById("2").addEventListener("click", function()
				{
					table.toggleColumn('T2P');
					table.toggleColumn('T2R');
					table.toggleColumn('T2C');
				});
				
				document.getElementById("3").addEventListener("click", function()
				{
					table.toggleColumn('T3P');
					table.toggleColumn('T3R');
					table.toggleColumn('T3C');
				});
				
				document.getElementById("4").addEventListener("click", function()
				{
					table.toggleColumn('T4P');
					table.toggleColumn('T4R');
					table.toggleColumn('T4C');
				});
			}
		});
	}	
	else if(tipo == 'Region')
	{
		let idRegion = $( "#selectbox-region" ).val();
		console.log('Region: ' + idRegion);
	}
	else if(tipo == 'Latam')
	{
		console.log('Latam');
	}
}


