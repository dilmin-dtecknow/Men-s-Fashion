function addToCart(id) {
    // alert(id);
    const add_cart_qty = document.getElementById("add_cart_qty").value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 & request.status == 200) {
            let response = request.responseText.trim();  // Ensure no extra spaces in response

            // Use the plain text response to determine the outcome
            if (response === "Product quantity updated in cart") {
                Swal.fire({
                    title: 'Updated',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'ok'
                });
            } else if (response === "Product added to cart") {
                Swal.fire({
                    title: 'Added',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'ok'
                });
            } else {
                // Handle error or other messages
                Swal.fire({
                    title: 'Error',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'ok'
                });
            }
        }
    }

    request.open("GET", "process//addToCart.php?id=" + id + "&qty=" + add_cart_qty, true);
    request.send();
}


function loadCartData() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {

        if (request.readyState === 4 & request.status === 200) {
            let response = request.responseText.trim();

            console.log(response);
        }

    }

    request.open("GET", "process//loadCartData.php", true);
    request.send();
}