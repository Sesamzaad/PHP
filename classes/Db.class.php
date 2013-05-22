<?php
	class Db
	{
		//member variabelen
		private $m_sHost = "localhost";
		private $m_sUser = "root";
		private $m_sPassword = "";
		private $m_sDatabase = "lesphp";
		public $conn;
		
		public function __construct()
		{
			$this->conn = new MySQLi($this->m_sHost,$this->m_sUser,$this->m_sPassword,$this->m_sDatabase);		
			
			if($this->conn->connect_errno)
			{	
				throw new Exception("Databaselink nie guuuuuud");	
			}
		}
			
	}
	


?>