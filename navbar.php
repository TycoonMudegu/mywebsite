<?php
include 'head.php';

?>

<style>

    
/* Add a border and set initial styles for the "Contact" link */
.nav-link-contact {
position: relative; /* Enable absolute positioning for pseudo-element */
display: inline-block;
padding: 8px 12px;
border: 2px solid #4299e1; /* Blue border */
border-radius: 10px;
color: #4299e1; /* Blue text */
text-decoration: none; /* Remove underline */
transition: background-color 0.3s, color 0.3s; /* Smooth transition */
}

/* Change background and text color on hover */
.nav-link-contact:hover {
background-color: #4299e1; /* Blue background */
color: #fff; /* White text */
}

/* Create the animation starting from the left bottom */
.nav-link-contact::before {
content: '';
position: absolute;
bottom: 0;
left: 0;
height: 0;
width: 100%;
border-radius: 10px;
background-color: #4299e1; /* Blue color */
transition: height 0.3s; /* Smooth transition */
z-index: -1; /* Place behind the text */
}

/* Expand the pseudo-element on hover */
.nav-link-contact:hover::before {
height: 100%;
}

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


        .bg-white {
            /* From https://css.glass */
            background: rgba(227, 222, 222, 0.81);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5.1px);
            -webkit-backdrop-filter: blur(5.1px);
            border: 1px solid rgba(227, 222, 222, 0.35);
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .border-b-2 {
            border-bottom-width: 2px;
        }

        .border-transparent {
            border-color: transparent;
        }

        .font-serif {
            font-family: serif;
        }

        .text-3xl {
            font-size: 1.875rem;
        }

        .link {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s;
        }

        .text-green-800 {
            color: #2f855a;
        }

        .hover\:text-blue-500:hover {
            color: #4299e1;
        }

        .mt-16 {
            margin-top: 4rem;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .list {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .space-x-4 > :not(template) ~ :not(template) {
            --space-x-reverse: 0;
            margin-right: calc(1rem * var(--space-x-reverse));
            margin-left: calc(1rem * (1 - var(--space-x-reverse)));
        }

        .md\:hidden {
            display: none;
        }

        .w-6 {
            width: 1.5rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .md\:flex {
            display: flex;
        }

        .md\:justify-start {
            justify-content: flex-start;
        }

        .md\:space-x-4 > :not(template) ~ :not(template) {
            --space-x-reverse: 0;
            margin-right: calc(1rem * var(--space-x-reverse));
            margin-left: calc(1rem * (1 - var(--space-x-reverse)));
        }

        .md\:items-center {
            align-items: center;
        }

        .md\:text-left {
            text-align: left;
        }

        .md\:text-center {
            text-align: center;
        }

        .md\:text-right {
            text-align: right;
        }

        .md\:justify-between {
            justify-content: space-between;
        }

        .md\:flex-col {
            flex-direction: column;
        }

        .md\:space-y-4 > :not(template) ~ :not(template) {
            --space-y-reverse: 0;
            margin-top: calc(1rem * var(--space-y-reverse));
            margin-bottom: calc(1rem * (1 - var(--space-y-reverse)));
        }

        .md\:mt-8 {
            margin-top: 2rem;
        }

        .md\:mt-16 {
            margin-top: 4rem;
        }

        .md\:mt-24 {
            margin-top: 6rem;
        }

        .md\:pt-0 {
            padding-top: 0;
        }

        .md\:pt-4 {
            padding-top: 1rem;
        }

        .md\:pt-8 {
            padding-top: 2rem;
        }

        .md\:pt-16 {
            padding-top: 4rem;
        }

        .md\:pb-0 {
            padding-bottom: 0;
        }

        .md\:pb-4 {
            padding-bottom: 1rem;
        }

        .md\:pb-8 {
            padding-bottom: 2rem;
        }

        .md\:pb-16 {
            padding-bottom: 4rem;
        }

        .md\:px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .md\:border-b-2 {
            border-bottom-width: 2px;
        }

        .md\:border-transparent {
            border-color: transparent;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(10px);
            }
        }

        .sticky {
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }
    </style>
    </style>

    <header class="bg-white overflow:hidden sticky">
        <nav class="flex justify-between items-center py-4 px-6 border-b-2 border-transparent">
            <div>
                <a href="#" class="font-serif text-3xl">Mudegu Brian</a>
            </div>
            <?php
                function isActive($page)
                {
                    return strpos($_SERVER['REQUEST_URI'], $page) !== false ? 'link text-green-800 hover:text-blue-500 mt-16 font-serif text-xl' : 'link text-gray-600 hover:text-blue-500';
                }
            ?>

            

            <ul class="list hidden md:flex space-x-4">
                <li><a href="welcome" class="<?php echo isActive('welcome'); ?>">Home</a></li>
                <li><a href="about" class="<?php echo isActive('about'); ?>">Me</a></li>
                <li><a href="potfolio" class="<?php echo isActive('potfolio'); ?>">Portfolio</a></li>
                <li><a href="Reachout" class="nav-link-contact">Reach Out</a></li>
            </ul>
            <div class="md:hidden">
                <button>
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>