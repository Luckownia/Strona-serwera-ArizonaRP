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
            right: 30%;
            top: -300px;
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
        <!-- Ten div będzie używany do wyświetlania nazwy użytkownika -->
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="script-2.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = document.getElementById('users-table');
        const containerCar = document.querySelector('.container-car');
        table.addEventListener('click', function (event) {
            let target = event.target;
            while (target && target.nodeName !== 'TR') {
                target = target.parentElement;
            }
            if (target) {
                const userNickname = target.getAttribute('data-user-nickname');
                if (userNickname) {
                    containerCar.innerHTML = '<div class="user-details">' +
                        '<div class="user-nickname">' + 'Zarządzasz użytkownikiem: ' + userNickname + '</div>' +
                        '<div class="buttons">' +
                        '<button class="btn-join-2 userOptions">Przycisk 1</button>' +
                        '<button class="btn-join-2 userDelete userOptions">Przycisk 2</button>' +
                        '<button class="btn-join-2 userOptions">Przycisk 2</button>' +
                        '<button class="btn-join-2 userOptions">Przycisk 2</button>' +
                        '</div>' +
                        '</div>';
                }
            }
        });
    });
</script>
</body>
</html>
