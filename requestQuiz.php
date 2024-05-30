<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$questions = [
    'medic' => [
        'Medic.',
        'Napisz historię swojej postaci. (min. 200 słów)',
        'Napisz kreatywną akcję RP z udziałem twojej postaci. (min. 100 słów)'
    ],
    'police' => [
        'Mylicjant.',
        'Opisz swoje doświadczenie jako policjant. (min. 200 słów)',
        'Podaj przykładową akcję RP, w której uczestniczyłeś jako policjant. (min. 100 słów)'
    ],
    'mechanic' => [
        'Mechanic.',
        'Napisz historię swojego doświadczenia jako mechanik. (min. 200 słów)',
        'Opisz skomplikowaną naprawę, którą wykonałeś. (min. 100 słów)'
    ]
];

$job = isset($_GET['job']) ? $_GET['job'] : 'medic';
$current_questions = isset($questions[$job]) ? $questions[$job] : $questions['medic'];

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
            .next-btn:hover,.toQuestion:hover{
                opacity:0.9;
            }
            .next-btn,.toQuestion{
                margin-top: 20px;
                align-self:flex-end;
                padding: 20px 30px;
                border: none;
                font-size: 20px;
                font-family: var(--fontfirst);
                cursor:pointer;
                color: var(--seventhcolor);
                background-color: var(--eightcolor);
                border-radius:10px;
                font-weight: 600;
                letter-spacing:1px;
                text-transform: uppercase;
            }
            .clicked-answer{
                border:5px solid yellow;
            }

            .error-message {
                color: red;
                font-size: 18px;
                margin-top: 10px;
                font-weight:600;
                display:none;
            }
            .form-question{
                width: 500px;
                background: var(--fourthcolor);
                border-radius: 15px;
                box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: "Open Sans", sans-serif;
                padding:30px 60px;
            }
            .form-question input,textarea,.next-question{
                height: 100%;
                width: 100%;
                outline: none;
                font-size: 17px;
                padding-left: 20px;
                padding-top: 10px;
                border: 1px solid lightgrey;
                border-radius: 25px;
                transition: all 0.3s ease;
                margin-bottom: 20px;
                margin-top: 20px;
            }

            .form-question textarea{
                min-height:200px;
                border:5px solid var(--firstcolor);
            }

            .field input[type="submit"],.next-question {
                color: var(--seventhcolor);
                border: none;
                padding:10px 20px;
                font-size: 20px;
                font-weight: 500;
                cursor: pointer;
                background: var(--thirdcolor);
                transition: all 0.3s ease;
                border-radius: 25px;
            }
            .field input[type="submit"]:hover,.next-question:hover{
                transform:scale(1.05);
                box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
            }

            .form-question h2{
                color: var(--firstcolor);
                font-weight: 600;
                font-size: 30px;
                pointer-events: none;
                margin-bottom: 20px;
            }

            .hidden {
                display: none;
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
                        <a href="#" class="nav-link active"> requestQuiz</a>
                    </div>
                </nav>
                </header>
                    <div id="headline-panel" class="headline-section">
                    <form action="submitQuiz.php" method="post" class="form-question" id="quizForm">
                        <?php foreach ($current_questions as $index => $question): ?>
                            <div class="field <?php echo $index > 0 ? 'hidden' : ''; ?>" id="question<?php echo $index + 1; ?>">
                                <h2><?php echo htmlspecialchars($question); ?></h2>
                                <textarea name="answer<?php echo $index + 1; ?>" required></textarea>
                                <?php if ($index < count($current_questions) - 1): ?>
                                    <button class="next-question" type="button" onclick="nextQuestion(<?php echo $index + 2; ?>)">Dalej</button>
                                <?php else: ?>
                                    <input type="submit" value="Prześlij" name="send">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
            <script src="script-2.js"></script>
            <script>
                   //FORM WITH OPEN QUESTIONS 
                   function nextQuestion(questionNumber) {
                        // Ukryj wszystkie pytania
                        document.querySelectorAll('.form-question .field').forEach(function(field) {
                            field.classList.add('hidden');
                        });

                        // Pokaż następne pytanie
                        document.getElementById('question' + questionNumber).classList.remove('hidden');
                    }

                    
                    btnToQuestions.addEventListener('click',()=>{
                        document.getElementById('quizForm').addEventListener('submit', function(event) {
                            alert("Udało się przesłać formularz");
                        });
                    });
            </script>

            </body>

</html>