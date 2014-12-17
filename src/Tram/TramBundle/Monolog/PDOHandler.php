<?php

namespace Tram\TramBundle\Monolog;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class PDOHandler extends AbstractProcessingHandler
{
    private $initialized = false;
    private $pdo;
    private $statement;

    public function __construct(\PDO $pdo, $level = Logger::DEBUG, $bubble = true)
    {
        $this->pdo = $pdo;
        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        $date = new \DateTime();



        $this->statement->execute(array(
            'channel' => $record['channel'],
            'level' => $record['level'],
            'message' => $record['formatted'],
            'time' => $date->format('Y-m-d H:i:s')
        ));
    }

    private function initialize()
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS Log '
            .'(level INTEGER, channel VARCHAR(255), time string, message LONGTEXT)'
        );
        $this->statement = $this->pdo->prepare(
            'INSERT INTO Log (level, channel, time, message) VALUES (:level, :channel, :time, :message)'
        );

        $this->initialized = true;
    }
}
