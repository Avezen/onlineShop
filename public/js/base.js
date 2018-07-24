$(document).ready(function() {
    $("#showCart").click(function () {
        showShoppingCart();
        return false;
    });

    $("#login").click(function () {
        login();
        return false;
    });

    $("#userPanel").click(function () {
        userPanel();
        return false;
    });

    $('#loginform').on("click", "#getRegisterForm", function () {
        showShoppingCart();
        return false;
    });

});


$(window).scroll(function () {
    myFunction();
});

var header = document.getElementById("header");
var sticky = header.offsetTop;

function myFunction() {

    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}

function getRegisterForm() {
    const xhttp = new XMLHttpRequest();
    var registerform = document.getElementById('modal-content');
    if (registerform.style.display === "none") {
        if (registerform.innerHTML === "") {

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    registerform.innerHTML = this.responseText ;

                }
            };
            xhttp.open("GET", "{{ path('fos_user_registration_register') }}", true);
            xhttp.send();
        }
    }
}

function userPanel(){
    var panel = document.getElementById('loginform');

    if(panel.style.display === "none") {
        panel.style.display = "block";
    }
    else {
        panel.style.display = "none";
    }
}


function login(){
    const xhttp = new XMLHttpRequest();
    var loginform = document.getElementById('loginform');
    if(loginform.style.display === "none"){
        if(loginform.innerHTML === ""){
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    loginform.innerHTML = this.responseText ;

                }
            };
            xhttp.open("GET", "{{ path('fos_user_security_login') }}", true);
            xhttp.send();
        }
        document.getElementById('login').style.display="none";
        loginform.style.display = "block";
    }else{
        loginform.style.display = "none";
    }
}



function showShoppingCart(){
    var cart = document.getElementById('shoppingCart');

    if (cart.style.display === 'none') {

        if (cart.innerHTML === "") {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    cart.innerHTML = this.responseText;
                    cart.style.display = 'block';
                }
            };
            xhttp.open("GET", "{{ path('shoppingCart') }}", true);
            xhttp.send();
        }
    } else {
        cart.style.display = 'none';
    }
}

var slideIndex = 1;
showSlides(slideIndex);



// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

var slideShow = 0;
automaticSlides();

function automaticSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides fading");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideShow++;
    if (slideShow > slides.length) {slideShow = 1}
    slides[slideShow-1].style.display = "block";
    setTimeout(automaticSlides, 8000); // Change image every 2 seconds
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides fading");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";

}
