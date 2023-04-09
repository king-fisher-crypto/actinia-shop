/*
  Project: Ka Extensions
  Author : karapuz <support@ka-station.com>

  Version: 4 ($Revision: 245 $)

*/

(function ($) {

	if (!$.ka) {
		$.ka = {};
	}

    $.ka.alert = function(text, type) {
	
		var style = 'info';

		if (type) {
			if (type == 'D' || type == 'E') {
				style = 'danger';
			} else if (type == 'S') {
				style = 'success';
			} else if (type == 'W') {
				style = 'warning';
			}
		} 

		var msg = "";
		msg += '<div style="padding-top: 200px" id="ka_alert_window" class="modal fade" role="dialog">';
		msg += '<div class="modal-dialog modal-md">';
		msg += '<div class="modal-content">';
		
		msg += '<div class="modal-header alert-' + style + '">';
		msg += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		msg += '</div>';				
		msg += '<div class="modal-body alert-' + style + '">';
		if (style == 'danger') {
			msg += '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;';
		} else if (style == 'success') {
			msg += '<i class="fa fa-check-circle"></i>';
		}
		
		msg += text;
		msg += '</div>';

		msg += '</div>';
		msg += '</div>';
		msg += '</div>';

		if (!$('#ka_alert_window').length) {
			$('body').append(msg);
			$('#ka_alert_window').modal('show');
			
			$('#ka_alert_window').on('hidden.bs.modal', function (e) {
				$('#ka_alert_window').remove();
			});				
		}
				
        return this;
    };
 
}(jQuery));