<form method="post">
    Amount: <input type="number" step="0.01" name="amount">
    From: <select name="from">
        <?php foreach ($currencies as $currency) : ?>
            <option value="<?= htmlspecialchars($currency['code']) ?>"><?= htmlspecialchars($currency['currency']) ?> (<?= htmlspecialchars($currency['code']) ?>)</option>
        <?php endforeach; ?>
    </select>
    To: <select name="to">
        <?php foreach ($currencies as $currency) : ?>
            <option value="<?= htmlspecialchars($currency['code']) ?>"><?= htmlspecialchars($currency['currency']) ?> (<?= htmlspecialchars($currency['code']) ?>)</option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Convert">
</form>
