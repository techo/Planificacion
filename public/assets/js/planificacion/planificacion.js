window.onload = function() 
{
	var metadata = [];
	var data = [];
	oData   = new Object();	
	oResult = new Object();
	oData.id   = $('#id').val();
	oResult.id = $('#id').val();
	
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
	  
	  		event = event || window.event;
	  		
	  		if (event.keyCode == 13 || event.keyCode == 9) {
	  			this.onblur = null; 
	  			this.celleditor.applyEditing(this.element, this.celleditor.getEditorValue(this));
	  		
	  		var linha  = (this.celleditor['editablegrid']['lastSelectedRowIndex']);
	  		var coluna = (this.celleditor['column']['name']);
	  		var id     = (this.celleditor['editablegrid']['data'][linha]['id']);
	  		var valor  = (this.celleditor.getEditorValue(this));
	  		
	  		//Implementar Update de Dados
	  		
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
