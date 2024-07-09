## How to run app

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
    
sail up -d 

sail bash

# in bash
npm install

npm run dev

# for seeds
php artisan migrate:fresh --seed
```
