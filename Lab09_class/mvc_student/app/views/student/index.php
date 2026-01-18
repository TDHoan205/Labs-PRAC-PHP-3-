<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>

    <?php foreach ($students as $s): ?>
        <tr>
            <td><?= $s['id'] ?></td>
            <td><?= $s['name'] ?></td>
            <td><?= $s['email'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
