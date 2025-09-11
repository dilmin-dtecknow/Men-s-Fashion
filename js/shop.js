function loadShop() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);

            if (response.success) {
                // console.log(response);
                updateProductView(response)
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please try again.',
                    icon: 'error',
                    confirmButtonText: 'Cool'
                });
            }
        }
    }

    request.open("GET", "process//loadShopData.php", true);
    request.send();

}

function searchProducts(firstResult) {
    // Get sort value
    let sort = document.getElementById('p-sort').value;

    // Get selected category
    let selectedCategory = document.querySelector('input[name="category"]:checked');
    let selectedCategoryId = selectedCategory ? selectedCategory.id : null;// If a category is selected, get its ID or value

    // Other selections like color, size, etc.
    let selectedColors = document.querySelector('input[name="colour"]:checked');
    let selectedColourId = selectedColors ? selectedColors.id : null;// If a colour is selected, get its ID or value

    let selectedSize = document.querySelector('input[name="size"]:checked');
    let selectedSizeId = selectedSize ? selectedSize.id : null;// If a colour is selected, get its ID or value

    // let priceRange = ""; 
    let selectedBrand = document.querySelector('input[name="brand"]:checked');
    let selectedbrandId = selectedBrand ? selectedBrand.id : null;// If a brand is selected, get its ID or value

    // Get min and max price range values
    let minPrice = document.getElementById('minPriceRange').value;
    let maxPrice = document.getElementById('maxPriceRange').value;

    // Print selected values (you can replace console.log with any other action)
    console.log("Sort:", sort);
    console.log("Selected Category ID:", selectedCategoryId);
    console.log("Selected Color:", selectedColourId);
    console.log("Selected Size:", selectedSizeId);
    console.log("Price Range: Rs.", minPrice, " - Rs.", maxPrice);
    console.log("Selected Brands:", selectedbrandId);

    const data = {
        firstResult: firstResult,
        category_id: selectedCategoryId,
        brand_id: selectedbrandId,
        size_id: selectedSizeId,
        price_range_start: minPrice,
        price_range_end: maxPrice,
        color_id: selectedColourId,
        sort_text: sort
    };



    const request = new XMLHttpRequest();
    request.open("POST", "process/searchProducts.php", true);
    request.setRequestHeader("Content-Type", "application/json");

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = JSON.parse(request.responseText);
            if (response.productList.length != 0) {
                console.log(response);
                updateProductView(response);
            } else {
                console.log('no product found');
                let product_container = document.getElementById("product-container");
                product_container.innerHTML = "";

                // Create and insert the h2 element with the message
                let noProductMessage = document.createElement("h2");
                noProductMessage.textContent = "No products found";
                noProductMessage.classList.add("center-highlight");  // Add the CSS class for styling
                product_container.appendChild(noProductMessage);
            }

        }
    }

    request.send(JSON.stringify(data));


}


var currentPage = 0;
var single_product = document.getElementById("single-product");
//pagination button
var pagination_button = document.getElementById("pagination-button");
function updateProductView(response) {
    // console.log(response);

    //start load product
    let product_container = document.getElementById("product-container");
    product_container.innerHTML = "";

    response.productList.forEach(product => {
        let single_product_clone = single_product.cloneNode(true);
        //  console.log(product.product_name);
        let productName = product.product_name;
        console.log(productName);
        //update details
        // single_product_clone.querySelector("#single-product-a-1").href = "shop-single.html?id=" + product.id;
        single_product_clone.querySelector("#single-product-img-1").src = "webImg/productImages/" + product.product_id + "/image1.png";
        if (product.qty > 0) {
            single_product_clone.querySelector("#single-product-a-2").href = "single_product.php?product_id=" + product.product_id;
        } else {
            let anchor = single_product_clone.querySelector("#single-product-a-2");
            anchor.removeAttribute("href"); // Remove the link

            // Optionally, style the button to look disabled
            // anchor.style.pointerEvents = "none";  // Disable click events
            // anchor.style.opacity = "0.5"; 
            anchor.style.backgroundColor = "#F9DAAC";         // Make it look disabled
        }

        single_product_clone.querySelector("#single-product-title").innerHTML = productName;
        single_product_clone.querySelector("#single-product-price").innerHTML = "Rs." + new Intl.NumberFormat("en-US", { minimumFractionDigits: 2 }).format(product.price);
        //update details
        product_container.appendChild(single_product_clone);
    });
    //end:load product

    //start pagination
    let pagination_container = document.getElementById("pagination-container");
    pagination_container.innerHTML = "";

    let product_count = response.allProductCount;
    const product_per_page = 6;
    let pages = Math.ceil(product_count / product_per_page);
    
    //Add privios button
    if (currentPage != 0) {
        let pagination_button_clone_prv = pagination_button.cloneNode(true);
        pagination_button_clone_prv.innerHTML = "&lt;";

        pagination_button_clone_prv.addEventListener("click", e => {
            currentPage--;
            searchProducts(currentPage * 6);
        });
        pagination_container.appendChild(pagination_button_clone_prv);
    }
    
    //add page buttons
    for (let i = 0; i < pages; i++) {
        let pagination_button_clone = pagination_button.cloneNode(true);
        pagination_button_clone.innerHTML = i + 1;

        pagination_button_clone.addEventListener("click", e => {
//            alert("ok");
            currentPage = i;
            searchProducts(i * 6);

        });

        if (i == currentPage) {
            pagination_button_clone.className = "active";
        } else {
            pagination_button_clone.className = "";
        }
        pagination_container.appendChild(pagination_button_clone);
    }
    
    //Add Next button
    if (currentPage != (pages - 1)) {
        let pagination_button_clone_next = pagination_button.cloneNode(true);
        pagination_button_clone_next.innerHTML = "&gt;";

        pagination_button_clone_next.addEventListener("click", e => {
            currentPage++;
            searchProducts(currentPage * 6);
        });
        pagination_container.appendChild(pagination_button_clone_next);
    }
    //end pagination
}








function updateMinPriceValue(value) {
    const maxRange = document.getElementById('maxPriceRange');
    if (parseInt(value) > parseInt(maxRange.value)) {
        document.getElementById('minPriceRange').value = maxRange.value;
        value = maxRange.value;
    }
    document.getElementById('minPriceRangeValue').textContent = value;
}

function updateMaxPriceValue(value) {
    const minRange = document.getElementById('minPriceRange');
    if (parseInt(value) < parseInt(minRange.value)) {
        document.getElementById('maxPriceRange').value = minRange.value;
        value = minRange.value;
    }
    document.getElementById('maxPriceRangeValue').textContent = value;
}





// function toggleSelection(checkboxId) {
//     var checkbox = document.getElementById(checkboxId);
//     console.log(checkboxId);
//     checkbox.checked = !checkbox.checked;
// }
// function colourSelection(colorID) {
//     var checkbox = document.getElementById(colorID);
//     console.log(colorID);
//     checkbox.checked = !checkbox.checked;
// }

// var siteSliderRange = function () {
//     $("#slider-range").slider({
//         range: true,
//         min: 0,
//         max: 10000,
//         values: [0, 10000],
//         slide: function (event, ui) {
//             $("#amount").val("Rs." + ui.values[0] + " - Rs." + ui.values[1]);
//         }
//     });
//     $("#amount").val("Rs." + $("#slider-range").slider("values", 0) +
//         " - Rs." + $("#slider-range").slider("values", 1));
// };
// siteSliderRange();

// Function to get selected filter values
// function searchProducts() {
//     // Get sort value
//     let sort = document.getElementById('p-sort').value;

//     // Get selected categories
//     let selectedCategories = [];
//     let categoryCheckboxes = document.querySelectorAll('input[id^="category_"]:checked');
//     categoryCheckboxes.forEach((checkbox) => {
//         selectedCategories.push(checkbox.nextElementSibling.textContent); // Get the label text
//     });

//     console.log("Selected Categories:", selectedCategories);

//     // Get selected colors
//     let selectedColors = [];
//     let colorCheckboxes = document.querySelectorAll('input[id^="color_"]:checked');
//     colorCheckboxes.forEach((checkbox) => {
//         selectedColors.push(checkbox.nextElementSibling.textContent.trim()); // Get the label text
//     });

//     // Get selected sizes
//     let selectedSizes = [];
//     let sizeCheckboxes = document.querySelectorAll('input[id^="s"], input[id^="m"], input[id^="l"]:checked');
//     sizeCheckboxes.forEach((checkbox) => {
//         selectedSizes.push(checkbox.nextElementSibling.textContent); // Get the label text
//     });

//     // Get price range
//     let priceRange = document.getElementById('priceRange').value;

//     // Get selected brands
//     let selectedBrands = [];
//     let brandCheckboxes = document.querySelectorAll('input[id^="brand"]:checked');
//     brandCheckboxes.forEach((checkbox) => {
//         selectedBrands.push(checkbox.nextElementSibling.textContent); // Get the label text
//     });

//     // Print selected values (you can replace console.log with any other action)
//     console.log("Sort:", sort);
//     console.log("Selected Categories:", selectedCategories);
//     console.log("Selected Colors:", selectedColors);
//     console.log("Selected Sizes:", selectedSizes);
//     console.log("Price Range:", priceRange);
//     console.log("Selected Brands:", selectedBrands);
// }

// const data = new FormData();
//     data.append("firstResult", firstResult);
//     data.append("category_id", selectedCategoryId);
//     data.append("brand_id", selectedbrandId);
//     data.append("size_id", selectedSizeId);
//     data.append("price_range_start", minPrice);
//     data.append("price_range_end", maxPrice);
//     data.append("color_id", selectedColourId);
//     data.append("sort_text", sort);


//     const request = new XMLHttpRequest();

//     request.onreadystatechange = () => {
//         if (request.readyState == 4 && request.status == 200) {
//             let response = JSON.parse(request.responseText);

//             console.log(response);
//         }
//     }

//     request.open("POST", "process//searchProducts.php", true);
//     request.send(data);