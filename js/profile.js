function showOrderDetails(orderId) {

   // Set the orderId as a data attribute on the confirm button
   document.getElementById('confirmOrderButton').setAttribute('data-order-id', orderId);

   // Show the modal
   document.getElementById('orderDetailsModal').style.display = "block";
   const request = new XMLHttpRequest();

   request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
         let response = JSON.parse(request.responseText);

         console.log(response); // For debugging
         if (response.success) {
            let itemsTable = document.getElementById("orderItemsTableBody");
            itemsTable.innerHTML = ""; // Clear previous items

            response.items.forEach(item => {
               let row = `
                   <tr>
                     

                     <td>
                       <div class="product-info">
                           <img src="webImg/productImages/${item.product_id}/image1.png" alt="Product Image" style="width: 100px; height: 100px;">
                              <div>
                                   <p>${item.product_name}</p>
                               </div>
                        </div>
                         </td>
                       <td>${item.quantity}</td>
                       <td>Rs. ${item.price}</td>
                       <td>Rs. ${item.total}</td>
                       <td> ${item.name}</td>
                       <td>Rs. ${item.total_with_shipping}</td>
                   </tr>`;
               itemsTable.innerHTML += row;
            });

            document.getElementById("orderDetailsModal").style.display = "block";
         } else {
            alert("Failed to load order details.");
         }
      }
   };

   request.open("GET", "process/orderDetails.php?orderId=" + orderId);
   request.send();
}

function closeModal() {
   document.getElementById("orderDetailsModal").style.display = "none";
}

function confirmOrder() {
   // Get the order ID from the button's data attribute
   const orderId = document.getElementById('confirmOrderButton').getAttribute('data-order-id');
   console.log("Order ID:", orderId); // Print the order ID to the console

   const request = new XMLHttpRequest();

   request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
         let response = request.responseText;

         console.log(response);


         if (response == 'success') {
            console.log(response);
            window.location = 'account.php';
         } else {
            Swal.fire({
               title: 'Information Message!',
               text: response,
               icon: 'info',
               confirmButtonText: 'ok'
            });
         }
      }
   };

   request.open("GET", "process/confirmOrder.php?oderId=" + orderId, true);
   request.send();

   // Add further logic to handle order confirmation here, such as sending an AJAX request
}


function updateProfile() {
   // console.log("update");
   const fname = document.getElementById('fname').value;
   const lname = document.getElementById('lname').value;
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

   request.open("POST", "process/updateProfileDetail.php", true);
   request.send(form);
}

function changeImage() {
   const fileInput = document.getElementById('profileimg');
   const file = fileInput.files[0];
   console.log(fileInput);

   if (!file) {
      Swal.fire({
         title: 'Some thing Happend!',
         text: 'Please select an image first.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   }

   const formData = new FormData();
   formData.append('profile_image', file);

   const request = new XMLHttpRequest();

   request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
         let response = request.responseText;

         if (response == 'success') {
            Swal.fire({
               title: 'Success!',
               text: 'Image Upload completed',
               icon: 'success',
               confirmButtonText: 'ok'
            }).then(() => {
               window.location.reload();
            });
         } else {
            Swal.fire({
               title: 'Some thing Happend!!',
               text: response,
               icon: 'error',
               confirmButtonText: 'ok'
            }).then(() => {
               window.location.reload();
            });
         }
      }
   };

   request.open("POST", "process/updateProfileImage.php", true);
   request.send(formData);
}

// image preview show
function previewImage(event) {
   const file = event.target.files[0];
   const viewImg = document.getElementById('viewImg');

   if (file) {
      // Display the selected image in the img element
      viewImg.src = URL.createObjectURL(file);
   }
}


function updateAddress() {

   const addressFname = document.getElementById('adfname').value;
   const addressLname = document.getElementById('adlname').value;
   const mobile = document.getElementById('mobile').value;
   const addressl1 = document.getElementById('address-l1').value;
   const addressl2 = document.getElementById('address-l2').value;
   const zipcode = document.getElementById('zipcode').value;

   const mobileRegex = /^[0]{1}[7]{1}[01245678]{1}[0-9]{7}$/m;

   if (addressFname == '' || addressFname == null) {
      Swal.fire({
         title: 'Error!',
         text: 'Please Fill first name.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   }
   if (addressLname == '' || addressLname == null) {
      Swal.fire({
         title: 'Error!',
         text: 'Please Fill last name.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   }
   if (mobile == '' || mobile == null) {
      Swal.fire({
         title: 'Error!',
         text: 'Please Fill mobile.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   } else if (!mobileRegex.test(mobile)) {
      Swal.fire({
         title: 'Error!',
         text: 'Please enter a valid mobile number. It should start with "07" followed by a valid 9-digit number.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   }
   if (addressl1 == '' || addressl1 == null) {
      Swal.fire({
         title: 'Error!',
         text: 'Please Fill Address Line21.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   }
   if (addressl2 == '' || addressl2 == null) {
      Swal.fire({
         title: 'Error!',
         text: 'Please Fill Address Line2.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   } else if (zipcode == '' || zipcode == null) {
      Swal.fire({
         title: 'Error!',
         text: 'Please Fill Zip Code/Postal code.',
         icon: 'error',
         confirmButtonText: 'ok'
      }).then(() => {
         window.location.reload();
      });
      return;
   }

   const form = new FormData();
   form.append("addressFname", addressFname);
   form.append("addressLname", addressLname);
   form.append("mobile", mobile);
   form.append("addressl1", addressl1);
   form.append("addressl2", addressl2);
   form.append("zipcode", zipcode);

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

   request.open("POST", "process/updateAddressDetails.php", true);
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

   request.open("POST", "process/updatePassword.php", true);
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

