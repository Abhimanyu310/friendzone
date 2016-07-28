$(document).ready(function() {
    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-primary");
    });
});

$('.add-friend').on('click', function (event) {
    event.preventDefault();
    var addButton = event.target;
    var friendId = addButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlFriendRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            location.reload();
        });


})



$('.cancel-request').on('click', function (event) {
    event.preventDefault();
    var cancelButton = event.target;
    var friendId = cancelButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlCancelRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            location.reload();
        });


})

$('.delete-request').on('click', function (event) {
    event.preventDefault();
    var deleteButton = event.target;
    var friendId = deleteButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlDeleteRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            location.reload();
        });
})

$('.accept').on('click', function (event) {
    event.preventDefault();
    var acceptButton = event.target;
    var friendId = acceptButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlAcceptRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            location.reload();
        });
})



$('.remove-friend').on('click', function (event) {
    event.preventDefault();
    var removeButton = event.target;
    var friendId = removeButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlRemoveFriend,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            location.reload();
        });
})




