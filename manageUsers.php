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
        .userOptions {
            font-size: 0.8em; /* Zmniejszenie rozmiaru czcionki */
            padding: 5px 10px; /* Zmniejszenie paddingu */
            margin: 5px; /* Dodanie marginesu między przyciskami */
            background-color: #4CAF50; /* Kolor tła */
            color: white; /* Kolor tekstu */
            border: none; /* Usunięcie obramowania */
            border-radius: 5px; /* Zaokrąglenie rogów */
            cursor: pointer; /* Zmiana kursora na wskaźnik */
            right: 60%;
            top: -300px;
            display: none; /* Przyciski są ukryte na początku */
        }
        .userOptions:hover {
            background-color: #45a049; /* Kolor tła po najechaniu */
        }
        .userDelete {
            background-color: red; /* Kolor tła po najechaniu */
        }
        .userDelete:hover{
            background-color: darkred; /* Kolor tła po najechaniu */
        }
        .user-details{
            visibility: hidden;
        }
        /* Stylowanie dla okna modalnego */
        .modal {
            display: none; /* Ukrywamy modal na początku */
            position: fixed; /* Pozycjonowanie absolutne względem okna przeglądarki */
            z-index: 9999; /* Wysoki indeks z-index, aby być na wierzchu */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Przezroczyste tło */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Wyrównanie do środka */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Szerokość okna modalnego */
            max-width: 400px; /* Maksymalna szerokość */
        }

        /* Stylowanie przycisku zamknięcia */
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

    
        /* Styl dla całej tabelki */
        #users-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        margin-top: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        
        }

        /* Styl dla nagłówków tabelki */
        #users-table th {
        background-color: var(--fourthcolor);
        color: var(--firstcolor);
        padding: 15px;
        text-align: left;
        border: 2px solid var(--seventhcolor);
        }

        /* Styl dla komórek tabelki */
        #users-table td {
        padding: 15px;
        border: 2px solid var(--seventhcolor);
        color:var(--seventhcolor);
        }
     

    </style>
</head>
<body>
<div class="modal" id="changeRankModal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="rank-user-nickname">Wybierz nową rangę dla:</h2>
        <form id="changeRankForm" action="update_rank.php" method="post">
            <input type="hidden" id="userId" name="userId">
            <select id="newRankSelect" name="newRank"> <!-- Dodanie atrybutu name -->
                <option value="rekrut">Rekrut</option>
                <option value="gracz">Gracz</option>
                <option value="administrator">Administrator</option>
            </select>
            <button id="confirmRankChange" type="submit">Potwierdź</button>
        </form>
    </div>
</div>
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
                    <li><a href="index.php" class="nav-link">Główna</a></li>
                    <li><a href="logout.php" class="nav-link">Wyloguj się</a></li>
                    <li><a href="panel.php" class="nav-link active">Panel</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="headline-panel" class="headline-section">
        <?php
        require 'database.php';
        $sql = "SELECT id, nickname, rank FROM users";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<table border='1' id='users-table'>";
            echo "<tr><th>Nazwa użytkownika</th><th>Ranga</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr data-user-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' data-user-nickname='" . htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') . "'>";
                echo "<td>" . htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['rank'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
        echo '<a href="panel.php"><button class="btn-join-2">Wróć</button></a>';
        mysqli_close($conn);
        ?>
    </div>

    <div class="container-car">
        <div class="user-details">
            <div class="user-nickname">' + 'Zarządzasz użytkownikiem: ' + userNickname + '</div>
            <div class="buttons">
                <?php
                echo '<button class="btn-join-2 userOptions" id="rankChangeButton">Zmień rangę</button>';
                echo '<button class="btn-join-2 userDelete userOptions">Usuń użytkownika</button>';
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require 'database.php';
$sql = "SELECT id, nickname, rank FROM users";
$result = mysqli_query($conn, $sql);
mysqli_close($conn);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="script-2.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('users-table');
        const containerCar = document.querySelector('.container-car');
        const userDetails = document.querySelector('.user-details');
        const modal = document.getElementById('changeRankModal');
        const userIdInput = document.getElementById('userId');
        const form = document.getElementById('changeRankForm');
        const rankChangeButton = document.getElementById('rankChangeButton');
        const rankUserNickname = document.getElementById('rank-user-nickname');
        let userId = null;

        table.addEventListener('click', function (event) {
            let target = event.target;
            while (target && target.nodeName !== 'TR') {
                target = target.parentElement;
            }
            if (target) {
                const userNickname = target.getAttribute('data-user-nickname');
                userId = target.getAttribute('data-user-id');
                if (userNickname) {
                    userDetails.style.visibility = 'visible';
                    userDetails.querySelector('.user-nickname').innerHTML = 'Zarządzasz użytkownikiem: ' + userNickname;
                    const buttons = containerCar.querySelectorAll('.userOptions');
                    buttons.forEach(button => {
                        button.style.display = 'block';
                    });
                    rankUserNickname.innerHTML= 'Zmień rangę dla: ' + userNickname;
                }
            }
        });

        rankChangeButton.addEventListener('click', function() {
            const userId = this.dataset.userId;
            userIdInput.value = userId;
            modal.style.display = 'block';
        });

        form.addEventListener('submit', function () {
            // Po przesłaniu formularza strona zostanie odświeżona automatycznie
        });

        const closeModal = document.querySelector('.close');

        function closeModalFunc() {
            modal.style.display = 'none';
        }

        closeModal.addEventListener('click', closeModalFunc);

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                closeModalFunc();
            }
        });

        function changeUserRank() {
            const newRank = document.getElementById('newRankSelect').value;
            console.log('Nowa ranga:', newRank);
            closeModalFunc();
        }

        document.getElementById('confirmRankChange').addEventListener('click', changeUserRank);
    });
</script>
</body>
</html>

