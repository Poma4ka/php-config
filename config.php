<?php
namespace zcl;

class config
{
    private static string $configsPath = "";
  
    public static function setPath(string $path) {
        self::$configsPath = $path;
    }

    public static function get(string $name) :config
    {
        $config = self::getConfig($name);
        return new config($config,$name);
    }

    private static function getConfig($config) :?array
    {
        $configPath = self::$configsPath."/$config.json";
        if (file_exists($configPath)) {
            $config = file_get_contents($configPath);
            $config = json_decode($config,true);
            if (is_array($config)) {
                return $config;
            }
        }
        return null;
    }

    private ?array $config;
    private string $config_name;

    private function __construct(?array $config,string $name)
    {
        $this->config = $config;
        $this->config_name = $name;
    }

    public function value($value)
    {
        if (!$this->config) return null;
        return $this->config[$value] ?? null;
    }

    public function values(string ...$values) :?array
    {
        if (!$this->config) return null;

        $result = [];

        if (!$values) {
            $result = $this->config;
        } else {
            foreach ($values as $value) {
                $result[$value] = $this->config[$value] ?? null;
            }
        }

        return $result;
    }

    public function exclude(string ...$values) :?array
    {
        if (!$this->config) return null;

        $result = $this->config;

        foreach ($values as $value) {
            unset($result[$value]);
        }

        return $result;
    }

    public function update(array $values) :?bool
    {
        if (!$this->config) return null;

        foreach ($values as $key => $value) {
            if (isset($this->config[$key])) {
                if (gettype($this->config[$key]) === gettype($value) || !$this->config[$key]) {
                    $this->config[$key] = $value;
                }
            }
        }
        return $this->writeConfig();
    }

    private function writeConfig() :bool
    {
        if (!$this->config) return false;

        $configPath = self::$configsPath."/$this->config_name.json";

        if (file_exists($configPath)) {
            try {
                file_put_contents($configPath,json_encode($this->config, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
                return true;
            } catch (Exception $e) {}
        }
        return false;
    }
}
