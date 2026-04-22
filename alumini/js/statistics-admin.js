/* global jQuery */
(function ($) {
	'use strict';

	if (typeof String.prototype.replaceAll !== 'function') {
		String.prototype.replaceAll = function (search, replacement) {
			return this.split(search).join(replacement);
		};
	}

	function updateHiddenInput($box) {
		var ids = [];
		$box.find('.alumini-stats-selected .alumini-selected-item').each(function () {
			var id = parseInt($(this).attr('data-id'), 10);
			if (!isNaN(id)) {
				ids.push(id);
			}
		});
		$box.find('#alumini_selected_stats_input').val(ids.join(','));
		return ids;
	}

	function setAvailableSelectedState($box, ids) {
		var map = {};
		ids.forEach(function (id) {
			map[id] = true;
		});

		$box.find('.alumini-stats-available .alumini-stat-item').each(function () {
			var $item = $(this);
			var id = parseInt($item.attr('data-id'), 10);
			var isSelected = !!map[id];
			$item.toggleClass('is-selected', isSelected);
			$item.find('.alumini-stat-hint').text(isSelected ? 'Selected' : 'Click to add');
		});
	}

	function addSelectedItem($box, id, title) {
		var $selected = $box.find('.alumini-stats-selected');
		var currentIds = updateHiddenInput($box)
			.map(function (x) {
				return parseInt(x, 10);
			})
			.filter(function (x) {
				return !isNaN(x);
			});

		if (currentIds.indexOf(id) !== -1) {
			return;
		}

		if (currentIds.length >= 4) {
			window.alert('You can select up to 4 statistics.');
			return;
		}

		var $li = $('<li />', {
			'class': 'alumini-selected-item',
			'data-id': String(id),
			'css': {
				display: 'flex',
				justifyContent: 'space-between',
				gap: '10px',
				padding: '6px 8px',
				border: '1px solid #e5e5e5',
				background: '#fff',
				margin: '0 0 6px',
				cursor: 'move'
			}
		});

		$li.append($('<span />', { 'class': 'alumini-selected-title', text: title }));
		$li.append(
			$('<button />', {
				type: 'button',
				'class': 'button-link-delete alumini-remove-stat',
				'aria-label': 'Remove',
				text: 'Remove'
			})
		);

		$selected.append($li);

		var ids = updateHiddenInput($box);
		setAvailableSelectedState($box, ids);
	}

	function removeSelectedItem($box, id) {
		$box.find('.alumini-stats-selected .alumini-selected-item[data-id="' + String(id) + '"]').remove();
		var ids = updateHiddenInput($box);
		setAvailableSelectedState($box, ids);
	}

	function initStatsBox($box) {
		$box.find('.alumini-color-field').wpColorPicker();

		var $selected = $box.find('.alumini-stats-selected');
		$selected.sortable({
			items: '.alumini-selected-item',
			handle: '.alumini-selected-title, .alumini-selected-item',
			placeholder: 'alumini-sort-placeholder',
			update: function () {
				var ids = updateHiddenInput($box);
				setAvailableSelectedState($box, ids);
			}
		});

		$box.on('click', '.alumini-stats-available .alumini-stat-item', function (e) {
			e.preventDefault();
			var $item = $(this);
			var id = parseInt($item.attr('data-id'), 10);
			if (isNaN(id)) {
				return;
			}
			if ($item.hasClass('is-selected')) {
				return;
			}
			addSelectedItem($box, id, $item.attr('data-title') || $item.text());
		});

		$box.on('click', '.alumini-remove-stat', function (e) {
			e.preventDefault();
			var $li = $(this).closest('.alumini-selected-item');
			var id = parseInt($li.attr('data-id'), 10);
			if (isNaN(id)) {
				return;
			}
			removeSelectedItem($box, id);
		});

		$box.on('input', '.alumini-stats-search', function () {
			var q = String($(this).val() || '').toLowerCase();
			$box.find('.alumini-stats-available .alumini-stat-item').each(function () {
				var $item = $(this);
				var title = String($item.attr('data-title') || '').toLowerCase();
				var match = !q || title.indexOf(q) !== -1;
				$item.toggle(match);
			});
		});

		var ids = updateHiddenInput($box);
		setAvailableSelectedState($box, ids);
	}

	function initGenericPicker($root) {
		var max = parseInt($root.attr('data-max') || '3', 10);
		if (isNaN(max) || max < 1) {
			max = 3;
		}

		function getIds() {
			var ids = [];
			$root.find('.alumini-post-selected .alumini-selected-item').each(function () {
				var id = parseInt($(this).attr('data-id'), 10);
				if (!isNaN(id)) {
					ids.push(id);
				}
			});
			return ids;
		}

		function updateHidden() {
			var inputId = $root.attr('data-selected-input');
			if (!inputId) {
				return;
			}
			$('#' + inputId).val(getIds().join(','));
		}

		function setAvailableState(ids) {
			var map = {};
			ids.forEach(function (id) {
				map[id] = true;
			});
			$root.find('.alumini-post-available .alumini-post-item').each(function () {
				var $item = $(this);
				var id = parseInt($item.attr('data-id'), 10);
				var isSelected = !!map[id];
				$item.toggleClass('is-selected', isSelected);
				$item.find('.alumini-post-hint').text(isSelected ? 'Selected' : 'Click to add');
			});
		}

		function addItem(id, title) {
			var ids = getIds();
			if (ids.indexOf(id) !== -1) {
				return;
			}
			if (ids.length >= max) {
				window.alert('Maximum ' + String(max) + ' items allowed.');
				return;
			}

			var $li = $('<li />', {
				'class': 'alumini-selected-item',
				'data-id': String(id),
				'css': {
					display: 'flex',
					justifyContent: 'space-between',
					gap: '10px',
					padding: '6px 8px',
					border: '1px solid #e5e5e5',
					background: '#fff',
					margin: '0 0 6px',
					cursor: 'move'
				}
			});
			$li.append($('<span />', { 'class': 'alumini-selected-title', text: title }));
			$li.append(
				$('<button />', {
					type: 'button',
					'class': 'button-link-delete alumini-remove-item',
					'aria-label': 'Remove',
					text: 'Remove'
				})
			);
			$root.find('.alumini-post-selected').append($li);

			ids = getIds();
			updateHidden();
			setAvailableState(ids);
		}

		function removeItem(id) {
			$root.find('.alumini-post-selected .alumini-selected-item[data-id="' + String(id) + '"]').remove();
			var ids = getIds();
			updateHidden();
			setAvailableState(ids);
		}

		$root.find('.alumini-post-selected').sortable({
			items: '.alumini-selected-item',
			handle: '.alumini-selected-title, .alumini-selected-item',
			update: function () {
				var ids = getIds();
				updateHidden();
				setAvailableState(ids);
			}
		});

		$root.on('click', '.alumini-post-available .alumini-post-item', function (e) {
			e.preventDefault();
			var $item = $(this);
			if ($item.hasClass('is-selected')) {
				return;
			}
			var id = parseInt($item.attr('data-id'), 10);
			if (isNaN(id)) {
				return;
			}
			addItem(id, $item.attr('data-title') || $item.text());
		});

		$root.on('click', '.alumini-remove-item', function (e) {
			e.preventDefault();
			var $li = $(this).closest('.alumini-selected-item');
			var id = parseInt($li.attr('data-id'), 10);
			if (isNaN(id)) {
				return;
			}
			removeItem(id);
		});

		$root.on('input', '.alumini-post-search', function () {
			var q = String($(this).val() || '').toLowerCase();
			$root.find('.alumini-post-available .alumini-post-item').each(function () {
				var $item = $(this);
				var title = String($item.attr('data-title') || '').toLowerCase();
				$item.toggle(!q || title.indexOf(q) !== -1);
			});
		});

		var ids = getIds();
		updateHidden();
		setAvailableState(ids);
	}

	$(function () {
		// Enable WP color picker (with Clear button) for all fields.
		$('.alumini-color-field').each(function () {
			var $field = $(this);
			if (typeof $field.wpColorPicker === 'function') {
				$field.wpColorPicker();
			}
		});

		// Statistics meta box behaviors (pick/search/sort).
		var $box = $('#alumini_stats_section');
		if ($box.length) {
			initStatsBox($box);
		}

		// Generic pickers (case studies, future sections).
		$('.alumini-post-picker').each(function () {
			initGenericPicker($(this));
		});

		// Benefits repeater.
		$(document).on('click', '.alumini-add-benefit', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.alumini-benefits-repeater');
			var $items = $wrap.find('.alumini-benefits-items');
			var index = $items.find('.alumini-benefit-item').length;

			var tmpl = $('#tmpl-alumini-benefit-item').html() || '';
			tmpl = tmpl.replaceAll('__INDEX__', String(index));
			tmpl = tmpl.replaceAll('__INDEX_LABEL__', String(index + 1));
			$items.append(tmpl);
		});

		$(document).on('click', '.alumini-remove-benefit', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.alumini-benefits-repeater');
			$(this).closest('.alumini-benefit-item').remove();

			// Re-index names to keep PHP array clean.
			$wrap.find('.alumini-benefit-item').each(function (i) {
				var $item = $(this);
				$item.find('.alumini-benefit-index').text(String(i + 1));

				$item.find('input, textarea').each(function () {
					var $field = $(this);
					var name = $field.attr('name') || '';
					name = name.replace(/benefits_items\[\d+\]/, 'benefits_items[' + String(i) + ']');
					$field.attr('name', name);
				});
			});
		});

		// Next section: description blocks repeater (HTML allowed).
		$(document).on('click', '.alumini-add-next-desc', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.alumini-next-desc-repeater');
			var $items = $wrap.find('.alumini-next-desc-items');
			var index = $items.find('.alumini-next-desc-item').length;

			var tmpl = $('#tmpl-alumini-next-desc-item').html() || '';
			tmpl = tmpl.replaceAll('__INDEX__', String(index));
			tmpl = tmpl.replaceAll('__INDEX_LABEL__', String(index + 1));
			$items.append(tmpl);
		});

		$(document).on('click', '.alumini-remove-next-desc', function (e) {
			e.preventDefault();
			var $wrap = $(this).closest('.alumini-next-desc-repeater');
			$(this).closest('.alumini-next-desc-item').remove();

			$wrap.find('.alumini-next-desc-item').each(function (i) {
				var $item = $(this);
				$item.find('.alumini-next-desc-index').text(String(i + 1));
				$item.find('textarea').each(function () {
					var $field = $(this);
					var name = $field.attr('name') || '';
					name = name.replace(/next_desc_items\[\d+\]/, 'next_desc_items[' + String(i) + ']');
					$field.attr('name', name);
				});
			});
		});

		// Case study: show/hide Video URL field based on taxonomy selection.
		function toggleCaseStudyVideoField() {
			var $wrap = $('.alumini-casestudy-video-fields');
			if (!$wrap.length) {
				return;
			}
			var termId = parseInt($wrap.attr('data-video-term-id') || '0', 10);
			var termSlug = String($wrap.attr('data-video-term-slug') || '').toLowerCase();
			var termLabel = String($wrap.attr('data-video-term-label') || 'Video casestudy').toLowerCase();

			function hasCheckedTerm() {
				// 1) Most common: checkbox value is term ID.
				if (termId) {
					var selector = 'input[type="checkbox"][value="' + String(termId) + '"]';
					if ($(selector).is(':checked')) {
						return true;
					}
				}

				// 2) Some UIs use slug in value.
				if (termSlug) {
					var slugSel = 'input[type="checkbox"][value="' + termSlug + '"]';
					if ($(slugSel).is(':checked')) {
						return true;
					}
				}

				// 3) Gutenberg panel: match by visible label text.
				var found = false;
				$('input[type="checkbox"]:checked').each(function () {
					var $cb = $(this);
					var txt = '';
					var $label = $cb.closest('label');
					if ($label.length) {
						txt = $label.text();
					} else {
						var $next = $cb.next();
						if ($next.length) {
							txt = $next.text();
						}
					}
					txt = String(txt || '').trim().toLowerCase();
					if (txt && txt.indexOf(termLabel) !== -1) {
						found = true;
						return false;
					}
					return true;
				});
				return found;
			}

			var checked = hasCheckedTerm();
			$wrap.toggle(checked);
			$('.alumini-casestudy-video-note').toggle(!checked);
		}

		// Gutenberg often injects "Meta Boxes" after DOM ready.
		// Re-run the toggle for a short time to catch late-rendered UI.
		toggleCaseStudyVideoField();
		var attempts = 0;
		var timer = window.setInterval(function () {
			attempts += 1;
			toggleCaseStudyVideoField();
			if (attempts >= 20) {
				window.clearInterval(timer);
			}
		}, 500);

		// React sidebar interactions don't always fire 'change' reliably.
		$(document).on('change click', 'input[type="checkbox"], label', function () {
			toggleCaseStudyVideoField();
		});
	});
})(jQuery);

