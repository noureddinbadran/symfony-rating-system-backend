<h1>vicoland-rating-apis</h1>

# Tech-stack
- PHP 7.4
- Symfony 5
- Doctrine
- Mysql RDMS

# To Run The Project Local
<ol>
<li>
Install the required packages
    by running command 'composer install' in root project directory</li>
<li>
Edit .env file with <br> 
a- Database connection string <br>
b- Front end server ip that use in cros allow orgin
</li>

<li>
Create the database by running the command <br>
```
php bin/console doctrine:database:create --if-not-exists
``` 
</li>

<li>
Migrate the database by running the command <br>
'php bin/console doctrine:schema:update --force' 
</li>

<li>
Fill the database by random data by running the following command
'php bin/console doctrine:fixtures:load'
</li>

<li>
Generate your private.pem & public.pem for JWT-TOKEN as follows:

</li>

</ol>


# To Test The Project Local
<ol>
<li>
Install the required packages
    by running command 'composer install' in root project directory</li>
<li>
Edit .env.test.local file with <br> 
a- Database connection string <br>
b- Front end server ip that use in cros allow orgin
</li>

<li>
Create the database by running the command <br>
'php bin/console --env=test doctrine:database:create --if-not-exists' 
</li>

<li>
Migrate the database by running the command <br>
'php bin/console --env=test doctrine:schema:update --force' 
</li>

<li>
Migrate the database by running the command <br>
'php bin/console --env=test doctrine:schema:update --force' 
</li>

<li>
Fill the database by random data by running the following command
'php bin/console --env=test doctrine:fixtures:load'
</li>

<li>
run the unit test by running the command <br>
"vendor/bin/phpunit"
</li>
</ol>

# API
<ol>
<li>
{backendServerIp}:{backendServerPort}/api/doc
</li>
<li>
{backendServerIp}:{backendServerPort}/api/auth/register
</li>
<li>
{backendServerIp}:{backendServerPort}/api/login_check
</li>
<li>
{backendServerIp}:{backendServerPort}/api/rating-aspects
</li>
<li>
{backendServerIp}:{backendServerPort}/api/rating
</li>
</ol>
