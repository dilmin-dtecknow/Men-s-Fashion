function signUp() {
    // console.log("ok");
    const first_name = document.getElementById("register-fname").value;
    const last_name = document.getElementById("register-lname").value;
    const email = document.getElementById("register-email").value;
    const password = document.getElementById("register-password").value;
    const confirmPassword = document.getElementById("register-confoirm-password").value;



    const data = new FormData();

    data.append("first_name", first_name);
    data.append("last_name", last_name);
    data.append("email", email);
    data.append("password", password);
    data.append("confirmPassword", confirmPassword);

    const request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "success") {
                Swal.fire({
                    title: 'Completed',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'ok'
                });
                window.location = "verification.php";
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                });
            }
        }
    };

    request.open("POST", "process//sellerSignUp.php", true);
    request.send(data);


}

function checkPasswordMatch() {
    const password = document.getElementById("register-password").value;
    const confirmPassword = document.getElementById("register-confoirm-password").value;
    const message = document.getElementById("error_message");

    if (password === confirmPassword) {
        message.textContent = "Passwords match";
        message.style.color = "green";
    } else {
        message.textContent = "Passwords do not match";
        message.style.color = "red";
    }

}

function capitalizeFirstLetter(input) {
    const value = input.value;
    input.value = value.charAt(0).toUpperCase() + value.slice(1);
}