<?php
session_start();
$sShowProducts  = "";
$sShowLogin  = "";
$sShowAddProduct = "";
$sShowSeeUsers = "";

if( isset( $_SESSION['jUser'] ) )
{
    // show product page
    $sShowProducts  = "show";
    if ($_SESSION['sAdmin'] == true){

        $sShowAddProduct = "show";
        $sShowSeeUsers   = "show";
    }
}
else
{
    // show the login page for regular users
    $sShowLogin = "show";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EXAM WEBSHOP</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>


<div id="frontPage" class="currentPage <?php echo $sShowLogin; ?>" >
    <!--ELEMENTS: SIGNUP & LOG IN-->
    <div id="userForm">

    <form id="frmSignIn">

        <h1>SIGN IN</h1>
        <p>E-MAIL ADDRESS</p>
        <input type="text" name="userEmail" placeholder="Email">
        <p>PASSWORD</p>
        <input type="password" name="userPassword" placeholder="Password">

        <button type="button" id="btnSignIn">SIGN IN</button>


    </form>


    <form id="frmSignUp">

        <h1>SIGN UP</h1>
        <p>DON'T HAVE AN ACCOUNT YET ?</p>
        <p>FIRST NAME</p>
        <input type="text" name="userFirstName" placeholder="First Name">
        <p>LAST NAME</p>
        <input type="text" name="userLastName" placeholder="Last Name">
        <p>E-MAIL ADDRESS</p>
        <input id="userEmail" type="email" name="userEmail" placeholder="Email">
        <p>PASSWORD</p>
        <input id="userPassword" type="password" name="userPassword" placeholder="Password">
        <p>PHONE NUMBER</p>
        <input type="number" name="userPhoneNumber" placeholder="Phone Number">
        <p>UPLOAD A PROFILE PICTURE</p>
        <input type="file" name="userProfilePicture">

        <button type="button" id="btnCreateAccount">CREATE ACCOUNT</button>

    </form>


    </div>

</div>

<div id="pageViewProducts" class="currentPage <?php echo $sShowProducts; ?>" >

    <!--user Info-->
    <div id="boxUserInfo">
        <h2 style="color:white">MY PROFILE</h2>

        <div id="count"></div>
        <img src="img/cart.png">


        <form id="frmLoggedUser">

            <h1>Update Profile</h1>

            <p>NAME</p>
            <input type="text" name="updateLoggedUserName" placeholder="First Name">
            <p>Email</p>
            <input type="text" name="updateLoggedUserEmail" placeholder="Email">
            <p>PASSWORD</p>
            <input type="text" name="updatedLoggedUserPassword" placeholder="Password">

            <button type="button" id="btnSaveUpdatedUserLogged">Update Changes</button>

        </form>


        <!--NEWSLETTER FORM-->
        <form id="frmNewsletter">
        <h2>Sign up for our news letter</h2>
        <input type="text" name="emailNewsletter" placeholder="insert email">
        <button type="button" id="btnSaveNewsletter">SUBMIT</button>
        </form>


        <button id="btnLogout" type="button">LOGOUT</button>

        <button  type="button" id="btnAddProducts" class="adminButton  <?php echo $sShowAddProduct; ?>" >Add Products</button>
        <button   type="button" id="btnSeeUsers" class="adminButton <?php echo $sShowSeeUsers; ?>">See Users</button>

    </div>


    <div id="boxProducts"></div>


    </div>


    <div id="pageAddProducts">

        <button class="btnBack"><-BACK</button>

        <form id="frmAddProduct">

            <h1>Add a new product</h1>

        <p>NAME</p>
        <input type="text" name="nameProduct" placeholder="Product Name">
        <p>PRICE</p>
        <input type="text" name="priceProduct" placeholder="PRICE">
        <p>PRODUCT PICTURE</p>
        <input type="file" name="pictureProduct">

        <button type="button" id="btnSaveProduct">SAVE PRODUCT</button>

        </form>

        <div id="boxListProducts"></div>

        <form id="frmUpdateProduct">

            <h1>Update product</h1>

            <p>NAME</p>
            <input type="text" name="updatedNameProduct" placeholder="Product Name">
            <p>PRICE</p>
            <input type="text" name="updatedPriceProduct" placeholder="PRICE">
            <p>PRODUCT PICTURE</p>
            <input type="file" name="updatedPictureProduct">

            <button type="button" id="btnSaveChanges">SAVE CHANGES</button>

        </form>


    </div>



<div id="pageListUsers" >

    <button class="btnBack"><-BACK</button>

    <div id="userList"></div>

    <form id="frmUpdateUserInfo">

        <h1>Update User</h1>

        <p>NAME</p>
        <input type="text" name="updateUserName" placeholder="First Name">
        <p>EMAIL</p>
        <input type="text" name="updateUserEmail" placeholder="Email">
        <p>PASSWORD</p>
        <input type="text" name="updateUserPassword" placeholder="Password">

        <button type="button" id="btnSaveUserChanges">SAVE</button>

    </form>

</div>



<div id="findStore">
    <h3>You can find us here</h3>
    <div id="map"></div></div>


<script>



   //Sign up

    btnCreateAccount.addEventListener("click", saveUser);
        //console.log("X");
        //here we need to push the data through api-save-user.php to the data.txt
        function saveUser() {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var sDataFromServer = JSON.parse(this.responseText);
                   // console.log("Response: ",sDataFromServer);
                }
            };
            request.open("POST", "api-save-user.php", true);
            var aFrmUser = new FormData(frmSignUp);
            request.send(aFrmUser);
        };

        //Sign in
   getProducts();
   getAllProducts();
   getUserInfo();
   getAllUsers();

   btnSignIn.addEventListener("click", function () {
            //console.log("X");

         var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    var jDataFromServer = JSON.parse( this.responseText );

                    if( jDataFromServer.login == "ok" )
                    {
                        console.log("WELCOME", jDataFromServer.idUser);

                        getUserInfo();

                        changePages();
                    }
                    else
                    {
                        console.log("LOGIN FAIL - TRY AGAIN");
                        console.log(jDataFromServer);

                    }
                }
            };
            request.open("POST", "api-login.php", true);
            var jFrmLogin = new FormData(frmSignIn);
            request.send(jFrmLogin);
    });


        //Logout

       btnLogout.addEventListener( "click" , function(){
           var ajax = new XMLHttpRequest();
           ajax.onreadystatechange = function()
           {
               // console.log("x")
               document.getElementById("pageViewProducts").style.display = "none";
               document.getElementById("frontPage").style.display = "flex";
           };
           ajax.open( "GET", "api-logout.php" , true );
           ajax.send();
       });


     //Show user details after login


        function getUserInfo() {

            var sDivUser = "";

            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var sDataFromServer = this.responseText;
                    //console.log(sDataFromServer);
                    var aDataFromServer = JSON.parse(sDataFromServer);
                    // console.log( aDataFromServer );
                    sDivUser += '    <div><span> Welcome ' + aDataFromServer.firstName + '</span>\
                                    <div><button id="btnEditUserLogged" data-id="'+aDataFromServer.id+'">Edit Information</button></div>\
                                     <span>' + aDataFromServer.lastName + '</span></div>\
                                     <div><span>' + aDataFromServer.email + '</span>\
                                     <span>' + aDataFromServer.phoneNumber + '</span></div>\
                                     <div><img src="' + aDataFromServer.image + '"></div>\  ';


                    boxUserInfo.insertAdjacentHTML("beforeend", sDivUser);
                    setupEditButtonsUsers();
                }
            };

            ajax.open("GET", "api-get-user-info.php", true);
            ajax.send();

        }


    // Show all users

   function getAllUsers() {

       var sDivUsers = "";
       var ajax = new XMLHttpRequest();
       ajax.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
               var sDataFromServer = this.responseText;
               // console.log(sDataFromServer);
               var aDataFromServer = JSON.parse(sDataFromServer);
               console.log( aDataFromServer );
               for (var i = 0; i < aDataFromServer.length; i++) {
                   sDivUsers += '<div><span> Welcome ' + aDataFromServer[i].firstName + '</span>\
                                     <span>' + aDataFromServer[i].lastName + '</span></div>\
                                     <div><span>' + aDataFromServer[i].email + '</span>\
                                     <span>' + aDataFromServer[i].phoneNumber + '</span></div>\
                                     <div><img src="' + aDataFromServer[i].image + '"></div>\
                                    <div><button id="btnDeleteUser" data-id="'+aDataFromServer[i].id+'">Delete User</button></div>\
                                    <div><button id="btnEditUsers" data-id="'+aDataFromServer[i].id+'">Edit User</button></div>'
                   ;
               }

               userList.insertAdjacentHTML("beforeend", sDivUsers);
               deleteSingleUser();
               setupUpdateButtonsUsers();
           }
       };

       ajax.open("GET", "api-get-all-users.php", true);
       ajax.send();

   }


        //function to show and hide pages

        function changePages(){
            pageViewProducts.style.display = "flex";
            frontPage.style.display = "none";
        };


    //List of products on front page

   function getProducts() {


        var sDivsProducts = "";
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var sDataFromServer = this.responseText;
                // console.log(sDataFromServer);
                var aDataFromServer = JSON.parse( sDataFromServer );
                // console.log( aDataFromServer );
                for( var i = 0; i < aDataFromServer.length; i++){
                    sDivsProducts += '<div><span>' + aDataFromServer[i].productName + '</span>\
                                     <div><span>' + aDataFromServer[i].price +'</span>\
                                    <div><button id="btnBuyProduct">Buy Product</button></div>\
                                     <div><img src="'+aDataFromServer[i].productPicture +'"></div>';

                }

               // console.log(sDivsProducts);

                boxProducts.insertAdjacentHTML("beforeend", sDivsProducts);
                buyProduct();
            }

        };
    
        ajax.open( "GET", "api-get-products.php", true );
        ajax.send();

   }

    //List of products on ADD PRODUCTS page

   function getAllProducts() {

   var sDivListProducts = "";
   var ajax = new XMLHttpRequest();
   ajax.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
           var sDataFromServer = this.responseText;
           // console.log(sDataFromServer);
           var aDataFromServer = JSON.parse( sDataFromServer );
           // console.log( aDataFromServer );
           for( var i = 0; i < aDataFromServer.length; i++){
               sDivListProducts += '<div><span>' + aDataFromServer[i].productName + '</span></div>\
                                    <div><span>' + aDataFromServer[i].price +'</span></div>\
                                    <div><img src="'+aDataFromServer[i].productPicture +'"></div>\
                                    <div><button id="btnDeleteProduct" data-id="'+aDataFromServer[i].id+'">Delete Product</button></div>\
                                    <div><button id="btnEditProduct" data-id="'+aDataFromServer[i].id+'">Edit Product</button></div>'
                  ;
           }


           //console.log(sDivsProducts);

           boxListProducts.insertAdjacentHTML("beforeend", sDivListProducts);
           deleteSingleProduct();
           setupEditButtons();
       }

   };

   ajax.open( "GET", "api-get-products.php", true );
   ajax.send();

   }

   //Add products form

   btnSaveProduct.addEventListener("click", saveProduct);
   //console.log("X");
   //here we need to push the data through api-save-user.php to the data.txt
   function saveProduct() {
       var request = new XMLHttpRequest();
       request.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var sDataFromServer = JSON.parse(this.responseText);
               // console.log("Response: ",sDataFromServer);
           }
       };
       request.open("POST", "api-save-products.php", true);
       var aFrmProduct = new FormData(frmAddProduct);
       request.send(aFrmProduct);
   };



   //Go Back Button

    var btnBack = document.querySelector(".btnBack");

    btnBack.addEventListener("click", function () {
        //console.log("X");
       pageViewProducts.style.display = "flex";
    });

    //show add product page after clicking the btnAddPrd

    btnAddProducts.addEventListener("click", function () {
        //console.log("X");
        pageAddProducts.style.display = "flex";
        pageViewProducts.style.display = "none";
    });

    //show user list after clicking btnSeeUser

    btnSeeUsers.addEventListener("click", function () {
        //console.log("X");
        pageListUsers.style.display = "flex";
        pageViewProducts.style.display = "none";
    });


        //desktop notification
      function notifyMe() {

        // Let's check whether notification permissions have already been granted
        if (Notification.permission === "granted") {
            // If it's okay let's create a notification
            displayNotification();
        }
        // Otherwise, we need to ask the user for permission
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
                // If the user accepts, let's create a notification
                if (permission === "granted") {
                    displayNotification();
                }
            });
        }
    }


        function displayNotification(){
            var notification = new Notification("WEBSHOP",{
                "icon":"https://www.brabbu.com/resources/images/products/128/gallery/andes-armchair-1-HR.jpg",
                "body":"20% on this product today!"
            });
        }

 setTimeout( function(){
        notifyMe();

    } , 10000 );


    //counter for bought products

    var count = 0;
    function increaseNumber() {
        count++ ;
            //console.log(count);
        document.getElementById("count").innerHTML = "Purchased items " + count ;
        var oSound = new Audio('sound.mp3');
        oSound.play();
    }


    // Increase number everytime the buy product btn was clciked
    function buyProduct() {
        btnBuyProduct = document.querySelectorAll("#btnBuyProduct");
        for (var i = 0; i < btnBuyProduct.length; i++) {
            btnBuyProduct[i].addEventListener("click", increaseNumber);
        }
    }

 //delete product from data.txt

   function getSingleProduct(e) {
       var productId = e.target.getAttribute('data-id');
       var request = new XMLHttpRequest();
       request.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
              // var sDataFromServer = JSON.parse(this.responseText);
               console.log(this.responseText)

           }
       };
       request.open("GET", "api-delete-product.php?id=" + productId);
       request.send();

   }

       function deleteSingleProduct()      {
           btnsDeleteProduct = document.querySelectorAll("#btnDeleteProduct");
           for (var i = 0; i < btnsDeleteProduct.length; i++) {
               btnsDeleteProduct[i].addEventListener("click", getSingleProduct);
               //console.log("X")
           }
       }


   //delete user from users.txt

   function getSingleUser(e) {
       var singleUserId = e.target.getAttribute('data-id');
       var request = new XMLHttpRequest();
       request.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
               // var sDataFromServer = JSON.parse(this.responseText);
               console.log(this.responseText)

           }
       };
       request.open("GET", "api-delete-user.php?id=" + singleUserId);
       request.send();

   }

   function deleteSingleUser()      {
       btnsDeleteOneUser = document.querySelectorAll("#btnDeleteUser");
       for (var i = 0; i < btnsDeleteOneUser.length; i++) {
           btnsDeleteOneUser[i].addEventListener("click", getSingleUser);
           //console.log("X")
       }
   }


   // UPDATE USERS FROM THE LIST



   function setupUpdateButtonsUsers()      {
       btnsEditUserInfo = document.querySelectorAll("#btnEditUsers");
       for (var i = 0; i < btnsEditUserInfo.length; i++) {
           btnsEditUserInfo[i].addEventListener("click", function (e){
               console.log("x");
               var userChangeId = e.target.getAttribute('data-id');
               btnSaveUserChanges.setAttribute('data-id',userChangeId);
               btnSaveUserChanges.addEventListener("click", updateOneUser);
               frmUpdateUserInfo.style.display = "grid"
           });
           //console.log("X");
       }
   }

   function updateOneUser(e) {
       var updateNewUserId = e.target.getAttribute('data-id');
       var request = new XMLHttpRequest();
       request.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
              // var sDataFromServer = JSON.parse(this.responseText);
              //  console.log(this.responseText)

           }
       };
       request.open("POST", "api-update-users.php", true);
       var aFrmUpdateUserInfo = new FormData(frmUpdateUserInfo);
       aFrmUpdateUserInfo.append("id",updateNewUserId );
       request.send(aFrmUpdateUserInfo);

   }





   // UPDATE PRODUCTS


   // edit product
   function setupEditButtons()      {
       btnsEditProduct = document.querySelectorAll("#btnEditProduct");
       for (var i = 0; i < btnsEditProduct.length; i++) {
           btnsEditProduct[i].addEventListener("click", function (e){
               var productId = e.target.getAttribute('data-id');
               btnSaveChanges.setAttribute('data-id',productId);
               btnSaveChanges.addEventListener("click", updateSingleProduct);
               frmUpdateProduct.style.display = "grid"
           });
           //console.log("X");
       }
   }

   function updateSingleProduct(e) {
       var updateProductId = e.target.getAttribute('data-id');
       var request = new XMLHttpRequest();
       request.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
               var sDataFromServer = JSON.parse(this.responseText);
               // console.log(this.responseText)

           }
       };
       request.open("POST", "api-update-product.php", true);
       var aFrmUpdateProduct = new FormData(frmUpdateProduct);
       aFrmUpdateProduct.append("id",updateProductId );
       request.send(aFrmUpdateProduct);

   }



   // UPDATE LOGGED IN USER
 // edit user
   function setupEditButtonsUsers()      {
       btnEditUserLogged.addEventListener("click", function (e){
           //console.log("X")
           var userId = e.target.getAttribute('data-id');
           btnSaveUpdatedUserLogged.setAttribute('data-id', userId);
           btnSaveUpdatedUserLogged.addEventListener("click", updateSingleUser);
           frmLoggedUser.style.display = "grid"
           });
           //console.log("X");
       }


   function updateSingleUser(e) {
       var updateUserId = e.target.getAttribute('data-id');
       var request = new XMLHttpRequest();
       request.onreadystatechange = function () {
           if (this.readyState == 4 && this.status == 200) {
              // var sDataFromServer = JSON.parse(this.responseText);
               //console.log(this.responseText)

           }
       };
       request.open("POST", "api-update-user.php", true);
       var aFrmUpdateUser = new FormData(frmLoggedUser);
       aFrmUpdateUser.append("id",updateUserId );
       request.send(aFrmUpdateUser);

   }




   //NEWSLETTER

   btnSaveNewsletter.addEventListener("click", saveNewsletter);
   //console.log("X");
   //here we need to push the data through api-save-user.php to the data.txt
   function saveNewsletter() {
       //console.log("X");
       var request = new XMLHttpRequest();
       request.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var sDataFromServer = JSON.parse(this.responseText);
              // console.log("Response: ",sDataFromServer);
           }
       };
       request.open("POST", "api-save-newsletter.php", true);
       var aFrmNewsletter = new FormData(frmNewsletter);
       request.send(aFrmNewsletter);
   };


   //GOOGLE MAPS


   function initMap() {
       var uluru = {lat: 55.686080, lng: 12.587755};
       var map = new google.maps.Map(document.getElementById('map'), {
           zoom: 15,
           center: uluru
       });
       var marker = new google.maps.Marker({
           position: uluru,
           map: map
       });
   }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBl6t4Jo97hSf4uQH_XcbEhspiuSjYuZiY&callback=initMap">
</script>


</body>
</html>