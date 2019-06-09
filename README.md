Built with Symfony 4.3.1 using PHP 7.2

Installing
1. Run "composer install"
2. Copy .env to .env.local and add MySQL and SMTP data
3. Run "php bin/console doctrine:migrations:migrate"
4. Run "php bin/console server:start"
5. Run "yarn install"
6. Run "yarn encore dev"