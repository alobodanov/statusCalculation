<?php

class StateInterval {

    /**
     * @var int
     */
    protected $start;

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @var int
     */
    protected $end;

    public function __construct($start = null, $end = null) {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @param $start
     * @return StateInterval
     */
    public function setStart($start): self {
        $this->start = $start;
        return $this;
    }

    /**
     * @param $end
     * @return StateInterval
     */
    public function setEnd($end): self {
        $this->end = $end;
        return $this;
    }

    public function isClosed() : bool {
        return isset($this->start) && isset($this->end);
    }

    public function isOpen(): bool {
        return isset($this->start) && !isset($this->end);
    }

    public function getLength(): int {
        return $this->end - $this->start;
    }

    public function getTime($date) {
        $time = ($this->end ? $this->end : time()) - $date;

        return $time;
    }
}
