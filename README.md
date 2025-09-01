# `Zerotoprod\DataModelGenerator`

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/data-model-generator)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/data-model-generator/test.yml?label=test)](https://github.com/zero-to-prod/data-model-generator/actions)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/data-model-generator/backwards_compatibility.yml?label=backwards_compatibility)](https://github.com/zero-to-prod/data-model-generator/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/data-model-generator?color=blue)](https://packagist.org/packages/zero-to-prod/data-model-generator/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/data-model-generator?color=f28d1a)](https://packagist.org/packages/zero-to-prod/data-model-generator)
[![License](https://img.shields.io/packagist/l/zero-to-prod/data-model-generator?color=red)](https://github.com/zero-to-prod/data-model-generator/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/data-model-generator.svg)](https://wakatime.com/badge/github/zero-to-prod/data-model-generator)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/data-model-generator?branch=main)](https://hitsofcode.com/github/zero-to-prod/data-model-generator/view?branch=main)

## Contents

- [Installation](#installation)
- [Documentation Publishing](#documentation-publishing)
    - [Automatic Documentation Publishing](#automatic-documentation-publishing)
- [Testing](#testing)

## Installation

Install the package via composer:

```bash
composer require zero-to-prod/data-model-generator
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
