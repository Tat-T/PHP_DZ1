<?php
        if (isset($_GET['month'])) {
            $month = (int)$_GET['month'];
            $year = date('Y');

            if ($month < 1 || $month > 12) {
                echo "<p style='color: red;'>Ошибка: введите номер месяца от 1 до 12.</p>";
                return;
            }

            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $firstDayOfMonth = date('N', strtotime("$year-$month-01"));

            ob_start(); // Начинаем буферизацию вывода
            echo "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse; text-align: center;'>";
            echo "<tr><th colspan='7' style='background-color: #f2f2f2;'>" . date('F Y', strtotime("$year-$month-01")) . "</th></tr>";
            echo "<tr style='background-color: #ddd;'><th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th style='color: red;'>Сб</th><th style='color: red;'>Вс</th></tr>";
            echo "<tr>";

            for ($i = 1; $i < $firstDayOfMonth; $i++) {
                echo "<td></td>";
            }

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDay = date('N', strtotime("$year-$month-$day"));
                $color = ($currentDay >= 6) ? " style='color: red;'" : "";
                echo "<td$color>$day</td>";
                if ($currentDay == 7) echo "</tr><tr>";
            }

            echo "</tr></table>";
            echo ob_get_clean(); // Отправляем только HTML-код календаря
            exit;
        }
        ?>
<section>
    <div class="container">
        <div class="row mt-3 bg-light border rounded p-3">
            <h5 class="text-primary">Задание 1</h5>
            <p>
                Написать PHP скрипт, создающий на странице три текстовых
                поля. В эти поля пользователь должен заносить значения R, G
                и B цветовых компонент (в интервале 0-255). На странице также
                должна присутствовать кнопка Accept и тег span с каким-либо
                текстом внутри.
                После нажатия на кнопку Accept, надо создать цвет на основе
                введенных пользователем значений R, G и B. Этим цветом залить
                фон тега span, а текст залить дополнительным цветом.
            </p>
        </div>
        <?php
        include "header.php";
        // Инициализация переменных для R, G, B и сообщения об ошибке
        $r = $g = $b = '';
        $error = '';
        // Функция для проверки корректности введённого значения
        function isValidColorComponent($value)
        {
            return is_numeric($value) && $value >= 0 && $value <= 255;
        }
        // Обработка данных после отправки формы
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $r = $_POST['r'];
            $g = $_POST['g'];
            $b = $_POST['b'];
            // Проверка корректности введённых значений
            if (isValidColorComponent($r) && isValidColorComponent($g) && isValidColorComponent($b)) {
                $backgroundColor = "rgb($r,$g,$b)";
                // Определение цвета текста для обеспечения контраста
                $textColor = (0.299 * $r + 0.587 * $g + 0.114 * $b) > 186 ? 'black' : 'white';
            } else {
                $error = 'Пожалуйста, введите корректные значения для R, G и B (от 0 до 255).';
            }
        }
        ?>
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-6 offset-md-3">
                    <form method="post">
                        <div class="form-group d-flex align-items-center">
                            <label for="r" class="me-3 mb-3">R:</label>
                            <input type="text" class="form-control mb-3" id="r" name="r" value="<?= htmlspecialchars($r) ?>">
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label for="g" class="me-3 mb-3">G:</label>
                            <input type="text" class="form-control mb-3" id="g" name="g" value="<?= htmlspecialchars($g) ?>">
                        </div>
                        <div class="form-group d-flex align-items-center">
                            <label for="b" class="me-3 mb-3">B:</label>
                            <input type="text" class="form-control mb-3" id="b" name="b" value="<?= htmlspecialchars($b) ?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary mt-3 p-3 text-center">Accept</button>
                        </div>
                    </form>
                    <?php if ($error): ?>
                        <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
                    <?php elseif (isset($backgroundColor)): ?>
                        <div class="mt-3 p-3 text-center" style="background-color: <?= htmlspecialchars($backgroundColor) ?>; color: <?= htmlspecialchars($textColor) ?>;">
                            Пример текста
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row mt-3 bg-light border rounded p-3">
            <h5 class="text-primary">Задание 2</h5>
            <p>
                Создать функцию, которая принимает в качестве параметра
                целочисленное значение month в интервале от 1 до 12. Это
                значение интерпретируется как номер месяца текущего года. При
                вызове функция должна вывести на странице в виде таблицы
                календарь одного месяца текущего года, соответствующего переданному значению month.
                Формат календаря продумать самостоятельно. Предусмотреть
                реакцию функции на неправильные значения month. Для оформления
                использовать CSS, выделять цветом выходные дни и т.п.
            </p>
        </div>
        <div class="row mt-3">
            <div class="col-md-6 offset-md-3">
                <h5 class="text-center">Выберите месяц:</h5>
                <select id="month" class="form-control mb-3" onchange="loadCalendar()">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>"><?= date('F', strtotime("2024-$m-01")) ?></option>
                    <?php endfor; ?>
                </select>
                <div class="col-md-6 offset-md-3 d-flex justify-content-center">
                    <div id="calendar" class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include "footer.php";
?>