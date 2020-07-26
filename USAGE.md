## Install

1. ```composer install```
2. setup ion_auth database: ```mysql -u <mysql_user> <mysql db> < application/sql/ion_auth.sql```
3. setup rest auth: ```mysql -u <mysql_user> <mysql db> < application/sql/user_digests.sql```

## Test

### Using [httpie](http://httpie.org)

```
$ http --auth-type digest --auth "admin@admin.com:password" http://localhost/api/user/me
```

### Using guzzle

Install guzzle: ```composer install guzzlehttp/guzzle```

```php 
require_once __DIR__ . "/vendor/autoload.php";

use GuzzleHttp\Client;

$base_uri = 'http://localhost';
$identity = 'admin@admin.com';
$password = 'password';

$client = new Client(['base_uri' => $base_uri]);

try
{
    $res = $client->request('GET', '/api/user/me', [
        'auth' => [$identity, $password, 'digest'],
    ]);

    /* echo json_encode($res->getHeaders()); */
    /* echo PHP_EOL; */
    echo $res->getBody();
} catch (Exception $e)
{
    echo "FAILED ". $e->getMessage();
}

```
