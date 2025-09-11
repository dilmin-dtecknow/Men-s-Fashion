function signIn() {
   const email = document.getElementById('ad-email').value;
   const password = document.getElementById('ad-password').value;
    console.log(email);
    console.log(password);

    let form = new FormData();
    form.append('email',email);
    form.append('password',password);

   const request = new XMLHttpRequest();

   request.onreadystatechange = ()=>{
    if (request.readyState == 4 && request.status == 200) {
       let response = request.responseText;

       console.log(response);

       if (response == 'success') {
        window.location = "adminVerification.php";
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
   
   request.open("POST","process/adminSignIn.php",true);
   request.send(form);
}