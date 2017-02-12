# Safebox Changelog

## 1.1.2

### Clients
- The `phone` field is not required anymore

### Accounts
- Fix decrypt when `login`, `password` or `comment` is empty

### Tests
- Fix how database migrations are done between each tests
- Fix `Clients` and `Sites` tests
- Add tests for `Accounts`