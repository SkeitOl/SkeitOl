<div id="da-slider" class="da-slider">
            <div class="da-slide">
                <h2>Расписание в компютере</h2>
                <p>Узнай своё расписание за 1 клик.</p>
                <a href="view_program.php?id=1" class="da-link">Подробнее..</a>
                <div class="da-img">
                    <img src="images/anim/sked.gif" alt="image01" class="imgsize" />
                </div>
            </div>
            <div class="da-slide">
                <h2>Тренеруй мозги</h2>
                <p>Простенькая и захватывающая игра Балда</p>
                <a href="view_program.php?id=2" class="da-link">Подробнее..</a>
                <div class="da-img">
                    <img src="images/anim/Balda.ico" alt="image01" class="imgsize" />
                </div>
            </div>
            <div class="da-slide">
                <h2>Кушай, кушай</h2>
                <p>Змейка! Используется класс и List<> </p>
                <a href="view_program.php?id=5" class="da-link">Подробнее..</a>
                <div class="da-img">
                    <img src="images/anim/Snayke.ico" alt="image01" class="imgsize" />
                </div>
            </div>
            <div class="da-slide">
                <h2>Шпаргалка под рукой</h2>
                <p>Не можешь найти слово играю в игру Балда. Попробуй воспользоваться программой BaldaHelper её рекурсивный поиск не упустит ни одно слово, ну если оно есть в словаре =)</p>
                <a href="view_program.php?id=3" class="da-link">Подробнее..</a>
                <div class="da-img">
                    <img src="images/anim/BaldaHelper.gif" alt="image01" class="imgsize" />
                </div>
            </div>
            <nav class="da-arrows">
           <span class="da-arrows-prev"></span>
           <span class="da-arrows-next"></span>
           </nav>
        </div>
        <script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
        <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="js/jquery.cslider.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#da-slider').cslider({
                    autoplay: true,
                    bgincrement: 50,
                    interval: 7000
                });
            });
		</script>