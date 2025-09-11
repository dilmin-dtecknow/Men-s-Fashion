function changeStatus(pid, stateId) {
    console.log(pid);
    console.log(stateId);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            console.log(response);
            if (response == 'success') {
                window.location.reload();
            }
        }
    };

    request.open("GET", "process/productStateChange.php?productid=" + pid + "&stateId=" + stateId, true);
    request.send();
}

function searchProduct() {
    let productid = document.getElementById('searchtext').value;
    console.log(productid);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;
            // console.log(response);


            if (response != 'Invalide Product ID') {
                document.getElementById("body").innerHTML = response;
            }
        }
    };

    request.open("GET", "process/productSearch.php?pid=" + productid, true);
    request.send();
}

function giveDiscount(productId) {
    // Get the discount value using the product's unique ID
    const discountValue = document.getElementById(`discount_${productId}`).value;
    console.log(discountValue);
    console.log(productId);

    // Validate if the discount value is empty
    if (discountValue === '' || discountValue === null) {
        alert("Please enter a discount value (minimum 0)");
        return; // Stop further execution if the value is empty
    }

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            console.log(response);
            if (response === 'success') {
                Swal.fire({
                  title: 'Updated',
                  text: 'Discount updated successfully!',
                  icon: 'success',
                  confirmButtonText: 'OK'
                }).then(() => {
                  // Optionally reload the page or update UI
                  window.location.reload();
                });
              } else {
                Swal.fire({
                  title: 'Error',
                  text: response,
                  icon: 'error',
                  confirmButtonText: 'OK'
                });
              }
        }
    };

    request.open("GET", "process/giveDiscount.php?discount=" + discountValue + "&pid=" + productId);
    request.send();
}