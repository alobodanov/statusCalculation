<?php

/*
 * A class representing the object described in the README.
 */
class SomeObject {
	protected $statusLog;
	protected $startDate;
	protected $stopDate;

	public function __construct($statusLog, $startDate = null, $stopDate = null) {
		$this->statusLog = $statusLog;
		$this->startDate = $startDate;
		$this->stopDate = $stopDate;
	}

	/*
	 * @return array
	 */
	public function getStatusLog() {
		return $this->statusLog;
	}

	/*
	 * @return int|null
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/*
	 * @return int|null
	 */
	public function getStopDate() {
		return $this->stopDate;
	}

    public function getDateBoundedStatusLog() {

        if (!$this->startDate && !$this->stopDate) {
            return $this->statusLog;
        }

        return array_filter($this->statusLog, function($log) {

            $isOnOrAfterStart = empty($this->startDate) || $log['date'] >= $this->startDate;
            $isBeforeStop = empty($this->stopDate) || $log['date'] < $this->stopDate;

            return
                $isOnOrAfterStart &&
                $isBeforeStop
                ;

        });

    }

    public function isRunning($status){
        $lastKey = array_key_last($this->statusLog);

        return $this->statusLog[$lastKey]['newState'] === $status;
    }


}

?>