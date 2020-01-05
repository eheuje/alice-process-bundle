alice-process-bundle
===

Simple Task fileloader of nelmio/alice-bundle for the Process Bundle

# How to...

You need to create "fake" instance of the following classe. 

```php
<?php

namespace App\Entity;

class User
{
    private $lastName;
    private $firstName;

    public function __construct(string $lastName, string $firstName)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
    }
}
```

You can use easily [Alice](https://github.com/nelmio/alice) which provide an easy way to get a bunch of fake instance of
our class `App\Entity\User` which the following declaration.

```yaml
## '%kernel.project_dir%/fixtures/dev.yaml'

App\Entity\User:
  user_{1..20}:
    __construct:
      - '<lastName()>'
      - '<firstName()>'

```

Then, define a configuration for an install process

```yaml
## '%kernel.project_dir%/config/packages/process.yml'

clever_age_process:
    configurations:
        install:
            entry_point: load
            tasks:
                load:
                    service: '@Jycamier\AliceProcessBundle\Task\File\AliceFixtureLoaderTask'
                    options:
                        file_path: '%kernel.project_dir%/fixtures/dev.yml'
                    outputs: [debug]
                debug:
                    service: '@CleverAge\ProcessBundle\Task\Debug\DebugTask'
```

```bash
$ bin/console cleverage:process:execute install
```
 
## See

* [Process Bundle](https://github.com/cleverage/process-bundle)
* [Doctrine Process Bundle](https://github.com/cleverage/doctrine-process-bundle)
* [Console Command Process Bundle](https://github.com/jycamier/console-command-process-bundle)
