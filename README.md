# `Zerotoprod\DataModelGenerator`

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/data-model-generator)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/data-model-generator/test.yml?label=test)](https://github.com/zero-to-prod/data-model-generator/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/data-model-generator/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/data-model-generator/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/data-model-generator?color=blue)](https://packagist.org/packages/zero-to-prod/data-model-generator/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/data-model-generator?color=f28d1a)](https://packagist.org/packages/zero-to-prod/data-model-generator)
[![License](https://img.shields.io/packagist/l/zero-to-prod/data-model-generator?color=red)](https://github.com/zero-to-prod/data-model-generator/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/data-model-generator.svg)](https://wakatime.com/badge/github/zero-to-prod/data-model-generator)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/data-model-generator?branch=main)](https://hitsofcode.com/github/zero-to-prod/data-model-generator/view?branch=main)

Generates PHP classes and enums from OpenAPI 3.0 and Swagger 2.0 schemas.

Reads your API schema and a configuration file, then outputs fully-typed PHP classes with configurable visibility, readonly modifiers, constants, comments, and type mappings.

## Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Initialize Configuration](#initialize-configuration)
    - [Generate from a Schema](#generate-from-a-schema)
    - [Programmatic Usage](#programmatic-usage)
- [Configuration](#configuration)
    - [Model Options](#model-options)
    - [Property Options](#property-options)
    - [Constant Options](#constant-options)
- [Example](#example)
- [Documentation Publishing](#documentation-publishing)
    - [Automatic Documentation Publishing](#automatic-documentation-publishing)
- [Testing](#testing)

## Installation

Install the package via composer:

```bash
composer require zero-to-prod/data-model-generator
```

Requires PHP 8.1 or higher.

## Usage

### Initialize Configuration

Generate a `data-model.json` configuration file in your project root:

```bash
vendor/bin/data-model-generator init
```

This copies a default configuration template that you can customize.

### Generate from a Schema

Pass a path or URL to an OpenAPI 3.0 or Swagger 2.0 schema:

```bash
vendor/bin/data-model-generator generate /path/to/openapi.json
```

The CLI detects the schema type automatically and generates PHP files based on your `data-model.json` configuration.

### Programmatic Usage

You can also call the engine directly:

```php
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Config;

Engine::generate(
    Components::from($componentsArray),
    Config::from($configArray)
);
```

## Configuration

The `data-model.json` file controls how classes and enums are generated.

```json
{
  "$schema": "./vendor/zero-to-prod/data-model-generator/src/Schema/data_model.json",
  "model": {
    "directory": "./app/DataModels",
    "namespace": "App\\DataModels",
    "imports": [
      "use Zerotoprod\\DataModel;"
    ],
    "comments": true,
    "readonly": false,
    "use_statements": [
      "use DataModel;"
    ],
    "properties": {
      "comments": true,
      "visibility": "public",
      "readonly": true,
      "types": {
        "integer": "int",
        "boolean": "bool",
        "number": "float"
      },
      "nullable": true
    },
    "constants": {
      "comments": true,
      "type": true,
      "visibility": "public"
    }
  }
}
```

### Model Options

| Option           | Type     | Default | Description                                      |
|------------------|----------|---------|--------------------------------------------------|
| `directory`      | `string` | `null`  | Output directory for generated files              |
| `namespace`      | `string` | `null`  | PHP namespace for generated classes               |
| `imports`        | `array`  | `[]`    | `use` import statements added to every file       |
| `comments`       | `bool`   | `false` | Include class-level docblock comments             |
| `readonly`       | `bool`   | `false` | Apply the `readonly` modifier to classes          |
| `use_statements` | `array`  | `[]`    | Traits added inside every class body              |

### Property Options

| Option       | Type                  | Default | Description                                                            |
|--------------|-----------------------|---------|------------------------------------------------------------------------|
| `visibility` | `public\|protected\|private` | `public` | Visibility modifier for properties                              |
| `readonly`   | `bool`                | `false` | Apply `readonly` to all properties                                     |
| `comments`   | `bool`                | `false` | Include property-level docblock comments                               |
| `types`      | `object`              | `{}`    | Type mapping (e.g., `"integer": "int"` maps `integer` types to `int`)  |
| `nullable`   | `bool`                | `false` | Append `null` to all property types and default to `null`              |

### Constant Options

| Option       | Type                  | Default  | Description                                     |
|--------------|-----------------------|----------|-------------------------------------------------|
| `visibility` | `public\|protected\|private` | `public` | Visibility modifier for constants         |
| `type`       | `bool`                | `false`  | Include type declarations on constants           |
| `comments`   | `bool`                | `false`  | Include constant-level docblock comments         |

## Example

Given a schema that defines a `User` model and a `Role` enum, and using the default configuration above, the generator produces:

**`app/DataModels/User.php`**

```php
<?php

namespace App\DataModels;

use Zerotoprod\DataModel;

/** Represents a user */
class User
{
    use DataModel;

    /** The user's name */
    public const string name = 'name';

    /** The user's age */
    public const string age = 'age';

    /** The user's name */
    public readonly string|null $name = null;

    /** The user's age */
    public readonly int|null $age = null;
}
```

**`app/DataModels/Role.php`**

```php
<?php

namespace App\DataModels;

use Zerotoprod\DataModel;

enum Role: string
{
    use DataModel;

    case Admin = 'admin';
    case User = 'user';
}
```

## Documentation Publishing

You can publish this README to your local documentation directory.

This can be useful for providing documentation for AI agents.

This can be done using the included script:

```bash
# Publish to default location (./docs/zero-to-prod/data-model-generator)
vendor/bin/zero-to-prod-data-model-generator

# Publish to custom directory
vendor/bin/zero-to-prod-data-model-generator /path/to/your/docs
```

### Automatic Documentation Publishing

You can automatically publish documentation by adding the following to your `composer.json`:

```json
{
    "scripts": {
        "post-install-cmd": [
            "zero-to-prod-data-model-generator"
        ],
        "post-update-cmd": [
            "zero-to-prod-data-model-generator"
        ]
    }
}
```

## Testing

```shell
./vendor/bin/phpunit
```