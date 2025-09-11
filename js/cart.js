function removeCart(p_id) {

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText.trim();

            if (response === "Product removed from cart") {
                Swal.fire({
                    title: 'Removed',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'ok'
                });
                window.location = 'cart.php';
            }else{

                Swal.fire({
                    title: 'Error',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'ok'
                });
            }
            
            // if(t == "success"){
            //     alert ("Product delete from cart");
            //     window.location.reload();
            // }else{
            //  alert (t);   
            // }

        }
    }

    request.open("GET", "process//removeProduct_cart.php?id=" + p_id, true);
    request.send();

}

// function updateCart(product_id){
//     // console.log(product_id);
//     // console.log(document.getElementById("update_qty").value);

//   const data =  new FormData();
//   data.append("product_id",product_id);
//   data.append("update_qty",document.getElementById("update_qty").value);

//   const request = new XMLHttpRequest();
//   request.onreadystatechange = function(){
//     if (request.readyState == 4) {
//        var response = request.responseText;

//        if(response == "success"){

//        }else{

//         alert(response);

//        }
//     }
//   };

//   request.open("POST","process//update_cart.php",true);
//   request.send(data);
// }