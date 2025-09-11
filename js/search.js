function serchProduct() {
   const searchText = document.getElementById('search-text').value.trim();
    console.log(searchText);

    if (searchText == '' || searchText == null) {
        window.location.reload();
        return;
    }

    if (searchText.length > 0) {
        // Send an AJAX request to search.php
        const request = new XMLHttpRequest();
        request.open('GET', `process/searchProductName.php?query=${encodeURIComponent(searchText)}`, true);
        request.onload = function() {
            if (this.status === 200) {
                // Show the search results
               let response = this.responseText;
                document.getElementById('product-results').innerHTML = "";
                document.getElementById('product-results').innerHTML = this.responseText;
                // console.log(response);
            }
        };
        request.send();
    } 
}