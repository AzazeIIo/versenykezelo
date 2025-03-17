$("#newCompetitionSubmit").on("click", function(e) {
    e.preventDefault();
    postNewComp();
});

$("#newRoundSubmit").on("click", function(e) {
    e.preventDefault();
    postNewRound();
});

$(".addBtn").each(function(index, obj) {
    obj.onclick = function(e) {
        e.preventDefault();
        addCompetitor(obj);
    }
});

$(".removeBtn").each(function(index, obj) {
    obj.onclick = function(e) {
        e.preventDefault();
        removeCompetitor(obj);
    }
});

function addCompetitor(obj) {
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
            $("#errorMsgContainer").html("");
            $("#emptyList").css("display", "none");
            $(`<div id="competitor${result[0].id}" class="row addCompetitorRow">
                <div class="col-6">
                    <p>${result[1].username}</p>
                </div>
                    <div class="col-6 buttonColumn">
                        <form method="POST" class="removeCompetitorForm">
                            <input type="hidden" name="_token" id="token" value="${$("#token").val()}">
                            <input type="hidden" name="_route" id="delroute${result[0].id}" value="${result[2]}">
                            <button type="submit" id="del${result[0].id}" class="btn btn-primary removeBtn">
                                Remove
                            </button>
                        </form>
                    </div>
            </div>`).appendTo($("#competitor_list"));
            $(`#competitor${result[0].id}`)[0].onclick = function(e) {
                removeCompetitor($(`#del${result[0].id}`)[0]);
            }                
        }  
    });
}

function removeCompetitor(obj) {
    $.ajax({
        type: "DELETE",
        data: {
            "_token": $("#token").val()
        },
        url: $("#delroute" + obj.id.substring(3)).val(),
        error:function(err) {
            let error = err.responseJSON;
            let errorMsgContainer = $("#errorMsgContainer");
            errorMsgContainer.html("");
            $.each(error.errors, function (index, value) {
                errorMsgContainer.append("<span class='text-danger'>" + value + "<span><br>");
            });
        },
        success:function() {
            let errorMsgContainer = $("#errorMsgContainer");
            errorMsgContainer.html("");
            document.getElementById("competitor" + obj.id.substring(3)).remove();
        }  
    });
}
    
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
            $("#errorMsgContainer").html("");
            $("#emptyList").css("display", "none");
            $("#round_number").val("");
            $("#date").val("");
            $("#round_list").append("<li><a href='/competitions/" + result[0].competition_id + "/rounds/" + result[0].id + "'>Round " + result[0].round_number + " – " + result[0].date + "</a></li>");
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
            $("#emptyList").css("display", "none");
            $("#errorMsgContainer").html("");
            $("#name").val("");
            $("#year").val("");
            $("#languages").val("");
            $("#right_ans").val("");
            $("#wrong_ans").val("");
            $("#empty_ans").val("");
            $("#competition_list").prepend("<li><a href='/competitions/" + result[0].id + "'>" + result[0].name + " – " + result[0].year + "</a></li>");
        }
    });
}
