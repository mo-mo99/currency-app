<?php
namespace Mamad\CurrencyApp;
require 'vendor/autoload.php';
use Cron\CronExpression;
use DateTime;
use React\EventLoop\Loop;
/**
 * Schedule the given task based on the specified CRON expression
 *
 * @param callable $task
 * @param CronExpression $cron
 */
function schedule(callable $task, CronExpression $cron): void
{
    $now = new DateTime();
    // CRON is due, run task asap:
    if ($cron->isDue($now)) {
        Loop::futureTick(function () use ($task) {
            $task();
        });
    }
    // Function that executes the task
    // and adds a timer to the event loop to execute the function again when the task is next due:
    $schedule = function () use (&$schedule, $task, $cron) {
        $task();
        $now = new DateTime();
        $nextDue = $cron->getNextRunDate($now);
        Loop::addTimer($nextDue->getTimestamp() - $now->getTimestamp(), $schedule);
    };
    // Add a timer to the event loop to execute the task when it is next due:
    $nextDue = $cron->getNextRunDate($now);
    Loop::addTimer($nextDue->getTimestamp() - $now->getTimestamp(), $schedule);
}
// Run example task every minute:
$cron = new CronExpression('* * * * *');
$task = function () {
    echo date('Y-m-d H:i:s') . ": Task running\n";
};
schedule($task, $cron);