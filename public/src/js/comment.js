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
            $('#comment-body'+postId).innerHTML = '';
            var new_comment = '<hr><div class="media"><div class="pull-left">';
            new_comment += '<img class="media-object img-circle" src="http://placehold.it/64x64" alt="">';
            new_comment += '</div><div class="media-body"><p>';
            new_comment += '<a href='+urlAuthUserProfile+'>';
            new_comment += comment.first_name + ' ' + comment.last_name + ' </a>';
            new_comment += comment.body;
            new_comment += '<small class="pull-right text-muted">' + comment.created_at.date + '</small>'
            new_comment += '</p></div></div>';
            $(formElement).append(new_comment);
        });
});
//TODO clear textarea and add delete button when comment added with ajax and use fade animation...
$('.delete-comment').on('click', function(event) {
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
            commentElement.previousElementSibling.remove();
            commentElement.remove();


        });
});