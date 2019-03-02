# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.1 - TBD

### Added

- [#11](https://github.com/zendframework/zend-expressive-authentication-basic/pull/11) adds support for PHP 7.3.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.0.0 - 2018-09-28

### Added

- [#10](https://github.com/zendframework/zend-expressive-authentication-basic/pull/10) adds support for the upcoming PHP 7.3 release.

- [#10](https://github.com/zendframework/zend-expressive-authentication-basic/pull/10) adds full configuration and usage documentation.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- [#10](https://github.com/zendframework/zend-expressive-authentication-basic/pull/10) removes support for pre-1.0 versions of
  zendframework/zend-expressive-authentication.

### Fixed

- Nothing.

## 0.3.1 - 2018-07-25

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing

### Fixed

- [#9](https://github.com/zendframework/zend-expressive-authentication-basic/pull/9) fixes an issue in PHP 7.2 that occurred when the decoded
  authentication string did not contain a colon (`:`). It now correctly
  interprets this as a lack of credentials.

- [#9](https://github.com/zendframework/zend-expressive-authentication-basic/pull/9) provides a fix that allows passwords that contain colons.

## 0.3.0 - 2018-03-15

### Added

- Nothing.

### Changed

- Updates the zendframework/zend-expressive-authentication minimum supported
  version to 0.4.

- [#5](https://github.com/zendframework/zend-expressive-authentication-basic/pull/5)
  changes the constructor of the `Zend\Expressive\Authentication\Basic\BasicAccess`
  class to accept a callable `$responseFactory` instead of a
  `Psr\Http\Message\ResponseInterface` response prototype. The
  `$responseFactory` should produce a `ResponseInterface` implementation when
  invoked.

- [#5](https://github.com/zendframework/zend-expressive-authentication-basic/pull/5)
  updates the `BasicAccessFactory` to no longer use
  `Zend\Expressive\Authentication\ResponsePrototypeTrait`, and instead always
  depend on the `Psr\Http\Message\ResponseInterface` service to correctly return
  a PHP callable capable of producing a `ResponseInterface` instance.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.2.0 - 2018-02-26

### Added

- Nothing.

### Changed

- [#4](https://github.com/zendframework/zend-expressive-authentication-basic/pull/4)
  changes the zendframework/zend-expressive-authentication minimum supported
  version to 1.0.0alpha3.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.3 - 2018-02-26

### Added

- Nothing.

### Changed

- [#3](https://github.com/zendframework/zend-expressive-authentication-basic/pull/3)
  updates the zendframework/zend-expressive-authentication minimum supported
  version to 0.3.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.2 - 2017-12-13

### Added

- [#1](https://github.com/zendframework/zend-expressive-authentication-basic/pull/1)
  adds support for the 1.0.0-dev branch of zend-expressive-authentication.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.1 - 2017-11-28

### Added

- Adds support for zend-expressive-authentication 0.2.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.0 - 2017-11-09

Initial release.

### Added

- Everything.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
