 <?php

use Illuminate\Support\Str;
return [
    'default' => 'pgsql',
    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

       
          'pgsql' => [
            'driver' => 'pgsql',
            'host' => 'shulesoftdb.postgres.database.azure.com',
            // 'host'=>'localhost',
            'port' =>'6432',
            'database' =>'shulesoft_2022',
            'username' => 'pgeshuleadmin',
            'password' =>'Shul3@s0ft@202!',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'admin',
              'options' => [
                \PDO::ATTR_EMULATE_PREPARES => true
            ]
        ],

        'karibusms' => [
            'driver' => 'pgsql',
            'host' => 'shulesoftdb.postgres.database.azure.com',
            // 'host'=>'localhost',
            'port' =>'6432',
            'database' =>'other_app',
            'username' => 'pgeshuleadmin',
            'password' =>'Shul3@s0ft@202!',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'new_karibusms',
            'sslmode' => 'prefer',
            'options' => [
                \PDO::ATTR_EMULATE_PREPARES => true
            ]
        ],

    'biotime' => [
            'driver' => 'pgsql',
            // 'url' => env('DATABASE_URL'),
            'host' => '51.91.251.252',
            'port' => '5432',
            'database' => 'biotime',
            'username' => 'postgres',
            'password' => 'Jesus_ShuleSoft@2020_',
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
            'options' => [
                \PDO::ATTR_EMULATE_PREPARES => true
            ]
        ],
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    'migrations' => 'migrations',

    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

]; 
