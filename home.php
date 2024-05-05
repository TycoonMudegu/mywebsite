<?php
include 'navbar.php';

?>
<style>

/* Button styles */
.btn-reach-out,
.btn-know-me {
padding: 12px 24px;
color: #000; /* Set text color to black */
border: 2px solid #000; /* Black border */
background-color: transparent; /* Transparent background */
border-radius: 999px; /* Large border radius for a pill shape */
cursor: pointer;
transition: all 0.3s ease;
}

/* Hover effect */
.btn-reach-out:hover,
.btn-know-me:hover {
background-color: #000; /* Black background on hover */
color: #fff; /* White text on hover */
transform: translateY(-3px); /* Move the element 3px up on hover */
}

/* Active/focus state */
.btn-reach-out:focus,
.btn-know-me:focus {
outline: none;
}


.social-icons {
    display: flex;
    justify-content: flex-end;
    margin-top: 10%;
}

.social-icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    font-size: 20px;
    margin-right: 10px;
    border: 2px solid #000;
    border-radius: 50%;
    color: #000;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background-color: #000;
    color: #fff;
}

.social-icon:hover i {
    animation: rotate 0.5s ease;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}


</style>

<body>
    <!-- Your content here -->
<section class=" py-20">
        <div class="container mx-auto px-4">
            <div class="text-center md:text-left">
                <p class="text-lg text-gray-500 font-semibold">I am<span class="border-b-2 border-blue-500"> </span></p>
                <h1 class="text-4xl md:text-6xl font-bold">Mudegu Brian</h1>
                <p class="mt-2 text-lg text-gray-600">Lab Technician, Web Developer, Graphic Designer</p>
                <div class="mt-8 flex justify-center md:justify-start space-x-4">
                    <a href="Reachout" class="btn-reach-out">Reach Out</a>
                    <a href="about" class="btn-know-me">Know Me</a>
                </div>
            </div>
        </div>
    </section>

    <div class="social-icons">
        <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="//wa.me/254713056820" class="social-icon"><i class="fab fa-whatsapp"></i></a>
        <a href="http://linkedin.com/in/tycoon-mudegu-7766022b5" class="social-icon"><i class="fab fa-linkedin"></i></a>
    </div>
</body>


