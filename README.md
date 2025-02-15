# Shroomer

- [Docker](https://www.docker.com/)
- [Symfony](https://symfony.com)
- [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) 

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## DayToDay usage

```
docker run -it --rm jakzal/phpqa
phpqa phpstan analyse src
phpqa phpcs src
phpqa phpcbf src
```

## ASCII arts

Most of ascii art are generated using pyBonsai:
```
pybonsai --width 84 --height 40 -C zZ -l 8 -L 8 -c '|' -S 18 -f -a 330  
pybonsai --width 84 --height 40 -C zZ -l 8 -L 8 -c '|' -S 18 -f -a 30  
```

