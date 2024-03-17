<?php
$host = '127.0.0.1';
$dbname = 'lb_pdo_workers';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->query("SELECT name FROM project");
$projects = $stmt->fetchAll(PDO::FETCH_COLUMN);
$stmt = $pdo->query("SELECT date FROM work");
$dates = $stmt->fetchAll(PDO::FETCH_COLUMN);
$stmt = $pdo->query("SELECT chief FROM department");
$names = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <form action="result.php" method="post">
        <div class="container">
            <div class="block">
                <p>Виконані завдання в проєкті за дату</p>
                <select class="text-area" name="text1">
                    <?php foreach ($projects as $project) : ?>
                        <option value="<?php echo $project; ?>"><?php echo $project; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="date" class="text-area" name="text2">
                <button type="submit" name="saveButton1">Зберегти зміни</button>
            </div>
            <div class="block">
                <p>Загальний час роботи над проєктом</p>
                <select class="text-area" name="text3">
                    <?php foreach ($projects as $project) : ?>
                        <option value="<?php echo $project; ?>"><?php echo $project; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="saveButton2">Зберегти зміни</button>
            </div>
            <div class="block">
                <p>Кількість співробітників відділу керівника</p>
                <select class="text-area" name="text4">
                    <?php foreach ($names as $name) : ?>
                        <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="saveButton3">Зберегти зміни</button>
            </div>
        </div>
    </form>
</body>

</html>