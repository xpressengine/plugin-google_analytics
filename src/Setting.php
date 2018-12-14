<?php
/**
 * Setting.php
 *
 * This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Plugins\GoogleAnalytics;

use Xpressengine\Config\ConfigManager;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;
use XeStorage;

/**
 * Setting
 *
 * @category    GoogleAnalytics
 * @package     Xpressengine\Plugins\GoogleAnalytics
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        http://www.xpressengine.com
 */
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

    /**
     * Setting constructor.
     *
     * @param ConfigManager $cfg     config manager
     * @param Storage       $storage storage
     * @param Keygen        $keygen  keygen
     */
    public function __construct(ConfigManager $cfg, Storage $storage, Keygen $keygen)
    {
        $this->cfg = $cfg;
        $this->storage = $storage;
        $this->keygen = $keygen;
    }

    /**
     * exists
     *
     * @return bool
     */
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

    /**
     * get
     *
     * @param string $name    name
     * @param null   $default default
     *
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        $val = $this->exists() ? $this->config->get($name) : $default;

        return !empty($val) ? $val : $default;
    }

    /**
     * set
     *
     * @param array $data data
     *
     * @return void
     */
    public function set(array $data)
    {
        $this->config = $this->cfg->set($this->key, $data);

        if (!$this->config->get('uuid')) {
            $this->config->set('uuid', $this->keygen->generate());

            $this->cfg->modify($this->config);
        }
    }

    /**
     * get key file
     *
     * @return mixed
     */
    public function getKeyFile()
    {
        if (!$this->file && $this->get('uuid')) {
            $files = XeStorage::fetchByFileable($this->get('uuid'));

            $this->file = $files->first();
        }

        return $this->file;
    }

    /**
     * set key file
     *
     * @param File $file file
     *
     * @return void
     */
    public function setKeyFile(File $file)
    {
        $this->storage->unBindAll($this->get('uuid'), true);
        $this->storage->bind($this->get('uuid'), $file);
    }

    /**
     * get key content
     *
     * @return mixed|null
     */
    public function getKeyContent()
    {
        if ($file = $this->getKeyFile()) {
            return $file->getContent();
        }

        return null;
    }

    /**
     * destroy
     *
     * @return void
     */
    public function destroy()
    {
        $this->storage->unBindAll($this->get('uuid'), true);
        $this->cfg->removeByName($this->key);
    }
}
