<?php

declare(strict_types=1);

namespace ChainCommandBundle;

class CommandChainRegistry
{
    private array $commandChains = [];

    public function registerCommandChain(string $masterCommandName, array $chainedCommands): void
    {
        $this->commandChains[$masterCommandName] = $chainedCommands;
    }

    public function isCommandInChain(string $commandName): bool
    {
        if (array_key_exists($commandName, $this->commandChains)) {
            return true;
        }

        return false;
    }

    public function isCommandChained(string $commandName): ?string
    {
        foreach ($this->commandChains as $masterCommand => $chainedCommands) {
            foreach ($chainedCommands as $chainedCommand) {
                if ($chainedCommand === $commandName) {
                    return $masterCommand;
                }
            }
        }

        return null;
    }

    public function getChainedCommands(string $masterCommandName): array
    {
        if (isset($this->commandChains[$masterCommandName])) {
            return $this->commandChains[$masterCommandName];
        }

        return [];
    }
}
