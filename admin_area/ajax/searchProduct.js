function searchProduct() {
    var productId = document.getElementById("search").value;
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("productTable").innerHTML = this.responseText;
        }
    };

    xhr.open("GET", "../controller/SearchProduct.php?search=" + productId, true);
    xhr.send();
}
