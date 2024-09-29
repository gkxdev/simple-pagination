<?php
require_once __DIR__ . '/db.inc.php';
require_once __DIR__ . '/Pagination.php';

$total = $pdo->query("SELECT COUNT(id) FROM countries")
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
