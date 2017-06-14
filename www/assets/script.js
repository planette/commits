/**!*/
;(function (window, $) {

	$.fn.collapse.Constructor.TRANSITION_DURATION = 0;

	$(function () {

		var spinner = $('#spinner');

		$.nette.ext('spinner', {
			start: function () {
				spinner.show();
			},

			complete: function () {
				spinner.hide();
			}
		});

		$.nette.ext('clipboard', {
			load: function () {
				$('[data-clipboard-text]').each(function () {
					var btn = $(this);
					var origTitle = btn.attr('title');
					var clipboard = new ClipboardJS(this);

					clipboard.on('success', function (event) {
						btn.attr('title', 'Copied!')
							.tooltip('fixTitle')
							.tooltip('show')
							.attr('title', origTitle)
							.tooltip('fixTitle');
					});
				});
			}
		});

		// tooltips intentionally after clipboard since tooltips remove title
		// attribute which is needed at clipboard instantiation
		$.nette.ext('tooltips', {
			load: function () {
				$('.tooltip').remove();

				$('[title]').tooltip({
					animation: false,
					container: 'body'
				});
			}
		});

		$.nette.ext('filters', {
			success: function (payload, status, jqXHR, settings) {
				if (settings.nette && settings.nette.el) {
					var name = settings.nette.el.attr('name');

					if (name && name.indexOf('filters[buttons]') !== -1) {
						$('#commits-header').collapse('hide');
					}
				}
			}
		});

		$.nette.ext('pagination', {
			success: function (payload, status, jqXHR, settings) {
				if (settings.nette && settings.nette.el) {
					var href = settings.nette.el.attr('href');

					if (href && href.indexOf('paginate') !== -1) {
						window.scrollTo(0, 0);
					}
				}
			}
		});

		$.nette.init();

	});

})(window, window.jQuery);
