<?php
namespace App;
use App\Config\DB;
use ModelController;

class Model extends ModelController
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = null;
    protected $connection;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        // Make sure we have our DB Table - could have skipped this
        if (!$this->table) {
            $this->getExpectedTableName();
        }

        $DB = new DB();
        $this->connection = $DB->connect();
    }

    /**
     * @param Int $id
     * @return array
     */
    public function get($id): array
    {
        $entity = [];
        $query = "SELECT * FROM {$this->table} WHERE `id` = {$id}";
        if ($results = $this->connection->query($query)) {
            while ($obj = $results->fetch_assoc()) {
                $entity[] = $obj;
            }
        }
        return $entity;
    }

    /**
     * This could also be combined with the singular get method but...
     * @return array
     */
    public function getAll(): array
    {
        $entities = [];
        $query = "SELECT * FROM {$this->table} ORDER BY `duedate` ASC";
        if ($results = $this->runQuery($query)) {
            while ($obj = $results->fetch_assoc()) {
                $entities[] = $obj;
            }
        }
        return $entities;
    }

    /**
     * @param string $taskName
     * @param string $taskDate
     * @return bool
     */
    public function insert(string $taskName, string $taskDate): bool
    {
        $query = sprintf(
            'INSERT INTO %s (`task`,`duedate`,`created`) VALUES ("%s", "%s", "%s")',
            $this->table,
            $this->cleanString($taskName),
            date('Y-m-d H:i:s', strtotime($taskDate)),
            date('Y-m-d H:i:s')
        );
        return $this->runQuery($query);
    }

    /**
     * @param Int $taskId
     * @return bool
     */
    public function update($taskId): bool
    {
        parse_str(file_get_contents("php://input"),$postData);
        $query = sprintf(
            'UPDATE %s SET `task`="%s", `duedate`="%s" WHERE `id`="%s"',
            $this->table,
            $this->cleanString($postData['task']),
            date('Y-m-d H:i:s', strtotime($postData['date'])),
            $taskId
        );
        return $this->runQuery($query);
    }

    /**
     * @param Int $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->runQuery("DELETE FROM {$this->table} WHERE id = '{$id}'");
    }

    /**
     * Helper
     * @param $query
     * @return mixed|bool
     */
    public function runQuery($query)
    {
        return $this->connection->query($query);
    }

    /**
     * Helper
     * @param $string
     * @return string
     */
    public function cleanString($string): string
    {
        return htmlentities(
            mb_convert_encoding($string, 'UTF-8', 'UTF-8'), ENT_QUOTES, 'UTF-8'
        );
    }

    /**
     * Used to get class name in case the model was instantiated without it
     * @return string
     */
    public function getExpectedTableName():string
    {
        $class = explode('\\', static::class);
        return strtolower(array_pop($class));
    }
}