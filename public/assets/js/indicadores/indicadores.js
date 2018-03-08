oTemporalidad = new Object();	

var columnDefs = [
	{headerName: 'Indicador', field: 'Indicador', editable: false},
    {
        headerName: 'Temporalidad',
        field: 'Temporalidad',
        editable: true,
        cellEditor:'agSelectCellEditor',
        cellEditorParams: {
            values: ['Anual', 'Semestral', 'Anual']
        }
    },
    {
        headerName: 'Tipo',
        field: 'Tipo',
        editable: true,
        cellEditor:'agSelectCellEditor',
        cellEditorParams: {
            values: ['Acumulado', 'Minimo', 'Ultimo']
        }
    },
    {
        headerName: 'Pilar Estrategico',
        field: 'Pilar',
        editable: true,
        cellEditor:'agSelectCellEditor',
        cellEditorParams: {
            values: ['Desarrollo Institucional', 'Promocion de la Conciencia y Accion Social', 'Incidencia en Política']
        }
    },
    {
        headerName: 'Area',
        field: 'Area',
        editable: true,
        cellEditor:'agSelectCellEditor',
        cellEditorParams: {
            values: ['AFF', 'COM', 'DDF']
        }
    }
];

$.ajax({
	type: "POST",
	url: "/temporalidades/lista",
	dataType: "json",
	data: oTemporalidad,
	success: function(oTemporalidad)
	{	
		if(oTemporalidad['values'])
		{
			console.log(oTemporalidad['values']);
			
			columnDefs.forEach(function(o,i) {
				if(columnDefs[i].field == 'Temporalidad' )  {
					columnDefs[i].cellEditorParams.values = oTemporalidad['values']
				}
			})
			
		}
	}
});

function getRowData() 
{
    var rowData = [];
    for (var i = 0; i < 5; i++) 
    {
        rowData.push({Indicador: 'Toyota', Temporalidad: 'Celica', Tipo: 'Teste', Pilar: 'Sample 22', Area: 'Sample 23'});
    }

    return rowData;
}

var gridOptions = {
    components:{
        numericCellEditor: getNumericCellEditor()
    },
    columnDefs: columnDefs,
    rowData: getRowData(),
    editType: 'fullRow',
    onCellValueChanged: function(event) {
        console.log('onCellValueChanged: ' + event.colDef.field + ' = ' + event.newValue);
    },
    onRowValueChanged: function(event) {
        var data = event.data;
        console.log('onRowValueChanged: (' + data.make + ', ' + data.model + ', ' + data.price + ')');
    }
};

function onBtStopEditing() 
{
    gridOptions.api.stopEditing();
}

function onBtStartEditing() 
{
    gridOptions.api.setFocusedCell(2, 'make');
    gridOptions.api.startEditingCell({
        rowIndex: 2,
        colKey: 'make'
    });
}

function getNumericCellEditor() 
{
    function NumericCellEditor() {}

    NumericCellEditor.prototype.init = function(params) {
        this.focusAfterAttached = params.cellStartedEdit;
        this.eInput = document.createElement('input');
        this.eInput.style.width = '100%';
        this.eInput.style.height = '100%';
        this.eInput.value = isCharNumeric(params.charPress) ? params.charPress : params.value;

        var that = this;
        this.eInput.addEventListener('keypress', function(event) 
        {
            if (!isKeyPressedNumeric(event)) {
                that.eInput.focus();
                if (event.preventDefault) event.preventDefault();
            }
        });
    };

    NumericCellEditor.prototype.getGui = function() 
    {
        return this.eInput;
    };

    NumericCellEditor.prototype.afterGuiAttached = function() 
    {
        if (this.focusAfterAttached) {
            this.eInput.focus();
            this.eInput.select();
        }
    };

    NumericCellEditor.prototype.isCancelBeforeStart = function() 
    {
        return this.cancelBeforeStart;
    };
    
    NumericCellEditor.prototype.isCancelAfterEnd = function() {};

    NumericCellEditor.prototype.getValue = function() 
    {
        return this.eInput.value;
    };

    NumericCellEditor.prototype.focusIn = function() 
    {
        var eInput = this.getGui();
        eInput.focus();
        eInput.select();
        console.log('NumericCellEditor.focusIn()');
    };

    NumericCellEditor.prototype.focusOut = function() 
    {
        console.log('NumericCellEditor.focusOut()');
    };

    return NumericCellEditor;
}

function isCharNumeric(charStr) 
{
    return !!/\d/.test(charStr);
}

function isKeyPressedNumeric(event) 
{
    var charCode = getCharCodeFromEvent(event);
    var charStr = String.fromCharCode(charCode);
    return isCharNumeric(charStr);
}

function getCharCodeFromEvent(event) 
{
    event = event || window.event;
    return typeof event.which === 'undefined' ? event.keyCode : event.which;
}

document.addEventListener('DOMContentLoaded', function() 
{
    var eGridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(eGridDiv, gridOptions);
    gridOptions.api.sizeColumnsToFit();
});