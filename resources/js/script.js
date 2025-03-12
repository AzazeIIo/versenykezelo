const submitBtn = document.getElementById("submit");

submitBtn.onclick = function(e) {
    e.preventDefault();
    postNewComp();
}

function postNewComp() {
    $.ajax({
        method: "POST",
        data: {
            "_token": $("#token").val(),
            "name": $("#name").val(),
            "year": $("#year").val()
        },
        url: "/home",
        })/*.done(function( msg ) {
        if(msg.error == 0){
            //$('.sucess-status-update').html(msg.message);
            alert(msg.message);
        }else{
            alert(msg.message);
            //$('.error-favourite-message').html(msg.message);
        }
    })*/;
}
