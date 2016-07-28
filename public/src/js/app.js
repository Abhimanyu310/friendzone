var postId = 0;
var postBodyElement = null;


$('.post').find('.edit').on('click', function (event) {
    event.preventDefault();

    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];

    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});






$('#modal-save').on('click', function () {
    $.ajax({
            method: 'POST',
            url: urlEdit,
            data: {body: $('#post-body').val(), postId: postId, _token: token}
        })
        .done(function (msg) {
            // console.log(msg);
            $(postBodyElement).text(msg['new_body']);
            $('#edit-modal').modal('hide');
        });
});


$('.like').on('click', function(event) {
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var likeElement = event.target;
    var dislikeElement = event.target.nextElementSibling.nextElementSibling;

    $.ajax({
            method: 'POST',
            url: urlLike,
            data: {postId: postId, _token: token}
        })
        .done(function(obj) {
            if(obj.status === 'liked'){
                likeElement.innerText = 'You liked this';
                if(obj.toggle){
                    dislikeElement.innerText = 'Dislike';
                }
            }
            else if(obj.status === 'unliked'){
                likeElement.innerText = 'Like';
            }

        });
});

$('.dislike').on('click', function(event) {
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var dislikeElement = event.target;
    var likeElement = event.target.previousElementSibling.previousElementSibling;
    console.log(likeElement);

    $.ajax({
            method: 'POST',
            url: urlDislike,
            data: {postId: postId, _token: token}
        })
        .done(function(obj) {
            if(obj.status === 'disliked'){
                dislikeElement.innerText = 'You disliked this';
                if(obj.toggle){
                    likeElement.innerText = 'Like';
                }
            }
            else if(obj.status === 'undisliked'){
                dislikeElement.innerText = 'Dislike';
            }

        });
});
