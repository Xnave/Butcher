// Colour the current URL
$(document).ready(function() {
    $("[href]").each(function() {
        if (this.href == window.location.href) {
            $(this).css(
                {"background-color":"rgb(94, 119, 132)",
                    "color":"white"});
        }
    });
});

// If its the current url - cancel surfing
var link = document.URL;

$('.menuOption').click(function(e){
    clickedUrl = this.childNodes[1].href;

    if(link == clickedUrl){
        e.preventDefault();
        $(this).children().css({"cursor":"no-drop"});
    }
});