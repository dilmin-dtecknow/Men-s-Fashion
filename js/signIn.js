function SignIn() {
    // alert("Ok SignIn");

    let email = document.getElementById("login-email").value;
    let password = document.getElementById("login-password").value;

    // Regular expression to validate email format
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;


    // Check if email and password fields are not empty
    if (email === "") {

        Swal.fire({
            title: 'Error!',
            text: 'Please enter your email address.',
            icon: 'error',
            confirmButtonText: 'Cool'
        });

    } else if (!emailRegex.test(email)) {
        // Check if the email format is valid

        Swal.fire({
            title: 'Error!',
            text: "Please enter a valid email address.",
            icon: 'error',
            confirmButtonText: 'Cool'
        });
    } else if (password === "") {
        // Check if password field is not empty

        Swal.fire({
            title: 'Error!',
            text: 'Please enter your password.',
            icon: 'error',
            confirmButtonText: 'Cool'
        });
    } else if (password.length < 8) {
        // Ensure password length is at least 8 characters
        Swal.fire({
            title: 'Error!',
            text: 'Password must be at least 8 characters long.',
            icon: 'error',
            confirmButtonText: 'Cool'
        });
    } else {

        const data = new FormData();

        data.append("email", email);
        data.append("password", password);
        data.append("rememberme", rememberme.checked);

        const request = new XMLHttpRequest();

        request.onreadystatechange = () => {
            if (request.readyState && request.status == 200) {
                // const response = JSON.parse(request.responseText);
                const response = request.responseText;
                if (response==="success") {
                    Swal.fire({
                        title: 'Completed',
                        // text: response.content,
                        text: response,
                        icon: 'success',
                        confirmButtonText: 'ok'
                    });
                    window.location = "home.php";
                } else {
                    // Swal.fire({
                    //     title: 'Error!',
                    //     text: response,
                    //     icon: 'error',
                    //     confirmButtonText: 'Cool'
                    // });

                    if (response === "Unverified") {
                        window.location = "verification.php"; // Redirect if account not verified
                    } else {
                        Swal.fire({
                                title: 'Error!',
                                text: response,
                                icon: 'error',
                                confirmButtonText: 'Cool'
                            }); // Display error message
                    }
                }
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "Please try again later!",
                    icon: 'error',
                    confirmButtonText: 'Cool'
                });
            }
        }

        request.open("POST","process//signIn.php",true);
        request.send(data);
    }

}