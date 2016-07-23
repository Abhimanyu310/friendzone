$('.post').find('.edit').on('click', function (event) {
    event.preventDefault();

    var postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;

    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});