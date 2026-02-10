# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Run tests (local PHP)
./vendor/bin/phpunit

# Run a single test file
./vendor/bin/phpunit tests/Acceptance/Config/Readonly/Readonly/ReadonlyTest.php

# Run tests matching a name pattern
./vendor/bin/phpunit --filter "OverwriteModel"

# Docker-based development (multi-PHP version)
sh dock init              # First-time setup (creates .env, installs deps)
sh dock composer update   # Update dependencies
sh dock test              # Run tests with PHP version from .env
sh test.sh                # Run tests across all PHP versions (8.1-8.5)
```

## Architecture

This package generates PHP class and enum files from parsed API schemas (OpenAPI 3.0, Swagger 2.0). It does NOT parse schemas itself — external adapter packages convert schemas into an intermediate `Components` model that this package consumes.

### Data Flow

```
Schema adapters (separate packages)     This package
─────────────────────────────────────   ──────────────────────────────
OpenApi30::adapt($schema) ─┐
                           ├─► Components { Models[], Enums[] }
Swagger::adapt($schema) ──┘         │
                                    ▼
                           Engine::generate(Components, Config)
                                    │
                           ┌────────┴────────┐
                           ▼                 ▼
                     Model::save()      Enum::save()
                           │                 │
                           ▼                 ▼
                     User.php           RoleEnum.php
```

### Key Classes

- **`Engine`** — Static `generate()` method. Merges per-model data with global Config, then calls `save()` on each Model/Enum. This is the only public API.
- **`Components`** — Input container with `Models[]` and `Enums[]` arrays. Produced by external adapter packages.
- **`Config` → `ModelConfig` → `PropertyConfig` / `ConstantConfig`** — Nested configuration loaded from `data-model.json`. Controls output directory, namespace, visibility, readonly, type mappings, nullable, comments.
- **`Model`** / **`Enum`** — Renderable PHP file representations. Use `DataModel` trait for hydration, `RendersClassComponents` trait for shared rendering (namespace, imports, use statements, constants), and `File` trait for filesystem writes.
- **`Property`** / **`Constant`** / **`EnumCase`** — Leaf renderable components. Each has a `render()` method that returns a PHP code string.

### Rendering Chain

`Model::save()` → `Model::render()` → assembles lines from `namespaceLine()`, `imports()`, `classLine()`, `useStatements()`, `constants()`, `properties()` → `File::put()` writes to disk.

### Config Merging (in Engine)

The Engine merges Config defaults with per-model data. Config takes precedence for: directory, namespace, readonly, visibility. Config merges with (appends to) model data for: imports, use_statements. Config gates inclusion of: comments, constants, properties.

Type mapping in `PropertyConfig::types` replaces schema types with PHP types (e.g., `"integer" → "int"`).

## Test Conventions

**Acceptance tests** are the primary pattern. Each test scenario is a directory containing:
- `models.json` — input Components (Models/Enums definitions)
- `data_model.json` — Config (must include `"directory": "./tests/generated"`)
- `*Test.php` — calls `$this->engineGenerate(__DIR__)` then asserts file contents

The base `TestCase` wipes `./tests/generated/` in `setUp()` and provides `engineGenerate()`.

Assertions use `assertStringEqualsFile()` with HEREDOC expected output. The generated PHP has **no indentation** — all lines are flush-left within the class body.

**CLI tests** (in `tests/Unit/Cli/`) use `exec()` to invoke `bin/data-model-generator` as a subprocess.

## Related Packages

Adapters that produce `Components` for this package (located in sibling directories under `~/dev/zero-to-prod/packages/`):
- `data-model-adapter-openapi30` — converts OpenAPI 3.0 schemas
- `data-model-adapter-swagger` — converts Swagger 2.0 schemas

Data model packages these adapters parse into:
- `data-model-openapi30` — OpenAPI 3.0 PHP data models
- `data-model-swagger` — Swagger 2.0 PHP data models
