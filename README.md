# EventBonus
a pocketmine plugin where rewards are set depending on commands given by the owner
  
## ♛ 🛠️ Features:
- Easy to use and setup
- Setting up in-game or in-console
- Automatic given rewards to players

About EventBonus:
- The EventBonus is for server owners where the server owners forgot to give rewards or compensation to the players

Example:
- You have an manual uhc event, then all online players are invited then you can put the names in the bonus key then if the player goes online the next day, then the reward will automatically be given immediately without asking or pinging the owner who forgot to give the reward they should have.

## 🔧 How to install EventBonus? 
1) [Download](https://poggit.pmmp.io/ci/EventBonus/~) latest stable version from poggit  
2) Move dowloaded file to your server **/plugins/** folder  
3) Restart the server and enjoy!
  
## ✍ EventBonus commands   
<br> 
| **Command** | **Description** |  **Usage ** |
| --- | --- |  --- |
| **/bonus** | **the main command of eventbonus** | /bonus |

| **Subcommands** | **Description** | **Usage** |
| --- | --- | --- |
| **help** | list of subcommands of eventbonus | /bonus help |
| **make** | make eventbonus key | /bonus make <bonus_name> |
| **del** | delete eventbonus key | /bonus del <bonus_name> |
| **addplayer** | adding player in eventbonus | /bonus addplayer <bonus_name> <player_name> |
| **delplayer** | deleting player in eventbonus | /bonus delplayer <bonus_name> <player_name> |
| **addcmd** | adding command in eventbonus key | /bonus addcmd <bonus_name> <command> |
| **delcmd** | deleting command in eventbonus key | /bonus delcmd <bonus_name> <command> |
| **list** | list of eventbonus keys | /bonus list |
<br>

## 📃  Permissions  

- lentou.eventbonus.command | default: op
  
## 🔧 Configuration  
- Default configuration:

```yaml  
# EventBonus by lentou
# the configuration of eventbonus

# the bonus array that gives you a reward!
# you can manually add the bonus by copying my template
# or just use commands in-game or in-console
# supported placeholders in this plugin
# for cmds: & - color code, {player} - player's name
bonus:
  # the bonus key
  example:
    # the player names who can receive the rewards when they join or online!
    # if they already receive the reward then the name will be removed in the list
    # the name must be small letters
    players:
      - "hytlenz"
      - "xlentou"
      - "rhevisco"
      - "speczgm"
    # the command list for executing all commands for giving players a bonus/reward!
    # i dont support items here because give command can enchant an item, even an custom ones!
    cmds:
      - "givemoney {player} 10000"
      - "give {player} diamond 100"
      - "give {player} stick 1 {display:{Name:'§r§6§lEvent Stick'},ench:[{id:9s,lvl:2s},{id:10s,lvl:2s}]}"
    # the message when the player receive the bonus
    message: "&eYou received an Example Bonus Key from &cHalloween Event, &eEnjoy your Reward :) - &bL2"
```

##  💡 License  
  
Full license [here](https://github.com/Lentou/EventBonus/blob/main/LICENSE).
