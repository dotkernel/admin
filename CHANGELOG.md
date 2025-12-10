# Changelog

## 7.0.0 - 2025-12-10

Main features:

- Added PostgreSQL support
- Replaced usage of binary UUIDs with string UUIDs (still using the `ramsey/uuid` package)
- Entities can choose between using a [numeric](https://github.com/dotkernel/admin/blob/7.0/src/Core/src/App/src/Entity/NumericIdentifierTrait.php) or [UUID](https://github.com/dotkernel/admin/blob/7.0/src/Core/src/App/src/Entity/UuidIdentifierTrait.php) identifier
- UUID identifiers are now stored in a native `uuid` column
- Renamed entity identifier field from `$uuid` to `$id`

### Changed

* Issue [#400](https://github.com/dotkernel/admin/issues/400): Bumped dependencies by [@alexmerlin](https://github.com/alexmerlin) in [#401](https://github.com/dotkernel/admin/pull/401)
* Issue [#402](https://github.com/dotkernel/admin/issues/402): Core Sync and update codebase by [@alexmerlin](https://github.com/alexmerlin) in [#403](https://github.com/dotkernel/admin/pull/403)
* updated readme, oss by [@bidi47](https://github.com/bidi47) in [#397](https://github.com/dotkernel/admin/pull/397)
* Core sync by [@alexmerlin](https://github.com/alexmerlin) in [#398](https://github.com/dotkernel/admin/pull/398)

### Added

* Nothing

### Deprecated

* Nothing

### Removed

* Nothing

### Fixed

* Nothing

## 6.2.0 - 2025-11-19

### Changed

* Core sync by [@alexmerlin](https://github.com/alexmerlin) in [#381](https://github.com/dotkernel/admin/pull/381)
* Update badge for Packagist dependency version by [@arhimede](https://github.com/arhimede) in [#387](https://github.com/dotkernel/admin/pull/387)
* Form updates by [@Jurj-Bogdan](https://github.com/Jurj-Bogdan) in [#388](https://github.com/dotkernel/admin/pull/388)
* Issue [#298](https://github.com/dotkernel/admin/issues/298): Bump to PHP 8.4 by [@alexmerlin](https://github.com/alexmerlin) in [#393](https://github.com/dotkernel/admin/pull/393)

### Added

* Added comment with new possible rbac guard config by [@Jurj-Bogdan](https://github.com/Jurj-Bogdan) in [#386](https://github.com/dotkernel/admin/pull/386)
* Issue [#391](https://github.com/dotkernel/admin/issues/391): Implemented Doctrine table prefixes by [@alexmerlin](https://github.com/alexmerlin) in [#392](https://github.com/dotkernel/admin/pull/392)

### Deprecated

* Nothing

### Removed

* Issue [#382](https://github.com/dotkernel/admin/issues/382): Removed migration file by [@alexmerlin](https://github.com/alexmerlin) in [#383](https://github.com/dotkernel/admin/pull/383)
* Removed mezzio/mezzio-tooling dependency by [@Jurj-Bogdan](https://github.com/Jurj-Bogdan) in [#390](https://github.com/dotkernel/admin/pull/390)

### Fixed

* Nothing

## 6.1.0 - 2025-09-04

### Changed

* Issue [#374](https://github.com/dotkernel/admin/issues/374): Changed route names to be in line with the Dotkernel API naming scheme by [@Jurj-Bogdan](https://github.com/Jurj-Bogdan) in [#375](https://github.com/dotkernel/admin/pull/375)
* Issue [#377](https://github.com/dotkernel/admin/issues/377): Updated all handler names to match route names by [@Jurj-Bogdan](https://github.com/Jurj-Bogdan) in [#376](https://github.com/dotkernel/admin/pull/376)

### Added

* Issue [#332](https://github.com/dotkernel/admin/issues/332): Added `.laminas-ci.json` config file by [@alexmerlin](https://github.com/alexmerlin) in [#378](https://github.com/dotkernel/admin/pull/378)
* Issue [#379](https://github.com/dotkernel/admin/issues/379): Implement `dotkernel/dot-maker` in dev mode by [@alexmerlin](https://github.com/alexmerlin) in [#380](https://github.com/dotkernel/admin/pull/380)

### Deprecated

* Nothing

### Removed

* Issue [#332](https://github.com/dotkernel/admin/issues/332): Removed `.laminas-ci/pre-run.sh` script by [@alexmerlin](https://github.com/alexmerlin) in [#378](https://github.com/dotkernel/admin/pull/378)

### Fixed

* Issue [#370](https://github.com/dotkernel/admin/issues/370): Infinite redirect after login by [@bidi47](https://github.com/bidi47) in [#371](https://github.com/dotkernel/admin/pull/371) and [#372](https://github.com/dotkernel/admin/pull/371)

## 6.0.0 - 2025-06-05

### Changed

* Issue [#275](https://github.com/dotkernel/admin/issues/275): Template refactoring by [@alexmerlin](https://github.com/alexmerlin) in [#287](https://github.com/dotkernel/admin/pull/287)
* Issue [#299](https://github.com/dotkernel/admin/issues/299): Navigation menu templates by [@MarioRadu](https://github.com/MarioRadu) in [#328](https://github.com/dotkernel/admin/pull/328)
* Issue [#303](https://github.com/dotkernel/admin/issues/303): Implemented dotkernel/dot-mail 5.0 by [@MarioRadu](https://github.com/MarioRadu) in [#315](https://github.com/dotkernel/admin/pull/315)
* Issue [#309](https://github.com/dotkernel/admin/issues/309): Restricted `Qodana` to supported PHP versions by [@alexmerlin](https://github.com/alexmerlin) in [#310](https://github.com/dotkernel/admin/pull/310)
* Issue [#313](https://github.com/dotkernel/admin/issues/313): Updated laminas/laminas-coding-standard to latest version  by [@MarioRadu](https://github.com/MarioRadu) in [#314](https://github.com/dotkernel/admin/pull/314)
* Issue [#316](https://github.com/dotkernel/admin/issues/316): Obfuscate admin login IP address by [@alexmerlin](https://github.com/alexmerlin) in [#318](https://github.com/dotkernel/admin/pull/318)
* Issue [#326](https://github.com/dotkernel/admin/issues/326): Refactored forms and responses by [@MarioRadu](https://github.com/MarioRadu) in [#333](https://github.com/dotkernel/admin/pull/333)
* Issue [#330](https://github.com/dotkernel/admin/issues/330): Replace controllers with handlers by [@MarioRadu](https://github.com/MarioRadu) in [#335](https://github.com/dotkernel/admin/pull/335)
* Issue [#344](https://github.com/dotkernel/admin/issues/344): Major refactoring by [@alexmerlin](https://github.com/alexmerlin) in [#347](https://github.com/dotkernel/admin/pull/347)
* Issue [#358](https://github.com/dotkernel/admin/issues/358): Render templates separately then pass body to `MailService` by [@alexmerlin](https://github.com/alexmerlin) in [#359](https://github.com/dotkernel/admin/pull/359)
* Issue [#361](https://github.com/dotkernel/admin/issues/361): Increase `PHPStan` level to `8` by [@alexmerlin](https://github.com/alexmerlin) in [#362](https://github.com/dotkernel/admin/pull/362)
* Issue [#368](https://github.com/dotkernel/admin/issues/368): Switch from `UUID4` to `UUID7` by [@alexmerlin](https://github.com/alexmerlin) in [#369](https://github.com/dotkernel/admin/pull/369)
* Update qodana_code_quality.yml by [@arhimede](https://github.com/arhimede) in [#297](https://github.com/dotkernel/admin/pull/297)
* Update README.md by [@alexmerlin](https://github.com/alexmerlin) in [#353](https://github.com/dotkernel/admin/pull/353)
* Update qodana_code_quality.yml by [@arhimede](https://github.com/arhimede) in [#357](https://github.com/dotkernel/admin/pull/357)

### Added

* Issue [#288](https://github.com/dotkernel/admin/issues/288): Improved dashboard by adding useful links by [@alexmerlin](https://github.com/alexmerlin) in [#290](https://github.com/dotkernel/admin/pull/290)
* Issue [#301](https://github.com/dotkernel/admin/issues/301): Replaced Psalm with PHPStan by [@MarioRadu](https://github.com/MarioRadu) in [#302](https://github.com/dotkernel/admin/pull/302)
* Issue [#311](https://github.com/dotkernel/admin/issues/311): Composer post install script by [@MarioRadu](https://github.com/MarioRadu) in [#312](https://github.com/dotkernel/admin/pull/312)
* Issue [#327](https://github.com/dotkernel/admin/issues/327) & [#329](https://github.com/dotkernel/admin/issues/329): Implemented core arhitecture by [@MarioRadu](https://github.com/MarioRadu) in [#343](https://github.com/dotkernel/admin/pull/343)
* Issue [#336](https://github.com/dotkernel/admin/issues/336): Implemented doctrine enums by [@MarioRadu](https://github.com/MarioRadu) in [#339](https://github.com/dotkernel/admin/pull/339)
* Issue [#345](https://github.com/dotkernel/admin/issues/345): Implemented route grouping by [@alexmerlin](https://github.com/alexmerlin) in [#346](https://github.com/dotkernel/admin/pull/346)
* Added .gitattributes by [@bidi47](https://github.com/bidi47) in [#289](https://github.com/dotkernel/admin/pull/289)
* Add demo and docs links to  README.md by [@arhimede](https://github.com/arhimede) in [#325](https://github.com/dotkernel/admin/pull/325)

### Deprecated

* Nothing

### Removed

* Issue [#301](https://github.com/dotkernel/admin/issues/301): Replaced Psalm with PHPStan by [@MarioRadu](https://github.com/MarioRadu) in [#302](https://github.com/dotkernel/admin/pull/302)
* Issue [#306](https://github.com/dotkernel/admin/issues/306): Removed laminas/laminas-http dependency by [@MarioRadu](https://github.com/MarioRadu) in [#307](https://github.com/dotkernel/admin/pull/307)
* Issue [#320](https://github.com/dotkernel/admin/issues/320): Removed `credential_callable` from authentication config by [@alexmerlin](https://github.com/alexmerlin) in [#321](https://github.com/dotkernel/admin/pull/321)
* Issue [#365](https://github.com/dotkernel/admin/issues/365): Removed `laminas/laminas-i18n` by [@alexmerlin](https://github.com/alexmerlin) in [#366](https://github.com/dotkernel/admin/pull/366)

### Fixed

* Issue [#291](https://github.com/dotkernel/admin/issues/291): Temporarily removed `.gitattributes` file to repair CRLF files by [@alexmerlin](https://github.com/alexmerlin) in [#293](https://github.com/dotkernel/admin/pull/293)
* Issue [#292](https://github.com/dotkernel/admin/issues/292): Fixed CRLF files and restored `.gitattributes` by [@alexmerlin](https://github.com/alexmerlin) in [#294](https://github.com/dotkernel/admin/pull/294)
* Issue [#295](https://github.com/dotkernel/admin/issues/295): Fix bootstrap-icons by [@alexmerlin](https://github.com/alexmerlin) in [#296](https://github.com/dotkernel/admin/pull/296)
* Issue [#304](https://github.com/dotkernel/admin/issues/304): Increased PHPStan `memory_limit` to `1G` by [@alexmerlin](https://github.com/alexmerlin) in [#319](https://github.com/dotkernel/admin/pull/319)
* Issue [#322](https://github.com/dotkernel/admin/issues/322): Skip Doctrine cache on admin authentication by [@alexmerlin](https://github.com/alexmerlin) in [#323](https://github.com/dotkernel/admin/pull/323)
* Issue [#349](https://github.com/dotkernel/admin/issues/349): test readme.md to be updated by [@Howriq](https://github.com/Howriq) in [#355](https://github.com/dotkernel/admin/pull/355)
* Issue [#351](https://github.com/dotkernel/admin/issues/351): `Qodana`: use branch `6.0` by [@alexmerlin](https://github.com/alexmerlin) in [#352](https://github.com/dotkernel/admin/pull/352)
* Issue [#363](https://github.com/dotkernel/admin/issues/363): Fixed invalid call to `getData` in `PostUserDeleteHandler` by [@alexmerlin](https://github.com/alexmerlin) in [#364](https://github.com/dotkernel/admin/pull/364)
* PHP-CS bug fix by [@MarioRadu](https://github.com/MarioRadu) in [#342](https://github.com/dotkernel/admin/pull/342)
* Pre-release tweaks by [@alexmerlin](https://github.com/alexmerlin) in [#350](https://github.com/dotkernel/admin/pull/350)
* Moved exceptions back from `Core` to `App` by [@alexmerlin](https://github.com/alexmerlin) in [#354](https://github.com/dotkernel/admin/pull/354)
* Core sync by [@alexmerlin](https://github.com/alexmerlin) in [#360](https://github.com/dotkernel/admin/pull/360)

## 5.0.3 - 2024-09-26

### Changed

* Nothing

### Added

* Issue [#284](https://github.com/dotkernel/admin/issues/284): Created file `CHANGELOG.md` by [@alexmerlin](https://github.com/alexmerlin) in [#285](https://github.com/dotkernel/admin/pull/285)
* Issue [#282](https://github.com/dotkernel/admin/issues/282): Show current page as active/open in left menu by [@alexmerlin](https://github.com/alexmerlin) in [#286](https://github.com/dotkernel/admin/pull/286)

### Deprecated

* Nothing

### Removed

* Nothing

### Fixed

* Nothing

## 5.0.2 - 2024-09-25

### Changed

* Issue [#273](https://github.com/dotkernel/admin/issues/273): Bump `dotkernel/dot-session` to `^5.5.2` by [@bidi47](https://github.com/bidi47) in [#274](https://github.com/dotkernel/admin/pull/274)
* Issue [#277](https://github.com/dotkernel/admin/issues/277): Upgraded `dot-errorhandler` to version `4.x` by [@alexmerlin](https://github.com/alexmerlin) in [#278](https://github.com/dotkernel/admin/pull/278)

### Added

* Issue [#276](https://github.com/dotkernel/admin/issues/276): Implemented Twig CS checker/fixer by [@alexmerlin](https://github.com/alexmerlin) in [#279](https://github.com/dotkernel/admin/pull/279)
* Issue [#280](https://github.com/dotkernel/admin/issues/280): Admin logins page as bootstrap (simple) table by [@alexmerlin](https://github.com/alexmerlin) in [#281](https://github.com/dotkernel/admin/pull/281)

### Deprecated

* Nothing

### Removed

* Nothing

### Fixed

* Nothing

## 5.0.1 - 2024-08-05

### Changed

* Nothing

### Added

* Issue [#184](https://github.com/dotkernel/admin/issues/184): Implemented `CSRF` protection in all forms by [@alexmerlin](https://github.com/alexmerlin) in [#270](https://github.com/dotkernel/admin/pull/270)

### Deprecated

* Nothing

### Removed

* Issue [#266](https://github.com/dotkernel/admin/issues/266): Removed `HasLifecycleCallbacks` from `TimestampsTrait.php` by [@alexmerlin](https://github.com/alexmerlin) in [#269](https://github.com/dotkernel/admin/pull/269)

### Fixed

* Issue [#241](https://github.com/dotkernel/admin/issues/241): Hide modal messages fix by [@MarioRadu](https://github.com/MarioRadu) in [#268](https://github.com/dotkernel/admin/pull/268)
* Issue [#271](https://github.com/dotkernel/admin/issues/271): Fixed namespace across the application by [@alexmerlin](https://github.com/alexmerlin) in [#272](https://github.com/dotkernel/admin/pull/272)

## 5.0.0 - 2024-07-25

### Changed

* Issue [#198](https://github.com/dotkernel/admin/issues/198): updated readme badge by [@bidi47](https://github.com/bidi47) in [#220](https://github.com/dotkernel/admin/pull/220)
* Issue [#222](https://github.com/dotkernel/admin/issues/222): Updated dot-cli & dot-geoip versions by [@MarioRadu](https://github.com/MarioRadu) in [#224](https://github.com/dotkernel/admin/pull/224)
* Issue [#225](https://github.com/dotkernel/admin/issues/225): Refactored doctrine config by [@MarioRadu](https://github.com/MarioRadu) in [#227](https://github.com/dotkernel/admin/pull/227)
* Issue [#226](https://github.com/dotkernel/admin/issues/226): Updated package.json by [@mada27](https://github.com/mada27) in [#229](https://github.com/dotkernel/admin/pull/229)
* Issue [#231](https://github.com/dotkernel/admin/issues/231): refactor checking for a public or private ip by [@cPintiuta](https://github.com/cPintiuta) in [#234](https://github.com/dotkernel/admin/pull/234)
* Issue [#235](https://github.com/dotkernel/admin/issues/235): Updated GHA files to use latest action releases by [@alexmerlin](https://github.com/alexmerlin) in [#238](https://github.com/dotkernel/admin/pull/238)
* Issue [#243](https://github.com/dotkernel/admin/issues/243): Di attributes by [@cPintiuta](https://github.com/cPintiuta) in [#245](https://github.com/dotkernel/admin/pull/245)
* Issue [#249](https://github.com/dotkernel/admin/issues/249): crlf to lf by [@cPintiuta](https://github.com/cPintiuta) in [#257](https://github.com/dotkernel/admin/pull/257)
* Issue [#258](https://github.com/dotkernel/admin/issues/258): crlf to lf by [@cPintiuta](https://github.com/cPintiuta) in [#259](https://github.com/dotkernel/admin/pull/259)
* Issue [#258](https://github.com/dotkernel/admin/issues/258): new line by [@cPintiuta](https://github.com/cPintiuta) in [#260](https://github.com/dotkernel/admin/pull/260)
* Issue [#262](https://github.com/dotkernel/admin/issues/262): bump psr-container-doctrine and refactoring config providers by [@cPintiuta](https://github.com/cPintiuta) in [#263](https://github.com/dotkernel/admin/pull/263)
* Issue [#255](https://github.com/dotkernel/admin/issues/255): Javascript refactoring and packages updates by [@MarioRadu](https://github.com/MarioRadu) in [#261](https://github.com/dotkernel/admin/pull/261)
* Issue [#241](https://github.com/dotkernel/admin/issues/241): Refactored handler by [@MarioRadu](https://github.com/MarioRadu) in [#265](https://github.com/dotkernel/admin/pull/265)
* Update qodana_code_quality.yml to include composer install by [@arhimede](https://github.com/arhimede) in [#250](https://github.com/dotkernel/admin/pull/250)

### Added

* Issue [#217](https://github.com/dotkernel/admin/issues/217): Implemented dot-cache by [@MarioRadu](https://github.com/MarioRadu) in [#228](https://github.com/dotkernel/admin/pull/228)
* Issue [#240](https://github.com/dotkernel/admin/issues/240): Orm3 by [@cPintiuta](https://github.com/cPintiuta) in [#253](https://github.com/dotkernel/admin/pull/253)
* Create qodana_code_quality.yml by [@arhimede](https://github.com/arhimede) in [#244](https://github.com/dotkernel/admin/pull/244)

### Deprecated

* Nothing

### Removed

* Issue [#221](https://github.com/dotkernel/admin/issues/221): removed references for PhpFileCache by [@bidi47](https://github.com/bidi47) in [#223](https://github.com/dotkernel/admin/pull/223)
* Issue [#232](https://github.com/dotkernel/admin/issues/232): Removed user-agent-sniffer by [@alexmerlin](https://github.com/alexmerlin) in [#233](https://github.com/dotkernel/admin/pull/233)
* Issue [#236](https://github.com/dotkernel/admin/issues/236): Removed unnecessary `HasLifecycleCallbacks` entity attributes by [@alexmerlin](https://github.com/alexmerlin) in [#237](https://github.com/dotkernel/admin/pull/237)
* Issue [#246](https://github.com/dotkernel/admin/issues/246): Removed unused config by [@MarioRadu](https://github.com/MarioRadu) in [#264](https://github.com/dotkernel/admin/pull/264)

### Fixed

* Issue [#254](https://github.com/dotkernel/admin/issues/254): fixed updating login logs by [@cPintiuta](https://github.com/cPintiuta) in [#256](https://github.com/dotkernel/admin/pull/256)
