<?php
require_once(__DIR__ . "/../../../../lib/db.php"); ?>

<?php
// don't edit - this
$expected_fields = ["task", "due", "assigned"];
$diff = array_diff($expected_fields, array_keys($_GET));

if (empty($diff)) {

    // data variables, don't edit
    $task = $_GET["task"];
    $due = $_GET["due"];
    $assigned = $_GET["assigned"];

    $is_valid = true;

    // Start validations
    // mm3275 2026-06-29
    // Plan: clean and validate task, due, and assigned before inserting.

    $task = trim($task);
    $due = trim($due);
    $assigned = trim($assigned);

    if (empty($task)) {
        echo "<p>Task is required.</p>";
        $is_valid = false;
    } elseif (strlen($task) > 128) {
        echo "<p>Task must be 128 characters or less.</p>";
        $is_valid = false;
    }

    $date = DateTime::createFromFormat("Y-m-d", $due);
    if (!$date || $date->format("Y-m-d") !== $due) {
        echo "<p>Due date must be valid.</p>";
        $is_valid = false;
    }

    if (empty($assigned) || strlen($assigned) > 60) {
        $assigned = "self";
    }
    // End validations

    
    if ($is_valid) {
        $query = "INSERT INTO M4_Todos (task, due, assigned) VALUES (:task, :due, :assigned)";
        $params = [
            ":task" => $task,
            ":due" => $due,
            ":assigned" => $assigned
        ];

        try {
            $db = getDB();
            $stmt = $db->prepare($query);
            $r = $stmt->execute($params);
            if ($r) {
                echo "Inserted new Todo with id " . $db->lastInsertId();
            } else {
                echo "Failed to insert";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == "23000") {
                echo "A todo with this task and due date already exists.";
            } else {
                echo "There was an error inserting the record; check the logs (terminal)";
            }
            error_log("Insert Error: " . var_export($e, true));
        }
    } else {
        error_log("Creation input wasn't valid");
    }
}
?>
<html>

<body>
    <?php require_once(__DIR__ . "/../nav.php"); ?>
    <section>
        <h2>Create ToDo </h2>
        <form>
            <div>
                <label for="task">Task</label>
                <input type="text" id="task" name="task" maxlength="128" required />
            </div>

            <div>
                <label for="due">Due Date</label>
                <input type="date" id="due" name="due" required />
            </div>

            <div>
                <label for="assigned">Assigned</label>
                <input type="text" id="assigned" name="assigned" maxlength="60" value="self" />
            </div>

            <div>
                <input type="submit" value="Create Todo" />
            </div>
        </form>
    </section>
</body>

</html>