function updateProduct(pid) {
    const mainCategory = document.getElementById("productCategory");
    const productName = document.getElementById("productName");
    const productDescription = document.getElementById("productDescription");
    const productPrice = document.getElementById("productPrice");
    const brandSelect = document.getElementById("brandSelect");
    const sizeSelect = document.getElementById("sizeSelect");
    const colorSelect = document.getElementById("colorSelect");
    const quantity = document.getElementById("quantity");

    const image1Tag = document.getElementById("image1");
    const image2Tag = document.getElementById("image2");
    const image3Tag = document.getElementById("image3");

    const currentImage1 = document.getElementById("currentImage1").value;
    const currentImage2 = document.getElementById("currentImage2").value;
    const currentImage3 = document.getElementById("currentImage3").value;

    // console.log(currentImage1);
    // console.log(currentImage2);
    // console.log(currentImage3);

    console.log(mainCategory.value, productName.value, productDescription.value, productPrice.value, brandSelect.value, sizeSelect.value, colorSelect.value, quantity.value);

    const data = new FormData();
    data.append("mainCategoryId", mainCategory.value);
    data.append("productName", productName.value);
    data.append("productDescription", productDescription.value);
    data.append("productPrice", productPrice.value);
    data.append("brandId", brandSelect.value);
    data.append("sizeId", sizeSelect.value);
    data.append("colorId", colorSelect.value);
    data.append("quantity", quantity.value);
    data.append("pid", pid);

    // Handle images: Send new files or current image paths
    data.append("image1", image1Tag.files[0] ? image1Tag.files[0] : currentImage1);
    data.append("image2", image2Tag.files[0] ? image2Tag.files[0] : currentImage2);
    data.append("image3", image3Tag.files[0] ? image3Tag.files[0] : currentImage3);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState === 4) {
            if (request.status === 200) {
                const response = request.responseText;
                console.log(response);

                if (response === "success") {
                    Swal.fire({
                        title: 'Product Updated!',
                        text: 'The product has been successfully updated.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong during the request.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    };

    request.open("POST", "process/productsUpdate.php", true);
    request.send(data);
}

// Event listeners for image inputs to detect cancellation or selection
document.getElementById("image1").addEventListener('change', handleImageChange);
document.getElementById("image2").addEventListener('change', handleImageChange);
document.getElementById("image3").addEventListener('change', handleImageChange);

function handleImageChange(event) {
    const imageInput = event.target;

    if (!imageInput.files[0]) {
        // User canceled image selection
        Swal.fire({
            title: 'No Image Selected!',
            text: `You canceled the image selection for ${imageInput.id}`,
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
    } else {
        // Display selected image
        console.log(`Image selected for ${imageInput.id}:`, imageInput.files[0].name);
    }
}
