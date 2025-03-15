const submitBtn = document.getElementById("submit");
const newRoundSubmit = document.getElementById("newRoundSubmit");

if(submitBtn !== null) {
    submitBtn.onclick = function(e) {
        e.preventDefault();
        postNewComp();
    }
}

if(newRoundSubmit !== null) {
    newRoundSubmit.onclick = function(e) {
        e.preventDefault();
        postNewRound();
    }
}

$(".addBtn").each(function(index, obj) {
    obj.onclick = function(e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            data: {
                "_token": $("#token").val(),
                "user_id": obj.id,
                "round_id": $("#round_id").val(),
            },
            url: $("#route").val(),
            error:function(err) {
                let error = err.responseJSON;
                let errorMsgContainer = $("#errorMsgContainer");
                errorMsgContainer.html("");
                $.each(error.errors, function (index, value) {
                    errorMsgContainer.append("<span class='text-danger'>" + value + "<span><br>");
                });
            },
            success:function(result) {
                $("#competitor_list").append("<p>" + result[0].username + "</p>");
            }  
        });
    }
});
    
function postNewRound() {
    $.ajax({
        method: "POST",
        data: {
            "_token": $("#token").val(),
            "competition_id": $("#competition_id").val(),
            "round_number": $("#round_number").val(),
            "date": $("#date").val()
        },
        url: $("#route").val(),
        error:function(err) {
            let error = err.responseJSON;
            let errorMsgContainer = $("#errorMsgContainer");
            errorMsgContainer.html("");
            $.each(error.errors, function (index, value) {
                errorMsgContainer.append("<span class='text-danger'>" + value + "<span><br>");
            });
        },
        success:function(result) {
            $("#round_number").val("");
            $("#date").val("");
            $("#round_list").append("<h3><a href='/competitions/" + result[0].competition_id + "/rounds/" + result[0].id + "'>Round " + result[0].round_number + " – " + result[0].date + "</a></h3>");
        }  
    });
}

function postNewComp() {
    $.ajax({
        method: "POST",
        data: {
            "_token": $("#token").val(),
            "name": $("#name").val(),
            "year": $("#year").val(),
            "languages": $("#languages").val(),
            "right_ans": $("#right_ans").val(),
            "wrong_ans": $("#wrong_ans").val(),
            "empty_ans": $("#empty_ans").val(),
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
            $("#competition_list").prepend("<h3><a href='/competitions/" + result[0].id + "'>" + result[0].name + " – " + result[0].year + "</a></h3>");
        }
    });
}
