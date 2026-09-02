var xhr = null;

function checkUsername(username) {

    var status = document.getElementById("usernameStatus");

    username = username.trim();

    if (username === "") {
        status.innerHTML = "";
        return;
    }

    // Cancel previous request
    if (xhr !== null) {
        xhr.abort();
    }

    xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "../../Controller/Restaurant/restaurantSignupController.php",
        true
    );

    xhr.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );

    xhr.onreadystatechange = function () {

        if (xhr.readyState === 4 && xhr.status === 200) {

            var response = xhr.responseText.trim();

            if (response === "exists") {

                status.style.color = "red";
                status.innerHTML = "Username already exists";

            } else if (response === "available") {

                status.style.color = "green";
                status.innerHTML = "Username is available";
            }
        }
    };

    xhr.send(
        "action=checkUsername&username=" +
        encodeURIComponent(username)
    );
}