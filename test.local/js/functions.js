/*
 * js functions
 **/

(function($) {
    /************************ Public functions - begin ************************/    
	$.da = {};
	
    $.da.orders = {
		ordersGridXML: null,
        menuGridXML: null,
		ordersGrid: null,
		menuGrid: null,
		
		doInitGrids: function()
		{
			__doInitOrdersGrid();
			__doInitMenuGrid();
			__initOrdersButtons();
		},
		
		deleteOrder: function(){
			__removeRow();			
		},
		
		refreshAmount: function(){
			$('#user-total').load('ajax.php?action=get-total-amount&order_data='+$('#order_data').val());
		}
    };
    
    /**************************** Private functions ****************************/ 
    function __initOrdersButtons(){
		$('input.submitOrder').live('click', function(){
			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { action: 'add-order', menuid: $(this).attr('id'), order_data: $('#order_data').val()},
				success: function(response, code)
				{
					//document.location.reload();
					ordersGrid.updateFromXML($.da.orders.ordersGridXML);					
				},
				error:  function(xhr, str) {}
            });
		});
	}
		
    function __doInitOrdersGrid(){	 
		$.da.orders.ordersGridXML = "data/order.php?order_data="+$('#order_data').val();
		ordersGrid = new dhtmlXGridObject('ordersGrid_container');			
		ordersGrid.setImagePath("js/lib/imgs/");
		ordersGrid.setHeader("Наименование,Состав,Цена (грн.)");				
		ordersGrid.setInitWidths("110,317,50");	
		ordersGrid.setColAlign("left,left,right");
		ordersGrid.setColTypes("txt,txt,txt");
		ordersGrid.enableTooltips("false,false,false");		
		ordersGrid.enableMultiline(true);		
		ordersGrid.setSkin("light");	
		ordersGrid.init();
		ordersGrid.loadXML($.da.orders.ordersGridXML);		
		var dp = new dataProcessor('data/update.php');
		dp.init(ordersGrid);			
	}
	
	function __doInitMenuGrid(){
        $.da.orders.menuGridXML = "menu.xml";//data/menu.php?order_data="+$('#order_data').val();
		menuGrid = new dhtmlXGridObject('menuGrid_container');
			
		menuGrid.setImagePath("js/lib/imgs/");		 
		menuGrid.setHeader("Наименование,Состав,Цена (грн.)");		 
		menuGrid.setInitWidths("110,317,50");		 
		menuGrid.setColAlign("left,left,right");
		menuGrid.setColTypes("ro,ro,ro");
		menuGrid.attachEvent("onRowDblClicked",__doOnRowDblClicked);
        menuGrid.attachEvent("onRowSelect",__doOnRowSelected);
		menuGrid.setSkin("light");	
		menuGrid.enableMultiselect(true);
		menuGrid.enableMultiline(true);
		menuGrid.init();
		menuGrid.loadXML($.da.orders.menuGridXML);		
		//var dp = new dataProcessor('test.php');
		//dp.init(menuGrid);			
	}
	
	function __addRow(){
		var newId = (new Date()).valueOf()
		ordersGrid.addRow(newId,"",ordersGrid.getRowsNum())
		ordersGrid.selectRow(ordersGrid.getRowIndex(newId),false,false,true);
	}
    
	function __removeRow(){
		var selId = ordersGrid.getSelectedId()
		ordersGrid.deleteRow(selId);
	}
	
    function __doOnRowDblClicked(rowID,celInd){
        var add_value = menuGrid.cellByIndex(menuGrid.getRowIndex(rowID),0).getValue();
        ordersGrid.cellByIndex(0,$('select#date').val()-1).setValue(add_value);		
        menuGrid.clearSelection();        
    }
    
	function __doOnRowSelected(rowID,celInd){
        var title = menuGrid.cellByIndex(menuGrid.getRowIndex(rowID),0).getValue();
        var info = menuGrid.cellByIndex(menuGrid.getRowIndex(rowID),1).getValue();
        var price = menuGrid.cellByIndex(menuGrid.getRowIndex(rowID),2).getValue();
        var html = '<br/><br/><b>Детальная информация:</b><br/><u>' + title + '</u> - <b>' + price + 'грн.</b><br>' + info + '<br><input type="button" class="submitOrder" id="' + rowID + '" value="Добавить к заказу">';
        $("#order_info").html(html);
	   
	}
	
	function __f(){
		ordersGrid.cellByIndex(1,1).setValue('dd');
	}   
    
 })(jQuery);