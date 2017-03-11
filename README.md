# DeathView
A [PocketMine-MP](https://github.com/pmmp/PocketMine-MP) plugin that puts a player into spectator when they die.  
  
Basically its like Mineplex: 
1. Player 'dies' (but isint shown a death screen).
2. Player gets put in spectator for a few seconds.
3. Player gets put in survival and teleported to spawn.

### Configuration
```yaml
# Death message configuration
death-message:
  display: true
  died: "{victim} died"
  
# The amount of time you will be in spectator mode for
# 20 ticks = 1 second
ticks: 100

# Teleport to the world spawnpoint when you respawn
teleport-to-spawn: true
```
 
### TODO
* Add permissions 

