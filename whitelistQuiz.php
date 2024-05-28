<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ArizonaRP</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" href="public/css/style.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap"
            rel="stylesheet">
        <style>
            .quiz{
                background: var(--fourthcolor);
                border-radius: 15px;
                box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: var( --fontfirst);
                padding: 20px 60px;
                display:flex;
                justify-content:center;
                align-items:center;
                flex-direction:column;
            }
            .quiz-btns{
                display:flex;
                flex-direction:column;
            }
            #question{
                color: var(--firstcolor);
                font-size:30px;
            }

            .quiz-answer{
                margin-bottom: 20px;
                padding: 25px 80px;
                border: none;
                font-size: 22px;
                text-transform: uppercase;
                color: var(--seventhcolor);
                background-color: var(--eightcolor);
                border-radius: 20px;
                margin-top: 20px;
                font-weight: 600;
                font-family: var( --fontfirst);
                cursor:pointer;
            }
            .quiz-answer:hover{
                opacity:0.9;
            }
        </style>
    </head>

    <body>
        <span class="mouse"></span>
            <div class="landing-page">
                <header>
                <nav>
                    <div class="navbar">
                        <div class="logo">
                            <img src="public/assets/palm-tree-48.png" alt="palm-tree" width="48px">
                            <a href="#" class="logo-link">ArizonaRP</a>
                        </div>
                        <label class="switch-mode-container">
                            <input type="checkbox" class="switch-mode-checkbox">
                            <span class="btn-switch-mode" tabindex="0">
                                <span class="circle">
                                    <img src="public/assets/sun.png" alt="light-sun" class="circle-image">
                                </span>
                            </span>
                        </label>
                        <button class="hamburger">
                         <span class="pasek1"></span>
                        </button>
                        <ul class="navigation">
                            <li> <a href="index.php" class="nav-link"> Główna</a> </li>
                            <li> <a href="logout.php" class="nav-link"> Wyloguj się</a> </li>
                            <li> <a href="panel.php" class="nav-link active"> Panel</a> </li>
                        </ul>

                    </div>
                </nav>
                </header>
                    <div id="headline-panel" class="headline-section">
                        <div class="quiz">
                            <h2 id="question">Question 1:</h2>
                            <div class="quiz-btns">
                                <button class="quiz-answer">Answer 1</button>
                                <button class="quiz-answer">Answer 2</button>
                                <button class="quiz-answer">Answer 3</button>
                                <button class="quiz-answer">Answer 4</button>
                            </div>
                        </div>
                    </div>
            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
            <script src="script-2.js"></script>
            <script>
                const headline_panel = document.querySelector("#headline_panel");
                headline_panel.addEventListener("mouseenter", animateCursor);
                headline_panel.addEventListener("mouseleave", removeAnimateCursor);

                const all_btn = document.querySelectorAll(".btn-join-2");
                all_btn.forEach(btn => {
                    btn.addEventListener("mouseenter", animateCursor);
                    btn.addEventListener("mouseleave", removeAnimateCursor);
                });
            </script>

    </body>

    </html>