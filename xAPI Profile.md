# Serious Games xAPI Profile

This document defines the type of xAPI statements that can be built using the vocabulary defined by the [RAGE Serious Games xAPI Profile
](https://w3id.org/xapi/seriousgames).

## Tracking progress

All videogames contains a set of challenges the player must overcome in order to complete it. The profile defines the following type of challenges:

| Activity Type          | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|Serious Game            | https://w3id.org/xapi/seriousgames/activity-types/serious-game            |
|Level                   | https://w3id.org/xapi/seriousgames/activity-types/level                   |
|Quest                   | https://w3id.org/xapi/seriousgames/activity-types/quest                   |

The progress in these activities can be tracked with the following verbs:

| Verb                   | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|initialized             | https://w3id.org/xapi/adb/verbs/initialized                               |
|progressed              | http://adlnet.gov/expapi/verbs/progressed                                 |
|completed               | http://adlnet.gov/expapi/verbs/completed                                  |


**initialized**

The player has started an activity.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "https://w3id.org/xapi/adb/verbs/initialized",    
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace",
    "definition": {
      "name": { "en-US": "Lost In Space Serious Game" },
      "type": "https://w3id.org/xapi/seriousgames/activity-types/serious-game"
    }
  }
}
```

**progressed**

The player has progressed in an activity. This statement uses the extension [progress](https://w3id.org/xapi/seriousgames/extensions/progress) to indicates the progress quantity with a decimal number between 0 and 1.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "http://adlnet.gov/expapi/verbs/progressed",    
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace",
    "definition": {
      "name": { "en-US": "Lost In Space Serious Game" },
      "type": "https://w3id.org/xapi/seriousgames/activity-types/serious-game"
    }
  },
  "result": {
  	"extensions": {
  		"https://w3id.org/xapi/seriousgames/extensions/progress": 0.25
  	}
  }
}
```

**completed**

The player has completed an activity. This statement can use the property "success" to specify whether the activity was completed successfully. For instance, completing a serious game with a game over will set "success" to false.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "http://adlnet.gov/expapi/verbs/completed",
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace",
    "definition": {
      "name": { "en-US": "Lost In Space Serious Game" },
      "type": "https://w3id.org/xapi/seriousgames/activity-types/serious-game"
    }
  },
  "result": {
  	"success": false
  }
}
```

## Tracking navigation

The player navigates the game world during each gameplay. The game world can be divided into different types of locations. The profile defines:

| Activity Type          | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|Area                    | https://w3id.org/xapi/seriousgames/activity-types/area                    |
|Zone                    | https://w3id.org/xapi/seriousgames/activity-types/zone                    |
|Cutscene                | https://w3id.org/xapi/seriousgames/activity-types/cutscene                |
|Screen					 | https://w3id.org/xapi/seriousgames/activity-types/screen                  |

The navigation through these parts is represented with the verbs:

| Verb                   | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|accessed                | https://w3id.org/xapi/seriousgames/verbs/accessed                         |
|skipped                 | http://id.tincanapi.com/verb/skipped 	                                 |

**accessed**

The player has accessed a part of the game.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "http://adlnet.gov/expapi/verbs/completed",
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace/Intro",
    "definition": {      
      "type": "https://w3id.org/xapi/seriousgames/activity-types/cutscene"
    }
  }  
}
```

**skipped**

The player has skipped voluntarily a part of the game.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "http://adlnet.gov/expapi/verbs/skipped",
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace/Intro",
    "definition": {      
      "type": "https://w3id.org/xapi/seriousgames/activity-types/cutscene"
    }
  }  
}
```

## Tracking decisions

The player make a lot of decisions during a gameplay. The profile contains the following types of decisions:

| Activity Type          | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|Dialog Tree             | https://w3id.org/xapi/seriousgames/activity-types/dialog-tree             |
|Menu                    | https://w3id.org/xapi/seriousgames/activity-types/menu                    |
|Question                | http://adlnet.gov/expapi/activities/question                              |

The choices made in these decisions are represented with the verbs:

| Verb                   | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|selected                | https://w3id.org/xapi/adb/verbs/selected                                  |
|unlocked                | https://w3id.org/xapi/seriousgames/verbs/unlocked                         |

**selected**

The player selected an option in a decision. This type of statement uses the "response" property to represent the option selected. This type of statement can also use the "success" in those decisions in which assessment is possible. For instance, in a question with right and wrong options, "success" would be set to true for the right options and to false for the wrong options.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "https://w3id.org/xapi/adb/verbs/selected",
  },
  "object": {
    "id": "http://example.com/seriousgames/Geography/CapitalOfSpain",
    "definition": {      
      "type": "http://adlnet.gov/expapi/activities/question"
    }
  },
  "result": {
  	"response": "Barcelona",
  	"success": false
  }
}
```

**unlocked**

The player unlocked a previously unavailable option. This type of statement uses the "response" property to represent the option unlocked.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "https://w3id.org/xapi/seriousgames/verbs/unlocked",
  },
  "object": {
    "id": "http://example.com/seriousgames/Geography/GameModes",
    "definition": {      
      "type": "https://w3id.org/xapi/seriousgames/activity-types/menu"
    }
  },
  "result": {
  	"response": "Time Attack"  	
  }
}
```

## Tracking game world interactions

The player interacts with different game elements that have effects in the game world. The profile defines the following game objects:

| Activity Type          | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|Enemy                   | https://w3id.org/xapi/seriousgames/activity-types/enemy                   |
|Item                    | https://w3id.org/xapi/seriousgames/activity-types/item                    |
|Non-Playable-Character  | https://w3id.org/xapi/seriousgames/activity-types/non-playable-character  |

The player can interact with these game objects through the following verbs:

| Verb                   | Id                                                                        |
|------------------------|---------------------------------------------------------------------------|
|interacted              | http://adlnet.gov/expapi/verbs/interacted                                 |
|used                    | https://w3id.org/xapi/seriousgames/verbs/used                             |

**interacted**

The player has interacted with a game object in a significant way.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "http://adlnet.gov/expapi/verbs/interacted",
  },
  "object": {
    "id": "http://example.com/seriousgames/Geography/HelpButton",
    "definition": {      
      "type": "https://w3id.org/xapi/seriousgames/activity-types/non-playable-character"
    }
  }
}
```

**used**

The player used an object of his inventory.

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "https://w3id.org/xapi/seriousgames/verbs/used",
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace/Potion",
    "definition": {      
      "type": "https://w3id.org/xapi/seriousgames/activity-types/item"
    }
  }
}
```
## Tracking game state variables

The player has always an associated game state that represents his current state in the game. This game state contains a set of variables with different meanings.

The profile specifies that any statement can pass variables of the game state in the "results" property, using extensions. For instance, the following state pass the variable "health", that has been updated after using a potion:

```json
{
  "actor": {
    "name": "Jane Doe",
    "mbox": "mailto:jane@example.com"
  },
  "verb": {
    "id": "https://w3id.org/xapi/seriousgames/verbs/used",
  },
  "object": {
    "id": "http://example.com/seriousgames/LostInSpace/Potion",
    "definition": {      
      "type": "https://w3id.org/xapi/seriousgames/activity-types/item"
    }
  },
  "result": {
  	"extensions": {
  		"https://w3id.org/xapi/seriousgames/extensions/health": 0.5
  	}
  }
}
```