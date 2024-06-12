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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        #headline-manage{
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .userOptions {
            font-size: 0.8em; /* Zmniejszenie rozmiaru czcionki */
            padding: 5px 10px; /* Zmniejszenie paddingu */
            margin: 5px; /* Dodanie marginesu między przyciskami */
            background-color: #4CAF50; /* Kolor tła */
            color: white; /* Kolor tekstu */
            border: none; /* Usunięcie obramowania */
            border-radius: 5px; /* Zaokrąglenie rogów */
            cursor: pointer; /* Zmiana kursora na wskaźnik */
            display: none; /* Przyciski są ukryte na początku */
        }
        .userOptions:hover {
            background-color: #45a049; /* Kolor tła po najechaniu */
        }
        .userDelete {
            background-color: red; /* Kolor tła po najechaniu */
        }
        .userDelete:hover{
            background-color: #d30f0f; /* Kolor tła po najechaniu */
        }
        .user-details{
            visibility: hidden;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
        }
        .user-details .btn-join-2{
            font-size:18px;
            padding: 25px 40px;
            width: 300px;
        }
        .user-details .btn-join-2:first-child{
            margin-right: 20px;
        }

        .user-details .buttons{
            position:static;
        }

        .user-nickname{
            font-size:30px;
            font-family:var(--fontfirst);
            font-weight:700;
            color:var(--seventhcolor);
            margin-bottom: 20px;
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
            padding: 40px;
            border: 1px solid #888;
            width: 80%; /* Szerokość okna modalnego */
            max-width: 400px; /* Maksymalna szerokość */
        }
        
        #newRankSelect{
        font-size: 17px;
        padding: 10px 20px;
        border: 1px solid lightgrey;
        border-radius: 25px;
        margin-right: 25px;
        margin-left: 10px;
        }
        #confirmRankChange{
            color: white;
            border: none;
            padding:10px 20px;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
            background: #444444;
            transition: all 0.3s ease;
            border-radius: 25px;
        }

        #confirmRankChange:hover{
            transform: scale(1.05);
            box-shadow: 2px 2px 10px #444444;
        }
        #rank-user-nickname{
            font-size:24px;
            font-family:var(--fontfirst);
            font-weight:700;
            color:black;
            margin-bottom: 40px;
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
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            width:100%;
        }
        .table-container{
            max-height: 400px; /*Wysokosc ktora po przekroczeniu wlacza sie scrollbar*/
            overflow-y: auto;  
            box-shadow: 0 2px 20px var(--seventhcolor);
        }
        .category{
            position: sticky;
            top:0;
            z-index:2;
        }
        #headline-manage .btn-join-2{
            margin-top:30px;
        }
        #users-table:hover{
            cursor: pointer;
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
        <form id="changeRankForm" action="../models/updateRank.php" method="post">
            <input type="hidden" id="userId" name="userId">
            <select id="newRankSelect" name="newRank"> <!-- Dodanie atrybutu name -->
                <option value="Rekrut">Rekrut</option>
                <option value="Gracz">Gracz</option>
                <option value="Administrator">Administrator</option>
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
                    <img src="../assets/palm-tree-48.png" alt="palm-tree" width="48px">
                    <a href="../../index.php" class="logo-link">ArizonaRP</a>
                </div>
                <label class="switch-mode-container">
                    <input type="checkbox" class="switch-mode-checkbox">
                    <span class="btn-switch-mode" tabindex="0">
                        <span class="circle">
                            <img src="../assets/sun.png" alt="light-sun" class="circle-image">
                        </span>
                    </span>
                </label>
                <button class="hamburger">
                    <span class="pasek1"></span>
                </button>
                <ul class="navigation">
                    <li><a href="../../index.php" class="nav-link">Główna</a></li>
                    <li><a href="../models/logout.php" class="nav-link">Wyloguj się</a></li>
                    <li><a href="panel.php" class="nav-link active">Panel</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="headline-manage" class="headline-section">
    <?php
require '../config/database.php';
$sql = "SELECT id, nickname, rank FROM users";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<div class='table-container'>";
    echo "<table border='1' id='users-table'>";
    echo "<tr class='category'><th>Nazwa użytkownika</th><th>Ranga</th></tr>"; // Dodano kolumnę Akcje
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr data-user-id='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' data-user-nickname='" . htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') . "'>";
        echo "<td>" . htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['rank'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "Błąd: " . mysqli_error($conn);
}
echo '<a href="panel.php"><button class="btn-join-2" id="btn_back">Wróć</button></a>';
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
require '../config/database.php';
$sql = "SELECT id, nickname, rank FROM users";
$result = mysqli_query($conn, $sql);
mysqli_close($conn);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="../../script/script-2.js"></script>
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
                    button.setAttribute('data-user-id', userId); // Przypisanie ID użytkownika do przycisku
                });
                rankUserNickname.innerHTML = 'Zmień rangę dla: ' + userNickname;
            }
        }
    });

    rankChangeButton.addEventListener('click', function() {
        userIdInput.value = this.getAttribute('data-user-id'); // Pobranie ID użytkownika z atrybutu data-user-id
        modal.style.display = 'block';
    });

    const userDeleteButtons = document.querySelectorAll('.userDelete');
    userDeleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            if (confirm('Czy na pewno chcesz usunąć tego użytkownika?')) {
                fetch(`deleteUsers.php?id=${userId}`, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        location.reload();
                    } else {
                        alert('Wystąpił błąd podczas usuwania użytkownika.');
                    }
                });
            }
        });
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

    // Najezdzenie myszka 
    const user_nickname = document.querySelector(".user-nickname");
    user_nickname.addEventListener("mouseenter", animateCursor);
    user_nickname.addEventListener("mouseleave", removeAnimateCursor);

    // Czy do wywalenia to najezdzenie na przyciski kursor?
    const btn_join = document.querySelector("#rankChangeButton");
    btn_join.addEventListener("mouseenter", animateCursor);
    btn_join.addEventListener("mouseleave", removeAnimateCursor);

    const btn_del = document.querySelector(".userDelete");
    btn_del.addEventListener("mouseenter", animateCursor);
    btn_del.addEventListener("mouseleave", removeAnimateCursor);

    const btn_back = document.querySelector("#btn_back");
    btn_back.addEventListener("mouseenter", animateCursor);
    btn_back.addEventListener("mouseleave", removeAnimateCursor);

    const users_table = document.querySelector("#users-table");
    users_table.addEventListener("mouseenter", animateCursor);
    users_table.addEventListener("mouseleave", removeAnimateCursor);

    document.getElementById('changeRankForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Zapobiega domyślnemu działaniu formularza

    const userId = document.getElementById('userId').value;
    const newRank = document.getElementById('newRankSelect').value;

    fetch('../models/updateRank.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `userId=${userId}&newRank=${newRank}`
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            alert('Ranga została zmieniona pomyślnie.');
            location.reload(); // Odśwież stronę, aby zobaczyć zmiany
        } else {
            alert('Wystąpił błąd podczas zmiany rangi: ' + data);
        }
    })
    .catch(error => console.error('Error:', error));
});
});

</script>
</body>
</html>

