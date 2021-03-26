# SETimerCommands
Control your timers directly from chat

## Instalation
* Install dependencies using `composer.json`
* Fill out your credentials in `config.php`
 * `$key` - Random string to distinguish genuine request
 * `$token` - SE JWT Token that you can find [here](https://streamelements.com/dashboard/account/channels) (After clicking "Show secrets")

## Usage
### URL parameters
* `key` - string from `config.php`
* `action` - action which will be executed
* `params` - all other parameters

### Adding command to StreamElements
Create new command, which you can call whatever you want, and as response use code below (with your **own** path and `key` parameter)
```
${customapi.example.com/setimercommands/main.php?key=YourKey&action=${pathescape ${1}}&params=${pathescape ${2:|' '}}}
```

### Calling commands
List of all available commands. Please be aware that `name` is case **insensitive**, all other arguments are case **sensitive**!

Please be aware that spaces (" ") **inside argument** should be replaced with underscores ("_")!

If you set online and/or offline interval to zero (*0*), online and/or offline interval will be disabled.
```
!timer create <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...
!timer update <Name> <OnlineInterval> <OfflineInterval> <ChatLines> <Message1> ...
!timer enable <Name>
!timer disable <Name>
!timer delete <Name>
!timer print <Name>
!timer list
```
