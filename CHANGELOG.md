# Changelog

All notable changes to this project will be documented in this file.

## 1.1.0 - 2026-11-18

### Changed

- Requires the 2.0 of the suite core, which runs on [laravel-privacy](https://github.com/jeffersongoncalves/laravel-privacy), the engine shared by the privacy suites. No change to this package's API, config or tables.

## 1.0.0 - 2026-11-16

First release: LGPD data subject requests (art. 18).

- `DataSubjectRequest` with all nine rights (art. 18, I-IX), status and legal deadline (15 days, configurable)
- Identity verification required before any export or erasure
- `fulfil()`: JSON export on a private disk (access/portability) or erasure via laravel-lgpd anonymize strategies (`Keep` columns preserved, art. 16)
- `ResolvesDataSubject` contract to find a subject's records across `lgpd.models`
- Events: opened, closed, overdue; `php artisan lgpd:dsar-overdue`

## [Unreleased]
