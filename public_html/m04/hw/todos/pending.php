<?php
require_once(__DIR__ . "/../../../../lib/db.php"); ?>

<?php
$db = getDB();

// mm3275 2026-06-29
// Plan: validate the posted todo id, update only that pending todo, then fetch incomplete todos.

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    if (filter_var($id, FILTER_VALIDATE_INT) !== false && (int)$id > 0) {
        $query = "UPDATE M4_Todos
                  SET is_complete = 1, completed = CURRENT_TIMESTAMP
                  WHERE id = :id AND is_complete = 0";

        $params = [
            ":id" => $id
        ];
        
        try {
            $stmt = $db->prepare($query);
            $r = $stmt->execute($params);
            if ($r) {
                echo "Marked task $id as completed";
            } else {
                echo "Failed to mark task $id as completed";
            }
        } catch (PDOException $e) {
            echo "Error updating task $id; check the logs (terminal)";
            error_log("Update Error: " . var_export($e, true));
        }
    } else {
        echo "Invalid todo id.";
    }
}

$query = "SELECT id, task, due,
          DATEDIFF(due, CURRENT_DATE) AS days_offset,
          assigned
          FROM M4_Todos
          WHERE is_complete = 0
          ORDER BY due ASC";

$results = [];

try {
    $stmt = $db->prepare($query);
    $r = $stmt->execute();
    if ($r) {
        $results = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    echo "Error fetching pending todos; check the logs (terminal)";
    error_log("Select Error: " . var_export($e, true));
}
?>
<html>

<body>
    <?php require_once(__DIR__ . "/../nav.php"); ?>
    <section>
        <h2>Pending ToDos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Assigned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $r): ?>
                    <tr>
                        <?php foreach ($r as $key => $val): ?>
                            <?php if ($key == "days_offset"): ?>
                                <?php if ($val >= 0): ?>
                                    <td><?php echo "Due in $val day(s)"; ?></td>
                                <?php else: ?>
                                    <td><?php echo "Overdue by " . abs($val) . " day(s)"; ?></td>
                                <?php endif; ?>
                            <?php else: ?>
                                <td><?php echo htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8'); ?></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$r['id'], ENT_QUOTES, 'UTF-8'); ?>" />
                                <input type="submit" value="Complete" />
                            </form>
                        </td>
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