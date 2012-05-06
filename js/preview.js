$(document).ready(function () {
    xOffset = 280;
    yOffset = -680;
    $("a.preview").hover(function (e) {
        $("body").append("<p id='preview'><img src='" + this.children[1].src + "' alt='Image preview' />&nbsp;</p>");
        $("#preview").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px").fadeIn("fast");
    }, function () {
        $("#preview").remove();
    });
    $("a.preview").mousemove(function (e) {
        $("#preview").css("top", (e.pageY - xOffset) + "px").css("left", (e.pageX + yOffset) + "px");
    });
});