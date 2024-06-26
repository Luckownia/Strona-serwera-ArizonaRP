
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
                            <li> <a href="#" class="nav-link active"> Główna</a> </li>
                            <?php
                            session_start();
                            if (isset($_SESSION['user'])) {
                                echo '<li> <a href="public/models/logout.php" class="nav-link"> Wyloguj się</a> </li>';
                            } else {
                                echo '<li> <a href="public/views/login.php" class="nav-link"> Zaloguj się</a> </li>';
                            }
                            ?>
                            <li> <a href="public/views/panel.php" class="nav-link"> Panel</a> </li>
                        </ul>

                    </div>
                </nav>
                </header>
                <div class="headline-car">
                    <div class="headline-section">
                        <h1 class="headline">Stworzona przez graczy dla graczy</h1>
                        <p class="sub-headline">ArizonaRP została stworzona aby zapewnić rozrywkę, oraz realistyczne i
                            dynamiczne
                            doświadczenie RP. Nasz zespół developerski ciągle stara się dodawać unikalną zawartość na
                            serwer
                            i
                            dzięki sugestiom od graczy reguralnie dodajemy nową ekscytująca zawartość.</p>
                        <a href="#section-0" class="btn-more" title="Dowiedz się więcej o naszym serwerze">Więcej</a>
                    </div>
                </div>
                <div class="container-car"></div>
                <div class="buttons">
                    <a href="#" class="turn-on"><img src="public/assets/car-key.png"
                            alt="car key after click sound car's turn on"></a>
                    <a href="#" class="turn-off"><img src="public/assets/stop.png"
                            alt="stop sign, after click sound car's turn off"></a>
                </div>
                <div class="car-3d"></div>

            </div>
            <div class="landing-page-2" id="section-0">
                <section id="section-1">
                    <div class="section-feature">
                        <div class="feature-1">
                            <p class="feature-p1">Odtwórz siebie</p>
                            <h1>Unikalny kreator postaci</h1>
                            <p class="feature-p2">Na ArizonaRP mamy unikalny kreator postaci, który pozwoli ci
                                dostosowywać
                                twojego awatara na wszelakie sposoby. Możesz wybrać mu jedną z niestandardowych fryzur,
                                bądź
                                nawet wydziarać tatuaż!</p>
                            <a href="#section-2"><button class="btn-join-2">Dalej</button></a>
                        </div>
                        <div class="feature-photo"><img src="public/assets/feature1.jpeg"></div>
                    </div>
                </section>
            </div>
            <section id="section-2">
                <div class="section-feature">
                    <div class="feature-photo"><img src="public/assets/car.jpg"></div>
                    <div class="feature-2">
                        <p class="feature-p1">Los Santos to miasto możliwości</p>
                        <h1>Zostań kim chcesz!</h1>
                        <p class="feature-p2">Chcesz być stróżem prawa i łapać bandytów? Proszę bardzo! A może bardziej
                            interesuje cię praca jako mechanik? Czemu nie!
                            Być może chcesz jednak żyć na pieńku z prawem? Chciałbyś razem z kolegami zrobić wymarzony
                            napad na bank? Na ArizonaRP wszystko jest możliwe. Ogranicza cię tylko twoja wyobraźnia
                        </p>
                        <a href="#section-3"><button class="btn-join-2">Dalej</button></a>
                    </div>
                </div>
            </section>
            <div class="landing-page-2" id="section-3">
                <section id="section-3">
                    <div class="section-feature">
                        <div class="feature-3">
                            <p class="feature-p1">Nikt nie mówił że będzie łatwo</p>
                            <h1>Autorski system napadów</h1>
                            <p class="feature-p2">Na naszej wyspie znajduje się unikalny system napadów, dzięki któremu
                                szanse policji i napastników są bardziej wyrównane i bardziej liczą się umiejętności
                                danej grupy.
                                Ważną rolę odgrywają tu zakładnicy, nad którymi napastnicy muszą jeszcze bardziej
                                czuwać.</p>
                            <a href="#section-4"><button class="btn-join-2">Dalej</button></a>
                        </div>
                        <div class="feature-photo"><img src="public/assets/heist.jpg"></div>
                    </div>
                </section>
            </div>
            <section id="section-4">
                <div class="section-feature">
                    <div class="feature-photo"><img src="public/assets/bar.jpg"></div>
                    <div class="feature-4">
                        <p class="feature-p1">Łatwa forsa? Wchodzę w to!</p>
                        <h1>Masa nowych prac!</h1>
                        <p class="feature-p2">Nie przekonuje cię zarabianie w mniej legalny sposób? Nie czujesz się na
                            siłach aby wstąpić w szeregi policji i nie masz wystarczających umiejętności na prace jako
                            mechanik?
                            Nic nie szkodzi! Na ArizonaRP mamy prace dorywcze, takich jak kucharz, rolnik, rybak, taxi,
                            śmieciarz oraz wiele innych!</p>
                        <a href="public/views/login.php"><button class="btn-join-2">Dołącz do nas!</button></a>
                    </div>
                </div>
            </section>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
            <script src="script/script.js"></script>
            <script src="script/GLTFLoader.js"></script>
            <script src="script/car3d.js"></script>

    </body>

    </html>