## Setup

### docker-compose
```bash
sudo apt update
sudo apt install docker.io -y
```

```bash
sudo systemctl start docker
sudo systemctl enable docker
```

```bash 
sudo apt install docker-compose -y
```

Set up Docker's apt repository.
```bash
# Add Docker's official GPG key:
sudo apt-get update
sudo apt-get install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# Add the repository to Apt sources:
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt-get update
```

To install the latest version, run:
```bash
sudo apt-get install docker-ce docker-ce-cli containerd.io
```

Verify that the Docker Engine installation is successful by running the hello-world image.
```bash
sudo docker run hello-world
```

```bash
sudo apt-get update
sudo apt-get install docker-compose-plugin
```

### git

install
```bash
sudo apt-get update
sudo apt-get install git
```

### /var/www/html/
```bash
cd /var/www/
git clone islenska-back
mv islenska-back /var/www/html/
```
Deploy `vendor/laravel/sail`
`storage/app/public/audio`
`storage/texts/`


### /var/www/pwa/ >
dist
Dockerfile

```bash
docker exec -u root -it ib-app bash
```

```bash
docker-compose down
docker-compose build
docker-compose up -d
```

```bash
docker compose exec -w /etc/caddy caddy caddy reload
```

```bash
docker-compose down
docker-compose build
docker-compose up -d
```

```bash
docker compose logs caddy -n=10 -f
```

```bash
composer install
```

```bash
php artisan key:generate
```
