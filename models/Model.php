<?php
    require_once('../config/db.php');

    interface ModelInterface {
        public function runQuery($query, $data);
        public function create($data);
        public function update(array $data);
        public function delete(int $id);
        public function select($columns);
        public function where(array $params);
        public function find(array $params);
    }

    abstract class Model implements ModelInterface {
        
        protected $table;
        protected $dates;//to define columns expecting date value
        protected $primary_key;
        private $method;
        private $query_data;

        private $pdo = null;
        private $stmt = null;
        
        //establish connection for the model to query the DB
        function __construct () {
            try {
                $this->pdo = new PDO(
                    "mysql:hosts=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
            } catch (Exception $e) {
                trigger_error($e->getMessage());
            }
        }

        //close connection
        function __destruct () {
            if ($this->stmt!==null) { 
                $this->stmt = null; 
            }
            if ($this->pdo!==null) { 
                $this->pdo = null; 
            }
        }

        public function getTableName(): string {
            if ($this->table) {
                return $this->table;
            }
            $this->table = static::class ."s";
            return $this->table;
        }

        public function select($columns) {

        }
        public function find(array $params) {
            //only the first param we use for now
            $col_names = array_keys($params);
            $col_values = array_values($params);
            $this->stmt = $this->pdo->prepare(
                "SELECT * FROM {$this->getTableName()} WHERE {$col_names[0]} = '{$col_values[0]}' limit 1"
            );
            $stmt = $this->_execute($this->stmt, []);
            return $stmt->fetch();
        }
        public function selectAll() {
            $this->stmt = $this->pdo->prepare(
                "SELECT * FROM {$this->getTableName()}"
            );
            $stmt = $this->_execute($this->stmt, []);
            return $stmt->fetchAll();
        }

        public function runQuery($query, $params = []) {
            $this->stmt = $this->pdo->prepare($query);
            return $this->_execute($this->stmt, $params);
        }

        public function create($data = array()) {
            if (is_array($data) && count($data)) {
                $col_names = join(",", array_keys($data));
                $col_values = array_values($data);

                $values_string = "";
                $last_key = count($data) - 1;

                foreach ($col_values as $key => $value) {
                    if ($last_key !== $key) {
                        $values_string .= is_int($value) ? $value .",": "'$value'" .",";
                        continue;
                    }
                    $values_string .= is_int($value) ? $value : "'$value'";
                }

                $query = "INSERT INTO {$this->getTableName()} ({$col_names}) values($values_string)";
                $this->stmt = $this->pdo->prepare($query);

                return $this->_execute($this->stmt);
            }
            return false;
        }

        public function update(array $data) {
            $this->query_data = $data;
            return $this;
        }

        public function where(array $data) {
            if ($this->query_data && count($this->query_data)) {
                $set_value_string = "";
                $i = 0;
                $c = count($this->query_data);
                foreach ($this->query_data as $column => $value) {
                    if ($i === 0) {
                        if(is_int($value)) {
                            $set_value_string .=$this->_addComma(" SET $column = $value", $i, $c );
                        } else {
                            $set_value_string .=$this->_addComma(" SET $column = '$value'", $i, $c );
                        }
                    } else {
                        if(is_int($value)) {
                            $set_value_string .=$this->_addComma(" $column = $value", $i, $c );
                        } else {
                            $set_value_string .=$this->_addComma(" $column = '$value'", $i, $c );
                        }
                    }
                    $i++;
                }
                if (count($data) > 0) {
                    $i = 0;
                    $c = count($data);
                    foreach ($data as $column => $value) {
                        if ($i === 0) {
                            if(is_int($value)) {
                                $set_value_string .= $this->_addComma(" WHERE $column = $value", $i, $c );
                            } else {
                                $set_value_string .= $this->_addComma(" WHERE $column = '$value'", $i, $c );
                            }
                        } else {
                            if(is_int($value)) {
                                $set_value_string .= $this->_addComma(" AND $column = $value", $i, $c );
                            } else {
                                $set_value_string .=$this->_addComma(" AND $column = '$value'", $i, $c );
                            }
                        }
                        $i++;
                    }
                    $query = "UPDATE {$this->getTableName()} " . $set_value_string;
                    $this->stmt = $this->pdo->prepare($query);
                    return $this->_execute($this->stmt);
                }
            }
            return false;
        }

        private function _addComma($str, $i, $c) {
            if($c===($i + 1)) return $str;
            return $str . ', ';
        }

        public function delete(int $val) {
            $col_name = $this->primary_key ?? 'id';
            $query = "DELETE FROM {$this->getTableName()} WHERE {$col_name} = $val LIMIT 1";
            $this->stmt = $this->pdo->prepare($query);
            return $this->_execute($this->stmt);
        }

        private function _execute(PDOStatement $sth, array $params = array()) {
            if (empty($params)) {
                $sth->execute();
            } else {
                $sth->execute($params);
            }
            return $sth;
        }
    }
?>