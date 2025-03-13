const submitBtn = document.getElementById("submit");

if(submitBtn !== null) {
    submitBtn.onclick = function(e) {
        e.preventDefault();
        postNewComp();
    }
}

function postNewComp() {
    $.ajax({
        method: "POST",
        data: {
            "_token": $("#token").val(),
            "name": $("#name").val(),
            "year": $("#year").val()
        },
        url: "/competitions",
        error:function(err) {
            let error = err.responseJSON;
            let errorMsgContainer = $("#errorMsgContainer");
            errorMsgContainer.html("");
            $.each(error.errors, function (index, value) {
                errorMsgContainer.append("<span class='text-danger'>" + value + "<span><br>");
            });
        },
        success:function(result) {
            $("#name").val("");
            $("#year").val("");
            $("#competition_list").prepend("<h3>" + result[0].name + " – " + result[0].year + "</h3>");
        }
    });
}
