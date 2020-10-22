$(document).ready(() => {
    $(".navShowHide").on("click", () => {
        var main = $("#mainSectionContainer");
        var nav = $("#sideNavContainer");

        main.toggleClass("leftPadding")
        main.hasClass("leftPadding") ? nav.show() : nav.hide();
    })

    setTimeout(function() {
        $(".alert").fadeTo(500, 0) 
    }, 2000);
});

function notSignedIn() {
    alert("You must be signed in to perform this action");
}