function editProfile() {
    // console.log("update");
    const fname = document.getElementById('f-name').value;
    const lname = document.getElementById('l-name').value;
    const email = document.getElementById('email').value;
    // console.log(fname);
    // console.log(lname);
    // console.log(email);

    let form = new FormData();
    form.append("fname", fname);
    form.append("lname", lname);
    form.append("email", email);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;
            console.log(response);

            if (response == 'success') {
                window.location.reload();
            } else {
                Swal.fire({
                    title: 'Some thing Happend!',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'ok'
                }).then(() => {
                    window.location.reload();
                });
            }
        }
    };

    request.open("POST", "process/editProfileDetail.php", true);
    request.send(form);
}

function updatePassword() {

    const newPassword = document.getElementById('account-paassword').value;
    const confirmPassword = document.getElementById('account-paassword-confirm').value;

    const passwordRegex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    // Basic validation
    if (newPassword.trim() === "" || confirmPassword.trim() === "") {
        Swal.fire({
            title: 'Error!',
            text: 'Please Fill both filds.',
            icon: 'error',
            confirmButtonText: 'ok'
        });
        return false;
    }

    if (!passwordRegex.test(newPassword)) {
        Swal.fire({
            title: 'Error!',
            text: 'Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character..',
            icon: 'error',
            confirmButtonText: 'ok'
        });
        return;
    }

    if (confirmPassword != newPassword) {
        document.getElementById('show-msg').innerHTML = "Password dosn't match!"
        return;
    }



    console.log(newPassword);
    console.log(confirmPassword);

    const form = new FormData();
    form.append("new_password", newPassword);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            if (response == 'password_updated') {
                Swal.fire({
                    title: 'Sucess!',
                    text: 'Password Update Success!',
                    icon: 'success',
                    confirmButtonText: 'ok'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'ok'
                });
            }
        }
    };

    request.open("POST", "process/resetPassword.php", true);
    request.send(form);
}

function showMsg() {
    // Get the password values
    const newPassword = document.getElementById('account-paassword').value;
    const confirmPassword = document.getElementById('account-paassword-confirm').value;

    // Get the element to display the message
    const messageElement = document.getElementById('show-msg');

    // Check if the passwords match
    if (confirmPassword !== newPassword) {
        // Display the message if passwords don't match
        messageElement.innerHTML = "Passwords don't match!";
        messageElement.style.color = "red";
    } else {
        // Clear the message if passwords match
        messageElement.innerHTML = "Password Match";
        messageElement.style.color = "green";
    }
}

function togglePasswordVisibility(inputId, iconId) {
    const inputElement = document.getElementById(inputId);
    const iconElement = document.getElementById(iconId);

    if (inputElement.type === "password") {
        inputElement.type = "text";
        iconElement.classList.remove('fa-eye');
        iconElement.classList.add('fa-eye-slash');
    } else {
        inputElement.type = "password";
        iconElement.classList.remove('fa-eye-slash');
        iconElement.classList.add('fa-eye');
    }
}