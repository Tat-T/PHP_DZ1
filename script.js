    function loadCalendar() {
        let month = document.getElementById("month").value;
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "?month=" + month, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("calendar").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }