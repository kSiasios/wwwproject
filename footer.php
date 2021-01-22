<!--- Footer --->
<footer class="footer">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-md-4"
                style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
                <img src="/Project2/images/logo.png">
                <hr class="light">
                <p>555-555-5555</p>
                <p>email@myemail.com</p>
                <p>100 Street Name</p>
                <p>City, Country, 00000</p>
            </div>
            <div class="col-md-4"
                style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
                <hr class="light">
                <h5>Our Hours</h5>
                <hr class="light">
                <p>Monday - Friday: 9am - 5pm</p>
                <p>Saturday: 10am - 4pm</p>
            </div>
            <div class="col-md-4"
                style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
                <hr class="light">
                <h5>Service Area</h5>
                <hr class="light">
                <p>City, Country, 00000</p>
                <p>City, Country, 00000</p>
                <p>City, Country, 00000</p>
            </div>
            <div class="col-12">
                <hr class="light">
                <h5>&copy;2020-2021 myDomainName.com</h5>
            </div>
        </div>
    </div>
</footer>
<!--- Go to Top Button --->

<button id="scrolltoTop"><i class="fas fa-angle-up"></i></button>
<script>
const scrolltoTop = document.querySelector("#scrolltoTop");

scrolltoTop.addEventListener("click", function() {
    //window.scrollTo(0, 0);
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
    })

    //$("html, body").animate({ scrollTop: 0 }, "slow");
});
</script>

</body>

</html>