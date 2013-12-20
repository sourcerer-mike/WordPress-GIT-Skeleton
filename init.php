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
    public function __construct()
    {
    }


    function __destruct()
    {
        echo PHP_EOL;
        exit;
    }



    public function indexAction()
    {
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
        $this->_symlink('wp-content', 'public/wp-content');
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

        $x = symlink(
            realpath($target),
            $link
        );

        var_dump($x);
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
