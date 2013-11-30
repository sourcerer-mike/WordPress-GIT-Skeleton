<?php
/**
 * Class InitCommand.
 *
 * PHP 5.3
 *
 * @category  WordPress Git Skeleton
 * @author    Mike Pretzlaw <pretzlaw@gmail.com>
 * @copyright 2013 Mike Pretzlaw
 * @license   http://github.com/sourcerer-mike/${PROJECT_NAME}/blob/master/License.md BSD 3-Clause ("BSD New")
 * @link      http://github.com/sourcerer-mike/${PROJECT_NAME}
 * @since     0.0.2
 */

class InitCommand
{
    const ARG_PLUGINS = 'plugins';

    const ARG_THEMES = 'themes';

    const ARG_WORDPRESS = 'wordpress';

    public $conf = array();


    public function __construct()
    {
        $this->conf = array(
            static::ARG_THEMES    => 'themes',
            static::ARG_PLUGINS   => 'plugins',
            static::ARG_WORDPRESS => 'public',
        );
    }


    function __destruct()
    {
        echo PHP_EOL;
        exit;
    }


    /**
     * Retrieve a specific config or everything.
     *
     * @param null|string $node Everything when `null` and one when path given.
     *
     * @return array|string
     */
    public function getConfig($node = null)
    {
        if (null == $node)
        { // $node is null: create
            return $this->conf;
        }

        if (!isset($this->conf[$node]))
        { // not set: ...
            return null;
        }

        return $this->conf[$node];
    }


    /**
     * .
     *
     * @return bool
     */
    public function getErrors()
    {
        $err = array();

        if (!$this->_validateDirectory($this->getConfig(static::ARG_PLUGINS)))
        {
            $err[] = "Plugin directory can not be accessed.";
        }

        if (!$this->_validateDirectory($this->getConfig(static::ARG_THEMES)))
        {
            $err[] = "Theme directory can not be accessed.";
        }

        if (!$this->_validateDirectory($this->getConfig(static::ARG_WORDPRESS)))
        {
            $err[] = "Wordpress directory can not be accessed.";
        }

        return $err;
    }


    public function indexAction()
    {
        $errors = $this->getErrors();

        if (!empty($errors))
        {
            $this->log($errors);

            return;
        }

        $this->makeSymlinksAction();
    }


    /**
     * .
     *
     * @param $message
     *
     * @return void
     */
    public function log($message)
    {
        if (is_array($message))
        {
            foreach ($message as $msg)
            {
                $this->log($msg);
            }

            return;
        }

        $data = func_get_args();
        array_shift($data);

        $message = vsprintf($message, $data);

        echo $message . PHP_EOL;
    }


    public function makeSymlinksAction()
    {
        $wpDir  = $this->getConfig(static::ARG_WORDPRESS) . DIRECTORY_SEPARATOR;
        $target = $this->getConfig(static::ARG_THEMES);
        $link   = $wpDir . 'wp-content/local-themes';

        $this->_symlink($target, $link);

        $target = $this->getConfig(static::ARG_PLUGINS);
        $link = $wpDir . 'wp-content/local-plugins';
        $this->_symlink($target, $link);
    }


    /**
     * .
     *
     * @param $target
     * @param $link
     *
     * @return void
     */
    protected function _symlink($target, $link)
    {
        $this->log('Link %s to %s', $target, $link);

        if (file_exists($link))
        {
            $this->log('File already exists. Abort.');
            return;
        }

        symlink(
            realpath($target),
            $link
        );
    }


    /**
     * Test a directory.
     *
     * @param string $dir
     *
     * @return bool Exists and is writable?
     */
    protected function _validateDirectory($dir)
    {
        return (is_dir($dir) && is_writable($dir));
    }
}

$cmd = new InitCommand();
$cmd->indexAction();
