<table>
    <thead>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Amount</th>
            <th>Result</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($conversions as $conversion) : ?>
            <tr>
                <td><?= htmlspecialchars($conversion['from_currency']) ?></td>
                <td><?= htmlspecialchars($conversion['to_currency']) ?></td>
                <td><?= htmlspecialchars($conversion['amount']) ?></td>
                <td><?= htmlspecialchars($conversion['result']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
