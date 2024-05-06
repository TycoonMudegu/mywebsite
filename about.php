<?php
include 'navbar.php';
// Get the current URI
$uri = $_SERVER['REQUEST_URI'];

// Debugging
echo 'Current URI: ' . $uri . '<br>';

?>

<style>
body {

font-family: 'Source Serif 4';
}
/* Hide scrollbar for Chrome, Safari and Opera */
body::-webkit-scrollbar {
    display: none;
}

.splash {
    height: 100vh;
    background-color: #AFE1AF;
    background-image: url('https://www.textures.com/system/gallery/photos/Fabric/Otherfabric/47929/FabricOtherfabric0011_1_S.jpg');
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.scroll-indicator {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 36px;
    animation: bounce 1s infinite alternate;
}

.scroll-indicator::before {
    content: "";
    display: block;
    width: 40px;
    height: 40px;
    border: 6px solid #333;
    border-width: 0 6px 6px 0;
    transform: rotate(45deg);
    margin: 0 auto;
}

@keyframes bounce {
    from {
        transform: translateY(0);
    }
    to {
        transform: translateY(20px);
    }
}

/* section adter  */
.description {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ace598;
    opacity: 1;
    background-image:  radial-gradient(#e3e3e3 0.9500000000000001px, transparent 0.9500000000000001px), radial-gradient(#e3e3e3 0.9500000000000001px, #ace598 0.9500000000000001px);
    background-size: 38px 38px;
    background-position: 0 0,19px 19px;
    height: 100vh; /* Set the height of the section */
}

.container {
    text-align: center; /* Center the text inside the container */
    max-width: 800px; /* Set a max-width for the container */
    padding: 0 20px; /* Add some padding to the container */
}

.skills {
    height: 100vh;
    background-image: radial-gradient(#ace598 2.5px, transparent 2.5px), radial-gradient(#ace598 2.5px, transparent 2.5px);
    background-size: 24px 24px;
    background-position: 0 0, 12px 12px;
    background-color: #fafafa;
    padding: 50px 0; /* Adjust the padding as needed */
}

.skill {
   
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.skill:hover {
    transform: translateY(-5px);
}

.skill h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.skill p {
    color: #555;
}


/* Smooth scrolling */
html {
            scroll-behavior: smooth;
        }

        .arrow-section {
        height: 100vh; /* Full height of the viewport */
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f0f0f0;
    }

    .pill-link {
        display: inline-flex;
        align-items: center;
        padding: 32px 64px; /* Increased padding for a larger pill */
        border-radius: 9999px; /* Use a large value to create a pill shape */
        font-size: 25px;
        color: black; /* Text color */
        text-decoration: none;
        border: 2px solid black; /* Border */
        transition: background-color 0.3s ease, color 0.3s ease;
        position: relative;
    }

    .pill-link:hover {
        background-color: black; /* Background color on hover */
        color: white; /* Text color on hover */
    }

    .pill-link span {
        margin-right: 8px;
    }

    .pill-link i {
        margin-left: 8px;
        transition: transform 0.3s ease; /* Animation for arrow */
    }

    .pill-link:hover i {
        transform: translateX(20px); /* Move arrow to the right on hover */
    }

</style>



<div class="splash" onclick="scrollToNextSection()">
    <h1 style="font-size: 36px; font-weight: bold;">Just Scroll down</h1>
    <p style="font-size: 24px;">More is waiting </p>
</div>
<div class="scroll-indicator"></div>

<section class="description" onclick="scrollToNextSection()">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4">Who Is this Mudegu Brian ? </h2>
        <p class="text-lg text-gray-700">
        I am Mudegu Brian, a highly skilled and versatile professional based in Eldoret, Kenya. With a background in both graphic design and coding, I bring a unique blend of creativity and technical expertise to my work. Proficient in Corel software and Abobe creative Suite. I have a knack for creating visually captivating concepts and responsive websites. My coding skills extend to HTML, CSS, JavaScript, PHP, MySQL and Python, allowing me to develop dynamic and functional web solutions. In addition to my digital skills, I also possess a strong foundation in industrial microbiology and biotechnology laboratory practices, with experience in operating and troubleshooting laboratory equipment. Fluent in French. I am a dedicated learner and have pursued a Bachelor of Technology in Industrial Microbiology and Biotechnology at the Technical University of Mombasa, with an expected graduation date of July 2024. In my professional journey, I have been recognized with awards such as Atachee of the year and Best graphic designer, alongside certifications in Google Coding and PHP. My passion for innovation has driven me to undertake projects like a Personal Website, Hospital Management System, School Management System, and the establishment of The Mudegu Group. I am known for my attention to detail, strong work ethic, and commitment to excellence in all endeavors.
</p>
    </div>
</section>

<section class="skills bg-gray-100 py-20" onclick="scrollToNextSection()">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center">Skills</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="skill">
                <h3 class="text-xl font-bold mb-2">Laboratory Works</h3>
                <p class="text-gray-700">Proficient in industrial microbiology, biotechnology, and phlebotomy, with skills in equipment operation, sample preparation, and safety.</p>
            </div>
            <div class="skill">
                <h3 class="text-xl font-bold mb-2">JavaScript</h3>
                <p class="text-gray-700">Implemented interactive form validation in JavaScript for a website, enhancing user experience and data accuracy.</p>
            </div>
            <div class="skill">
                <h3 class="text-xl font-bold mb-2">HTML</h3>
                <p class="text-gray-700">Designed responsive web pages with HTML, ensuring compatibility across devices for optimal user experience.</p>
            </div>
            <div class="skill">
                <h3 class="text-xl font-bold mb-2">PHP</h3>
                <p class="text-gray-700">Developed dynamic web applications using PHP, ensuring functionality and interactivity for seamless user experience.</p>
            </div>
            <div class="skill">
                <h3 class="text-xl font-bold mb-2">CSS</h3>
                <p class="text-gray-700">Designed responsive website layouts with CSS, ensuring compatibility across devices and enhancing visual appeal.</p>
            </div>
            <div class="skill">
                <h3 class="text-xl font-bold mb-2">Graphic Design</h3>
                <p class="text-gray-700">Created visually stunning graphics for various projects, blending creativity with technical skills and client requirements.</p>
            </div>
        </div>
    </div>

</section>


<section class="arrow-section" onclick="scrollToNextSection()">
    <a href="potfolio" class="pill-link">
        <span>See my work</span>
        <i class="fa-solid fa-arrow-right-long"></i>
    </a>
</section>

<script>
      function scrollToNextSection() {
            const currentSection = document.querySelector('.arrow-section');
            const nextSection = currentSection.nextElementSibling;
            const offset = nextSection.offsetTop - currentSection.offsetHeight;

            window.scrollTo({
                top: offset,
                behavior: 'smooth'
            });
        }
    </script>
