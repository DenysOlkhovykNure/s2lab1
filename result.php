<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
function Request($req, $params = array())
{
    $host = '127.0.0.1';
    $dbname = 'lb_pdo_workers';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        //$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($req);
        $stmt->execute($params);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            foreach ($row as $column) {
                echo "<td>$column</td>";
            }
            echo '</tr>';
        }
    } catch (PDOException $e) {
        echo "Помилка: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveButton1"])) {
    $text1 = $_POST["text1"];
    $text2 = $_POST["text2"];
    echo '<div class="container">';
    echo '<div class="block2">';
    echo '<table class="styled-table">';
    echo '<th>Ім&apos;я керівника</th>';
    echo '<th>Ім&apos;я менеджера</th>';
    echo '<th>Опис</th>';
    $params1 = array(':text1' => $text1, ':text2' => $text2);
    Request("SELECT d.chief AS department_chief, p.manager AS project_manager, w.description AS work_description
    FROM department AS d, project AS p, work AS w, worker AS wr 
    WHERE p.ID_PROJECTS = w.FID_PROJECTS AND wr.ID_WORKER = w.FID_WORKER AND d.ID_DEPARTMENT = wr.FID_DEPARTMENT
    AND p.name = :text1 AND w.date = :text2", $params1);
    echo '</table>';
    echo '</div>';
    echo '</div>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveButton2"])) {
    $text = $_POST["text3"];
    echo '<div class="container">';
    echo '<div class="block2">';
    echo '<table class="styled-table">';
    echo '<th>Загальний час роботи</th>';
    $params2 = array(':text' => $text);
    Request("SELECT SUM(w.time_end - w.time_start) AS total_time
    FROM work AS w, project AS p 
    WHERE p.ID_PROJECTS = w.FID_PROJECTS AND p.name = :text", $params2);
    echo '</div>';
    echo '</div>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["saveButton3"])) {
    $text = $_POST["text4"];
    echo '<div class="container">';
    echo '<div class="block2">';
    echo '<table class="styled-table">';
    echo '<th>Кількість співробітників</th>';
    $params2 = array(':text' => $text);
    Request("SELECT COUNT(*) AS total_workers
    FROM worker AS wr, department AS d 
    WHERE d.ID_DEPARTMENT = wr.FID_DEPARTMENT AND d.chief = :text", $params2);
    echo '</div>';
    echo '</div>';
}
?>
</body>

</html>