# MagicObject

# Introduction

MagicObject is a powerful library for developing applications in PHP with ease. It enables the dynamic creation of classes for various intended uses. Below are some of its key features:

# Features

1. **Dynamic Object Creation**: Easily create objects at runtime.
2. **Setters and Getters**: Simplify property management with automatic methods.
3. **Multi-Level Objects**: Support for nested objects.
4. **ORM**: Object-Relational Mapping support for easier interactions with databases.
5. **Filtering and Pagination**: Built-in methods for managing data display.
6. **Native Query**: Defining native queries for a function will increase flexibility and resource efficiency in accessing the database.
7. **Multiple Database Connection**: MagicObject supports the configuration of multiple database connections, allowing applications to interact with different databases simultaneously.
8. **Database Dumping**: Export database contents efficiently.
9. **Serialization/Deserialization**: Handle JSON and YAML formats seamlessly.
10. **Data Importing**: Import data even if source and destination schemas differ.
11. **File Reading**: Read INI, YAML, and JSON configuration files.
12. **Environment Variable Access**: Easily fetch environment variable values.
13. **Configuration Encryption**: Secure application settings.
14. **HTTP Data Handling**: Create objects from global request variables (POST, GET, etc.).
15. **Session Management**: Integrate with PHP sessions.
16. **Object Labeling**: Enhance object identification.
17. **Multi-Language Support**: Facilitate localization.
18. **File Uploads**: Handle file uploads efficiently.
19. **Annotations**: Add metadata to objects for better structure.
20. **Debugging**: Tools to debug and inspect objects.

This library provides a versatile toolkit for building robust PHP applications!

# Installation

## Installing MagicObject

To install MagicObject, run:

```
composer require planetbiru/magic-object
```

If Composer is not installed, use:

```
php composer.phar require planetbiru/magic-object
```

To remove MagicObject:

```
composer remove planetbiru/magic-object
```

Or if Composer is not installed:

```
php composer.phar remove planetbiru/magic-object
```

## Installing Composer

To install Composer on your system or download the latest `composer.phar`, visit https://getcomposer.org/download/ 

To see available versions of MagicObject, visit https://packagist.org/packages/planetbiru/magic-object



## Installing MagicObject on PHP 5

This guide walks you through the steps to install **MagicObject** using Composer on a PHP project, particularly if you're working with a PHP version that might not meet the platform requirements for the package.

### Prerequisites:

-   PHP installed on your system (PHP 5.x or higher)
-   Composer installed globally or locally in your project

----------

### Steps to Install MagicObject

#### 1. **Navigate to Your Project Directory**

Open your terminal and navigate to your PHP project folder:

```bash
cd /path/to/your/project
```

Make sure you're in the correct directory where your PHP project resides.

#### 2. **Install MagicObject Using Composer**

Run the following command to require **MagicObject** in your project:

```bash
composer require planetbiru/magic-object
```

This command will:

-   Add `planetbiru/magic-object` as a dependency to your `composer.json` file.
-   Download and install the MagicObject package into your `vendor/` directory.

#### 3. **Update Dependencies with Ignored Platform Requirements**

If you're using a PHP version or configuration that doesn't meet the platform requirements specified by MagicObject, you can use the `--ignore-platform-reqs` flag to bypass those checks during the installation process:

```bash
composer update --ignore-platform-reqs
```

This command will:

-   Update all dependencies listed in `composer.json`.
-   Ignore platform-specific checks like PHP version or missing extensions, allowing you to proceed with the installation.

#### 4. **Autoload Composer in Your PHP Script**

After the installation completes, include Composer's autoloader in your PHP scripts to make MagicObject available for use:

```bash
require 'vendor/autoload.php';
```

This ensures that all your dependencies, including MagicObject, are loaded automatically.

#### 5. **Verify Installation**

Check that MagicObject is installed by verifying its presence in the `vendor` directory:

```bash
ls vendor/planetbiru/magic-object
```

You should see the MagicObject files in the `vendor/planetbiru/magic-object` folder.

#### 6. **Start Using MagicObject**

You can now start using MagicObject in your PHP application. Example usage:

```php
use MagicObject\MagicObject;

$object = new MagicObject();
```

Replace this with your specific use cases as needed.

# Advantages

MagicObject is designed for ease of use and can even be used with a code generator. An example of a code generator that successfully creates MagicObject code using only parameters is **MagicAppBuilder**. MagicObject offers many flexible ways to write code, allowing users to choose the approach that best suits their needs.

In addition to prioritizing ease of use, MagicObject is also optimized for efficiency in terms of both time and resource usage, enabling applications to run smoothly even on servers with minimal specifications. This reduces costs in both development and operational phases.

# Application Scaling

For large applications, MagicObject supports database and storage scaling. You can distribute user access across multiple servers and use Redis for session storage. MagicObject integrates with Redis for cloud-based session storage, which can be secured using a password.

![](https://github.com/Planetbiru/MagicObject/blob/main/scale-up.svg)

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
     * @param bool $readonly Readonly flag
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
$cfg->getDatabase()
//
// to get database.host
 $cfg->getDatabase()->getHost()
// to get database.database_name
$cfg->getDatabase()->getDatabaseName()
```

## Entity

```php
<?php

namespace MusicProductionManager\Data\Entity;

use MagicObject\MagicObject;

/**
 * @Entity
 * @JSON(property-naming-strategy=SNAKE_CASE, prettify=true)
 * @Table(name="album")
 * @Cache(enable="true")
 * @package MusicProductionManager\Data\Entity
 */
class Album extends MagicObject
{
	/**
	 * Album ID
	 * 
	 * @Id
	 * @GeneratedValue(strategy=GenerationType.UUID)
	 * @NotNull
	 * @Column(name="album_id", type="varchar(50)", length=50, nullable=false)
	 * @Label(content="Album ID")
	 * @var string
	 */
	protected $albumId;

	/**
	 * Name
	 * 
	 * @Column(name="name", type="varchar(50)", length=50, nullable=true)
	 * @Label(content="Name")
	 * @var string
	 */
	protected $name;

	/**
	 * Title
	 * 
	 * @Column(name="title", type="text", nullable=true)
	 * @Label(content="Title")
	 * @var string
	 */
	protected $title;

	/**
	 * Description
	 * 
	 * @Column(name="description", type="longtext", nullable=true)
	 * @Label(content="Description")
	 * @var string
	 */
	protected $description;

	/**
	 * Producer ID
	 * 
	 * @Column(name="producer_id", type="varchar(40)", length=40, nullable=true)
	 * @Label(content="Producer ID")
	 * @var string
	 */
	protected $producerId;

	/**
	 * Release Date
	 * 
	 * @Column(name="release_date", type="date", nullable=true)
	 * @Label(content="Release Date")
	 * @var string
	 */
	protected $releaseDate;

	/**
	 * Number Of Song
	 * 
	 * @Column(name="number_of_song", type="int(11)", length=11, nullable=true)
	 * @Label(content="Number Of Song")
	 * @var int
	 */
	protected $numberOfSong;

	/**
	 * Duration
	 * 
	 * @Column(name="duration", type="float", nullable=true)
	 * @Label(content="Duration")
	 * @var float
	 */
	protected $duration;

	/**
	 * Image Path
	 * 
	 * @Column(name="image_path", type="text", nullable=true)
	 * @Label(content="Image Path")
	 * @var string
	 */
	protected $imagePath;

	/**
	 * Sort Order
	 * 
	 * @Column(name="sort_order", type="int(11)", length=11, nullable=true)
	 * @Label(content="Sort Order")
	 * @var int
	 */
	protected $sortOrder;

	/**
	 * Time Create
	 * 
	 * @Column(name="time_create", type="timestamp", length=26, nullable=true, updatable=false)
	 * @Label(content="Time Create")
	 * @var string
	 */
	protected $timeCreate;

	/**
	 * Time Edit
	 * 
	 * @Column(name="time_edit", type="timestamp", length=26, nullable=true)
	 * @Label(content="Time Edit")
	 * @var string
	 */
	protected $timeEdit;

	/**
	 * Admin Create
	 * 
	 * @Column(name="admin_create", type="varchar(40)", length=40, nullable=true, updatable=false)
	 * @Label(content="Admin Create")
	 * @var string
	 */
	protected $adminCreate;

	/**
	 * Admin Edit
	 * 
	 * @Column(name="admin_edit", type="varchar(40)", length=40, nullable=true)
	 * @Label(content="Admin Edit")
	 * @var string
	 */
	protected $adminEdit;

	/**
	 * IP Create
	 * 
	 * @Column(name="ip_create", type="varchar(50)", length=50, nullable=true, updatable=false)
	 * @Label(content="IP Create")
	 * @var string
	 */
	protected $ipCreate;

	/**
	 * IP Edit
	 * 
	 * @Column(name="ip_edit", type="varchar(50)", length=50, nullable=true)
	 * @Label(content="IP Edit")
	 * @var string
	 */
	protected $ipEdit;

	/**
	 * Active
	 * 
	 * @Column(name="active", type="tinyint(1)", length=1, defaultValue="1", nullable=true)
	 * @DefaultColumn(value="1")
	 * @var bool
	 */
	protected $active;

	/**
	 * As Draft
	 * 
	 * @Column(name="as_draft", type="tinyint(1)", length=1, defaultValue="1", nullable=true)
	 * @DefaultColumn(value="1")
	 * @var bool
	 */
	protected $asDraft;

}
```

**Usage**

```php
<?php

use MagicObject\Database\PicoDatabase;
use MagicObject\Database\PicoDatabaseCredentials;
use MusicProductionManager\Config\ConfigApp;
use MusicProductionManager\Data\Entity\Album;

require_once dirname(__DIR__)."/vendor/autoload.php";

$cfg = new ConfigApp(null, true);
$cfg->loadYamlFile(dirname(__DIR__)."/.cfg/app.yml", true, true, true);

$databaseCredentials = new PicoDatabaseCredentials($cfg->getDatabase());
$database = new PicoDatabase($databaseCredentials);
try {
    $database->connect();
  
    // Create a new Album instance
    $album1 = new Album(null, $database);
    $album1->setAlbumId("123456");
    $album1->setName("Album 1");
    $album1->setAdminCreate("USER1");
    $album1->setDuration(300);
  
    // Another way to create an object
    // Create an object from stdClass or another object with matching properties (snake_case or camelCase)
    $data = new stdClass;
    // Snake case
    $data->album_id = "123456";
    $data->name = "Album 1";
    $data->admin_create = "USER1";
    $data->duration = 300;
  
    // Or camel case
    $data->albumId = "123456";
    $data->name = "Album 1";
    $data->adminCreate = "USER1";
    $data->duration = 300;
  
    $album1 = new Album($data, $database); 
  
    // Another way to create an object
    // Create an object from an associative array with matching properties (snake_case or camelCase)
    $data = array();
    // Snake case
    $data["album_id"] = "123456";
    $data["name"] = "Album 1";
    $data["admin_create"] = "USER1";
    $data["duration"] = 300;
  
    // Or camel case
    $data["albumId"] = "123456";
    $data["name"] = "Album 1";
    $data["adminCreate"] = "USER1";
    $data["duration"] = 300;
    $album1 = new Album($data, $database);
  
    // Get value from the form
    // This method is not safe
    $album1 = new Album($_POST, $database);
  
    // We can use another method
    $inputPost = new InputPost();
  
    // We can apply filters
    $inputPost->filterName(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);
    $inputPost->filterDescription(PicoFilterConstant::FILTER_SANITIZE_SPECIAL_CHARS);
  
    // If a property is not present in $inputPost, we can set a default value
    // Note that the user can modify the form and add/update unwanted properties
    $inputPost->checkboxActive(false);
    $inputPost->checkboxAsDraft(true);
  
    // We can remove any property data from the $inputPost object before applying it to the entity
    // This property will not be saved to the database
    $inputPost->setSortOrder(null);
  
    $album1 = new Album($inputPost, $database);
  
    // Insert into the database
    $album1->insert();
  
    // Insert or update the record
    $album1->save();
  
    // Update the record
    // A NoRecordFoundException will be thrown if the ID is not found
    $album1->update();
  
    // Convert the object to JSON
    $json = $album1->toString();
    // Alternatively:
    $json = $album1 . "";
  
    // Send to the output buffer
    // It is automatically converted to a string
    echo $album1;
  
    // Find one record by ID
    $album2 = new Album(null, $database);
    $album2->findOneByAlbumId("123456");
  
    // Find multiple records
    $album2 = new Album(null, $database);
    $albums = $album2->findByAdminCreate("USER1");
    $rows = $albums->getResult();
    foreach ($rows as $albumSaved) {
        // $albumSaved is an instance of Album
  
        // We can update the data
        $albumSaved->setAdminEdit("USER1");
        $albumSaved->setTimeEdit(date('Y-m-d H:i:s'));
  
        // This value will not be saved to the database because it does not have a corresponding column
        $albumSaved->setAnyValue("ANY VALUE");
  
        $albumSaved->update();
    }
  
} catch (Exception $e) {
    // Handle the exception (currently doing nothing)
}
```

# Conclusion


MagicObject is designed to offer ease and speed in creating and managing database entities. Here are several reasons why the methods used by MagicObject can be considered intuitive:

1.  **Declarative and Annotation-Based**:
    
    -   By using annotations, MagicObject allows developers to declare entity properties and metadata directly within the code. This makes it easier to understand the structure and relationships of the entities.
        
2.  **Easy Integration with Configuration**:
    
    -   MagicObject can be easily integrated with configuration systems like ConfigApp, making database and development environment setup more straightforward and organized.
        
3.  **Automation**:
    
    -   MagicObject automatically handles many routine tasks, such as CRUD (Create, Read, Update, Delete) operations and table relationships. Developers don’t need to write manual SQL code, reducing the potential for errors.
        
4.  **Object-Oriented Approach**:
    
    -   MagicObject uses an object-oriented approach, allowing developers to work with entities as PHP objects, utilizing methods and properties directly on the entities.
        
5.  **Support for Various Data Formats**:
    
    -   MagicObject can accept data in various formats, including stdClass objects, associative arrays, and form inputs from HTML. This provides flexibility in handling data from different sources.
        
6.  **Easy Relationship Management**:
    
    -   By defining relationships between entities, such as `ManyToOne` and `OneToMany`, MagicObject makes it easy to manage complex relationships without needing to write explicit join SQL.
        
7.  **Automatic Conversion Capabilities**:
    
    -   MagicObject has the capability to automatically convert objects to JSON, which is extremely useful for APIs and modern web applications.


# Tutorial

A tutorial is available here: https://github.com/Planetbiru/MagicObject/blob/main/tutorial.md

# Applications Using MagicObject

1. **Music Production Manager** https://github.com/kamshory/MusicProductionManager
2. **MagicApp** https://github.com/Planetbiru/MagicApp
3. **MagicAppBuilder** https://github.com/Planetbiru/MagicAppBuilder
4. **Koperasi-Simpan-Pinjam-Syariah** https://github.com/kamshory/Koperasi-Simpan-Pinjam-Syariah
5. **Toserba Online** https://toserba-online.top/

# Credit

1. Kamshory - https://github.com/kamshory/

# Contributors

1. Kamshory - https://github.com/kamshory/