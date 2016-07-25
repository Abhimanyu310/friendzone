$(document).ready(function() {
    $(".btn-pref .btn").click(function () {
        $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-primary");
    });
});

$('.add-friend').on('click', function (event) {
    event.preventDefault();
    addButton = event.target;
    var friendId = addButton.parentNode.dataset['userid'];
    $.ajax({
            method: 'POST',
            url: urlFriendRequest,
            data: {friendId: friendId, _token: token}
        })
        .done(function() {
            addButton.innerText = 'Zone request pending';
            $(addButton).removeClass("btn-info").addClass("btn-warning");
            var cancelButton = '<button type="button" class="btn btn-danger cancel-request">Cancel zone request</button>';
            $(cancelButton).insertAfter(addButton);
        });


})