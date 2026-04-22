jQuery(document).ready(function ($) {

    // ===============================
    // IMAGE UPLOADER
    // ===============================
    $(document).on('click', '.upload_image_button', function (e) {
        e.preventDefault();

        let button = $(this);
        let input = button.prev('input');

        let custom_uploader = wp.media({
            title: 'Select Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        custom_uploader.on('select', function () {
            let attachment = custom_uploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
        });

        custom_uploader.open();
    });


    // ===============================
    // STATS SECTION (MAX 4)
    // ===============================
    let maxStats = 4;

    function updateStatsInput() {
        let ids = [];
        $('#selected-stats li').each(function () {
            ids.push($(this).data('id'));
        });
        $('#selected_stats_input').val(ids.join(','));
    }

    $(document).on('change', '.stat-checkbox', function () {

        let id = $(this).val();
        let text = $(this).parent().text().trim();

        if ($(this).is(':checked')) {

            if ($('#selected-stats li').length >= maxStats) {
                alert('Maximum 4 items allowed');
                $(this).prop('checked', false);
                return;
            }

            $('#selected-stats').append(
                `<li data-id="${id}">
                    ${text}
                    <span class="remove-stat" style="float:right;cursor:pointer;">×</span>
                </li>`
            );

        } else {
            $('#selected-stats li[data-id="' + id + '"]').remove();
        }

        updateStatsInput();
    });

    $(document).on('click', '.remove-stat', function () {
        let li = $(this).closest('li');
        let id = li.data('id');

        $('.stat-checkbox[value="' + id + '"]').prop('checked', false);
        li.remove();

        updateStatsInput();
    });

    $('#selected-stats').sortable({
        update: updateStatsInput
    });


    // ===============================
    // QUICK LINKS (MAX 3)
    // ===============================
    let maxLinks = 3;

    function updateQuickLinksInput() {
        let ids = [];
        $('#selected-quicklinks li').each(function () {
            ids.push($(this).data('id'));
        });
        $('#selected_quicklinks_input').val(ids.join(','));
    }

    $('#available-quicklinks').on('click', 'li', function () {

        let id = $(this).data('id');
        let text = $(this).text();

        if ($('#selected-quicklinks li[data-id="' + id + '"]').length) return;

        if ($('#selected-quicklinks li').length >= maxLinks) {
            alert('Max 3 links allowed');
            return;
        }

        $('#selected-quicklinks').append(
            `<li data-id="${id}">
                ${text}
                <span class="remove-link" style="float:right;cursor:pointer;color:red;">×</span>
            </li>`
        );

        updateQuickLinksInput();
    });

    $(document).on('click', '.remove-link', function () {
        $(this).closest('li').remove();
        updateQuickLinksInput();
    });

    $('#selected-quicklinks').sortable({
        update: updateQuickLinksInput
    });
    // PROSPECTUS (ONLY ONE)
$('#available-prospectus').on('click', 'li', function () {

    let id = $(this).data('id');
    let text = $(this).text();

    $('#selected-prospectus').html(
        `<li data-id="${id}">
            ${text}
            <span class="remove-prospectus" style="float:right;cursor:pointer;">×</span>
        </li>`
    );

    $('#selected_prospectus_input').val(id);
});

$(document).on('click', '.remove-prospectus', function () {
    $('#selected-prospectus').empty();
    $('#selected_prospectus_input').val('');
});

});