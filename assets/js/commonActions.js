$(document).ready(() => {
    $(".navShowHide").on("click", () => {
        var main = $("#mainSectionContainer");
        var nav = $("#sideNavContainer");

        main.toggleClass("leftPadding")
        main.hasClass("leftPadding") ? nav.show() : nav.hide();
    })
});

function notSignedIn() {
    alert("You must be signed in to perform this action");
}