# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.0] - 2026-03-04

### Added
- `Event` class with full support for start/end dates, door time, duration (auto-computes `endDate` when only `duration` is set), event status, location, performers, organizers, directors, sponsors, and offers
- `MusicEvent` class extending `Event` with `composers` support
- `MusicComposition` class with `composer`, `lyricist`, and `musicCompositionForm` properties
- `Offer` class with `price` and `priceCurrency` properties
- `Place` class with nested `PostalAddress` support
- `SchemaFactory::makeEvent()` factory method
- `SchemaFactory::makeMusicComposition()` factory method
- `SchemaFactory::makeMusicEvent()` factory method
- `SchemaFactory::makeOffer()` factory method
- `SchemaFactory::makeOrganization()` factory method
- `SchemaFactory::makePlace()` factory method
- `SchemaFactory::makePostalAddress()` factory method
- Fluent setter API (all setters return `static`)
- `Thing::ldJson()` outputs a `<script type="application/ld+json">` tag
- `Thing::getSchema()` helper for mapping arrays of `Thing` subclasses to their schema arrays
- Comprehensive unit and integration test suite (98 tests, 302 assertions)
- Scrutinizer CI badges for code quality, coverage, and build status

### Changed
- Renamed `Schema` class to `SchemaFactory`
- Renamed all snake_case methods to camelCase (e.g. `make_person()` → `makePerson()`, `set_name()` → `setName()`)
- Removed underscore prefixes from protected properties
- Replaced `array()` syntax with `[]` throughout
- `Organization` and `Place` auto-convert an `address` array argument to a `PostalAddress` instance in their constructors
- `composer.json` now declares `"require": {"php": "^8.1"}`
- `phpunit.xml.dist` updated to PHPUnit 12.1 schema
- Updated documentation with full API reference and examples for all types

## [0.0.1] - 2025-04-16

### Added
- Initial release with `Thing`, `Person`, `Organization`, and `PostalAddress` classes
- `Schema` factory class with `make_person()` method
- Basic `schema()` method returning a `@context`/`@type` array
- MIT license

[Unreleased]: https://github.com/clubdeuce/schema-php/compare/0.1.0...HEAD
[0.1.0]: https://github.com/clubdeuce/schema-php/compare/0.0.1...0.1.0
[0.0.1]: https://github.com/clubdeuce/schema-php/releases/tag/0.0.1
