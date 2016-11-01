# Connect Four Server

## [1.0.0] - 2016-10-31
### Added
- Created `Strategy\Strategy`, which is the base class for strategies. Exposes a
single method `nextMove`, which can be overridden to define different
strategies.
- Added smart opponent as defined by `Strategy\Smart`.
- Random opponent is now defined by `Strategy\Random`.

### Changed
- Conforms to PSR-1 and PSR-2
- Refactored redundant code from `Model\Board`.
- Memoized check for winning row, so that it doesn't generate rows multiple
times during testing.
- Slight changes to the `Model\Game` ABI. Function names should be more in line
with what they do.

## [0.3.0] - 2016-01-04
### Added
- Namespacing
- `Model\Game` and `Model\Board`, with JSON serialization and deserialization.
- Ability to create games, and play against simple random opponent.
- `Lib\generatePID` using stronger PRNG and base64URL encoding when mcrypt is
available.

### Changed
- Fixed typo in change log for version 0.2.0
- Changed syntax to PHP 5.6
- Stop `Lib\responseError` from exiting. Exiting now explixitly written on guard
statements to better show intention

## [0.2.0] - 2016-09-08
### Added
- `lib.php` for common code between pages
- Added basic errors to `new/` and `play/`
- Function for error response.

### Changed
- Changed formatting for API files in change log to focus more on the API than
on the code structure.

## [0.1.0] - 2016-09-07
### Added
- Blank `new/` and `play/` PHP files
- `info/` with PHP code evaluating magic numbers
- Github repository
- `CHANGELOG` as an exercise in change logs
- `.gitignore` file

[1.0.0]: https://github.com/eseymour/connect-four-server/tree/v1.0.0
[0.2.0]: https://github.com/eseymour/connect-four-server/tree/v0.2.0
[0.1.0]: https://github.com/eseymour/connect-four-server/tree/v0.1.0
