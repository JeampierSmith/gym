<?php
define("base_url", "http://localhost:8080/");
define("host", getenv('DB_HOST') ?: "localhost");
define("user", getenv('DB_USER') ?: "root");
define("pass", getenv('DB_PASSWORD') ?: "");
define("db", getenv('DB_NAME') ?: "gimnasios");
define("charset", "charset=utf8");
?>