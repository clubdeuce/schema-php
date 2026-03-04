# Copilot Instructions for schema-php

## Overview

PHP library (`Clubdeuce\Schema`) for generating schema.org-compliant JSON-LD structured data. The library is intentionally selective — it implements only the schema.org types needed for real client projects, not the full spec.

## Commands

```bash
# Run full test suite
./vendor/bin/phpunit -c tests/phpunit.xml.dist

# Run a single test class or method
./vendor/bin/phpunit -c tests/phpunit.xml.dist --filter ThingTest
./vendor/bin/phpunit -c tests/phpunit.xml.dist --filter testSchema

# Install dependencies
composer install
```

## Architecture

All schema types extend `Thing`, which provides:
- `schema(): array` — returns the schema.org-compliant array (always includes `@context` and `@type`, uses `array_filter()` to strip empty values)
- `ldJson(): string` — wraps `schema()` output in `<script type="application/ld+json">` tags
- `set_state(array $args)` — called from the constructor; maps array keys to matching properties, unknown keys go into `$extra_args`

`Schema` is a factory class with `make*()` methods (e.g., `makePerson()`, `makeOrganization()`) that instantiate each type with an optional `$data` array.

Each subclass overrides `schema()` by calling `array_merge(parent::schema(), [...])` and setting its own `@type`.

Complex types (e.g., `Organization`) auto-convert nested array args to proper sub-objects in their constructors (e.g., `$args['address']` array becomes a `PostalAddress` instance).

## Key Conventions

**Naming inconsistency (by design):** Older classes (`Thing`, `Organization`) use `snake_case` setters/getters (`set_name()`, `image_url()`). Newer additions (`MusicEvent`, `Schema`) use `camelCase` (`setDoorTime()`, `makePerson()`). When adding new classes, follow `camelCase` for methods and `camelCase` prefixed with `_` for protected properties that use the legacy magic `__call` (see `MusicComposition`).

**`array_filter()` on schema output:** Empty strings, nulls, and empty arrays are stripped automatically. Do not add null-guard logic in properties — let `array_filter()` handle it in `schema()`.

**Adding a new schema type:**
1. Create `src/NewType.php` extending `Thing` (or another type)
2. Override `schema()` merging parent result and setting `@type`
3. Add a `makeNewType()` factory method to `Schema`
4. Create `tests/unit/NewTypeTest.php` extending `Clubdeuce\Schema\Tests\testCase`
5. Add `#[CoversClass(NewType::class)]` attribute — coverage metadata is **required** (PHPUnit will fail without it)

**Test base class:** Tests extend `Clubdeuce\Schema\Tests\testCase` (in `tests/includes/testCase.php`), which provides `reflectionMethodInvoke()` for testing protected methods.

**PHPUnit config strictness:** `phpunit.xml.dist` has `requireCoverageMetadata="true"`, `failOnRisky="true"`, `failOnWarning="true"`. Every test class needs a `#[CoversClass(...)]` attribute.
