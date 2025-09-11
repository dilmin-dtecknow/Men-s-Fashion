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

               let color;
               switch (item.id) {
                  case "1":
                     color = "#8FEC6A";
                     break;
                  case "2":
                     color = "#6C67F4";
                     break;
                  case "3":
                     color = "#A642C2";
                     break;
                  case "4":
                     color = "#8D6F64";
                     break;
                  default:
                     color = "black"; // Default color if the id doesn't match
               }

               let row = `
                   <tr>
                     

                     <td>
                       <div class="product-info">
                           <img src="../webImg/productImages/${item.product_id}/image1.png" alt="Product Image" style="width: 100px; height: 100px;">
                              <div>
                                   <p>${item.product_name}</p>
                               </div>
                        </div>
                         </td>
                       <td>${item.quantity}</td>
                       <td>Rs. ${item.price}</td>
                       <td>Rs. ${item.total}</td>
                        <td style="color: ${color}; font-weight: bold;">${item.name}</td>
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

   request.open("GET", "process/orderDetailsManage.php?orderId=" + orderId);
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


         if (response == 'success2') {
            console.log(response);
            Swal.fire({
               title: 'Updated',
               text: 'Prossing updated successfully!',
               icon: 'success',
               confirmButtonText: 'OK'
            }).then(() => {
               // Optionally reload the page or update UI
               window.location.reload();
            });
            // window.location.reload();
         } else if (response == 'success3') {
            console.log(response);
            Swal.fire({
               title: 'Updated',
               text: 'Shiped updated successfully!',
               icon: 'success',
               confirmButtonText: 'OK'
            }).then(() => {
               // Optionally reload the page or update UI
               window.location.reload();
            });
            // window.location.reload();
         } else if (response == 'success4') {
            console.log(response);
            Swal.fire({
               title: 'Updated',
               text: 'Deliverd updated successfully!',
               icon: 'success',
               confirmButtonText: 'OK'
            }).then(() => {
               // Optionally reload the page or update UI
               window.location.reload();
            });
            // window.location.reload();
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

   request.open("GET", "process/manageOrderStatus.php?oderId=" + orderId, true);
   request.send();

   // Add further logic to handle order confirmation here, such as sending an AJAX request
}

function searchInvoiceid() {
   let searchInId = document.getElementById('inId').value;
   console.log(searchInId);

   const request = new XMLHttpRequest();

   request.onreadystatechange = () => {
      if (request.readyState == 4 && request.status == 200) {
         let response = request.responseText;
         // console.log(response);


         if (response != 'Invalide Order ID') {
            document.getElementById("body").innerHTML = response;
         } else {
            document.getElementById("body").innerHTML = response;
         }
      }
   };

   request.open("GET", "process/invoiceIdSearch.php?inid=" + searchInId, true);
   request.send();
}

function orderDateSearch() {
   fromDate = document.getElementById('fromd').value;
   toDate = document.getElementById('tod').value;
   console.log(fromDate);
   console.log(toDate);

   var r = new XMLHttpRequest();

   r.onreadystatechange = () => {
      if (r.readyState == 4) {
         var response = r.responseText;
         
            document.getElementById("body").innerHTML = response;
        
      }
   }

   r.open("GET", "process/findSellingsDateProcess.php?f=" + fromDate + "&t=" + toDate, true);
   r.send();
}