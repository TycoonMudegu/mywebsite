<?php
include 'navbar.php';

?>
 <style>
        body {
            font-family: 'Source Serif 4';
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .content {
            flex: 1;
        }

        .border-afe1af {
            border: 2px solid #AFE1AF;
        }

        .border-afe1af:hover {
            background-color: #AFE1AF;
            cursor: pointer;
            transform: translateY(-3px);
        }

        .border-cv {
            border: 2px solid black;
        }

        .border-cv:hover {
            background-color: black;
            color: white;
            transform: translateY(-3px);
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
            transform: translateY(-3px);
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

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #f9f9f9;
        }

        footer:hover {
            color: #AFE1AF;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .social-icons {
                justify-content: center;
            }
        }
    </style>


<body>
    <div class="content">
        <div class="flex flex-col justify-center items-center h-screen">
            <div class="text-center mb-8">
                <h2 class="text-4xl lg:text-6xl font-bold">Get in touch with me through <br>any of the following ways!</h2>
                <hr class="my-6 border-b border-gray-300 w-1/4 mx-auto">
            </div>
            <div class="flex justify-center items-center mb-8">
                <div class="border border-solid border-afe1af border-2 rounded-full px-4 py-2 mx-2"><i class="fa fa-envelope mr-2"></i> tycoonmudegu@gmail.com</div>
                <div class="border border-solid border-afe1af border-2 rounded-full px-4 py-2 mx-2"><i class="fa fa-phone mr-2"></i> +254 713 056 820</div>
                <a href="#" class="border-cv text-black px-4 py-2 mx-2 flex items-center justify-center border border-black"><i class="fa-solid fa-file-arrow-down mr-2"></i>  Download CV</a>
            </div>

            <div class="flex justify-end items-center mb-8">
                <a href="#" class="social-icon mx-2"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="//wa.me/254713056820" class="social-icon mx-2"><i class="fa fa-whatsapp"></i></a>
                <a href="http://linkedin.com/in/tycoon-mudegu-7766022b5" class="social-icon mx-2"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; Tycoon Mudegu</p>
    </footer>
</body>