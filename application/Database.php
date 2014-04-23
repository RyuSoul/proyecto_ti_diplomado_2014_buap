<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 16/04/14
 * Time: 02:15 PM
 */

class Database extends PDO
{

    private $error;
    private $sql;
    private $bind;
    private $errorCallbackFunction;
    private $errorMsgFormat;
    private $driver;

    public function __construct($dsn, $user = "", $passwd = "")
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            parent::__construct($dsn, $user, $passwd, $options);
            $this->driver = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    private function debug()
    {
        if (!empty($this->errorCallbackFunction)) {
            $error = array("Error" => $this->error);
            if (!empty($this->sql))
                $error["SQL Statement"] = $this->sql;
            if (!empty($this->bind))
                $error["Bind Parameters"] = trim(print_r($this->bind, true));

            $backtrace = debug_backtrace();
            if (!empty($backtrace)) {
                foreach ($backtrace as $info) {
                    if ($info["file"] != __FILE__)
                        $error["Backtrace"] = $info["file"] . " at line " . $info["line"];
                }
            }

            $msg = "";
            if ($this->errorMsgFormat == "html") {
                if (!empty($error["Bind Parameters"]))
                    $error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
                $css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
                $msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
                $msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
                foreach ($error as $key => $val)
                    $msg .= "\n\t<label>" . $key . ":</label>" . $val;
                $msg .= "\n\t</div>\n</div>";
            } elseif ($this->errorMsgFormat == "text") {
                $msg .= "SQL Error\n" . str_repeat("-", 50);
                foreach ($error as $key => $val)
                    $msg .= "\n\n$key:\n$val";
            }

            $func = $this->errorCallbackFunction;
            $func($msg);
        }
    }

    public function delete($table, $where, $bind = "")
    {
        if ($this->driver == 'pgsql') {
            $table = '"' . $table . '"';
        }
        $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        $this->run($sql, $bind);
    }

    private function filter($table, $info)
    {
        if ($this->driver == 'sqlite') {
            $sql = "PRAGMA table_info('" . $table . "');";
            $key = "name";
        } elseif ($this->driver == 'mysql') {
            $sql = "DESCRIBE " . $table . ";";
            $key = "Field";
        } else {
            $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
            $key = "column_name";
        }

        if (false !== ($list = $this->run($sql))) {
            $fields = array();
            foreach ($list as $record)
                $fields[] = $record[$key];
            return array_values(array_intersect($fields, array_keys($info)));
        }
        return array();
    }

    private function cleanup($bind)
    {
        if (!is_array($bind)) {
            if (!empty($bind))
                $bind = array($bind);
            else
                $bind = array();
        }
        return $bind;
    }

    public function addQuotes($fields, $valor = false)
    {
        $modifiedFields = [];
        if (!$valor) {
            $fields = array_keys($fields);
        }
        foreach ($fields as $field) {
            if (!ctype_lower($field)) {
                $modifiedFields[] = '"' . $field . '"';
            } else {
                $modifiedFields[] = $field;
            }
        }
        return $modifiedFields;
    }

    public function insert($table, $info)
    {
        $fields = $this->filter($table, $info);
        if ($this->driver == 'pgsql') {
            $modifiedFields = $this->addQuotes($info);
            $table = '"' . $table . '"';
        } else {
            $modifiedFields = $fields;
        }
        $sql = "INSERT INTO " . $table . " (" . implode($modifiedFields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
        $bind = array();
        foreach ($fields as $field)
            $bind[":$field"] = $info[$field];
        return $this->run($sql, $bind);
    }

    public function run($sql, $bind = "")
    {
        $this->sql = trim($sql);
        $this->bind = $this->cleanup($bind);
        $this->error = "";
        try {
            $pdostmt = $this->prepare($this->sql);
            if ($pdostmt->execute($this->bind) !== false) {
                if (preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
                    return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                elseif (preg_match("/^(" . implode("|", array("delete", "insert", "update")) . ") /i", $this->sql))
                    return $pdostmt->rowCount();
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->debug();
            return false;
        }
        return 0;
    }

    public function select($table, $where = "", $bind = "", $fields = "*")
    {
        if ($this->driver = 'pgsql') {
            $table = '"' . $table . '"';
            if ($fields != "*") {
                $modifiedFields = $this->addQuotes($fields, true);
                $fields = implode($modifiedFields, ", ");
            }
        } else {
            if ($fields != "*") {
                $fields = implode($fields, ", ");
            }
        }
        $sql = "SELECT " . $fields . " FROM " . $table;
        if (!empty($where))
            $sql .= " WHERE " . $where;
        $sql .= ";";
        return $this->run($sql, $bind);
    }

    public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat = "html")
    {
        //Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
        if (in_array(strtolower($errorCallbackFunction), array("echo", "print")))
            $errorCallbackFunction = "print_r";

        if (function_exists($errorCallbackFunction)) {
            $this->errorCallbackFunction = $errorCallbackFunction;
            if (!in_array(strtolower($errorMsgFormat), array("html", "text")))
                $errorMsgFormat = "html";
            $this->errorMsgFormat = $errorMsgFormat;
        }
    }

    public function update($table, $info, $where, $bind = "")
    {
        $fields = $this->filter($table, $info);
        $fieldSize = sizeof($fields);

        if ($this->driver == 'pgsql') {
            $modifiedFields = $this->addQuotes($info);
            $table = '"' . $table . '"';
        } else {
            $modifiedFields = $fields;
        }
        $sql = "UPDATE " . $table . " SET ";
        for ($f = 0; $f < $fieldSize; ++$f) {
            if ($f > 0)
                $sql .= ", ";
            $sql .= $modifiedFields[$f] . " = :update_" . $fields[$f];
        }
        $sql .= " WHERE " . $where . ";";

        $bind = $this->cleanup($bind);
        foreach ($fields as $field)
            $bind[":update_$field"] = $info[$field];

        return $this->run($sql, $bind);
    }
}