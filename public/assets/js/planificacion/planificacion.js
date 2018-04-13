window.onload = function() 
{
	var metadata = [];
	oData = new Object();	
	oData.id   = $('#id').val();	
	
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
				
				var data = [];
				data.push({id: 1, values: {"indicador":"%CEF - Porcentaje de Cobertura de Egresos Fijos","enero_plan":2,"enero_real":1,"febrero_plan":3,"febrero_real":1,"marzo_plan":10,"marzo_real":2,"abril_plan":16,"abril_real": 5,"mayo_plan":12,"mayo_real": 3,"junio_plan":23,"junio_real": 42}});
				data.push({id: 4, values: {"name":"Conway","firstname":"Coby","age":47,"height":1.96,"country":"za","email":"coby@conwayinc.com","freelance":true,"lastvisit":"01\/12\/2007"}});
				data.push({id: 5, values: {"name":"Shannon","firstname":"Rana","age":24,"height":1.56,"country":"nl","email":"ranna.shannon@hotmail.com","freelance":false,"lastvisit":"07\/10\/2009"}});
				data.push({id: 6, values: {"name":"Benton","firstname":"Jasmine","age":61,"height":1.71,"country":"ca","email":"jasmine.benton@yahoo.com","freelance":false,"lastvisit":"13\/01\/2009"}});
				data.push({id: 7, values: {"name":"Belletoise","firstname":"André","age":31,"height":1.84,"country":"be","email":"belletoise@kiloutou.be","freelance":true,"lastvisit":""}});
				data.push({id: 15, values: {"name":"Santa-Maria","firstname":"Martin","age":37,"height":1.80,"country":"br","email":"martin.sm@gmail.com","freelance":false,"lastvisit":"12\/06\/1995"}});
				data.push({id: 30, values: {"name":"Dieumerci","firstname":"Amédé","age":37,"height":1.81,"country":"ng","email":"dieumerci@gmail.com","freelance":true,"lastvisit":"05\/07\/2009"}});
				data.push({id: 50,values: {"name":"Morin","firstname":"Wanthus","age":46,"height":1.77,"country":"zw","email":"morin.x@yahoo.jsdata.com","freelance":false,"lastvisit":"04\/03\/2004"}});
				 
				editableGrid = new EditableGrid("DemoGridJsData");
				editableGrid.load({"metadata": metadata, "data": data});
				editableGrid.renderGrid("tablecontent", "testgrid");
			}
			else
			{
				
			}
		}
	});
	
	CellEditor.prototype.edit = function(rowIndex, columnIndex, element, value) 
	{
		
	  	// tag element and remember all the things we need to apply/cancel edition
	  	element.isEditing = true;
	  	element.rowIndex = rowIndex; 
	  	element.columnIndex = columnIndex;
	  	
	  	// call the specialized getEditor method
	  	var editorInput = this.getEditor(element, value);
	  	if (!editorInput) return false;
	  	
	  	// give access to the cell editor and element from the editor widget
	  	editorInput.element = element;
	  	editorInput.celleditor = this;
	  
	  	// listen to pressed keys
	  	// - tab does not work with onkeyup (it's too late)
	  	// - on Safari escape does not work with onkeypress
	  	// - with onkeydown everything is fine (but don't forget to return false)
	  	editorInput.onkeydown = function(event) {
	  
	  		event = event || window.event;
	  		
	  		// ENTER or TAB: apply value
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
	  
	  	// if simultaneous edition is not allowed, we cancel edition when focus is lost
	  	if (!this.editablegrid.allowSimultaneousEdition) editorInput.onblur = this.editablegrid.saveOnBlur ?
	  			function(event) { this.onblur = null; this.celleditor.applyEditing(this.element, this.celleditor.getEditorValue(this)); } :
	  			function(event) { this.onblur = null; this.celleditor.cancelEditing(this.element); };
	  
	  	// display the resulting editor widget
	  	this.displayEditor(element, editorInput);
	  	
	  	// give focus to the created editor
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
	
 * */

