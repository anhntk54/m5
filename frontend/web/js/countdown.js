 function Countdown(options) {
    var timer,
            instance = this,
            id = options.id,
            seconds = options.seconds || 10,
            updateStatus = options.onUpdateStatus || function () {},
            counterEnd = options.onCounterEnd || function () {};
    function getTimeRemaining(endtime) {
        // console.log("end time:"+endtime);
        var t = Date.parse(endtime) - Date.parse(new Date());
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }
    function decrementCounter() {
        updateStatus(seconds, id);

        var _this = document.getElementById(id);
        var endtime = _this.getAttribute('data-date');
        var t = getTimeRemaining(endtime);
        var second = t.seconds;
        var minutes = t.minutes;
        var hours = t.hours;
        var days = t.days;
        var str = '';
        if (days > 0) {
            str += days + " days ";
        }
        if (hours > 0) {
            str += hours > 9 ? hours : "0" + hours;
            str += ":";
        } else {
            str += "00:";
        }
        if (minutes > 0) {
            str += minutes > 9 ? minutes : "0" + minutes;
            str += ":";
        } else {
            str += "00:";
        }
        if (second > 0) {
            str += second > 9 ? second : "0" + second;
        } else {
            str += "00";
        }
        // console.log('vao ham start'+str+"  "+t.hours);
        _this.innerHTML = str;
        if (t.total === 1000) {
            counterEnd();
            instance.stop();
        }
    }

    this.start = function () {

        clearInterval(timer);
        timer = 0;
        var _this = document.getElementById(id);
        var endtime = _this.getAttribute('data-date');
        var t = getTimeRemaining(endtime);
        seconds = t.total;
        timer = setInterval(decrementCounter, 1000);
    };
    this.stop = function () {
        clearInterval(timer);
    };
}