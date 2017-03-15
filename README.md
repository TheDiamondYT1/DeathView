# DeathView
A [PocketMine-MP](https://github.com/pmmp/PocketMine-MP) plugin that puts a player into spectator when they die.  
  
Basically its like Mineplex:  
1. Player 'dies' (but isint shown a death screen).<br>
2. Player gets put in spectator for a few seconds. <br> 
3. Player gets put in survival and teleported to spawn.  <br>

### Configuration
```yaml
# The messages to be displayed when you 'die'
# {victim} {world} - & instead of §
death-message:
  display: true
  died: 
    player: "Oh noes! You will respawn soon."
    all: "{victim} died :("
  
# The amount of time you will be in spectator mode for (in seconds)
time: 5

# Teleport to the world spawnpoint when you 'respawn'
teleport-to-spawn: true
```
 
### TODO
* Add permissions 

