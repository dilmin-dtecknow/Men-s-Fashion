function Verification() {
    let vCode = document.getElementById("code").value;

    // Check if the code is not empty
    if (vCode.trim() === "") {
        // alert("Please enter a verification code.");

        Swal.fire({
            title: 'Error!',
            text: 'Please enter a verification code.',
            icon: 'error',
            confirmButtonText: 'Ok'
        })

        return;
    }

    const data = new FormData();
    data.append("verification_code", vCode);

    // Send the verification code to verification.php using fetch
    let request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4) {
            const response = request.responseText;

            if (response == "success") {
                Swal.fire({
                    title: 'Completed',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'ok'
                });

                window.location = "home.php";
            } else {
                Swal.fire({
                    title: 'Completed',
                    text: response,
                    icon: 'Error',
                    confirmButtonText: 'ok'
                });
            }
        }
    }

    request.open("POST", "process//Verification.php", true);
    request.send(data);
}