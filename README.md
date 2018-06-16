Yii2 RBAC module
==============

1 Introduction
----------------------------

[![Latest Stable Version](https://poser.pugx.org/itstructure/yii2-rbac-module/v/stable)](https://packagist.org/packages/itstructure/yii2-rbac-module)
[![Latest Unstable Version](https://poser.pugx.org/itstructure/yii2-rbac-module/v/unstable)](https://packagist.org/packages/itstructure/yii2-rbac-module)
[![License](https://poser.pugx.org/itstructure/yii2-rbac-module/license)](https://packagist.org/packages/itstructure/yii2-rbac-module)
[![Total Downloads](https://poser.pugx.org/itstructure/yii2-rbac-module/downloads)](https://packagist.org/packages/itstructure/yii2-rbac-module)
[![Build Status](https://scrutinizer-ci.com/g/itstructure/yii2-rbac-module/badges/build.png?b=master)](https://scrutinizer-ci.com/g/itstructure/yii2-rbac-module/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itstructure/yii2-rbac-module/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/itstructure/yii2-rbac-module/?branch=master)

**Rbac module** -- Module for the Yii2 framework, which provides management with the next data:
- Roles
- Permissions

2 Dependencies
----------------------------

- php >= 7.1
- composer
- MySql >= 5.5

3 Installation
----------------------------

Via composer:

```composer require "itstructure/yii2-rbac-module": "^1.1.0"```

or in section **require** of composer.json file set the following:
```
"require": {
    "itstructure/yii2-rbac-module": "^1.1.0"
}
```
and command ```composer install```, if you install yii2 project extensions first,

or command ```composer update```, if all yii2 project extensions are already installed.

In accordance with the [documentation for Yii2](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html), set **authManager** for application:

```php
'components' => [
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    // ...
],
```

In accordance with the [documentation for Yii2](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html), run command:

```php
yii migrate --migrationPath=@yii/rbac/migrations
```

4 Usage
----------------------------

### 4.1 Main properties

- The **name** of module: ```rbac```
- The **namespace** for used classes: ```Itstructure\RbacModule```.
- The **alias** to access in to module root directory: ```@rbac```.
- **There is not a layout !** It's taken from application layout **main** by default **or how it is 
configured**.
You cat set ```layout``` attribute in module by custom.
- **View** component is taken by default from the framework like **yii\web\View**. You cat set 
**view** component in module by custom.

### 4.2 Application config
Base application config must be like in example below:

```php
use Itstructure\RbacModule\Module;
use Itstructure\RbacModule\controllers\RolesController;
use Itstructure\RbacModule\controllers\PermissionsController;
```
```php
'modules' => [
    'rbac' => [
        'class' => Module::class,
        'controllerMap' => [
            'roles' => RolesController::class,
            'permissions' => PermissionsController::class,
        ],
    ],
],
```

### 4.3 Useful module attributes

- ```loginUrl``` - set url to be redirected if you are not authorized.
- ```accessRoles``` - The roles of users who are allowed access.

License
----------------------------

Copyright © 2018 Andrey Girnik girnikandrey@gmail.com.

Licensed under the [MIT license](http://opensource.org/licenses/MIT). See LICENSE.txt for details.
