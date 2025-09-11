function getCode() {
    const email = document.getElementById('login-email').value;

    // console.log(email);
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email === "" || email === null) {

        Swal.fire({
            title: 'Error!',
            text: 'Please enter your email address.',
            icon: 'error',
            confirmButtonText: 'Cool'
        });

        return;

    } else if (!emailRegex.test(email)) {
        // Check if the email format is valid

        Swal.fire({
            title: 'Error!',
            text: "Please enter a valid email address.",
            icon: 'error',
            confirmButtonText: 'Cool'
        });

        return;
    }

    const requsest = new XMLHttpRequest();

    requsest.onreadystatechange = () => {
        if (requsest.readyState == 4 && requsest.status == 200) {
            let response = requsest.responseText;

            console.log(response);
            if (response == 'success') {
                window.location = 'forgotPasswordVerification.php';
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                });  
            }
        }
    };

    requsest.open("GET", "process/sendForgotPasswordVerification.php?email=" + email, true);
    requsest.send();
}