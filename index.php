<section class="row mt-3 bg-light border rounded p-3">
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
</section>
<?php
include "footer.php";
