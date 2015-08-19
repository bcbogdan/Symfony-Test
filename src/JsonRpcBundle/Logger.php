<?php
namespace JsonRpcBundle;
use Symfony\Bridge\Monolog\Logger as LoggerBridge;
class Logger
{
    const ID = 'json_rpc.logger';
    private $logger;
    public function __construct(LoggerBridge $logger = null)
    {
        if (!$logger) {
            $logger = new LoggerBridge();
        }
        $this->logger = $logger;
    }
    public function getLogger()
    {
        return $this->logger;
    }
}