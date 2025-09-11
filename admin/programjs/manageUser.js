function stateChange(statusId, uid) {
    console.log(statusId);
    console.log(uid);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;
            console.log(response);
            if (response == 'success') {
                window.location.reload();
            }
        }
    }

    request.open("GET", "process/stateChange.php?statusid=" + statusId + "&userid=" + uid, true);
    request.send();
}

function searchUser() {
    let searchText = document.getElementById('search-txt').value;
   console.log(searchText);

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

   request.open("GET", "process/SearchUsers.php?text=" + searchText, true);
   request.send();
}