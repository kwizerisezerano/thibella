<?php

class DB
{
    private static ?mysqli $conn = null;

    public static function connect(): mysqli
    {
        if (self::$conn !== null) {
            return self::$conn;
        }

        $cfg = require __DIR__ . '/../config/database.php';

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        self::$conn = new mysqli(
            $cfg['host'],
            $cfg['user'],
            $cfg['password'],
            $cfg['database']
        );

        self::$conn->set_charset('utf8mb4');

        return self::$conn;
    }

    /**
     * Prepare → bind → execute → return mysqli_result
     * Usage: DB::run('SELECT * FROM t WHERE id = ?', 'i', [1])
     */
    public static function run(string $sql, string $types = '', array $values = []): \mysqli_result|bool
    {
        $db   = self::connect();
        $stmt = $db->prepare($sql);

        if ($types && $values) {
            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    /**
     * Run and fetch a single row
     */
    public static function fetchOne(string $sql, string $types = '', array $values = []): ?array
    {
        $result = self::run($sql, $types, $values);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Run and fetch all rows
     */
    public static function fetchAll(string $sql, string $types = '', array $values = []): array
    {
        $result = self::run($sql, $types, $values);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Run an INSERT/UPDATE/DELETE — returns affected rows
     */
    public static function execute(string $sql, string $types = '', array $values = []): int
    {
        $db   = self::connect();
        $stmt = $db->prepare($sql);

        if ($types && $values) {
            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        return $affected;
    }

    /**
     * INSERT shortcut — returns new insert_id
     */
    public static function insert(string $sql, string $types = '', array $values = []): int
    {
        $db   = self::connect();
        $stmt = $db->prepare($sql);

        if ($types && $values) {
            $stmt->bind_param($types, ...$values);
        }

        $stmt->execute();
        $id = $db->insert_id;
        $stmt->close();

        return $id;
    }

    /**
     * Count helper
     */
    public static function count(string $table, string $where = '', string $types = '', array $values = []): int
    {
        // $table is always an internal constant string — never user input
        $sql = 'SELECT COUNT(*) AS c FROM `' . $table . '`' . ($where ? ' WHERE ' . $where : '');
        $result = self::run($sql, $types, $values);
        return $result ? (int) $result->fetch_assoc()['c'] : 0;
    }

    public static function lastId(): int
    {
        return (int) self::connect()->insert_id;
    }
}
