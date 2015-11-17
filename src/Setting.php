<?php
namespace Xpressengine\Plugins\GoogleAnalytics;

use Xpressengine\Config\ConfigManager;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

class Setting
{
    protected $cfg;

    protected $storage;

    protected $keygen;

    protected $key = 'google_analytics';

    /**
     * @var \Xpressengine\Config\ConfigEntity
     */
    protected $config;

    protected $file;

    public function __construct(ConfigManager $cfg, Storage $storage, Keygen $keygen)
    {
        $this->cfg = $cfg;
        $this->storage = $storage;
        $this->keygen = $keygen;
    }

    public function exists()
    {
        if ($this->config !== null) {
            return true;
        }

        if (!$config = $this->cfg->get($this->key)) {
            return false;
        }

        $this->config = $config;

        return true;
    }

    public function get($name, $default = null)
    {
        $val = $this->exists() ? $this->config->get($name) : $default;

        return !empty($val) ? $val : $default;
    }

    public function set(array $data)
    {
        $this->config = $this->cfg->set($this->key, $data);

        if (!$this->config->get('uuid')) {
            $this->config->set('uuid', $this->keygen->generate());

            $this->cfg->modify($this->config);
        }
    }

    public function getKeyFile()
    {
        if (!$this->file && $this->get('uuid')) {
            $files = $this->storage->getsByTargetId($this->get('uuid'));

            $this->file = current($files);
        }

        return $this->file;
    }

    public function setKeyFile(File $file)
    {
        $this->storage->removeAll($this->get('uuid'));
        $this->storage->bind($this->get('uuid'), $file);
    }

    public function getKeyContent()
    {
        if ($file = $this->getKeyFile()) {
            return $this->storage->read($file);
        }

        return null;
    }
}
