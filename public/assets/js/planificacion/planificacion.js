window.onload = function() 
{
	var metadata = [];
	var data = [];
	oData   = new Object();	
	oResult = new Object();
	oData.id     = $('#id').val();
	oData.pais   = $('#pais').val();
	oData.sede   = $('#sede').val();
	oResult.id   = $('#id').val();
	oResult.pais = $('#pais').val();
	oResult.sede = $('#sede').val();
	
	$.ajax({
		type: "POST",
		url: "/planificacion/dados",
		dataType: "json",
		data: oData,
		success: function(oData)
		{	
			if(oData['metadata'])
			{
				metadata = oData['metadata'];
				
				//Criar Ajax data ...
				$.ajax({
					type: "POST",
					url: "/planificacion/listagem",
					dataType: "json",
					data: oResult,
					success: function(oData)
					{	
						if(oData['data'])
						{
							data = oData['data'];
						}
						
						editableGrid = new EditableGrid("DemoGridJsData");
						
						editableGrid.load({"metadata": metadata, "data": data});
						editableGrid.renderGrid("tablecontent", "testgrid");
						
						//Indicador
						if(editableGrid.columns[0]['editable'] == false)
						{
							$( ".editablegrid-indicador" ).removeClass( "editablegrid-indicador" ).addClass( "editablegrid-indicador No-Edit" );
						}
						//Pilar
						if(editableGrid.columns[1]['editable'] == false)
						{
							$( ".editablegrid-pilar" ).removeClass( "editablegrid-pilar" ).addClass( "editablegrid-pilar No-Edit" );
						}
						
						//Area
						if(editableGrid.columns[2]['editable'] == false)
						{
							$( ".editablegrid-area" ).removeClass( "editablegrid-area" ).addClass( "editablegrid-area No-Edit" );
						}
						
						//01 Plan
						if(editableGrid.columns[3]['editable'] == false)
						{
							$( ".editablegrid-enero_plan" ).removeClass( "editablegrid-enero_plan" ).addClass( "editablegrid-enero_plan No-Edit" );
						}
						
						//01 Real
						if(editableGrid.columns[4]['editable'] == false)
						{
							$( ".editablegrid-enero_real" ).removeClass( "editablegrid-enero_real" ).addClass( "editablegrid-enero_real No-Edit" );
						}
						
						//02 Plan
						if(editableGrid.columns[5]['editable'] == false)
						{
							$( ".editablegrid-febrero_plan" ).removeClass( "editablegrid-febrero_plan" ).addClass( "editablegrid-febrero_plan No-Edit" );
						}
						
						//02 Real
						if(editableGrid.columns[6]['editable'] == false)
						{
							$( ".editablegrid-febrero_real" ).removeClass( "editablegrid-febrero_real" ).addClass( "editablegrid-febrero_real No-Edit" );
						}
						
						//03 Plan
						if(editableGrid.columns[7]['editable'] == false)
						{
							$( ".editablegrid-marzo_plan" ).removeClass( "editablegrid-marzo_plan" ).addClass( "editablegrid-marzo_plan No-Edit" );
						}
						
						//03 Real
						if(editableGrid.columns[8]['editable'] == false)
						{
							$( ".editablegrid-marzo_real" ).removeClass( "editablegrid-marzo_real" ).addClass( "editablegrid-marzo_real No-Edit" );
						}
						
						//04 Plan
						if(editableGrid.columns[9]['editable'] == false)
						{
							$( ".editablegrid-abril_plan" ).removeClass( "editablegrid-abril_plan" ).addClass( "editablegrid-abril_plan No-Edit" );
						}
						
						//04 Real
						if(editableGrid.columns[10]['editable'] == false)
						{
							$( ".editablegrid-abril_real" ).removeClass( "editablegrid-abril_real" ).addClass( "editablegrid-abril_real No-Edit" );
						}
						
						//05 Plan
						if(editableGrid.columns[11]['editable'] == false)
						{
							$( ".editablegrid-mayo_plan" ).removeClass( "editablegrid-mayo_plan" ).addClass( "editablegrid-mayo_plan No-Edit" );
						}
						
						//05 Real
						if(editableGrid.columns[12]['editable'] == false)
						{
							$( ".editablegrid-mayo_real" ).removeClass( "editablegrid-mayo_real" ).addClass( "editablegrid-mayo_real No-Edit" );
						}
						
						//06 Plan
						if(editableGrid.columns[13]['editable'] == false)
						{
							$( ".editablegrid-junio_plan" ).removeClass( "editablegrid-junio_plan" ).addClass( "editablegrid-junio_plan No-Edit" );
						}
						
						//06 Real
						if(editableGrid.columns[14]['editable'] == false)
						{
							$( ".editablegrid-junio_real" ).removeClass( "editablegrid-junio_real" ).addClass( "editablegrid-junio_real No-Edit" );
						}
						
						//07 Plan
						if(editableGrid.columns[15]['editable'] == false)
						{
							$( ".editablegrid-julio_plan" ).removeClass( "editablegrid-julio_plan" ).addClass( "editablegrid-julio_plan No-Edit" );
						}
						
						//07 Real
						if(editableGrid.columns[16]['editable'] == false)
						{
							$( ".editablegrid-julio_real" ).removeClass( "editablegrid-julio_real" ).addClass( "editablegrid-julio_real No-Edit" );
						}
						
						//08 Plan
						if(editableGrid.columns[17]['editable'] == false)
						{
							$( ".editablegrid-agosto_plan" ).removeClass( "editablegrid-agosto_plan" ).addClass( "editablegrid-agosto_plan No-Edit" );
						}
						
						//08 Real
						if(editableGrid.columns[18]['editable'] == false)
						{
							$( ".editablegrid-agosto_real" ).removeClass( "editablegrid-agosto_real" ).addClass( "editablegrid-agosto_real No-Edit" );
						}
						
						//09 Plan
						if(editableGrid.columns[19]['editable'] == false)
						{
							$( ".editablegrid-septiembre_plan" ).removeClass( "editablegrid-septiembre_plan" ).addClass( "editablegrid-septiembre_plan No-Edit" );
						}
						
						//09 Real
						if(editableGrid.columns[20]['editable'] == false)
						{
							$( ".editablegrid-septiembre_real" ).removeClass( "editablegrid-septiembre_real" ).addClass( "editablegrid-septiembre_real No-Edit" );
						}
						
						//10 Plan
						if(editableGrid.columns[21]['editable'] == false)
						{
							$( ".editablegrid-octubre_plan" ).removeClass( "editablegrid-octubre_plan" ).addClass( "editablegrid-octubre_plan No-Edit" );
						}
						
						//10 Real
						if(editableGrid.columns[22]['editable'] == false)
						{
							$( ".editablegrid-octubre_real" ).removeClass( "editablegrid-octubre_real" ).addClass( "editablegrid-octubre_real No-Edit" );
						}
						
						//11 Plan
						if(editableGrid.columns[23]['editable'] == false)
						{
							$( ".editablegrid-noviembre_plan" ).removeClass( "editablegrid-noviembre_plan" ).addClass( "editablegrid-noviembre_plan No-Edit" );
						}
						
						//11 Real
						if(editableGrid.columns[24]['editable'] == false)
						{
							$( ".editablegrid-noviembre_real" ).removeClass( "editablegrid-noviembre_real" ).addClass( "editablegrid-noviembre_real No-Edit" );
						}
						
						//12 Plan
						if(editableGrid.columns[25]['editable'] == false)
						{
							$( ".editablegrid-diciembre_plan" ).removeClass( "editablegrid-diciembre_plan" ).addClass( "editablegrid-diciembre_plan No-Edit" );
						}
						
						//12 Real
						if(editableGrid.columns[26]['editable'] == false)
						{
							$( ".editablegrid-diciembre_real" ).removeClass( "editablegrid-diciembre_real" ).addClass( "editablegrid-diciembre_real No-Edit" );
						}
						
						
						//console.log(editableGrid.columns[4]['editable']);
						
						var searchField = document.getElementById('searchField');
						searchField.addEventListener(
						    'keyup',
						    function (){
						    	editableGrid.filter(searchField.value);
						    }
						);
					}
				});
			}
		}
	});
	
	CellEditor.prototype.edit = function(rowIndex, columnIndex, element, value) 
	{
	  	element.isEditing = true;
	  	element.rowIndex = rowIndex; 
	  	element.columnIndex = columnIndex;
	  	
	  	var editorInput = this.getEditor(element, value);
	  	if (!editorInput) return false;
	  	
	  	editorInput.element = element;
	  	editorInput.celleditor = this;
	  
	  	editorInput.onkeydown = function(event) {
	  		
	  		$( "td" )
	  		  .focusout(function() {
	  			  
	  			$('#save1').show();
	  			setTimeout(function(){
		  			//Implementar AQUI TA COM PROBLEMA O VALOR
			  			var linha1 = editorInput.celleditor.editablegrid.lastSelectedRowIndex;
			  			var coluna1 = editorInput.celleditor.column.name;
			  			var coluna2 = editorInput.celleditor.column.columnIndex;
			  			var id1     = editorInput.celleditor.editablegrid.data[linha1].id;
			  			var valor1  = editorInput.celleditor.editablegrid.data[linha1].columns[coluna2];
			  			
			  			
			  		  	//Implementar Update de Dados
			  		  		oIndicador   = new Object();
			  		  		oIndicador.id     = id1;
			  		  		oIndicador.coluna = coluna1;
			  		  		oIndicador.valor  = valor1;
			  		  		
			  		  	$.ajax({
							type: "POST",
							url: "/planificacion/atualiza",
							dataType: "json",
							data: oIndicador,
							success: function(oData)
							{	
								$('#save1').hide();
								$('#save2').show();
								console.log('Gravou com Sucesso');
							}
						});
			  		  	
		  	  		}, 500);
	  			
	  				$('#save2').hide();
	  		  })

	  		event = event || window.event;
	  		
	  		if (event.keyCode == 13 || event.keyCode == 9) {
	  			this.onblur = null; 
	  			this.celleditor.applyEditing(this.element, this.celleditor.getEditorValue(this));
	  		
	  		var linha  = (this.celleditor['editablegrid']['lastSelectedRowIndex']);
	  		var coluna = (this.celleditor['column']['name']);
	  		var id     = (this.celleditor['editablegrid']['data'][linha]['id']);
	  		var valor  = (this.celleditor.getEditorValue(this));
	  		
	  		//Implementar Update de Dados
	  		oIndicador   = new Object();
	  		oIndicador.id     = id;
	  		oIndicador.coluna = coluna;
	  		oIndicador.valor  = valor;
	  		
	  		//Implementar Update de Dados
	  		$.ajax({
				type: "POST",
				url: "/planificacion/atualiza",
				dataType: "json",
				data: oIndicador,
				success: function(oData)
				{	
					$('#save1').hide();
					$('#save2').show();
					console.log('Gravou com Sucesso');
				}
			});
	  			$('#save2').hide();
	  			return false;
	  		}
	  		
	  		// ESC: cancel editing
	  		if (event.keyCode == 27) { 
	  			this.onblur = null; 
	  			this.celleditor.cancelEditing(this.element); 
	  			return false; 
	  		}
	  	};
	  
	  	if (!this.editablegrid.allowSimultaneousEdition) editorInput.onblur = this.editablegrid.saveOnBlur ?
	  			function(event) { this.onblur = null; this.celleditor.applyEditing(this.element, this.celleditor.getEditorValue(this)); } :
	  			function(event) { this.onblur = null; this.celleditor.cancelEditing(this.element); };
	  
	  	this.displayEditor(element, editorInput);
	  	
	  	editorInput.focus();
	};
	
	CellEditor.prototype.getEditorValue = function(editorInput) {
		  	return editorInput.value;
		  };
} 

/* 
Exemplo do JSON metadata

//	metadata.push({ name: "indicador", label: "Indicador", datatype: "string", editable: false});
//	metadata.push({ name: "enero_plan", label:"01 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "enero_real", label: "01 Real", datatype: "integer", editable: false});
//	metadata.push({ name: "febrero_plan", label: "02 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "febrero_real", label: "02 Real", datatype: "integer", editable: false});
//	metadata.push({ name: "marzo_plan", label: "03 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "marzo_real", label: "03 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "abril_plan", label: "04 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "abril_real", label: "04 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "mayo_plan", label: "05 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "mayo_real", label: "05 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "junio_plan", label: "06 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "junio_real", label: "06 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "julio_plan", label: "07 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "julio_real", label: "07 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "agosto_plan", label: "08 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "agosto_real", label: "08 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "septiembre_plan", label: "09 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "septiembre_real", label: "09 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "octubre_plan", label: "10 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "octubre_real", label: "10 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "noviembre_plan", label: "11 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "noviembre_real", label: "11 Real", datatype: "integer", editable: true});
//	metadata.push({ name: "diciembre_plan", label: "12 Plan", datatype: "integer", editable: true});
//	metadata.push({ name: "diciembre_real", label: "12 Real", datatype: "integer", editable: true});
	
 */


/* Exemplo de data
 	data.push({id: 1, values: {"indicador":"%CEF - Porcentaje de Cobertura de Egresos Fijos","enero_plan":2,"enero_real":1,"febrero_plan":3,"febrero_real":1,"marzo_plan":10,"marzo_real":2,"abril_plan":16,"abril_real": 5,"mayo_plan":12,"mayo_real": 3,"junio_plan":23,"junio_real": 42}});
	data.push({id: 4, values: {"name":"Conway","firstname":"Coby","age":47,"height":1.96,"country":"za","email":"coby@conwayinc.com","freelance":true,"lastvisit":"01\/12\/2007"}});
 * */
