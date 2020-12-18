window.onload = function() 
{
	var Global_idPais = 0;
	
	/*Ocultar Textos*/
	$('#loading-techo').hide();
	$('#text-sede').css('display','none');
	$('#text-pais').css('display','none');
	$('#text-region').css('display','none');
	$('#processar').css('display','none');
	/*Ocultar Grids*/
	$('#table-sede').css('display','none');
	$('#table-pais').css('display','none');
	$('#table-region').css('display','none');
	$('#table-latam').css('display','none');
	
	/*Dados da Table Exemplo*/
	var tableDataNested = [
	    {name:"Oli Bob", location:"United Kingdom", gender:"male", col:"red", dob:"14/04/1984", _children:[
	        {name:"Mary May", location:"Germany", gender:"female", col:"blue", dob:"14/05/1982"},
	        {name:"Christine Lobowski", location:"France", gender:"female", col:"green", dob:"22/05/1982"},
	        {name:"Brendon Philips", location:"USA", gender:"male", col:"orange", dob:"01/08/1980", _children:[
	            {name:"Margret Marmajuke", location:"Canada", gender:"female", col:"yellow", dob:"31/01/1999"},
	            {name:"Frank Harbours", location:"Russia", gender:"male", col:"red", dob:"12/05/1966"},
	        ]},
	    ]},
	    {name:"Jamie Newhart", location:"India", gender:"male", col:"green", dob:"14/05/1985"},
	    {name:"Gemma Jane", location:"China", gender:"female", col:"red", dob:"22/05/1982", _children:[
	        {name:"Emily Sykes", location:"South Korea", gender:"female", col:"maroon", dob:"11/11/1970"},
	    ]},
	    {name:"James Newman", location:"Japan", gender:"male", col:"red", dob:"22/03/1998"},
	];
	
	/*Inicia a Table*/
	var table = new Tabulator("#table-sede", {
	    height:"311px",
	    data:tableDataNested,
	    dataTree:true,
	    dataTreeStartExpanded:true,
	    autoResize:true,
	    movableColumns:true,
		resizableRows:true,
	    columns:[
	    {title:"Name", field:"name", width:200, responsive:0},
	    {title:"Location", field:"location", width:150},
	    {title:"Gender", field:"gender", width:150, responsive:2},
	    {title:"Favourite Color", field:"col", width:150},
	    {title:"Date Of Birth", field:"dob", hozAlign:"center", sorter:"date", width:150},
	    ],
	});
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
	Processar(tipo);
});

function Processar(tipo)
{
	let idAno = $('#ano').val();
	
	if(tipo == 'Sede')
	{
		let idPais = Global_idPais;
		let idSede = $( "#sedes" ).val();
		console.log('Sede: ' + idSede);
		console.log('Pais: ' + idPais);
	}
	else if(tipo == 'Pais')
	{
		let idPais = Global_idPais;
		//Ajax que manda dados para back-end
		$.ajax({
			type: "POST",
			url: "/visual/pilares/pais/"+idPais+"/ano/"+idAno,
			dataType: "json",
			success: function(oData)
			{	
				console.log('sucesso!');
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


