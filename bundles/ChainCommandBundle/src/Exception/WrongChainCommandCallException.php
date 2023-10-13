<?php

namespace ChainCommandBundle\Exception;

use Exception;
use Throwable;

class WrongChainCommandCallException extends Exception
{
    public function __construct(
        string $chainedCommandName,
        string $masterCommandName,
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $message = sprintf(
            '%s command is a member of %s command chain and cannot be executed on its own.',
            $chainedCommandName,
            $masterCommandName
        );
        parent::__construct($message, $code, $previous);
    }
}