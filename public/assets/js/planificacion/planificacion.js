window.onload = function() 
{
/*	var tabledata = [
		{id:1, indicador:"Indicador 001", enero_plan:12, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:2, indicador:"Indicador 002", enero_plan:13, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:3, indicador:"Indicador 003", enero_plan:14, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:4, indicador:"Indicador 004", enero_plan:15, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:5, indicador:"Indicador 005", enero_plan:16, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:6, indicador:"Indicador 006", enero_plan:17, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:7, indicador:"Indicador 007", enero_plan:18, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:8, indicador:"Indicador 008", enero_plan:19, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:9, indicador:"Indicador 009", enero_plan:20, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:10, indicador:"Indicador 010", enero_plan:21, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan:1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
		{id:11, indicador:"Indicador 011", enero_plan:22, enero_real:15, febrero_plan:3, febrero_real:5, marzo_plan:6, marzo_real:15, abril_plan:15, abril_real:15, mayo_plan:15, mayo_real:16, junio_plan: 12, junio_real: 12, julio_plan: 1, julio_real: 2, agosto_plan: 2, agosto_real: 3, septiembre_plan: 4, septiembre_real: 5, octubre_plan: 10, octubre_real: 11, noviembre_plan: 6, noviembre_real: 7, diciembre_plan: 8, diciembre_real: 9},
	];*/
	
	// Start Filtros
	//custom max min header filter
	var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){

		var end;

		var container = document.createElement("span");

		//create and style inputs
		var start = document.createElement("input");
		start.setAttribute("type", "number");
		start.setAttribute("placeholder", "Min");
		start.setAttribute("min", 0);
		start.setAttribute("max", 100);
		start.style.padding = "4px";
		start.style.width = "50%";
		start.style.boxSizing = "border-box";

		start.value = cell.getValue();

		function buildValues(){
			success({
				start:start.value,
				end:end.value,
			});
		}

		function keypress(e){
			if(e.keyCode == 13){
				buildValues();
			}

			if(e.keyCode == 27){
				cancel();
			}
		}

		end = start.cloneNode();
		end.setAttribute("placeholder", "Max");

		start.addEventListener("change", buildValues);
		start.addEventListener("blur", buildValues);
		start.addEventListener("keydown", keypress);

		end.addEventListener("change", buildValues);
		end.addEventListener("blur", buildValues);
		end.addEventListener("keydown", keypress);


		container.appendChild(start);
		container.appendChild(end);

		return container;
	 }
	// End Filtros
	
	// Ocultar Colunas
	//define row context menu
	var headerMenu = [
		{
			label:"<i class='fas fa-eye-slash'></i> Ocultar Columna",
			action:function(e, column){
				column.hide();
			}
		}
	]
	
	// Json com os Dados
	var tabledata = [];
	var data = [];
	oData    = new Object();	
	oData.id      = $('#id').val();
	oData.pais    = $('#pais').val();
	oData.sede    = $('#sede').val();
	
	/*Variaveis de travamento das Colunas*/
	let enero_p      = true;
	let enero_r      = true;
	let febrero_p    = true;
	let febrero_r    = true;
	let marzo_p      = true;
	let marzo_r      = true;
	let abril_p      = true;
	let abril_r      = true;
	let mayo_p       = true;
	let mayo_r       = true;
	let junio_p      = true;
	let junio_r      = true;
	let julio_p      = true;
	let julio_r      = true;
	let agosto_p     = true;
	let agosto_r     = true;
	let septiembre_p = true;
	let septiembre_r = true;
	let octubre_p    = true;
	let octubre_r    = true;
	let noviembre_p  = true;
	let noviembre_r  = true;
	let diciembre_p  = true;
	let diciembre_r  = true;
	
	$.ajax({
		type: "POST",
		url: "/planificacion/colunas",
		dataType: "json",
		data: oData,
		success: function(resp)
		{	
			if(resp)
			{
				//Enero
				enero_p = resp['colunas']['edit_plan_enero'] == 1 ? true : false;
				enero_r = resp['colunas']['edit_real_enero'] == 1 ? true : false;
				//Febrero
				febrero_p = resp['colunas']['edit_plan_febrero'] == 1 ? true : false;
				febrero_r = resp['colunas']['edit_real_febrero'] == 1 ? true : false;
				//Marzo
				marzo_p = resp['colunas']['edit_plan_marzo'] == 1 ? true : false;
				marzo_r = resp['colunas']['edit_real_marzo'] == 1 ? true : false;
				//Abril
				abril_p = resp['colunas']['edit_plan_abril'] == 1 ? true : false;
				abril_r = resp['colunas']['edit_real_abril'] == 1 ? true : false;
				//Mayo
				mayo_p = resp['colunas']['edit_plan_mayo'] == 1 ? true : false;
				mayo_r = resp['colunas']['edit_real_mayo'] == 1 ? true : false;
				//Junio
				junio_p = resp['colunas']['edit_plan_junio'] == 1 ? true : false;
				junio_r = resp['colunas']['edit_real_junio'] == 1 ? true : false;
				//Julio
				julio_p = resp['colunas']['edit_plan_julio'] == 1 ? true : false;
				julio_r = resp['colunas']['edit_real_julio'] == 1 ? true : false;
				//Agosto
				agosto_p = resp['colunas']['edit_plan_agosto'] == 1 ? true : false;
				agosto_r = resp['colunas']['edit_real_agosto'] == 1 ? true : false;
				//Septiembre
				septiembre_p = resp['colunas']['edit_plan_septiembre'] == 1 ? true : false;
				septiembre_r = resp['colunas']['edit_real_septiembre'] == 1 ? true : false;
				//Octubre
				octubre_p = resp['colunas']['edit_plan_octubre'] == 1 ? true : false;
				octubre_r = resp['colunas']['edit_real_octubre'] == 1 ? true : false;
				//Noviembre
				noviembre_p = resp['colunas']['edit_plan_noviembre'] == 1 ? true : false;
				noviembre_r = resp['colunas']['edit_real_noviembre'] == 1 ? true : false;
				//Diciembre
				diciembre_p = resp['colunas']['edit_plan_diciembre'] == 1 ? true : false;
				diciembre_r = resp['colunas']['edit_real_diciembre'] == 1 ? true : false;
				
				/* Busca os Dados Planificado e Realizado*/
				$.ajax({
					type: "POST",
					url: "/planificacion/planificado",
					dataType: "json",
					data: oData,
					success: function(resposta)
					{	
						tabledata = resposta['resultado'];
						
						//Generate print icon
						var printIcon = function(cell, formatterParams){ //plain text value
						    return "<i class='fa fa-print'></i>";
						};
						
						/* Inicia o COmponente da Grid com as Colunas*/
						var table = new Tabulator("#example-table", {
							data:tabledata,           //load row data from array
							tooltips:true,            //show tool tips on cells
							addRowPos:"top",          //when adding a new row, add it to the top of the table
							history:true,             //allow undo and redo actions on the table
							pagination:"local",       //paginate the data
							paginationSize:25,         //allow 7 rows per page of data
							movableColumns:true,      //allow column order to be changed
							resizableRows:true,       //allow row order to be changed
							initialSort:[             //set the initial sort order of the data
								{column:"indicador", dir:"asc"},
							],
							 langs:{
								"pt-br":{ //French language definition
								    "columns":{
								        "indicador":"Indicador",
								        "enero_plan":"Janeiro Plan",
								        "enero_real":"Janeiro Real",
								        "febrero_plan":"Fevereiro Plan",
								        "febrero_real":"Fevereiro Real",
								        "marzo_plan":"Março Plan",
								        "marzo_real":"Março Real",
								        "abril_plan":"Abril Plan",
								        "abril_real":"Abril Real",
								        "mayo_plan":"Maio Plan",
								        "mayo_real":"Maio Real",
								        "junio_plan":"Junho Plan",
								        "junio_real":"Junho Real",
								        "julio_plan":"Julho Plan",
								        "julio_real":"Julho Real",
								        "agosto_plan":"Agosto Plan",
								        "agosto_real":"Agosto Real",
								        "septiembre_plan":"Setembro Plan",
								        "septiembre_real":"Setembro Real",
								        "octubre_plan":"Outubro Plan",
								        "octubre_real":"Outubro Real",
								        "noviembre_plan":"Novembro Plan",
								        "noviembre_real":"Novembro Real",
								        "diciembre_plan":"Dezembro Plan",
								        "diciembre_real":"Dezembro Real",
								    },
								    "pagination":{
								        "first":"Primeira",
								        "first_title":"Primeira Página",
								        "last":"última",
								        "last_title":"última Página",
								        "prev":"Anterior",
								        "prev_title":"Página Anterior",
								        "next":"Próxima",
								        "next_title":"Próxima Página",
								        "all":"Listar Tudo",
								    },
								},
								
							},
							columns:[ // Columnas Default
								{formatter:printIcon, width:40, hozAlign:"center", headerMenu:headerMenu, frozen:true, cellClick:function(e, cell){Descricao(cell._cell.row.data['indicador'],cell._cell.row.data['descripcion']);}},
								{title:"Indicador", field:"indicador", width:560, editor:false, headerFilter:"input", frozen:true, headerMenu:headerMenu},
								{// 1 Trimestre
									title:"1º Trimestre",
									columns:[
									{title:"Enero Plan", field:"enero_plan", hozAlign:"left", editor:enero_p, headerMenu:headerMenu,formatter:"money", 
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Enero Real", field:"enero_real", hozAlign:"left", editor:enero_r, headerMenu:headerMenu,formatter:"money", 
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Febrero Plan", field:"febrero_plan", hozAlign:"left", editor:febrero_p, headerMenu:headerMenu,formatter:"money",
											formatterParams:
											{
											    decimal:",",
											    thousand:".",
											}
									},
									{title:"Febrero Real", field:"febrero_real", hozAlign:"left", editor:febrero_r, headerMenu:headerMenu,formatter:"money",
											formatterParams:
											{
											    decimal:",",
											    thousand:".",
											}
									},
									{title:"Marzo Plan", field:"marzo_plan", hozAlign:"left", editor:marzo_p, headerMenu:headerMenu,formatter:"money", 
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Marzo Real", field:"marzo_real", hozAlign:"left", editor:marzo_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									],
								},
								{// 2 Trimestre
									title:"2º Trimestre",
									columns:[
									{title:"Abril Plan", field:"abril_plan", hozAlign:"left", editor:abril_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Abril Real", field:"abril_real", hozAlign:"left", editor:abril_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Mayo Plan", field:"mayo_plan",  hozAlign:"left", editor:mayo_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Mayo Real", field:"mayo_real",  hozAlign:"left", editor:mayo_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Junio Plan", field:"junio_plan", hozAlign:"left", editor:junio_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Junio Real", field:"junio_real", hozAlign:"left", editor:junio_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									],
								},
								{// 3 Trimestre
									title:"3º Trimestre",
									columns:[
									{title:"Julio Plan", field:"julio_plan", hozAlign:"left", editor:julio_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Julio Real", field:"julio_real", hozAlign:"left", editor:julio_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Agosto Plan", field:"agosto_plan", hozAlign:"left", editor:agosto_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Agosto Real", field:"agosto_real", hozAlign:"left", editor:agosto_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Septiembre Plan", field:"septiembre_plan", hozAlign:"left", editor:septiembre_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Septiembre Real", field:"septiembre_real", hozAlign:"left", editor:septiembre_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									],
								},
								{// 4 Trimestre
									title:"4º Trimestre",
									columns:[
									{title:"Octubre Plan", field:"octubre_plan", hozAlign:"left", editor:octubre_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Octubre Real", field:"octubre_real", hozAlign:"left", editor:octubre_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Noviembre Plan", field:"noviembre_plan", hozAlign:"left", editor:noviembre_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Noviembre Real", field:"noviembre_real", hozAlign:"left", editor:noviembre_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Diciembre Plan", field:"diciembre_plan", hozAlign:"left", editor:diciembre_p, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									{title:"Diciembre Real", field:"diciembre_real", hozAlign:"left", editor:diciembre_r, headerMenu:headerMenu,formatter:"money",
										formatterParams:
										{
										    decimal:",",
										    thousand:".",
										}
									},
									],
								},
							],
						});
						
						/* Opcoes de Idioma */
						document.getElementById("lang-portugues").addEventListener("click", function(){
							table.setLocale("pt-br");
						});

						document.getElementById("lang-german").addEventListener("click", function(){
							table.setLocale("es-es");
						});
						
						/* Opcao de Download em Excel*/
						
						//trigger download of data.xlsx file
						document.getElementById("download-xlsx").addEventListener("click", function(){
						    table.download("xlsx", "data.xlsx", {sheetName:"My Data"});
						});
					}
				});
			}
		}
	});
} 

function Descricao(indicador, descricao)
{
	if(descricao == null)
	{
		descricao = '';
	}
	
	$.alert({
	    title: '<i class="fa fa-rocket"></i> Descripción',
	    content: '<p><strong>Indicador:</strong> ' + indicador + '</p><p><strong>Descripción:</strong> ' + descricao + '</p>',
	});
}
