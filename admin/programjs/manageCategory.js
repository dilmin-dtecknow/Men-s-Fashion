function addCategory() {
    const categoryName = document.getElementById('category-name').value;

    console.log(categoryName);

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

    request.open("GET", "process/addCategory.php?category_name=" + categoryName, true);
    request.send();
}

function updateCategory(categoryId) {

    const newCatagory_Name = document.getElementById(`catagory_${categoryId}`).value;
    console.log(categoryId);
    console.log(newCatagory_Name);

    if (newCatagory_Name === "" || newCatagory_Name === null) {
        Swal.fire({
            title: 'Error',
            text: "Please Enter Category Name!",
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
                    text: "Successfuly Updated Category",
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

    request.open("GET", "process/updateCategoryName.php?category_name=" + newCatagory_Name + "&category_id=" + categoryId);
    request.send();

    // console.log('done');
}