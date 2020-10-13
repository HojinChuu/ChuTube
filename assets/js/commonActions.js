$(document).ready(() => {
    $(".navShowHide").on("click", () => {
        var main = $("#mainSectionContainer");
        var nav = $("#sideNavContainer");

        main.hasClass("leftPadding") ? nav.hide() : nav.show();
        main.toggleClass("leftPadding")
    })
});