function addCity() {
    const cityName = document.getElementById('city-name').value;
    const charge = document.getElementById('charge').value;

    console.log(cityName);

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

    request.open("GET", "process/addCity.php?city_name=" + cityName + "&shiping=" + charge, true);
    request.send();
}

function updateCity(cityId) {

    const newCityName = document.getElementById(`city_${cityId}`).value;
    const newShiping = document.getElementById(`cityShip_${cityId}`).value;
    console.log(cityId);
    console.log(newCityName);
    console.log(newShiping);

    if (newCityName === "" || newCityName === null) {
        Swal.fire({
            title: 'Error',
            text: "Please Enter City Name!",
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.reload();
        });
        return;
    }
    if (newShiping === "" || newShiping === null) {
        Swal.fire({
            title: 'Error',
            text: "Please Enter Shiping!",
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
                }).then(() => {
                    window.location.reload();
                });;
            }
        }
    };

    request.open("GET", "process/updateCity.php?city_name=" + newCityName + "&city_id=" + cityId + "&shipping=" + newShiping);
    request.send();

    // console.log('done');
}