# Test task for ORO

### Description

Use CommandChainRegistry to connect console commands with registerCommandChain() method;

```php
    $this->commandChainRegistry->registerCommandChain(
        FooHelloCommand::getDefaultName(),
        [BarHelloCommand::getDefaultName()]
    );
```

It uses Event-Listener functionality to apply chaining logic. Event: `onConsoleCommand`