
# [nette commits](https://commits.nette.org)

Aggregation of all [nette](https://github.com/nette)/* repositories.

## Setup

1. fork and clone the project
2. create empty database for the project
3. copy [config/local.neon.template](config/local.neon.template) to `config/local.neon` and configure it properly:
    - `database` for database connection
    - `githubAPI` for GitHub API token - generate one [here](https://github.com/settings/tokens/new) with public access
4. run `make install`

## Synchronization

During the synchronization process, all commits from all repositories are being synchronized.

You can run the synchronization either via console command

```bash
php bin/console synchronize
```

or via HTTP GET request

```bash
curl http://yourhost.com/synchronize.php
```

You can set this as a CRON job to run every 5 minutes.

To prevent the synchronization to run multiple times at one time, the [Symfony Lock](https://symfony.com/doc/current/components/lock.html) component is used.
