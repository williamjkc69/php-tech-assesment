<?php

// app/helpers.php
if (!function_exists('config')) {
    /**
     * Retrieves a configuration value.
     *
     * @param string $key The configuration key (e.g., 'db.driver').
     * @param mixed $default Default value if the key does not exist.
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        static $config = [];

        // Split the key into parts (e.g., 'db.driver' => ['db', 'driver'])
        $keys = explode('.', $key);

        // Configuration file name (first part of the key)
        $file = $keys[0];

        // Load the configuration file if not already loaded
        if (!isset($config[$file])) {
            $configPath = __DIR__ . '/../config/' . $file . '.php';
            if (file_exists($configPath)) {
                $config[$file] = require $configPath;
            } else {
                throw new \RuntimeException("Config file {$file}.php not found.");
            }
        }

        // Retrieve the configuration value
        $value = $config[$file];
        foreach (array_slice($keys, 1) as $subKey) {
            if (isset($value[$subKey])) {
                $value = $value[$subKey];
            } else {
                return $default;
            }
        }

        return $value;
    }
}

if (!function_exists('env')) {
    /**
     * Retrieves an environment value.
     *
     * @param string $key The environment variable key.
     * @param mixed $default Default value if the key does not exist.
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
