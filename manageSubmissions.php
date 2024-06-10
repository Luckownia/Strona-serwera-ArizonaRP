<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php?newpwd=firstlogin");
    exit();
}
if ($_SESSION['user_rank'] != "Administrator") {
    header("Location: panel.php");
    exit();
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        #headline-manage {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .userOptions {
            font-size: 0.8em;
            padding: 5px 10px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }
        .userOptions:hover {
            background-color: #45a049;
        }
        .userDelete {
            background-color: red;
        }
        .userDelete:hover {
            background-color: #d30f0f;
        }
        .user-details {
            visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .user-details .btn-join-2 {
            padding: 20px;
            font-size: 18px;
        }
        .user-details .btn-join-2:first-child {
            margin-right: 20px;
        }

        .user-details .buttons {
            position: static;
        }

        .user-nickname {
            font-size: 30px;
            font-family: var(--fontfirst);
            font-weight: 700;
            color: var(--seventhcolor);
            margin-bottom: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 40px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            font-family: "Montserrat", sans-serif;
        }

        #newRankSelect {
            font-size: 17px;
            padding: 10px 20px;
            border: 1px solid lightgrey;
            border-radius: 25px;
            margin-right: 25px;
            margin-left: 10px;
        }
        #confirmRankChange {
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
            background: #444444;
            transition: all 0.3s ease;
            border-radius: 25px;
        }

        #confirmRankChange:hover {
            transform: scale(1.05);
            box-shadow: 2px 2px 10px #444444;
        }
        #rank-user-nickname {
            font-size: 24px;
            font-family: var(--fontfirst);
            font-weight: 700;
            color: black;
            margin-bottom: 40px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #users-table {
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 20px var(--seventhcolor);
            max-height: 400px;
            overflow-y: auto;
            width: 100%;
        }
        #users-table:hover {
            cursor: pointer;
        }

        #users-table th {
            background-color: var(--fourthcolor);
            color: var(--firstcolor);
            padding: 15px;
            text-align: left;
            border: 2px solid var(--seventhcolor);
        }

        #users-table td {
            padding: 15px;
            border: 2px solid var(--seventhcolor);
            color: var(--seventhcolor);
        }

        #applications-table {
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 20px var(--seventhcolor);
            max-height: 400px;
            overflow-y: auto;
            width: 100%;
        }

        #applications-table th {
            background-color: var(--fourthcolor);
            color: var(--firstcolor);
            padding: 15px;
            text-align: left;
            border: 2px solid var(--seventhcolor);
        }

        #applications-table td {
            padding: 15px;
            border: 2px solid var(--seventhcolor);
            color: var(--seventhcolor);
        }

        .container-car {
            margin-top: 20px;
            padding: 20px;
            border: 2px solid var(--seventhcolor);
            box-shadow: 0 2px 20px var(--seventhcolor);
            display: none;
        }

        .answer-content {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .answer-title {
            font-size: 18px;
            font-weight: bold;
        }

        .btn-show-answer {
            font-size: 0.8em;
            padding: 5px 10px;
            margin: 5px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-show-answer:hover {
            background-color: #45a049;
        }
        .btn-accept:hover{
           cursor:pointer;
        }
        .btn-reject:hover{
           cursor:pointer;
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
                    <a href="index.php" class="logo-link">ArizonaRP</a>
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
                    <li><a href="index.php" class="nav-link">Główna</a></li>
                    <li><a href="logout.php" class="nav-link">Wyloguj się</a></li>
                    <li><a href="panel.php" class="nav-link active">Panel</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="headline-manage" class="headline-section">
    <?php
        require 'database.php';
        $sql = "SELECT id_submission, id, nickname, type, answer1, answer2, answer3, date FROM submissions where status = 'Oczekujące'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            if ($result) {
                echo "<table border='1' id='applications-table'>";
                echo "<tr><th>Nick</th><th>Typ</th><th>Odpowiedź 1</th><th>Odpowiedź 2</th><th>Odpowiedź 3</th><th>Data</th><th>Akcja</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr data-id-submission='" . htmlspecialchars($row['id_submission'], ENT_QUOTES, 'UTF-8') . "' data-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>";
                    echo "<td>" . htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><button class='btn-show-answer' data-answer='" . htmlspecialchars($row['answer1'], ENT_QUOTES, 'UTF-8') . "'>Pokaż</button></td>";
                    echo "<td><button class='btn-show-answer' data-answer='" . htmlspecialchars($row['answer2'], ENT_QUOTES, 'UTF-8') . "'>Pokaż</button></td>";
                    echo "<td><button class='btn-show-answer' data-answer='" . htmlspecialchars($row['answer3'], ENT_QUOTES, 'UTF-8') . "'>Pokaż</button></td>";
                    echo "<td>" . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><button class='btn-accept' data-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' data-id-submission='" . htmlspecialchars($row['id_submission'], ENT_QUOTES, 'UTF-8') . "' data-type='" . htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8') . "'>&#10004;</button><button class='btn-reject' data-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' data-id-submission='" . htmlspecialchars($row['id_submission'], ENT_QUOTES, 'UTF-8') . "' data-type='" . htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8') . "'>&#10008;</button></td>";
                }
                echo "</table>";
            } else {
                echo "Błąd: " . mysqli_error($conn);
            }
        } else {
            echo "<h2 class='headline'>Nie znaleziono podań.</h2>"; 
        }
        echo '<a href="panel.php"><button class="btn-join-2" id="btn_back">Wróć</button></a>';
        mysqli_close($conn);
    ?>
    </div>

    <div class="container-car">

    </div>

    <div id="answer-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="answer-title">Odpowiedź</h2>
            <p class="answer-content"></p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="script-2.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const answerModal = document.getElementById('answer-modal');
    const answerContent = document.querySelector('.answer-content');
    const closeBtn = document.querySelector('.close');

    document.querySelectorAll('.btn-show-answer').forEach(button => {
        button.addEventListener('click', function () {
            const answer = this.getAttribute('data-answer');
            answerContent.innerHTML = answer;
            answerModal.style.display = 'block';
        });
    });

    closeBtn.addEventListener('click', function () {
        answerModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target == answerModal) {
            answerModal.style.display = 'none';
        }
    });
    function acceptSubmission(event) {
        // Pobieramy identyfikator podania
        const userId = event.target.getAttribute('data-id');
        const submissionId = event.target.getAttribute('data-id-submission');
        const submissionType = event.target.getAttribute('data-type');
        
        // Wywołujemy funkcję do zmiany rangi na "Gracz"
        if(submissionType == 'whitelist'){
            changeRank(userId, 'Gracz');
        }
        changeStatus(submissionId, 'Przyjęte');
        location.reload();
    }

    // Funkcja obsługująca kliknięcie na ikonkę odrzucenia
    function rejectSubmission(event) {
        // Pobieramy identyfikator podania
        const userId = event.target.getAttribute('data-id');
        const submissionId = event.target.getAttribute('data-id-submission');
        const submissionType = event.target.getAttribute('data-type');
        
        // Wywołujemy funkcję do zmiany rangi na "Niezdane"
        if(submissionType == 'whitelist'){
            changeRank(userId, 'Niezdane');
        }
        changeStatus(submissionId, 'Nieprzyjęte');
        location.reload();
    }

    // Funkcja do wysyłania żądania HTTP w celu zmiany rangi użytkownika
    function changeRank(submissionId, rank) {
        // Tworzymy obiekt FormData z danymi, które chcemy wysłać
        const formData = new FormData();
        formData.append('userId', submissionId);
        formData.append('newRank', rank);

        // Wysyłamy żądanie POST na odpowiedni adres URL
        fetch('updateRank.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Tutaj możesz obsłużyć odpowiedź z serwera, na przykład wyświetlić komunikat użytkownikowi
            console.log('Odpowiedź z serwera:', data);
        })
        .catch(error => {
            console.error('Wystąpił błąd:', error);
        });
    }
    function changeStatus(submissionId, status) {
        // Tworzymy obiekt FormData z danymi, które chcemy wysłać
        const formData = new FormData();
        formData.append('submissionId', submissionId);
        formData.append('newStatus', status);

        // Wysyłamy żądanie POST na odpowiedni adres URL
        fetch('updateSubmission.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Tutaj możesz obsłużyć odpowiedź z serwera, na przykład wyświetlić komunikat użytkownikowi
            console.log('Odpowiedź z serwera:', data);
        })
        .catch(error => {
            console.error('Wystąpił błąd:', error);
        });
    }

    // Dodajemy obsługę kliknięcia na ikonkę przyjęcia
    document.querySelectorAll('.btn-accept').forEach(button => {
        button.addEventListener('click', acceptSubmission);
    });

    // Dodajemy obsługę kliknięcia na ikonkę odrzucenia
    document.querySelectorAll('.btn-reject').forEach(button => {
        button.addEventListener('click', rejectSubmission);
    });
});
</script>
</body>
</html>
