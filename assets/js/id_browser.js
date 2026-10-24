$(document).ready(function() {
    var pengunjung = readCookie("pengunjung");

    if (pengunjung) {
        showVisitorId(pengunjung);
        return;
    }

    // Initialize the agent at application startup.
    import('https://openfpcdn.io/fingerprintjs/v3')
        .then(FingerprintJS => FingerprintJS.load())
        .then(fp => fp.get())
        .then(result => {
            setVisitorId(result.visitorId);
        })
        .catch(function() {
            setVisitorId(createFallbackVisitorId());
        });
});

function setVisitorId(browserId) {
    createCookie("pengunjung", browserId, "1");
    showVisitorId(browserId);
}

function showVisitorId(browserId) {
    var pengunjung = document.getElementById("pengunjung");

    if (pengunjung) {
        pengunjung.innerHTML = browserId || "-";
    }
}

function createFallbackVisitorId() {
    var randomValue = Math.random().toString(36).substring(2, 12);

    if (window.crypto && window.crypto.getRandomValues) {
        var randomBytes = new Uint32Array(2);
        window.crypto.getRandomValues(randomBytes);
        randomValue = randomBytes[0].toString(36) + randomBytes[1].toString(36);
    }

    return "local-" + Date.now().toString(36) + randomValue;
}

// Function to create the cookie 
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }

    document.cookie = escape(name) + "=" +
        escape(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

$('.copy').on('click', function() {
    var text = $("#pengunjung").get(0)
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(text);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand('copy');
});
