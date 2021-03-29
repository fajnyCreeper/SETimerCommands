# SETimerCommands
Control your timers directly from chat

## Instalation
* Install dependencies using `composer.json`
* Fill out your credentials in `config.php`
 * `$key` - Random string to distinguish genuine request
 * `$token` - SE JWT Token that you can find [here](https://streamelements.com/dashboard/account/channels) (After clicking "Show secrets")
 * `$baseUrl` - Full path to folder (without slash at the end). For example `https://example.com/setimercommands`

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
!timer bind <Timer_name> <Command_name>
```

## Examples
### Creating timer
This will create new timer:
```
!timer create Test_timer 15 0 5 This_is_first_message Second_message
```
#### Explanation
* *`Test_timer`* - This is name of the timer
* *`15`* - This is online interval (how often will timer be called when stream is live).
* *`0`* - This is offline interval (when set to zero, offline timer will be disabled).
* *`5`* - This is number of needed messages sent in the last 5 minutes in order to execute. timer
* *`This_is_first_message`* - First message of timer.
* *`Second_message`* Second message of timer (if timer has multiple messages, one of them is randomly chosen and sent to chat).

### Updating timer
This will update already existing timer:
```
!timer update Test_timer 15 0 5 This_is_first_message Second_message
```
#### Explanation
* *`Test_timer`* - This is name of the timer.
* *`15`* - This is online interval (how often will timer be called when stream is live).
* *`0`* - This is offline interval (when set to zero, offline timer will be disabled).
* *`5`* - This is number of needed messages sent in the last 5 minutes in order to execute. timer
* *`This_is_first_message`* - First message of timer.
* *`Second_message`* Second message of timer (if timer has multiple messages, one of them is randomly chosen and sent to chat).

### Binding timer
This will bind already existing timer with already existing command. Body of timer will point to body of command.
```
!timer bind Test_timer Test_command
```
#### Explanation
* *`Test_timer`* - Name of existing timer (cannot create new timer as you need to set up the timer properly beforehand).
* *`Test_command`* - Name of existing command (cannot create new command as you need to set up the command properly beforehand)
