<?php
// +----------------------------------------------------------------------
// | HaSog (幻神商城系统)
// +----------------------------------------------------------------------
// | 技术支持【幻神科技】: https://www.hasog.com
// +----------------------------------------------------------------------
// | 联系我们:  https://www.hasog.com
// +----------------------------------------------------------------------
// | gitee开源项目：https://gitee.com/orzice/hasog
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/orzice/hasog
// +----------------------------------------------------------------------
// | Author：Orzice(小涛)  https://gitee.com/orzice
// +----------------------------------------------------------------------
// | DateTime：2020-12-31 18:28:38
// +----------------------------------------------------------------------
/**
 * Cron - Job scheduling for Laravel [Orzice优化版，适用于TP6]
 *
 * @author      Marc Liebig
 * @copyright   2014 Marc Liebig
 * @link        https://github.com/liebig/cron/
 * @license     http://opensource.org/licenses/MIT
 * @package     Cron
 *
 * Please find more copyright information in the LICENSE file
 */

namespace AcgCron;

use think\facade\Event;
use think\facade\Cache;
use think\facade\Config;
/**
 * Cron
 *
 * Cron 作业管理
 * NOTE: The excellent library mtdowling/cron-expression (https://github.com/mtdowling/cron-expression) is required.
 *
 * @package Cron
 * @author  Marc Liebig
 */
class Cron {

    /**
     * @static
     * @var array Saves all the cron jobs
     */
    private static $cronJobs = array();


    // Interval定义两个run方法调用之间的时间（以分钟为单位），换句话说，将调用Cron路由或命令之间的时间
    protected $runInterval = 1;

    //防止作业重叠-如果Cron仍在运行，则无法再次启动
    protected $preventOverlapping = true;
    
    // 启用或禁用检查当前Cron运行是否及时
    protected $inTimeCheck = true;
    
    // 用于保护集成Cron运行路由的Cron应用程序密钥-如果该值为空，则禁用该路由
    protected $cronKey = '';



    /**
     * @static
     * @var int Laravel version
     */
    private static $laravelVersion;

    function __construct() {
    }

    /**
     * Add a cron job
     *
     * Expression definition:
     *
     *       *    *    *    *    *    *
     *       -    -    -    -    -    -
     *       |    |    |    |    |    |
     *       |    |    |    |    |    + year [optional]
     *       |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
     *       |    |    |    +---------- month (1 - 12)
     *       |    |    +--------------- day of month (1 - 31)
     *       |    +-------------------- hour (0 - 23)
     *       +------------------------- min (0 - 59)
     *
     * @static
     * @param  string $name The name for the cron job - has to be unique
     * @param  string $expression The cron job expression (e.g. for every minute: '* * * * *')
     * @param  callable $function The anonymous function which will be executed
     * @param  bool $isEnabled optional If the cron job should be enabled or disabled - the standard configuration is enabled
     * @throws \InvalidArgumentException if one of the parameters has the wrong data type, is incorrect or is not set
     */
    public static function add($name, $expression, $function, $isEnabled = true) {

        // Check if the given job name is set and is a string
        if (!isset($name) || !is_string($name)) {
            throw new \InvalidArgumentException('Method argument $name is not set or not a string.');
        }

        // Check if the given expression is set and is correct
        if (!isset($expression) || count(explode(' ', $expression)) < 5 || count(explode(' ', $expression)) > 6) {
            throw new \InvalidArgumentException('Method argument $expression is not set or invalid.');
        }

        // Check if the given closure is set and is callabale
        if (!isset($function) || !is_callable($function)) {
            throw new \InvalidArgumentException('Method argument $function is not set or not callable.');
        }

        // Check if the given isEnabled flag is set and is a boolean
        if (!isset($isEnabled) || !is_bool($isEnabled)) {
            throw new \InvalidArgumentException('Method argument $isEnabled is not set or not a boolean.');
        }

        // Check if the name is unique
        foreach (self::$cronJobs as $job) {
            if ($job['name'] === $name) {
                throw new \InvalidArgumentException('Cron job $name "' . $name . '" is not unique and already used.');
            }
        }

        // Create the CronExpression - all the magic goes here
        $expression = \Cron\CronExpression::factory($expression);

        // Add the new created cron job to the many other little cron jobs
        array_push(self::$cronJobs, array('name' => $name, 'expression' => $expression, 'enabled' => $isEnabled, 'function' => $function));
    }

    /**
     * 删除 cron job by name
     * 
     * @static
     * @param string $name The name of the cron job which should be removed from execution
     * @return bool Return true if a cron job with the given name was found and was successfully removed or return false if no job with the given name was found
     */
    public static function remove($name) {

        foreach (self::$cronJobs as $jobKey => $jobValue) {
            if ($jobValue['name'] === $name) {
                unset(self::$cronJobs[$jobKey]);
                return true;
            }
        }
        return false;
    }

    /**
     * Run the cron jobs
     * This method checks and runs all the defined cron jobs at the right time
     * This method (route) should be called automatically by a server or service
     * 
     * @static
     * @param bool $checkRundateOnce optional When we check if a cronjob is due do we take into account the time when the run function was called ($checkRundateOnce = true) or do we take into account the time when each individual cronjob is executed ($checkRundateOnce = false) - default value is true
     * @return array Return an array with the rundate, runtime, errors and a result cron job array (with name, function return value, runtime in seconds)
     */
    public static function run($checkRundateOnce = true) {

        // If a new lock file is created, $overlappingLockFile will be equals the file path
        $overlappingLockFile = "";

        try {
            // Get the rundate
            $runDate = new \DateTime();

            // Fire event before the Cron run will be executed
            //\Event::fire('cron.beforeRun', array($runDate->getTimestamp()));
            // 触发UserLogin事件 用于执行用户登录后的一系列操作
            Event::trigger('cron.beforeRun', array($runDate->getTimestamp()));


            // Check if prevent job overlapping is enabled and create lock file if true
            $preventOverlapping = self::getConfig('preventOverlapping', false);

            if (is_bool($preventOverlapping) && $preventOverlapping) {

                $storagePath = "";
                // Fallback function for Laravel3 with helper function path('storage')
                if (function_exists('storage_path')) {
                    $storagePath = storage_path();
                } else if (function_exists('path')) {
                    $storagePath = path('storage');
                }

                if (!empty($storagePath)) {

                    $lockFile = $storagePath . DIRECTORY_SEPARATOR . 'cron.lock';

                    if (file_exists($lockFile)) {
                        //self::log('warning', 'Lock file found - Cron is still running and prevent job overlapping is enabled - second Cron run will be terminated.');


                        // Fire the Cron locked event
                        //\Event::fire('cron.locked', array('lockfile' => $lockFile));
                        Event::trigger('cron.locked', array('lockfile' => $lockFile));

                        // Fire the after run event, because we are done here
                        //\Event::fire('cron.afterRun', array('rundate' => $runDate->getTimestamp(), 'inTime' => -1, 'runtime' => -1, 'errors' => 0, 'crons' => array(), 'lastRun' => array()));
                        Event::trigger('cron.afterRun', array('rundate' => $runDate->getTimestamp(), 'inTime' => -1, 'runtime' => -1, 'errors' => 0, 'crons' => array(), 'lastRun' => array()));

                        return array('rundate' => $runDate->getTimestamp(), 'inTime' => -1, 'runtime' => -1, 'errors' => 0, 'crons' => array(), 'lastRun' => array());
                    } else {

                        // Create lock file
                        touch($lockFile);

                        if (!file_exists($lockFile)) {
                            //self::log('error', 'Could not create Cron lock file at ' . $lockFile . '.');
                        } else {
                            // Lockfile created successfully
                            // $overlappingLockFile is used to delete the lock file after Cron run
                            $overlappingLockFile = $lockFile;
                        }
                    }
                } else {
                    //self::log('error', 'Could not get the path to the Laravel storage directory.');
                }
            }

            // Get the run interval from Laravel config
            $runInterval = self::getRunInterval();

            // Getting last run time only if database logging is enabled
                // If database logging is disabled
                // Cannot check if the cron run is in time
                $inTime = -1;
            

            // Initialize the job and job error array and start the runtime calculation
            $allJobs = array();
            $errorJobs = array();
            $beforeAll = microtime(true);

            // Should we check if the cron expression is due once at method call
            if ($checkRundateOnce) {
                $checkTime = $runDate;
            } else {
                // or do we compare it to 'now'
                $checkTime = 'now';
            }

            // For all defined cron jobs run this
            foreach (self::$cronJobs as $job) {

                // If the job is enabled and if the time for this job has come
                if ($job['enabled'] && $job['expression']->isDue($checkTime)) {

                    // Get the start time of the job runtime
                    $beforeOne = microtime(true);

                    // Run the function and save the return to $return - all the magic goes here
                    try {
                        $return = $job['function']();
                    } catch (\Exception $e) {
                        // If an uncaught exception occurs
                        $return = get_class($e) . ' in job ' . $job['name'] . ': ' . $e->getMessage();
                        //self::log('error', get_class($e) . ' in job ' . $job['name'] . ': ' . $e->getMessage() . "\r\n" . $e->getTraceAsString());
                    }

                    // Get the end time of the job runtime
                    $afterOne = microtime(true);

                    // If the function returned not null then we assume that there was an error
                    if (!is_null($return)) {
                        // Add to error array
                        array_push($errorJobs, array('name' => $job['name'], 'return' => $return, 'runtime' => ($afterOne - $beforeOne)));
                        // Log error job
                        //self::log('error', 'Job with the name ' . $job['name'] . ' was run with errors.');
                        // Fire event after executing a job with erros
                        //\Event::fire('cron.jobError', array('name' => $job['name'], 'return' => $return, 'runtime' => ($afterOne - $beforeOne), 'rundate' => $runDate->getTimestamp()));
                        Event::trigger('cron.jobError', array('name' => $job['name'], 'return' => $return, 'runtime' => ($afterOne - $beforeOne), 'rundate' => $runDate->getTimestamp()));

                    } else {
                        // Fire event after executing a job successfully
                        //\Event::fire('cron.jobSuccess', array('name' => $job['name'], 'runtime' => ($afterOne - $beforeOne), 'rundate' => $runDate->getTimestamp()));
                        Event::trigger('cron.jobSuccess', array('name' => $job['name'], 'runtime' => ($afterOne - $beforeOne), 'rundate' => $runDate->getTimestamp()));
                    }

                    // Push the information of the ran cron job to the allJobs array (including name, return value, runtime)
                    array_push($allJobs, array('name' => $job['name'], 'return' => $return, 'runtime' => ($afterOne - $beforeOne)));
                }
            }

            // Get the end runtime after all cron job executions
            $afterAll = microtime(true);

            // Removing overlapping lock file if lockfile was created
            if (!empty($overlappingLockFile)) {
                self::deleteLockFile($overlappingLockFile);
            }

            $returnArray = array('rundate' => $runDate->getTimestamp(), 'inTime' => $inTime, 'runtime' => ($afterAll - $beforeAll), 'errors' => count($errorJobs), 'crons' => $allJobs);

            // If Cron was called before, add the latest call to the $returnArray 
            if (isset($lastManager[0]) && !empty($lastManager[0])) {
                $returnArray['lastRun'] = array('rundate' => $lastManager[0]->rundate, 'runtime' => $lastManager[0]->runtime);
            } else {
                $returnArray['lastRun'] = array();
            }

            // Fire event after the Cron run was executed
            //\Event::fire('cron.afterRun', $returnArray);
            Event::trigger('cron.afterRun', $returnArray);
                    
            // Return the cron jobs array (including rundate, in-time boolean, runtime in seconds, number of errors and an array with the cron jobs reports)
            return $returnArray;
        } catch (\Exception $ex) {
            // Removing overlapping lock file if lockfile was created
            if (!empty($overlappingLockFile)) {
                self::deleteLockFile($overlappingLockFile);
            }

            throw($ex);
        }
    }

    /**
     * 删除 lock file
     *
     * @static
     * @param  string $file Path and name of the lock file which should be deleted
     */
    private static function deleteLockFile($file) {
        if (file_exists($file)) {
            if (is_writable($file)) {
                unlink($file);

                if (file_exists($file)) {
                    //self::log('critical', 'Could not delete Cron lock file at ' . $file . ' - please delete this file manually - as long as this lock file exists, Cron will not run.');
                }
            } else {
                //self::log('critical', 'Could not delete Cron lock file at ' . $file . ' because it is not writable - please delete this file manually - as long as this lock file exists, Cron will not run.');
            }
        } else {
            //self::log('warning', 'Could not delete Cron lock file at ' . $file . ' because file is not found.');
        }
    }




    /**
     * 重置
     * Remove the cron jobs array 
     *
     * @static
     */
    public static function reset() {
        self::$cronJobs = array();
    }

    /**
     * 设置运行间隔-运行间隔是两个cron作业路由调用之间的时间
     *
     * @static
     * @param  int $minutes Set the interval in minutes
     * @throws \InvalidArgumentException if the $minutes function paramter is not an integer
     */
    public static function setRunInterval($minutes) {
        if (is_int($minutes)) {
            self::setConfig('runInterval', $minutes);
        } else {
            throw new \InvalidArgumentException('Function paramter $minutes with value "' . $minutes . '" is not an integer.');
        }
    }

    /**
     * Get the current run interval value
     * 
     * @return int|null Return the current interval value in minutes or NULL if there is no value set
     * @throws \UnexpectedValueException if the cron::runInterval config value is not an integer or NULL
     */
    public static function getRunInterval() {
        
        $interval = self::getConfig('runInterval');
        
        if (is_null($interval) || is_int($interval)) {
            return $interval;
        } else {
            throw new \UnexpectedValueException('Config option "runInterval" is not an integer or not equals NULL.');
        }
    }


    /**
     * Enable a job by job name
     *
     * @static
     * @param  string $jobname The name of the job which should be enabled
     * @param  bool $enable The trigger for enable (true) or disable (false) the job with the given name
     * @return bool Return true if job was enabled successfully or false if no job with the $jobname parameter was found
     * @throws \InvalidArgumentException if the $enable function paramter is not a boolean
     */
    public static function setEnableJob($jobname, $enable = true) {
        // Check patameter
        if (!is_bool($enable)) {
            throw new \InvalidArgumentException('Function paramter $enable with value "' . $enable . '" is not a boolean.');
        }

        // Walk through the cron jobs and find the job with the given name
        foreach (self::$cronJobs as $jobKey => $jobValue) {
            if ($jobValue['name'] === $jobname) {
                // If a job with the given name is found, set the enable boolean
                self::$cronJobs[$jobKey]['enabled'] = $enable;
                return true;
            }
        }
        return false;
    }

    /**
     * Disable a job by job name
     *
     * @static
     * @param  String $jobname The name of the job which should be disabled
     * @return bool Return true if job was disabled successfully or false if no job with the $jobname parameter was found
     */
    public static function setDisableJob($jobname) {
        return self::setEnableJob($jobname, false);
    }

    /**
     * Is the given job by name enabled or disabled
     *
     * @static
     * @param  String $jobname The name of the job which should be checked
     * @return bool|null Return boolean if job is enabled (true) or disabled (false) or null if no job with the given name is found
     */
    public static function isJobEnabled($jobname) {

        // Walk through the cron jobs and find the job with the given name
        foreach (self::$cronJobs as $jobKey => $jobValue) {
            if ($jobValue['name'] === $jobname) {
                // If a job with the given name is found, return the is enabled boolean
                return self::$cronJobs[$jobKey]['enabled'];
            }
        }
        return;
    }

    /**
     * Enable prevent job overlapping
     *
     * @static
     */
    public static function setEnablePreventOverlapping() {
        self::setConfig('preventOverlapping', true);
    }

    /**
     * Disable prevent job overlapping
     *
     * @static
     */
    public static function setDisablePreventOverlapping() {
        self::setConfig('preventOverlapping', false);
    }

    /**
     * Is prevent job overlapping enabled or disabled
     *
     * @static
     * @return bool Return boolean if prevent job overlapping is enabled (true) or disabled (false)
     */
    public static function isPreventOverlapping() {
        
        $preventOverlapping = self::getConfig('preventOverlapping');
        
        if (is_bool($preventOverlapping)) {
            return $preventOverlapping;
        } else {
            // If no value or not a boolean value is given, prevent overlapping is disabled
            return false;
        }
    }

    /**
     * Enable the Cron run in time check
     *
     * @static
     */
    public static function setEnableInTimeCheck() {
        self::setConfig('inTimeCheck', true);
    }

    /**
     * Disable the Cron run in time check
     *
     * @static
     */
    public static function setDisableInTimeCheck() {
        self::setConfig('inTimeCheck', false);
    }

    /**
     * Is the Cron run in time check enabled or disabled
     *
     * @static
     * @return bool Return boolean if the Cron run in time check is enabled (true) or disabled (false)
     */
    public static function isInTimeCheck() {
        
        $inTimeCheck = self::getConfig('inTimeCheck');
        
        if (is_bool($inTimeCheck)) {
            return $inTimeCheck;
        } else {
            // If no value or not a boolean value is given, in time check should be enabled
            return true;
        }
    }

    /**
     * Get added Cron jobs as array
     *
     * @static
     * @return array Return array of the added Cron jobs
     */
    public static function getCronJobs() {
        return self::$cronJobs;
    }
    
    /**
     * Get Config value
     *
     * @static
     * @param  string $key Config key to get the value for
     * @param  mixed $defaultValue If no value for the given key is available, return this default value
     */
    private static function getConfig($key, $defaultValue = NULL) {
        $configValue = $defaultValue;

        $configValue = Config::get('cron.' . $key);
       
        return $configValue;
    }

    /**
     * Set config value
     *
     * @static
     * @param  string $key Config key to set the value for
     * @param  mixed $value Value which should be set
     */
    private static function setConfig($key, $value) {
        Config::set('cron.' . $key, $value);
    }
}
