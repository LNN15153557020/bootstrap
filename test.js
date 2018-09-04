$(function () {
    $("#login").click(function () {
        $("#allContent").load("login.html");
        $(".remove").removeClass("tops").addClass("top1");
    });
    $("#grade").click(function(){
        $("#allContent").load("grade.html");
    });
    $("#addClass").click(function(){
        $("#allContent").load("addClass.html");
    });

})