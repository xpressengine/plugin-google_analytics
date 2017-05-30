<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Xpressengine\Config\ConfigManager;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;
use XeStorage;

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
            $files = XeStorage::fetchByFileable($this->get('uuid'));

            $this->file = $files->first();
        }

        return $this->file;
    }

    public function setKeyFile(File $file)
    {
        $this->storage->unBindAll($this->get('uuid'), true);
        $this->storage->bind($this->get('uuid'), $file);
    }

    public function getKeyContent()
    {
        if ($file = $this->getKeyFile()) {
            return $file->getContent();
        }

        return null;
    }
}
