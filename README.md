# Pagination

Basit PHP sayfalama kütüphanesi.

## Kullanımı

```php
<?php
require_once 'Pagination.php';

$pagination = new Pagination(100, 10);
// $pagination = new Pagination(100, 10, 'example.php?id=1');

$limit  = $pagination->limit();
$offset = $pagination->offset();

echo $pagination->html();
```

### PDO İle Kullanım Örneği

```php
<?php
require_once 'db.inc.php';
require_once 'Pagination.php';

$total = $pdo->query("SELECT count(id) FROM countries")
    ->fetchColumn();

$pagination = new Pagination($total, 10);

$query = $pdo->prepare("
    SELECT * FROM countries
    LIMIT :offset, :limit
");

$query->execute([
    ':limit'  => $pagination->limit(),
    ':offset' => $pagination->offset()
]);

while ($row = $query->fetchObject()) {
    echo sprintf('<div>%s - %s</div>',
        $row->code,
        $row->name
    );
}

echo $pagination->html();
```

### CSS

Bootstrap pagination bileşenini kullanmaktadır.
