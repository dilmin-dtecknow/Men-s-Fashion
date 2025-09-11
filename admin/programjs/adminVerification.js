function verifyCode() {
    const code = document.getElementById('code').value;
    console.log(code)

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;
            console.log(response);

            if (response == 'success') {
                window.location = 'index.php';
            }else{
                Swal.fire({
                    title: 'Error',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'ok'
                });
            }
        }
    };

    request.open("GET", "process/codeVerify.php?code=" + code, true);
    request.send();
}