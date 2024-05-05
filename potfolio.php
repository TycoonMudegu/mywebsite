<?php
include 'navbar.php';

?>
<style>
body {

font-family: 'Source Serif 4';
}
.pill-container {
    display: flex;
    justify-content: space-around;
    margin-top: 50px;
}

.pill {
    background-color: transparent;
    color: #333;
    border: 2px solid #AFE1AF;
    border-radius: 20px;
    padding: 10px 20px;
    margin: 0 10px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s, box-shadow 1s;
    position: relative;
    font-size: 20px;
    letter-spacing: 2px;
}

.pill:hover {
    background-color: #AFE1AF;
    color: white;
    border-color: #AFE1AF;
    box-shadow: 0 5px 35px 0px rgba(0,0,0,.1);
}

#imageSection {
        display: flex;
        justify-content: center;
    }

    #imageSection img {
        width: 300px; /* Set the width of the images */
        height: auto; /* Maintain aspect ratio */
        margin: 10px; /* Add some margin between images */
    }


</style>

<div class="pill-container">
    <button class="pill" id="graphicDesignBtn">Graphic Design</button>
    <button class="pill" id="webDevelopmentBtn">Web Development</button>
    <button class="pill" id="microbiologyBtn">Other Endevours</button>
</div>

    <div id="imageSection"></div>

<script>

const graphicDesignBtn = document.getElementById('graphicDesignBtn');
const webDevelopmentBtn = document.getElementById('webDevelopmentBtn');
const microbiologyBtn = document.getElementById('microbiologyBtn');
const imageSection = document.getElementById('imageSection');

graphicDesignBtn.addEventListener('click', () => {
    loadImageSection('graphicDesign');
});

webDevelopmentBtn.addEventListener('click', () => {
    loadImageSection('webDevelopment');
});

microbiologyBtn.addEventListener('click', () => {
    loadImageSection('microbiology');
});

function loadImageSection(section) {
    let imageHTML = '';

    switch (section) {
        case 'graphicDesign':
            // Load graphic design images
            imageHTML = '<img src="https://niecollege.ac.ke/wp-content/uploads/2024/01/graphic-design.jpg"><img src="https://digitaltribe.ae/wp-content/uploads/2021/05/Graphic-designing.jpg" alt="Graphic Design Image 2">';
            break;
        case 'webDevelopment':
            // Load web development images
            imageHTML = '<img src="https://miro.medium.com/v2/resize:fit:1200/1*V-Jp13LvtVc2IiY2fp4qYw.jpeg" alt="Web Development Image 1"><img src="https://www.mooc.org/hubfs/javascript-jpg.jpeg" alt="Web Development Image 2">';
            break;
        case 'microbiology':
            // Load microbiology images
            imageHTML = '<img src="https://t4.ftcdn.net/jpg/01/30/82/47/360_F_130824738_8q37iy4194QUrFvsjTnnkrT01aoxgTPf.jpg" alt="Microbiology Image 1"><img src="https://www.verywellhealth.com/thmb/ZBhydG2TrCIW5x1Qyptk91Pla-k=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/petri-dish-containing-bacterial-culture-being-examined-with-inverted-light-microscope-in-microbiology-lab-561093901-5951a3795f9b58f0fc2682b7.jpg" alt="Microbiology Image 2">';
            break;
        default:
            break;
    }

    imageSection.innerHTML = imageHTML;
}


</script>