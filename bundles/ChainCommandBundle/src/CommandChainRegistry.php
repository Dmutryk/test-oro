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
        foreach ($this->commandChains as $masterCommand => $chainedCommands) {
            if ($masterCommand === $commandName) {
                return true;
            }
        }

        return false;
    }

    public function isCommandChained(string $commandName): ?string
    {
        foreach ($this->commandChains as $masterCommand => $chainedCommands) {
            if (in_array($commandName, $chainedCommands, true)) {
                return $masterCommand;
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
