function raceCountDown(curDate,elID,tz){
    var localOffset = new Date().getTimezoneOffset();
    var tzString = getUtcstring(localOffset)
    // console.log(localOffset);

    // Set the date we're counting down to considering timezone
    var countDownDate = new Date(curDate).getTime();
    countDownDate += ((tz + (localOffset/60))*3600*1000);

    // console.log(tz + (localOffset/60));
    // console.log(countDownDate);
    
    //update the browser racetime
    var browserDate = new Date(countDownDate);
    document.getElementById('localracedt').innerHTML = getTimeString(browserDate) + ' (UTC ' + tzString + ')';

    //set the first value before countdown starts to avoid 1 sec delay
    var firstNow = new Date().getTime();
    var firstDistance = countDownDate - firstNow;
    document.getElementById(elID).innerHTML = getTimeDiffString(firstDistance);

    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        // Display the result in the element with id="demo"
        document.getElementById(elID).innerHTML = getTimeDiffString(distance);
        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById(elID).innerHTML = "EXPIRED";
        }
    }, 1000);
}
function getTimeString(dttm){
    var bHour = dttm.getHours();
    var bMins = dttm.getMinutes();
    return bHour + ':' + bMins;
}
function getUtcstring(offset){
    return ( offset <= 0 ? '+'+(offset/60)*(-1) : (offset/60) );
}
function getTimeDiffString(distance){
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    return days + "d " + hours + "h " + minutes + "m " + seconds + "s "
}