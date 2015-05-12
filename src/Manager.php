<?php
/**
 * Cache main entry
 */
namespace CoreORM\Cache
{
    require_once __DIR__ . '/Enum/Manager.php';
    require_once __DIR__ . '/Utility.php';

    use CoreORM\Cache\Enum\Manager as OptionKey,
        CoreORM\Cache\Utility as Util;

    /**
     * Class Manager
     * @package CoreORM\Cache
     */
    class Manager
    {
        /**
         * the global control, this will override
         * all instances
         * @var bool
         */
        protected static $enabledGlobally = true;


        /**
         * current instance control
         * @var bool
         */
        protected $enabled = true;


        /**
         * if enabled, the instances created
         * by the manager
         * @var array
         */
        protected static $instances = array();


        /**
         * static constructor
         * @param array $options
         * @param bool $singleton if true, use singleton for each type
         * @return Manager
         */
        public static function getInstance($options = array(), $singleton = true)
        {
            if (!$singleton) {
                return new self($options);
            }

            $instanceKey = md5(serialize($options));
            if (!empty(self::$instances[$instanceKey])) {
                return self::$instances[$instanceKey];
            }

            $instance = new self($options);
            return self::$instances[$instanceKey] = $instance;

        }


        /**
         * constructor
         * @see CoreORM\Cache\Enum\Manager for option keys
         * @param array $options
         */
        public function __construct($options = array())
        {
            $adaptorType = Util::arrayGet($options, OptionKey::OPT_ADAPTOR);
            // default will be 30 seconds if not specified
            $defaultExp  = Util::arrayGet($options, OptionKey::OPT_DEFAULT_EXPIRY, 30);
            // by default, cache can be turned off
            $enabled     = (bool) Util::arrayGet($options, OptionKey::OPT_ENABLED);
            // version: this is used to control global cache control, by default it's null
            $version     = Util::arrayGet($options, OptionKey::OPT_DEFAULT_VERSION);

            // first of all, enable/disable the cache global control
            $this->enable($enabled);

        }


        /**
         * enable/disable current cache control
         * NOTE: global control will override this
         * @param bool $enabled
         */
        public function enable($enabled)
        {
            $this->enabled = $enabled;

        }


        /**
         * globally turn on/off the cache
         * @param $enabled
         */
        public static function enableGlobally($enabled)
        {
            self::$enabledGlobally = $enabled;

        }


        /**
         * is cache currently enabled?
         * Global must be enabled first
         * @return bool
         */
        public function isCacheEnabled()
        {
            return self::$enabledGlobally && $this->enabled;

        }


    }

}


/**
 * default namespace
 * for quick functions
 */
namespace
{

}
