<?php
    require_once('confidential.php');
    require_once('app/helpers/sanitizer.php');

    class Database extends Sanitizer{
        private $host = HOST;
        private $username = USERNAME;
        private $password = PASSWORD;
        private $database = DATABASE;
        private $connection;
        private $sanitizer;

        public function __construct() {
            $this->connection = $this->openConnection();
            $this->sanitizer = new Sanitizer();
        }

        /**
		 * Establish Database Connection
		 *
		 * @access public
         * @return object
		 **/
        public function openConnection() {
            $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        
            return $connection;
        }

        /**
		 * Fetching rows with MySQLi
		 *
         * @param string $query
		 * @access public
         * @return array
		 **/
        public function baseQuery($query) {
            $result = $this->connection->query($query);

            $resultSet = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $resultSet[] = $row;
                }
            }

            return $resultSet;
        }

        /**
		 * Fetching rows with MySQLi
		 *
         * @param string $query
		 * @access public
         * @return array
		 **/
        public function runQuery($query, $paramType, $paramData) {
            $sql = $this->connection->prepare($query);
            $this->bindQueryParams($sql, $paramType, $paramData);
            $sql->execute();
            $result = $sql->get_result();
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $resultset[] = $row;
                }
            }
            
            if(!empty($resultset)) {
                return $resultset;
            }
        }

        /**
		 * Binding data with MySQLi
		 *
         * @param string $query
         * @param string $paramType
         * @param array $paramDataArray
		 * @access public
		 **/
        public function bindQueryParams($sql, $paramType, $paramDataArray) {
            $paramValueReference[] = &$paramType;

            for ($i = 0; $i < count($paramDataArray); $i++) {
                $paramValueReference[] = &$paramDataArray[$i];
            }

            call_user_func_array(array(
                $sql,
                'bind_param'
            ), $paramValueReference);
        }

        /**
		 * Inserting data with MySQLi
		 *
         * @param string $query
         * @param string $paramType
         * @param array $paramDataArray
		 * @access public
         * @return id
		 **/
        public function insert($query, $paramType, $paramDataArray) {
            $sql = $this->connection->prepare($query);
            $cleanedData = $this->sanitizer->clean($paramDataArray);
            $this->bindQueryParams($sql, $paramType, $cleanedData);
            $sql->execute();
            $id = $sql->insert_id;
            
            return $id;
        }

        /**
		 * Closing Database Connection
		 *
		 * @access public
		 **/
        public function __destruct()
        {
            $closeConnection = $this->connection->close();

            if ($closeConnection === false)
            {
                die('Could not close MySQL connection.');
            }
        }
    }