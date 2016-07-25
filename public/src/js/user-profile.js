$(document).ready(function() {
    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-primary");
    });
});

$('#add-friend').on('click', function (event) {
    event.preventDefault();
    addButton = event.target;
    var friendId = addButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlFriendRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            addButton.innerText = 'Friend Request Sent';
            $(addButton).removeClass("btn-info").addClass("btn-warning")
        });


})