# Upgrade guide

- [Upgrading to 1.0.2 from 1.0.1](#upgrade-1.0.2)

<a name="upgrade-1.0.2"></a>
## Upgrading To 1.0.2

The structure of **allowedActions** section in the REST config file has been changed. This breaks the initial version of the plugin so users should make the necessary modifications in order to continue using the plugin. The old format is:
```
# Allowed Rest Actions
allowedActions:
  - store
```
The must be changed to the new format:
```
# Allowed Rest Actions
allowedActions:
  index:
      pageSize: 20
  store:
  show:
  update:
  destroy:
```

This allows for adding sub-properties for various kinds of verbs / actions which would be helpful for future updates. As usual, to disable an action from appearing in the REST API simply don't add it in the config under **allowedActions**. The overriding feature remains unaltered. Enjoy!
