window.onload = function() 
{
	/*Ocultar Textos*/
	$('#loading-techo').hide();
	$('#text-sede').css('display','none');
	$('#text-pais').css('display','none');
	$('#text-region').css('display','none');
	
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
	var table = new Tabulator("#table-pilares", {
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
	
	//Pais
	if(selecionado == 'Pais')
	{
		$('#loading-techo').show();
		$('#text-pais').css('display','block');
		$('#text-region').css('display','none');
		$('#tipo').css('display','none');
		$('#selectbox-sede').css('display','none');
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
		$('#text-pais').css('display','none');
		console.log('Region');
	}
	//Latam
	else if(selecionado == 'Latam')
	{
		console.log('Latam');
	}
	//Selecionar
	else if(selecionado == '0')
	{
		$('#text-pais').css('display','none');
		$('#text-region').css('display','none');
		$('#tipo').css('display','none');
	}
});

/*Change do SelectBox de Paises*/
$('#tipo').on('change',(event) => 
{
	if($('#agrupar').val() == 'Sede')
	{
		$('#loading-techo').show();
		let idPais = event.target.value;
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
});

