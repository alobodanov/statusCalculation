<?php

require('StateInterval.class.php');

class StateUtils
{
    /**
     * Calculating running state for each log and outputting the time
     * @param $object
     * @param string $status
     * @return int|mixed
     */
    public static function calculateTimeInState(SomeObject $object, $count,$status = 'RUNNING')
    {
        $statusLogs = $object->getDateBoundedStatusLog();
        $timeLength = 0;

        if (!$statusLogs) {
            //Handle logs that are still running
            if ($object->isRunning($status)) {
                $timeLength = time() - $object->getStartDate();
            }

            return $timeLength;
        }

        $interval = new StateInterval();
        $open = NULL;
        $close = NULL;

        foreach ($statusLogs as $i => $log) {
            if ($log['oldState'] === $log['newState']) {
                continue;
            }

            switch (true) {
                case $log['newState'] === $status && !$interval->isOpen():
                    $interval = new StateInterval($log['date']);
                    $open++;
                    break;

                case $log['oldState'] === $status && $interval->isOpen():
                    $interval->setEnd($log['date']);
                    $close++;
                    break;


            }

            if ($interval->isClosed()) {
                $timeLength += $interval->getLength();
            }

        }

        if ($open !== NULL && $close !== NULL && $open > $close && $interval->isOpen() && !$object->getStartDate() && !$object->getStopDate()) {
            $timeLength += $statusLogs[$close]['date'] - $statusLogs[$open]['date'];
        }

        if ($interval->isOpen()) {
            $interval->setEnd($object->getStopDate());
            $timeLength += $interval->getTime($statusLogs[$open]['date']);
        }

        if ($object->getStartDate() && $open !== NULL && $close !== NULL && $statusLogs[count($statusLogs) -1]['newState'] === $status){
            $timeLength = $interval->getTime($statusLogs[count($statusLogs)]['date']);
        }

        return $timeLength;
    }
}

?>