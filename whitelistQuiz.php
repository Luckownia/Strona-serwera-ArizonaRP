<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require 'database.php'; // Wczytaj połączenie z bazą danych

// Przetwarzanie formularza
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Odczytaj odpowiedzi z formularza
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    
    // Odczytaj dane użytkownika z sesji
    $nickname = $_SESSION['user_nickname'];
    $user_id = $_SESSION['user_id'];
    
    // Wstawianie odpowiedzi do tabeli submissions
    $stmt = $conn->prepare("INSERT INTO submissions (id, nickname, type, answer1, answer2, answer3, date, status) VALUES ($user_id, ?, 'whitelist', ?, ?, ?, NOW(), 'oczekujące')");
    $stmt->bind_param("ssss", $nickname, $answer1, $answer2, $answer3);
    $stmt->execute();

      // Zaktualizuj rangę użytkownika
      $_SESSION['user_rank'] = 'Oczekuję';

      // Zaktualizuj rangę w bazie danych
      $stmt = $conn->prepare("UPDATE users SET rank = ? WHERE id = ?");
      $rank = 'Oczekuję';
      $stmt->bind_param("si", $rank, $_SESSION['user_id']);
      $stmt->execute();

    // Sprawdź, czy zapytanie zostało wykonane poprawnie
    if ($stmt->affected_rows > 0) {
        // Przekieruj użytkownika na panel.php
        header("Location: panel.php");
        exit();
    } else {
        echo "Wystąpił błąd podczas zapisywania odpowiedzi.";
    }
    
    $stmt->close();
    $conn->close();
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
                top: 55%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-family: var( --fontfirst);
                padding: 20px 60px;
                display:flex;
                justify-content:center;
                align-items:center;
                flex-direction:column;
                margin-top: 20px;
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
                padding: 20px 80px;
                border: none;
                font-size: 22px;
                color: var(--seventhcolor);
                background-color: var(--eightcolor);
                border-radius: 20px;
                margin-top: 20px;
                font-weight: 600;
                font-family: var( --fontfirst);
                cursor:pointer;
                border:5px solid var(--eightcolor);

            }
            .quiz-answer:hover,.next-btn:hover,.toQuestion:hover{
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
                display:none;
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
                        <a href="panel.php" class="nav-link active">Powrót</a>
                    </div>
                </nav>
                </header>
                    <div id="headline-panel" class="headline-section">
                        <div class="quiz">
                            <h2 id="question">Question 1:</h2>
                            <div class="error-message" id="error-message">Proszę zaznaczyć odpowiedź!</div>
                            <div class="quiz-btns">
                                <button class="quiz-answer">Answer 1</button>
                                <button class="quiz-answer">Answer 2</button>
                                <button class="quiz-answer">Answer 3</button>
                                <button class="quiz-answer">Answer 4</button>
                            </div>
                            <button class="next-btn">➤</button>
                            <button class="toQuestion hidden">Część pytań otwartych</button>
                        </div>
                        <form action="whitelistQuiz.php" method="post" class="form-question" id="quizForm">
                            <div class="field" id="question1">
                                <h2>Podaj imię i nazwisko swojej postaci.</h2>
                                <textarea name="answer1" required></textarea>
                                <button class ="next-question" type="button" onclick="nextQuestion(2)">Dalej</button>
                            </div>
                            
                            <div class="field hidden" id="question2">
                                <h2>Napisz historię swojej postaci. (min. 200 słów)</h2>
                                <textarea name="answer2" required></textarea>
                                <button class ="next-question" type="button" onclick="nextQuestion(3)">Dalej</button>
                            </div>
                            
                            <div class="field hidden" id="question3">
                                <h2>Napisz kreatywną akcję RP z udziałem twojej postaci. (min. 100 słów) </h2>
                                <textarea name="answer3" required></textarea>
                                <input type="submit" value="Prześlij" name="send">
                            </div>
                        </form>
                    </div>
            </div>


            <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
            <script src="script-2.js"></script>
            <script>
                const questions = [
                    {
                        question:"Jeżeli ktoś celowo ucieka do zielonej strefy, aby uniknąć akcji RP dozwolone jest kontynuowanie akcji, która została rozpoczęta poza GZ?",
                        answers:[
                            {text:"Tak",correct:false},
                            {text:"Nie",correct:false},
                            {text:"Tak (oprócz komendy głównej oraz szpitala)",correct:true},
                            {text:"Nie, chyba że akcja jest hostylna",correct:false}
                        ]
                    },
                    {
                        question:"Do czego służy przycisk Z?",
                        answers:[
                            {text:"Do sprawdzenia ID gracza łamiącego regulamin",correct:true},
                            {text:"Do sprawdzenia ile jest graczy na serwerze",correct:false},
                            {text:"Do zobaczenia czy ktoś jest w pobliżu",correct:false},
                            {text:"Do zaspamienia czatu",correct:false}
                        ]
                    },
                    {
                        question:"Czy za pomocą komendy /do można kłamać?",
                        answers:[
                            {text:"Tak",correct:false},
                            {text:"Nie",correct:true},
                            {text:"Tylko jeżeli jest to dobrze usprawiedliwione",correct:false},
                            {text:"Tak, ale tylko gdy inny gracz używa MG",correct:false}
                        ]
                    },
                    {
                        question:"Czy możesz rozpoznać zamaskowaną osobę po głosie albo kolorze skóry??",
                        answers:[
                            {text:"Nie",correct:true},
                            {text:"Tak",correct:false},
                            {text:"Tak, jeżeli dużo czasu spędzałeś z tą osobą",correct:false},
                            {text:"Tak, jeżeli jest to osoba publicznie znana",correct:false}
                        ]
                    },
                    {
                        question:"Kiedy można przeszukać innego gracza?",
                        answers:[
                            {text:"Kiedy stoi AFK i go skujemy",correct:false},
                            {text:"Po zastrzeleniu go bez inicjacji",correct:false},
                            {text:"Po inicjacji i skuciu go",correct:true},
                            {text:"Kiedy jest nieprzytomny, a my nie uczestniczyliśmy w akcji",correct:false}
                        ]
                    },
                    {
                        question:"Ilu niepodstawionych zakładników potrzeba aby zorganizować napad?",
                        answers:[
                            {text:"3",correct:false},
                            {text:"0",correct:false},
                            {text:"2",correct:false},
                            {text:"1",correct:true}
                        ]
                    },
                    {
                        question:"Co mozesz wziac od nieprzytomnego policjanta?",
                        answers:[
                            {text:"Pałkę",correct:false},
                            {text:"Nic",correct:true},
                            {text:"Latarkę",correct:false},
                            {text:"Tazer",correct:false}
                        ]
                    },
                    {
                        question:"Co jest głównym wyznacznikiem tego, czy pojazd nadaje się do jazdy terenowej?",
                        answers:[
                            {text:"Przystosowanie pojazdu do poruszania się po nieubitej nawierzchni",correct:true},
                            {text:"Typ opon",correct:false},
                            {text:"Marka pojazdu",correct:false},
                            {text:"Rok produkcji pojazdu",correct:false}
                        ]
                    },
                    {
                        question:"Jakie zachowanie obywatela usprawiedliwia użycie PG przez medyków?",
                        answers:[
                            {text:"Poprawne wylegitymowanie się",correct:false},
                            {text:"Wykonywane poleceń",correct:false},
                            {text:"Wykazywanie nadmiernej agresji słownej",correct:true},
                            {text:"Medycy nie mogą użyć PG",correct:false}
                        ]
                    },
                    {
                        question:"Czy policja może zatrzymać w szpitalu obywatela po BW?",
                        answers:[
                            {text:"Tak",correct:false},
                            {text:"Nie",correct:false},
                            {text:"Tylko gdy obywatel łamie regulamin",correct:false},
                            {text:"Tylko jeżeli obywatel uniknął akcji RP poprzez odrodzeie się w szpitalu",correct:true}
                        ]
                    }
                ];
                const quizQuestion = document.querySelector('#question');
                const quizAnswers = document.querySelectorAll('.quiz-answer');
                const nextBtn = document.querySelector('.next-btn');
                const btnToQuestions = document.querySelector(".toQuestion");

                let currentIndex = 0;
                let score = 0;

                function showQuestion() {
                    let currentQuestion = questions[currentIndex];
                    let questionNo = currentIndex + 1;
                    quizQuestion.textContent = questionNo + ". " + currentQuestion.question;

                    quizAnswers.forEach((button, index) => {
                        //reset active status
                        quizAnswers.forEach(answer => {
                                answer.classList.remove("clicked-answer");
                        });
                        button.textContent = currentQuestion.answers[index].text;
                        //Status active when click answer
                        button = document.querySelectorAll('.quiz-answer')[index];
                        button.addEventListener("click", () => {
                            quizAnswers.forEach(answer => {
                                answer.classList.remove("clicked-answer");
                            });
                            button.classList.add("clicked-answer");
                            button.dataset.correct = currentQuestion.answers[index].correct;
                        });
                    });
                }

                showQuestion();

                nextBtn.addEventListener('click', () => {

const selectedAnswer = document.querySelector('.quiz-answer.clicked-answer');
const errorMessage = document.querySelector('.error-message');
if (!selectedAnswer) {
    errorMessage.style.display = 'block';
    return;
}

if (selectedAnswer.dataset.correct === "true") {
    score++;
}
errorMessage.style.display = 'none';
currentIndex++;
if (currentIndex < questions.length) {
    showQuestion();
} else {
    if (score >= 8) {
        quizQuestion.textContent = "Gratulujemy zdania 1 czesci zapraszamy na nastepna! Twój wynik: " + score * 10 + "%";
        quizAnswers.forEach(button => button.style.display = 'none');
        nextBtn.style.display = 'none';
        btnToQuestions.classList.remove("hidden");
    } else {
        quizQuestion.textContent = "Niestety nie udało ci sie zdać, zapraszamy jutro. Twój wynik: " + score * 10 + "%";
        quizAnswers.forEach(button => button.style.display = 'none');
        nextBtn.style.display = 'none';
        btnToQuestions.innerHTML = "Powrót";
        btnToQuestions.classList.remove("hidden");

        // Dodajemy event listener na przekierowanie do panel.php
        btnToQuestions.addEventListener('click', () => {
            window.location.href = 'panel.php';
        });
    }
}
});

btnToQuestions.addEventListener('click', () => {
if (score >= 8) {
    const formQuestion = document.querySelector('.form-question');
    const quizQuestion = document.querySelector('.quiz');
    formQuestion.style.display = 'block';
    quizQuestion.style.display = 'none';

    // FORM

    document.getElementById('quizForm').addEventListener('submit', function(event) {
        alert("Udało się przesłać formularz");
    });
}
});


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
                    const formQuestion = document.querySelector('.form-question');
                    const quizQuestion = document.querySelector('.quiz');
                    formQuestion.style.display='block';
                    quizQuestion.style.display='none';

                    //FORM

                    document.getElementById('quizForm').addEventListener('submit', function(event) {
                        alert("Udało się przesłać formularz");
                    });
            });
            </script>

    </body>

    </html>