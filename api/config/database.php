<?php
// Simple PDO database connection helper
// Update credentials to match your local MySQL/phpMyAdmin setup

declare(strict_types=1);

class DatabaseConnection
{
	private string $host;
	private string $dbName;
	private string $username;
	private string $password;
	private ?\PDO $pdo = null;

	public function __construct(
		string $host = '127.0.0.1',
		string $dbName = 'appointments_system',
		string $username = 'root',
		string $password = ''
	) {
		$this->host = $host;
		$this->dbName = $dbName;
		$this->username = $username;
		$this->password = $password;
	}

	public function getPdo(): \PDO
	{
		if ($this->pdo instanceof \PDO) {
			return $this->pdo;
		}

		try {
			$dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
			$options = [
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES => false,
			];

			$this->pdo = new \PDO($dsn, $this->username, $this->password, $options);
			return $this->pdo;
		} catch (\PDOException $e) {
			// في حالة فشل الاتصال، ارجع null للسماح بالتشغيل بدون قاعدة البيانات
			throw new \Exception('Database connection failed: ' . $e->getMessage());
		}
	}
}


