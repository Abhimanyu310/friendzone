$('.accept-request-notification').on('click', function (event) {
    event.preventDefault();
    var acceptButton = event.target;
    var notificationElement = acceptButton.parentNode.parentNode;
    var friendId = notificationElement.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlAcceptRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            $(notificationElement).fadeOut(500, function() {
                $(notificationElement).remove()
            });
        });
})

$('.delete-request-notification').on('click', function (event) {
    event.preventDefault();
    var deleteButton = event.target;
    var notificationElement = deleteButton.parentNode.parentNode;
    var friendId = notificationElement.dataset['userid'];
    // console.log(friendId);
    // console.log(notificationElement);
    $.ajax({
            method: 'POST',
            url: urlDeleteRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            $(notificationElement).fadeOut(500, function() {
                $(notificationElement).remove()
            });
        });
})