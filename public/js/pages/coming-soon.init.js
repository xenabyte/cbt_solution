document.addEventListener("DOMContentLoaded", function () {
    var e = new Date("Jan 1, 2024").getTime(),
        d = setInterval(function () {
            var t = new Date().getTime(),
                n = e - t,
                t =
                    '<div class="countdownlist-item"><div class="count-title">Days</div><div class="count-num">' +
                    Math.floor(n / 864e5) +
                    '</div></div><div class="countdownlist-item"><div class="count-title">Hours</div><div class="count-num">' +
                    Math.floor((n % 864e5) / 36e5) +
                    '</div></div><div class="countdownlist-item"><div class="count-title">Minutes</div><div class="count-num">' +
                    Math.floor((n % 36e5) / 6e4) +
                    '</div></div><div class="countdownlist-item"><div class="count-title">Seconds</div><div class="count-num">' +
                    Math.floor((n % 6e4) / 1e3) +
                    "</div></div>";
            document.getElementById("countdown") &&
                (document.getElementById("countdown").innerHTML = t),
                n < 0 &&
                    (clearInterval(d),
                    (document.getElementById("countdown").innerHTML =
                        '<div class="countdown-endtxt">The countdown has ended!</div>'));
        }, 1e3);
});
