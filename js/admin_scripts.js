$(function() {
	convert_checkboxes();

	$(document).on('click', '.checkbox', function() {
		if ($(this).hasClass('checked')) {
			$(this).removeClass('checked');
			$(this).find('+input[type=checkbox]').removeAttr('checked');
		}
		else {
			$(this).addClass('checked');
			$(this).find('+input[type=checkbox]').attr('checked', 'checked');
		}
	});
	
	$(document).on('click', '.addRow', function() {
		htmlvar = $(this).attr('data-html');
		parents = $(this).attr('data-parents');
		if (
				htmlvar === undefined
			||
				window[htmlvar] === undefined
			||
				parents === undefined
			) return false;

		e = $(this);
		for (i=0;i<parents;i++) {
			e = e.parent();
		}
		$(e).after(window[htmlvar]);
		convert_checkboxes();
		return false;
	});

	$(document).on('click', '.removeRow', function() {
		parents = $(this).attr('data-parents');
		e = $(this);
		for (i=0;i<parents;i++) {
			e = e.parent();
		}
		e.remove();
		return false;
	});

	$('form').on('submit', function(v) {
		e = $('input[type=checkbox]').filter(':checked');
		for (i=0;i<e.length;i++) {
			console.log(e[i]);
			$(e[i]).find('+input[type=hidden][name="'+$(e[i]).attr('name')+'"]').remove();
		}
	});
});

function convert_checkboxes() {
	// Convert checkboxes
	checkboxes = $('input[type=checkbox]');
	checkbox = null;
	for (i=0; checkbox = checkboxes[i]; i++) {
		if ($(checkbox).css('display') == 'none') continue;
		$(checkbox).css({'display':'none'});
		checked = false;
		if ($(checkbox).filter(':checked').length) checked = true;
		$(checkbox).before('<div class="checkbox'+ (checked?' checked':'') +'"></div>');
	}
}