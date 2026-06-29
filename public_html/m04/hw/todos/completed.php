<?php
require_once(__DIR__ . "/../../../../lib/db.php"); ?>

<?php
$db = getDB();

// mm3275 2026-06-29
// Plan: fetch only completed todos, extract completed date, calculate days offset, and order newest completed first.

$query = "SELECT id, task, due,
          DATE(completed) AS completed_date,
          DATEDIFF(DATE(completed), due) AS days_offset,
          assigned
          FROM M4_Todos
          WHERE is_complete = 1
          ORDER BY completed DESC, due DESC";

$results = [];

try {
    $stmt = $db->prepare($query);
    $r = $stmt->execute();
    if ($r) {
        $results = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    echo "Error fetching completed todos; check the logs (terminal)";
    error_log("Select Error: " . var_export($e, true));
}
?>
<html>

<body>
    <?php require_once(__DIR__ . "/../nav.php"); ?>
    <section>
        <h2>Completed ToDos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Due Date</th>
                    <th>Completed Date</th>
                    <th>Status</th>
                    <th>Assigned</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $r): ?>
                    <tr>
                        <?php foreach ($r as $key => $val): ?>
                            <?php if ($key == "days_offset"): ?>
                                <?php if ($val >= 0): ?>
                                    <td><?php echo "Completed in $val day(s)"; ?></td>
                                <?php else: ?>
                                    <td><?php echo "Overdue by " . abs($val) . " day(s)"; ?></td>
                                <?php endif; ?>
                            <?php else: ?>
                                <td><?php echo htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8'); ?></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($results) === 0): ?>
                    <tr>
                        <td colspan="100%">No results</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>

</html>