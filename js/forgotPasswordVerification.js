// function Verification() {
//     let vCode = document.getElementById("code").value;

//     // Check if the code is not empty
//     if (vCode.trim() === "") {
//         // alert("Please enter a verification code.");

//         Swal.fire({
//             title: 'Error!',
//             text: 'Please enter a verification code.',
//             icon: 'error',
//             confirmButtonText: 'Ok'
//         })

//         return;
//     }

//     const data = new FormData();
//     data.append("verification_code", vCode);

//     // Send the verification code to verification.php using fetch
//     let request = new XMLHttpRequest();

//     request.onreadystatechange = () => {
//         if (request.readyState == 4) {
//             const response = request.responseText;

//             if (response == "success") {
//                 Swal.fire({
//                     title: 'Completed',
//                     text: response,
//                     icon: 'success',
//                     confirmButtonText: 'ok'
//                 });


//             } else {
//                 Swal.fire({
//                     title: 'Error',
//                     text: response,
//                     icon: 'error',
//                     confirmButtonText: 'ok'
//                 });
//             }
//         }
//     }

//     request.open("POST", "process//Verification.php", true);
//     request.send(data);
// }

function Verification() {
    let vCode = document.getElementById("code").value;

    // Check if the code is not empty
    if (vCode.trim() === "") {
        Swal.fire({
            title: 'Error!',
            text: 'Please enter a verification code.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
        return;
    }

    const data = new FormData();
    data.append("verification_code", vCode);

    // Send the verification code to verification.php using XMLHttpRequest
    let request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4) {
            const response = request.responseText;

            if (response === "success") {
                Swal.fire({
                    title: 'Verification Successful!',
                    text: 'Please enter a new password.',
                    icon: 'success',
                    showCancelButton: true,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    html:
                        '<input id="new-password" type="password" class="swal2-input" placeholder="New Password">' +
                        '<input id="confirm-password" type="password" class="swal2-input" placeholder="Confirm Password">',
                    preConfirm: () => {
                        const newPassword = document.getElementById('new-password').value;
                        const confirmPassword = document.getElementById('confirm-password').value;
                        // Password Regex: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character
                        const passwordRegex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
                        // Basic validation
                        if (newPassword.trim() === "" || confirmPassword.trim() === "") {
                            Swal.showValidationMessage('Please fill out both fields.');
                            return false;
                        }
                        if (newPassword !== confirmPassword) {
                            Swal.showValidationMessage('Passwords do not match.');
                            return false;
                        }
                        if (!passwordRegex.test(newPassword)) {
                            Swal.showValidationMessage('Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.');
                            return false;
                        }
                        // Return the new password if everything is valid
                        return { newPassword: newPassword };
                    },
                    didOpen: () => {
                        document.getElementById('new-password').focus();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Process password change
                        const newPassword = result.value.newPassword;

                        // Send the new password to the server for processing
                        const passwordData = new FormData();
                        passwordData.append("new_password", newPassword);

                        // Use XMLHttpRequest or fetch to send the password change to the server
                        let passwordRequest = new XMLHttpRequest();
                        passwordRequest.onreadystatechange = () => {
                            if (passwordRequest.readyState == 4) {
                                const passwordResponse = passwordRequest.responseText;

                                if (passwordResponse === "password_updated") {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Your password has been updated.',
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then(() => {
                                        // Optionally redirect or take any other action after password update
                                        window.location.href = 'login.php';
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!Failed to update password. Please try again.',
                                        text: passwordResponse,
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            }
                        };

                        passwordRequest.open("POST", "process/updatePassword.php", true);
                        passwordRequest.send(passwordData);
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    };

    request.open("POST", "process/Verification.php", true);
    request.send(data);
}
