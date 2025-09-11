function getBarcode(selectedValue) {
  var colour_id = document.getElementById(selectedValue);
  var productId = document.getElementById("p_id").innerText;
  // alert(productId);
  // alert(selectedValue);


  var form = new FormData();
  form.append("selectedColor", selectedValue);
  form.append("product_id", productId);


  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (this.readyState == 4) {
      var response = this.responseText;
      //   alert(response);
      document.getElementById('setBarcode').innerText = this.responseText;
    }
  };

  request.open("POST", "process//get_barcode.php", true);
  request.send(form);

}

function addtoWatchlist(pid) {
  console.log(pid);

  const request = new XMLHttpRequest();

  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      let response = request.responseText;

      console.log(response);
      if (response == 'Added') {
        document.getElementById("heart" + pid).style.className = "text-danger";
        Swal.fire({
          title: 'Product Added to Watchlist!',
          text: response,
          icon: 'success',
          confirmButtonText: 'ok'
        }).then((result) => {
          // Check if the "OK" button was pressed
          if (result.isConfirmed) {
            window.location.reload();
          }
        });

      } else if (response == 'Removed') {
        document.getElementById("heart" + pid).style.className = "text-dark";
        Swal.fire({
          title: 'Product Removed successfully to Watchlist!',
          text: response,
          icon: 'success',
          confirmButtonText: 'ok'
        }).then((result) => {
          // Check if the "OK" button was pressed
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      }else{
        Swal.fire({
          title: 'Some thing went wrong',
          text: response,
          icon: 'error',
          confirmButtonText: 'ok'
        }).then((result) => {
          // Check if the "OK" button was pressed
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      }
    }
  };

  request.open("GET", "process/addtoWatchlist.php?pid=" + pid, true);
  request.send();
}