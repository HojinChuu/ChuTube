function subscribe(userTo, userFrom, button) {
    if (userTo == userFrom) {
        alert("You can't subscribe to yourself");
        return;
    }

    $.post("requests/subscribe.php", { userTo, userFrom })
    .done(count => {
        if (count != null) {
            let buttonText = $(button).hasClass("subscribe") ? "SUBSCRIBED" : "SUBSCRIBE";

            $(button).toggleClass("subscribe unsubscribe");
            $(button).text(buttonText + " " + count);
        } 
        else {
            alert("something wrong");
        }
    });
} 