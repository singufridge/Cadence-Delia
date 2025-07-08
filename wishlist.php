#!/usr/bin/php-cgi
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wishlist</title>
    <?php include 'includes/header.php'; ?>
    <body>
        <div class="container text-center">
            <h1>Wishlist</h1>
            <br><br>
            <ul class="list-group" id="wishlist"></ul>
        </div>
        <?php include 'includes/footer.php'; ?>
    </body>
    <script>
        let wishlist = document.getElementById('wishlist');
        window.onload = displayList();

        function wishlistRemove(itemName) {
            window.localStorage.removeItem(itemName);
            displayList();
        }

        function addButton(li, itemName) {
            const button = document.createElement('button');
            button.className = "btn btn-info";
            button.textContent = "Remove Item";

            button.onclick=() => wishlistRemove(itemName);
            li.appendChild(button);
        };

        function displayList() {
            if (wishlist) {
                wishlist.innerHTML ='';
            }

            for (i = 0; i < localStorage.length; i++) {
                if (localStorage.key(i) != 'debug') {
                    const li = document.createElement('li');
                    li.className = "list-group-item d-flex justify-content-between";

                    let jsonProd = JSON.parse(localStorage.getItem(localStorage.key(i)));
                    li.innerHTML = "$" + jsonProd[0].price + " | " + jsonProd[0].product_name;
                    
                    if (wishlist) {
                        wishlist.appendChild(li);
                    }
                    addButton(li, localStorage.key(i));
                }
            }
        };
    </script>
</html>