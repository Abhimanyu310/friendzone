$('.add-comment').on('click', function(event) {
    event.preventDefault();
    var formElement = event.target.parentNode;
    var postIdElement = formElement.parentNode;
    var postId = postIdElement.dataset['postid'];
    $.ajax({
            method: 'POST',
            url: urlAddComment,
            data: {body: $('#comment-body'+postId).val(), postId: postId, _token: token}
        })
        .done(function(comment) {
            $('#comment-body'+postId).val('');
            var new_comment = '<hr><div class="media"><div class="pull-left">';
            new_comment += '<img class="media-object img-circle" src="http://placehold.it/64x64" alt="">';
            new_comment += '</div><div class="media-body"><p>';
            new_comment += '<a href='+urlAuthUserProfile+'>';
            new_comment += comment.first_name + ' ' + comment.last_name + ' </a>';
            new_comment += comment.body;
            new_comment += '<div class="info" data-commentid="' + comment.id + '">';
            new_comment += '<small class="delete-this" class="delete-comment">';
            new_comment += '<a href="" class="delete-comment">Delete</a></small>';
            new_comment += '<small class="pull-right text-muted">' + comment.created_at + '</small>'
            new_comment += '</p></div></div>';
            var animated_comment = $(new_comment).hide().fadeIn(500);
            $(formElement).append(animated_comment);
        });
});




// delegated events. Since .post-comments was present at the time DOM was loaded, it handles this event..as
// all the events bubble up to it.
$('.post-comments').on('click', '.delete-comment', function(event) {
    event.preventDefault();
    var commentIdElement = event.target.parentNode.parentNode;
    var commentId = commentIdElement.dataset['commentid'];
    var commentElement = commentIdElement.parentNode.parentNode;
    $.ajax({
            method: 'POST',
            url: urlDeleteComment,
            data: {commentId: commentId, _token: token}
        })
        .done(function() {
            $(commentElement).fadeOut(500, function() {
                commentElement.previousElementSibling.remove();
                commentElement.remove();
            });
        });
});