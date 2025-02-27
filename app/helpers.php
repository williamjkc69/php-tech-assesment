<?php

// app/helpers.php
if (!function_exists('config')) {
    /**
     * Obtiene un valor de configuración.
     *
     * @param string $key La clave de configuración (por ejemplo, 'db.driver').
     * @param mixed $default Valor por defecto si la clave no existe.
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        static $config = [];

        // Divide la clave en partes (por ejemplo, 'db.driver' => ['db', 'driver'])
        $keys = explode('.', $key);

        // Nombre del archivo de configuración (primera parte de la clave)
        $file = $keys[0];

        // Carga el archivo de configuración si no está cargado
        if (!isset($config[$file])) {
            $configPath = __DIR__ . '/../config/' . $file . '.php';
            if (file_exists($configPath)) {
                $config[$file] = require $configPath;
            } else {
                throw new \RuntimeException("Config file {$file}.php not found.");
            }
        }

        // Obtiene el valor de la configuración
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
     * Obtiene un valor de entorno.
     *
     * @param string $key La clave de la variable de entorno.
     * @param mixed $default Valor por defecto si la clave no existe.
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
