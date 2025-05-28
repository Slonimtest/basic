$(function () {
    $('#shorten-form').on('submit', function (e) {
        e.preventDefault();
        let url = $('#url-input').val();
        $.post('index.php?r=site/shorten', { url: url }, function (response) {
            if (response.success) {
                $('#result').html(
                    `<p>Короткая ссылка: <a href="${response.short_link}" target="_blank">${response.short_link}</a></p>
                     <p><img src="${response.qr}" alt="QR Code"></p>`
                );
            } else {
                $('#result').html(`<p class="text-danger">${response.message}</p>`);
            }
        });
    });
});