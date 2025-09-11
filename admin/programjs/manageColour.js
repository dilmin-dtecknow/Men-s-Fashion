function addColour() {
    const colorName = document.getElementById('color-name').value;

    console.log(colorName);

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

    request.open("GET", "process/addColor.php?color_name=" + colorName, true);
    request.send();
}

function updateColour(colourId) {

    const newColourName = document.getElementById(`colour_${colourId}`).value;
    console.log(colourId);
    console.log(newColourName);

    if (newColourName === "" || newColourName === null) {
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
                    text: "Successfuly Updated Colour",
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

    request.open("GET", "process/updateColourName.php?colour_name=" + newColourName + "&colour_id=" + colourId);
    request.send();

    // console.log('done');
}
