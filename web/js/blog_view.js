$(document).on('submit', '#postCommentForm', function (e) {
        e.preventDefault();
        let currentForm = $('#postCommentForm');
        $.ajax({
            success: function(response) {
                currentForm.trigger("reset");
            },
            type: 'post',
            url: currentForm.attr('action'),
            data: currentForm.serialize(),
            cache: false,
            dataType: 'html'
        });
});