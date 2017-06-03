<?php
Error_reporting(E_ALL);
//Подключение к базе данных
$pdo = new PDO("mysql:host=localhost;dbname=ravler_netol41", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
    <html>
    <head>
    </head>
    <body>


    <h1>Библиотека успешного человека</h1>
    <form action="" method="get" enctype="multipart/form-data">
        <input type="text" name="isbn" placeholder="ISBN"  value="<?php echo $_GET["isbn"] ?>"/>
        <input type="text" name="name" placeholder="Название книги"  value="<?php echo $_GET["name"]; ?>"/>
        <input type="text" name="author" placeholder="Автор" value="<?php echo $_GET["author"]; ?>"/>
        <input type="submit" value="Поиск" />
        <a href="?isbn=&name=&author=">По умолчанию</a>
    </form>

    </body>
    </html>
<?php

if (isset($_GET["isbn"]) or isset($_GET["isbn"]) or isset($_GET["author"])) {
    $isbn = htmlspecialchars($_GET["isbn"]);
    $name = htmlspecialchars($_GET["name"]);
    $author = htmlspecialchars($_GET["author"]);

    $result = $pdo->prepare("SELECT * FROM books WHERE author LIKE :author AND isbn LIKE :isbn AND name LIKE :name");
    $result->bindValue(':author', $author, PDO::PARAM_STR);
    $result->bindValue(':isbn', $isbn, PDO::PARAM_STR);
    $result->bindValue(':name', $name, PDO::PARAM_STR);
    $result->execute();
    $rowsArray = $result->fetchAll();
} else {
    $result = $pdo->prepare('SELECT * FROM books');
    $result->execute();
    $rowsArray = $result->fetchAll();
}

echo '<table border="1">';
echo '<tr>';
echo '<td>№</td>' . "\n";
echo '<td>Имя</td>' . "\n";
echo '<td>Автор</td>' . "\n";
echo '<td>Год издания</td>' . "\n";
echo '<td>ISBN</td>' . "\n";
echo '<td>Жанр</td>' . "\n";
echo '</tr>';

foreach ($rowsArray as $key => $value) {
    echo '<tr>';
    echo '<td>' . $value['id'] . '</td>' . "\n";
    echo '<td>' . $value['name'] . '</td>' . "\n";
    echo '<td>' . $value['author'] . '</td>' . "\n";
    echo '<td>' . $value['year'] . '</td>' . "\n";
    echo '<td>' . $value['isbn'] . '</td>' . "\n";
    echo '<td>' . $value['genre'] . '</td>' . "\n";
    echo '</tr>';
}
echo '</table>';
