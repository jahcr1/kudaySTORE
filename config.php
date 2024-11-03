<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

// aca verifico si dotenv seteó alguna variable de entorno, si no lo hizo, carga las env
if (!isset($_ENV['DB_HOST'])) {

  $dotenv = Dotenv::createImmutable(__DIR__); // Cargar las variables de entorno desde .env
  $dotenv->load();
}
