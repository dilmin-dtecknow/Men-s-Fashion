function registerProduct() {
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

    // console.log(mainCategory.value);
    // console.log(productName.value);
    // console.log(productDescription.value);
    // console.log(productPrice.value);
    // console.log(brandSelect.value);
    // console.log(sizeSelect.value);
    // console.log(colorSelect.value);
    // console.log(quantity.value);

    // console.log(image1Tag.value);
    // console.log(image2Tag.value);
    // console.log(image3Tag.value);

    const data = new FormData();
    data.append("mainCategoryId", mainCategory.value);
    data.append("productName", productName.value);
    data.append("productDescription", productDescription.value);
    data.append("productPrice", productPrice.value);
    data.append("brandId", brandSelect.value);
    data.append("sizeId", sizeSelect.value);
    data.append("colorId", colorSelect.value);
    data.append("quantity", quantity.value);

    data.append("image1", image1Tag.files[0]);
    data.append("image2", image2Tag.files[0]);
    data.append("image3", image3Tag.files[0]);

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            console.log(response);
            if (response == "success") {
                Swal.fire({
                    title: 'Product Registation!',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
                window.location.reload();
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    }

    request.open("POST", "process//ProductRegistation.php", true);
    request.send(data);

}

const image1Tag = document.getElementById("image1");
const image2Tag = document.getElementById("image2");
const image3Tag = document.getElementById("image3");

// Add event listeners for each image input
image1Tag.addEventListener('change', function () {
    handleImageCancel(image1Tag);
});

image2Tag.addEventListener('change', function () {
    handleImageCancel(image2Tag);
});

image3Tag.addEventListener('change', function () {
    handleImageCancel(image3Tag);
});

function handleImageCancel(imageInput) {
    if (!imageInput.value) {
        // User canceled the image selection, the value is empty
        console.log("Image selection was canceled for:", imageInput.id);
        // Optionally, show a message or perform some action
        // alert("You have canceled the image selection for " + imageInput.id);
        Swal.fire({
            title: 'Error!',
            text: ("You have canceled the image selection for " + imageInput.id),
            icon: 'error',
            confirmButtonText: 'Cool'
        });
    } else {
        // Image has been selected
        console.log("Image selected:", imageInput.value);

    }
}