<?php

declare(strict_types=1);

function seedDatabasePath(): string
{
    return __DIR__ . '/data/cv.sqlite';
}

function storageRoot(): string
{
    $basePath = getenv('CV_STORAGE_DIR');

    if (!is_string($basePath) || trim($basePath) === '') {
        $basePath = getenv('LOCALAPPDATA');
    }

    if (!is_string($basePath) || trim($basePath) === '') {
        throw new RuntimeException('Impossibile determinare una cartella scrivibile per il database SQLite.');
    }

    $storageRoot = rtrim($basePath, "\\/") . DIRECTORY_SEPARATOR . 'cv-projects' . DIRECTORY_SEPARATOR . basename(__DIR__);

    if (!is_dir($storageRoot) && !mkdir($storageRoot, 0777, true) && !is_dir($storageRoot)) {
        throw new RuntimeException('Impossibile creare la cartella del database: ' . $storageRoot);
    }

    return $storageRoot;
}

function databasePath(): string
{
    static $databasePath = null;

    if (is_string($databasePath)) {
        return $databasePath;
    }

    $databasePath = storageRoot() . DIRECTORY_SEPARATOR . 'cv.sqlite';

    if (!is_file($databasePath) && !copy(seedDatabasePath(), $databasePath)) {
        throw new RuntimeException('Impossibile inizializzare il database SQLite in: ' . $databasePath);
    }

    return $databasePath;
}

function ensureSqliteAvailable(): void
{
    if (!class_exists(PDO::class)) {
        throw new RuntimeException('L\'estensione PDO non e\' disponibile in questa installazione PHP.');
    }

    if (!in_array('sqlite', PDO::getAvailableDrivers(), true)) {
        throw new RuntimeException(
            'Il driver PDO SQLite non e\' disponibile. Abilita le estensioni sqlite3 e pdo_sqlite nel php.ini in uso.'
        );
    }

    if (!is_file(seedDatabasePath())) {
        throw new RuntimeException('Database SQLite sorgente non trovato: ' . seedDatabasePath());
    }
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    ensureSqliteAvailable();

    $pdo = new PDO('sqlite:' . databasePath());
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}

function fetchOne(string $sql, array $params = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetch() ?: [];
}

function fetchAllRows(string $sql, array $params = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}
