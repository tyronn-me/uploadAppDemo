/*
A norification plugin built by Tyron Hayman used to notify the front end of actions preformed while useing the system.
*/
(function($) {

	$.extend({
        notify: function (options) {

    	var settings = $.extend({
				text : "This is a notification",
				status : "default",
				timeout : false
			}, options);

			var notification = $('<div class="toast" style="position: absolute; top: 0; right: 0;"><div class="toast-header"><strong class="mr-auto">Bannermen</strong><small>Now</small><button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">' + settings.text + '</div></div></div>');


			$("body").append(notification);

			return this;

        }
    });

  })(jQuery);
