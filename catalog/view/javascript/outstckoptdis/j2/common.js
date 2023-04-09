var outstckoptdis = {
	'prodpage': function(json) {
		$('#product option').each(function(){
			var povid = $(this).val().toString();
			if (json['povids'][povid]) {	
				$(this).attr('disabled','disabled');					
			}	
		}); 
		$('#product input[type=\'checkbox\'], #product input[type=\'radio\']').each(function(){
			var povid = $(this).val().toString();
			if (json['povids'][povid]) {
				$(this).attr('disabled','disabled');	
				$(this).parent().css({"pointer-events": "none", "opacity": "0.7"});				
			}	
		});
	},
	'initjson': function() {
		var product_id = false;
		if($("#product input[name='product_id']").length) {
			product_id = $("input[name='product_id']").val();
		}
 		if (product_id) {
			$.ajax({
				url: 'index.php?route=extension/outstckoptdis/getdata',
				type: 'post',
				data: 'product_id=' + product_id,
				dataType: 'json',
				cache: true,
				success: function(json) {
					if(json && json['disopt'] == 1) {
 						outstckoptdis.prodpage(json);
						$(document).ajaxStop(function(){ 
							outstckoptdis.prodpage(json);
						});
					}
				}
			});
		}
	}
}
$(document).ready(function() {
	outstckoptdis.initjson();
});