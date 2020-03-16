$(document).ready(function() {
    // CK Editor
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
    
    // Selecting all boxes
    $('#selectAllBoxes').click(function () {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        }else{
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }
    });
    
    // Loader
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("#wrapper").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function () {
        $(this).remove();
    });
})

function loadUsersOnline() {
    $.get("functions.php?onlineusers=result",function (data) {
        $(".usersonline").text(data);
    });
}

setInterval(function(){
    loadUsersOnline();
} , 500);




