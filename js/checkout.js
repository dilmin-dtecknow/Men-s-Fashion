//payHear
// Payment completed. It can be a successful failure.
payhere.onCompleted = function onCompleted(orderId) {

    console.log("Payment completed. OrderID:" + orderId);

    // window.location = "thankyou.html";
    window.location.href = "invoice.php?order_id=" + orderId;
};

// Payment window closed
payhere.onDismissed = function onDismissed() {
    console.log("Payment dismissed");
};

// Error occurred
payhere.onError = function onError(error) {
    console.log("Error:" + error);
};

function loadCheckout() {

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState === 4 && request.status === 200) {

            const response = JSON.parse(request.responseText);

            // Check if the success property is true
            if (response.success) {
                // Handle the success case (e.g., load address, city list, cart items)

                const address = response.address;
                const cityList = response.cityList;
                const cartList = response.cartList;

                console.log("Address: ", response.address);
                console.log("Cities: ", response.cityList);
                console.log("Cart Items: ", response.cartList);

                //load cities
                let citySelect = document.getElementById("city");
                citySelect.length = 1;
                cityList.forEach(city => {
                    let cityOption = document.createElement("option");
                    cityOption.value = city.id;
                    cityOption.innerHTML = city.name;
                    citySelect.appendChild(cityOption);
                });

                //set current address
                let diferentAddressCheckbox = document.getElementById("c_ship_different_address");
                diferentAddressCheckbox.addEventListener("change", e => {

                    let first_name = document.getElementById("checkout-fname");
                    let last_name = document.getElementById("checkout-lname");
                    let city = document.getElementById("city");
                    let address1 = document.getElementById("checkout-addressl1");
                    let address2 = document.getElementById("checkout-addressl2");
                    let postal_code = document.getElementById("checkout-zip-code");
                    let mobile = document.getElementById("checkout-mobile");

                    if (!diferentAddressCheckbox.checked) {
                        first_name.value = "";
                        last_name.value = "";
                        city.value = 0;
                        city.disabled = false;
                        city.dispatchEvent(new Event("change"));

                        address1.value = "";
                        address2.value = "";
                        postal_code.value = "";
                        mobile.value = "";

                    } else {

                        first_name.value = address.first_name;
                        last_name.value = address.last_name;
                        city.value = address.city_id;
                        city.disabled = true;
                        city.dispatchEvent(new Event("change"));

                        address1.value = address.line1;
                        address2.value = address.line2;
                        postal_code.value = address.postal_code;
                        mobile.value = address.mobile;
                    }
                });


                //load ceckout items
                let tbody = document.getElementById("cs-tbody");
                let item_tr = document.getElementById("item-tr");
                let order_subtotal_tr = document.getElementById("order-subtotal-tr");
                let order_shipping_tr = document.getElementById("order-shipping-tr");
                let order_total_tr = document.getElementById("order-total-tr");
                tbody.innerHTML = "";

                let sub_total = 0;
                cartList.forEach(item => {
                    let item_clone = item_tr.cloneNode(true);
                    item_clone.querySelector("#item-title").innerHTML = item.product_name;
                    item_clone.querySelector("#item-qty").innerHTML = item.qty;

                    let item_sub_total = item.price * item.qty;
                    sub_total += item_sub_total;

                    item_clone.querySelector("#item-subtotal").innerHTML = new Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(item_sub_total);

                    tbody.appendChild(item_clone);
                });

                order_subtotal_tr.querySelector("#subtotal").innerHTML = new Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(sub_total);
                tbody.appendChild(order_subtotal_tr);


                //update total on city change
                citySelect.addEventListener("change", e => {
                    const selectedCityId = parseInt(citySelect.value);
                    const selectedCity = cityList.find(city => city.id == selectedCityId);

                    // const selectedCity = cityList.find(city => {
                    //     console.log(`City ID: ${city.id}, Selected City ID: ${selectedCityId}`);
                    //      city.id === selectedCityId;
                    // });

                    //update shipping caharges
                    console.log(selectedCityId);
                    console.log(selectedCity);
                    // Remove previous shipping and total rows if they exist
                    // if (tbody.contains(order_shipping_tr)) {
                    //     tbody.removeChild(order_shipping_tr);
                    // }
                    // if (tbody.contains(order_total_tr)) {
                    //     tbody.removeChild(order_total_tr);
                    // }

                    if (selectedCity) {
                        //get cat item count
                        let item_count = cartList.length;
                        let shipping_amount = item_count * selectedCity.shipping_charge;

                        console.log("Selected city shipping charge:", selectedCity.shipping_charge);
                        console.log("Shipping amount:", shipping_amount);


                        order_shipping_tr.querySelector("#shipping-amount").innerHTML = new Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(shipping_amount);

                        tbody.appendChild(order_shipping_tr);

                        //update total
                        let total = sub_total + shipping_amount;
                        order_total_tr.querySelector("#total").innerHTML = new Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(total);
                        tbody.appendChild(order_total_tr);
                    } else {
                        console.log("false");
                    }
                });


            } else if (response.message == 'Not signed in.') {
                // Handle the case where the request did not succeed

                window.location = "login.php";
            } else {
                // console.log("Message: ", response.message);
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                });
            }

        }
    }

    request.open("GET", "process//loadCheckout.php", true);
    request.send();
}

function checkout() {

    let isCurentAddressCheckbox = document.getElementById("c_ship_different_address").checked;


    //get address data
    let first_name = document.getElementById("checkout-fname");
    let last_name = document.getElementById("checkout-lname");
    let city = document.getElementById("city");
    let address1 = document.getElementById("checkout-addressl1");
    let address2 = document.getElementById("checkout-addressl2");
    let postal_code = document.getElementById("checkout-zip-code");
    let mobile = document.getElementById("checkout-mobile");

    const data = new FormData();
    data.append("first_name", first_name.value);
    data.append("last_name", last_name.value);
    data.append("city", city.value);
    data.append("address1", address1.value);
    data.append("address2", address2.value);
    data.append("postal_code", postal_code.value);
    data.append("mobile", mobile.value);
    data.append("isCurentAddressCheckbox", isCurentAddressCheckbox);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            const response = JSON.parse(request.responseText);

            if (response.success) {
                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1223369",    // Replace your Merchant ID
                    "return_url": undefined,     // Important
                    "cancel_url": undefined,     // Important
                    "notify_url": "",
                    "order_id": response.paymentDetails.order,
                    "items": response.paymentDetails.items,
                    "amount": response.paymentDetails.amount,
                    "currency": "LKR",
                    "hash": response.paymentDetails.hash, // *Replace with generated hash retrieved from backend
                    "first_name": response.paymentDetails.fname,
                    "last_name": response.paymentDetails.lname,
                    "email": response.paymentDetails.mail,
                    "phone": response.paymentDetails.mobile,
                    "address": response.paymentDetails.address,
                    "city":  response.paymentDetails.city,
                    "country": "Sri Lanka",
                    "delivery_address": response.paymentDetails.address,
                    "delivery_city": response.paymentDetails.city,
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };
                payhere.startPayment(payment);
                Swal.fire({
                    title: 'Completed',
                    // text: response.content,
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'ok'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                });
            }

        }
    }

    request.open("POST", "process//checkOut.php", true);
    request.send(data);

}

function capitalizeFirstLetter(input) {
    const value = input.value;
    input.value = value.charAt(0).toUpperCase() + value.slice(1);
}