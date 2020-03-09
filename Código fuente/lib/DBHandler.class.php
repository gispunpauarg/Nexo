<?php

class DBHandler {
	private $dbhost;
	private $dbuser;
	private $dbpassword;
        private $schema;
        private $table;

	private $connection;

	function __construct() {
		$this->dbhost = 'localhost:3306';
		$this->dbuser = 'root';
		$this->dbpassword = 'root';
                $this->schema = 'metricsDb';
                $this->table = 'metrics';

		$this->connection = new mysqli($this->dbhost, $this->dbuser, $this->dbpassword, $this->schema);

		if ($this->connection->connect_error) {
                    throw new Exception("Connection to database failed! (error code " . mysqli_errno($this->connection) . ").");
		}
                
                $this->connection->query("SET AUTOCOMMIT = 1");
	}

	function closeConnection() {
		$this->connection->close();
	}

	function executeQuery($query) {
		$result = $this->connection->query($query);

		if (!$result) {
                    throw new Exception("An error occured during the query excecution. Error message: \"" . mysqli_error($this->connection) . "\" (code " . mysqli_errno($this->connection) . ").");
		}

		return $result;
	}
        
        function fetchIndicatorByUUID($uuid, $indicatorName) {
		$query = "SELECT * " .
			"FROM `" . $this->table . "` " .
			"WHERE `indicator` = \"{$indicatorName}\" AND `uuid` = \"{$uuid}\"";

		$result = $this->connection->query($query);

		if (!$result) {
                    throw new Exception("An error occured during the query excecution. Error message: \"" . mysqli_error($this->connection) . "\" (code " . mysqli_errno($this->connection) . ").");
		}

		return $result;
	}

	function fetchIndicatorsByUUID($uuid, $indicatorArray) {
		$query = "SELECT * " .
			"FROM `" . $this->table . "` " .
			"WHERE (";

		if (count($indicatorArray) > 1) {
			foreach ($indicatorArray as $indicator) {
				$query .= "`indicator` = \"{$indicator}\" OR ";
			}

			$query = substr($query, 0, -4);
		} else {
			$query .= "`indicator` = \"{$indicatorArray[0]}\"";
		}
		
		$query .= ") AND `uuid` = \"{$uuid}\"";

		$result = $this->connection->query($query);

		if (!$result) {
			throw new Exception("An error occured during the query excecution. Error message: \"" . mysqli_error($this->connection) . "\" (code " . mysqli_errno($this->connection) . ").");
		}

		return $result;
	}

	function getIndicatorTypes() {
		$query = "SELECT DISTINCT `indicator` " .
			"FROM `" . $this->table . "` " .
			"ORDER BY `indicator` ASC";

		$result = $this->connection->query($query);

		if (!$result) {
			throw new Exception("An error occured during the query excecution. Error message: \"" . mysqli_error($this->connection) . "\" (code " . mysqli_errno($this->connection) . ").");
		}

		return $result;
	}

	function getUUIDs() {
		$query = "SELECT DISTINCT `uuid` " .
			"FROM `" . $this->table . "`";

		$result = $this->connection->query($query);

		if (!$result) {
			throw new Exception("An error occured during the query excecution. Error message: \"" . mysqli_error($this->connection) . "\" (code " . mysqli_errno($this->connection) . ").");
		}

		return $result;
	}
}