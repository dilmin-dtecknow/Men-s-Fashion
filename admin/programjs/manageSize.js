function addSize() {
    const sizeName = document.getElementById('size-name').value;

    console.log(sizeName);

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

    request.open("GET", "process/addSize.php?size_name=" + sizeName, true);
    request.send();
}

function updateSize(sizedId) {

    const newSizeName = document.getElementById(`size_${sizedId}`).value;
    console.log(sizedId);
    console.log(newSizeName);

    if (newSizeName === "" || newSizeName === null) {
        Swal.fire({
            title: 'Error',
            text: "Please Enter Size Name!",
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
                    text: "Successfuly Updated SizeS",
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

    request.open("GET", "process/updateSizeName.php?size_name=" + newSizeName + "&size_id=" + sizedId);
    request.send();

    // console.log('done');
}