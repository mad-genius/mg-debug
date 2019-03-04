(function( $ ) {
	'use strict';

	$(function() {

		$('.mg-debug-frame iframe').load(function() {
			var $iframe = $(this);
			var $iframeBody = $iframe.contents().find('body');

			// watch all iframes for resize
			debugLogSyncHeight( $iframe, $iframeBody );

			$iframe.css('height', $iframeBody.outerHeight('true'));
			//setElementHeightWithDelay($iframe, $iframeBody, 0);

			$iframeBody.click(function() {
				$iframe.css('height', $(this).outerHeight('true'));
				//setElementHeightWithDelay($iframe, $(this));
			});
		});

		$('[data-delete-log]').click(function() {
			var filename = $(this).attr('data-delete-log');
			$.post('/wp-admin/admin-ajax.php', {
				action: 'mg_debug_delete_single_log',
				filename: filename
			}, function(response) {
				if(response === 'true') return window.location.reload();
				alert('Something went wrong. Reload the page and try again.');
			});
		});

		$('[data-clear-logs]').click(function() {
			var proceed = confirm('Are you sure? This will delete all of the MG Debug logs.');
			if(! proceed) return;

			$.post('/wp-admin/admin-ajax.php', {
				action: 'mg_debug_delete_all_logs',
			}, function(response) {
				if(response === 'true') {
					return window.location.reload();
				} else {
					alert('Something went wrong. Reload the page and try again.');
				}
			});
		});

	});

	function debugLogSyncHeight($el, $innerEl) {
		setInterval(() => {
			var height = $innerEl.outerHeight(true);
			if(height !== $el.css('height')) {
				$el.css('height', height);
			}
		}, 100);
	}

	function setElementHeightWithDelay($el, $innerEl, delay = 300) {
		setTimeout(() => {
			var height = $innerEl.outerHeight(true);
			console.log('setting height', height)
			$el.css('height', height);
		}, delay);
	}

})( jQuery );
