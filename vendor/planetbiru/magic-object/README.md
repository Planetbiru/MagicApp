# MagicObject

# Introduction

MagicObject is a powerful library for creating applications in PHP with ease. It allows for the derivation of classes with various intended uses. Below are some of its key features:

# Features

1. **Dynamic Object Creation**: Easily create objects at runtime.
2. **Setters and Getters**: Simplify property management with automatic methods.
3. **Multi-Level Objects**: Support for nested objects.
4. **Entity Access**: Streamline interactions with entities.
5. **Filtering and Pagination**: Built-in methods for managing data display.
6. **Native Query**: Defining native queries for a function will increase flexibility and resource efficiency in accessing the database.
7. **Database Dumping**: Export database contents efficiently.
8. **Serialization/Deserialization**: Handle JSON and YAML formats seamlessly.
9. **Data Importing**: Import data even if source and destination schemas differ.
10. **File Reading**: Read INI, YAML, and JSON configuration files.
11. **Environment Variable Access**: Easily fetch environment variable values.
12. **Configuration Encryption**: Secure application settings.
13. **HTTP Data Handling**: Create objects from global request variables (POST, GET, etc.).
14. **Session Management**: Integrate with PHP sessions.
15. **Object Labeling**: Enhance object identification.
16. **Multi-Language Support**: Facilitate localization.
17. **File Uploads**: Handle file uploads efficiently.
18. **Annotations**: Add metadata to objects for better structure.
19. **Debugging**: Tools to debug and inspect objects.

This library provides a versatile toolkit for building robust PHP applications!

# Installation

To install Magic Obbject

```
composer require planetbiru/magic-object
```

or if composer is not installed

```
php composer.phar require planetbiru/magic-object
```

To remove Magic Obbject

```
composer remove planetbiru/magic-object
```

or if composer is not installed

```
php composer.phar remove planetbiru/magic-object
```

To install composer on your PC or download latest composer.phar, click https://getcomposer.org/download/ 

To see available versions of MagicObject, visit https://packagist.org/packages/planetbiru/magic-object

# Advantages

MagicObject is designed to be easy to use and can even be coded using a code generator. An example of a code generator that successfully creates MagicObject code using only parameters is MagicAppBuilder. MagicObject provides many ways to write code. Users can choose the way that is easiest to implement.

MagicObject does not only pay attention to the ease of users in creating applications. MagicObject also pays attention to the efficiency of both time and resources used by applications so that applications can be run on servers with minimum specifications. This of course will save costs used both in application development and operations.

# Application Scaling

For large applications, users can scale the database and storage. So that a user can access any server, use Redis as a session repository. MagicObject clouds session storage with Redis which can be secured using a password.

![](https://github.com/Planetbiru/MagicObject/blob/main/scale-up.svg)

# Stable Version

Stable version of MagicObject is `1.17.2` or above. Please don't install versions bellow it.

# Tutorial

Tutorial is provided here https://github.com/Planetbiru/MagicObject/blob/main/tutorial.md


# Example

## Simple Object

## Yaml

**Yaml File**

```yaml
result_per_page: 20
song_base_url: ${SONG_BASE_URL}
app_name: Music Production Manager
user_image:
  width: 512
  height: 512
album_image:
  width: 512
  height: 512
song_image:
  width: 512
  height: 512
database:
  time_zone_system: Asia/Jakarta
  default_charset: utf8
  driver: ${APP_DATABASE_TYPE}
  host: ${APP_DATABASE_SERVER}
  port: ${APP_DATABASE_PORT}
  username: ${APP_DATABASE_USER}
  password: ${APP_DATABASE_PASSWORD}
  database_name: ${APP_DATABASE_NAME}
  database_schema: public
  time_zone: ${APP_DATABASE_TIME_ZONE}
  salt: ${APP_DATABASE_SALT}
```

**Configuration Object**

Create class `ConfigApp` by extends `MagicObject`

```php
<?php
namespace MusicProductionManager\Config;

use MagicObject\MagicObject;

class ConfigApp extends MagicObject
{
    /**
     * Constructor
     *
     * @param mixed $data Initial data
     * @param boolean $readonly Readonly flag
     */
    public function __construct($data = null, $readonly = false)
    {
        if($data != null)
        {
            parent::__construct($data);
        }
        $this->readOnly($readonly);
    }
    
}
```

```php
<?php

$cfg = new ConfigApp(null, true);
$cfg->loadYamlFile(dirname(__DIR__)."/.cfg/app.yml", true, true, true);

// to get database object,
// $cfg->getDatabase()
//
// to get database.host
// $cfg->getDatabase()->getHost()
// to get database.database_name
// $cfg->getDatabase()->getDatabaseName()
```

# Application

Applications that uses **MagicObjects** are :

1. **Music Production Manager** https://github.com/kamshory/MusicProductionManager
2. **AppBuilder** https://github.com/Planetbiru/AppBuilder
3. **Koperasi-Simpan-Pinjam-Syariah** https://github.com/kamshory/Koperasi-Simpan-Pinjam-Syariah
4. **Toserba Online** https://toserba-online.top/

# Credit

1. Kamshory - https://github.com/kamshory/