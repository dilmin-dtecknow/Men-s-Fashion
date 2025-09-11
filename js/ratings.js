function rateProduct(productId, rating) {
    // Highlight the stars based on the rating

    console.log(rating);
    console.log(productId);

    for (let i = 1; i <= 5; i++) {
        const starElement = document.getElementById(`star-${productId}-${i}`);
        if (i <= rating) {
            starElement.style.color = 'gold'; // Highlight selected stars
        } else {
            starElement.style.color = 'gray'; // Reset unselected stars
        }
    }

    // Send the rating to the server using AJAX
    const request = new XMLHttpRequest();
    request.open('POST', 'process/rate_product.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // request.onload = function () {
    //     if (xhr.status === 200) {
    //         alert('Rating submitted successfully!');
    //     } else {
    //         alert('Failed to submit rating.');
    //     }
    // };

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText.trim();

            console.log(response);
            if (response == 'Rating submitted successfully') {
                console.log(response);
                Swal.fire({
                    title: 'Information Message!',
                    text: response,
                    icon: 'info',
                    confirmButtonText: 'ok'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                console.log(response);
            }
        }
    };
    request.send(`product_id=${productId}&rating=${rating}`);
}
