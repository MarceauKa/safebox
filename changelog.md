# Safebox Changelog

## Develop

### Clients
- The `phone` field is not required anymore

### Accounts
- Fix decrypt error when `comment` is empty
- Fix decrypt when `login` or `password` is empty

### Tests
- Fix how database migrations are done between each tests
- Fix `Clients` and `Sites` tests
- Add tests for `Accounts`