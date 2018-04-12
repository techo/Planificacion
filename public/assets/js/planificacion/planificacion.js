 $("#grid").shieldGrid({
            dataSource: {
                remote: {
                    read: "/products",
                    modify: {
                        create: {
                            url: "/products/productCreate",
                            type: "post",
                            data: function (edited) {
                                var date = edited[0].data.AddedOn ? edited[0].data.AddedOn.toJSON() : new Date().toJSON();
                                return {
                                    Active: edited[0].data.Active,
                                    AddedOn: date,
                                    Category: edited[0].data.Category,
                                    Name: edited[0].data.Name,
                                    Price: edited[0].data.Price,
                                    Id: edited[0].data.Id
                                };
                            }
                        },
                        update: {
                            url: "/products/productUpdate",
                            type: "post",
                            data: function (edited) {
                                var date = edited[0].data.AddedOn ? edited[0].data.AddedOn.toJSON() : new Date().toJSON();
                                return { 
                                    Active: edited[0].data.Active,
                                    AddedOn: date,
                                    Category: edited[0].data.Category,
                                    Name: edited[0].data.Name,
                                    Price: edited[0].data.Price,
                                    Id: edited[0].data.Id
                                };
                            }
                        },
                        remove: {
                            url: "/products/productRemove",
                            type: "post",
                            data: function (removed) {
                                return { id: removed[0].data.Id };
                            }
                        }
                    }
                },
                schema: {
                    fields: {
                    	indicador: { path: "indicador", type: String },
                    	enero_plan: { path: "enero_plan", type: String },
                    	enero_real: { path: "enero_real", type: String },
                    	febrero_plan: { path: "febrero_plan", type: String },
                    	febrero_real: { path: "febrero_real", type: String },
                    	marzo_plan: { path: "marzo_plan", type: String },
                    	marzo_real: { path: "marzo_real", type: String },
                    	abril_plan: { path: "abril_plan", type: String },
                    	abril_real: { path: "abril_real", type: String },
                    	mayo_plan: { path: "mayo_plan", type: String },
                    	mayo_real: { path: "mayo_real", type: String },
                    	junio_plan: { path: "junio_plan", type: String },
                    	junio_real: { path: "junio_real", type: String },
                    	julio_plan: { path: "julio_plan", type: String },
                    	julio_real: { path: "julio_real", type: String },
                    	agosto_plan: { path: "agosto_plan", type: String },
                    	agosto_real: { path: "agosto_real", type: String },
                    	septiembre_plan: { path: "septiembre_plan", type: String },
                    	septiembre_real: { path: "septiembre_real", type: String },
                    	octubre_plan: { path: "octubre_plan", type: String },
                    	octubre_real: { path: "octubre_real", type: String },
                    	noviembre_plan: { path: "noviembre_plan", type: String },
                    	noviembre_real: { path: "noviembre_real", type: String },
                    	diciembre_plan: { path: "diciembre_plan", type: String },
                    	diciembre_real: { path: "diciembre_real", type: String },
                    }
                }
            },
            rowHover: false,
            columns: [
            	{ field: "indicador", title: "Indicador", width: "450px", editable: false },
                { field: "enero_plan", title: "01 Plan", width: "50px" },
                { field: "enero_real", title: "01 Real", width: "50px" },
                { field: "febrero_plan", title: "02 Plan", width: "50px" },
                { field: "febrero_real", title: "02 Real", width: "50px" },
                { field: "marzo_plan", title: "03 Plan", width: "50px" },
                { field: "marzo_real", title: "03 Real", width: "50px" },
                { field: "abril_plan", title: "04 Plan", width: "50px" },
                { field: "abril_real", title: "04 Real", width: "50px" },
                { field: "mayo_plan", title: "05 Plan", width: "50px" },
                { field: "mayo_real", title: "05 Real", width: "50px" },
                { field: "junio_plan", title: "06 Plan", width: "50px" },
                { field: "junio_real", title: "06 Real", width: "50px" },
                { field: "julio_plan", title: "07 Plan", width: "50px" },
                { field: "julio_real", title: "07 Real", width: "50px" },
                { field: "agosto_plan", title: "08 Plan", width: "50px" },
                { field: "agosto_real", title: "08 Real", width: "50px" },
                { field: "septiembre_plan", title: "09 Plan", width: "50px" },
                { field: "septiembre_real", title: "09 Real", width: "50px" },
                { field: "octubre_plan", title: "10 Plan", width: "50px" },
                { field: "octubre_real", title: "10 Real", width: "50px" },
                { field: "noviembre_plan", title: "11 Plan", width: "50px" },
                { field: "noviembre_real", title: "11 Real", width: "50px" },
                { field: "diciembre_plan", title: "12 Plan", width: "50px" },
                { field: "diciembre_real", title: "12 Real", width: "50px" }
            ],
            editing: {
                enabled: true,
                event: "click",
                type: "cell",
                confirmation: {
                    "delete": {
                        enabled: true,
                        template: function (item) {
                            return "Delete row with ID = " + item.Id
                        }
                    }
                }
            }
        });