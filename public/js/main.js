//clock for header
function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    
    var time = h + ":" + m;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;
    setTimeout(showTime, 1000);    
}

showTime();
//end of clock for header

//number seperator
function numberWithSpaces(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}
for (let i=0; i < $('.number-seperator').length; i++ ) {     
    $(".number-seperator")[i].innerText = parseFloat($(".number-seperator")[i].textContent).toLocaleString();
}
//end of number seperator

// phone number format
$(".tel").text(function(i, text) {
    text = text.replace(/(\d{2})(\d{3})(\d{2})(\d{2})/, "$1 $2 $3$4");
    return text;
});
// disable all inputs autocomplete
$('input').attr('autocomplete','off');