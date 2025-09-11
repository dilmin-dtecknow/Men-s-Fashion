function addBrand() {
    const brandName = document.getElementById('brand-name').value;

    console.log(brandName);

    const request = new XMLHttpRequest();


    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            console.log(response);

            if (response == 'success') {
                window.location.reload();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'ok'
                });
            }
        }
    };

    request.open("GET", "process/addBrand.php?b_name=" + brandName, true);
    request.send();
}

function updateBrand(brandId) {

    const currentBName = document.getElementById(`brand_${brandId}`).value;
    console.log(brandId);
    console.log(currentBName);

    if (currentBName === "" || currentBName === null) {
        Swal.fire({
            title: 'Error',
            text: "Please Enter Brand Name!",
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.reload();
        });
        return;
    }

    const request = new XMLHttpRequest();

    request.onreadystatechange = () => {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            console.log(response);

            if (response == 'success') {
                Swal.fire({
                    title: 'Updated',
                    text: "Successfuly Updated Brand",
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    };

    request.open("GET", "process/updateBrandName.php?b_name=" + currentBName + "&bid=" + brandId);
    request.send();

    // console.log('done');
}