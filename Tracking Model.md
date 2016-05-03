# Serious Games Interactions Model

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [1. Interactions Model](#1-interactions-model)
- [2. Completable](#2-completable)
  - [2.1. Predefined types](#21-predefined-types)
  - [2.2. Actions](#22-actions)
    - [2.2.1. started](#221-started)
    - [2.2.2. progressed _progress_](#222-progressed-_progress_)
    - [2.2.3. completed _ending_](#223-completed-_ending_)
  - [2.3. Requirements and considerations](#23-requirements-and-considerations)
  - [2.4. Metrics](#24-metrics)
- [3. Reachable](#3-reachable)
  - [3.1. Predefined types](#31-predefined-types)
  - [3.2. Actions](#32-actions)
    - [3.2.1. accessed](#321-accessed)
    - [3.2.2 skipped](#322-skipped)
  - [3.3. Requirements and considerations](#33-requirements-and-considerations)
  - [3.4. Metrics](#34-metrics)
- [4. Variable](#4-variable)
  - [4.1. Predefined types](#41-predefined-types)
  - [4.2. Actions](#42-actions)
    - [4.2.1. set _value_](#421-set-_value_)
    - [4.2.2. increased/decreased _value_](#422-increaseddecreased-_value_)
  - [4.3. Requirements and considerations](#43-requirements-and-considerations)
  - [4.4. Metrics](#44-metrics)
- [5. Alternative](#5-alternative)
  - [5.1. Predefined types](#51-predefined-types)
  - [5.2. Actions](#52-actions)
    - [5.2.1. selected](#521-selected)
    - [5.2.2. unlocked](#522-unlocked)
  - [5.3. Requirements and considerations](#53-requirements-and-considerations)
  - [5.4. Metrics](#54-metrics)
- [6. Device](#6-device)
  - [6.1. Predefined types](#61-predefined-types)
  - [6.2. Actions](#62-actions)
    - [6.2.1. pressed _button/key/position_](#621-pressed-_buttonkeyposition_)
    - [6.2.2. released _button/key/position_](#622-released-_buttonkeyposition_)
  - [6.3. Requirements and considerations](#63-requirements-and-considerations)
  - [6.4. Metrics](#64-metrics)
- [7. Target](#7-target)
  - [7.1. Predefined Types](#71-predefined-types)
  - [7.2. Actions](#72-actions)
    - [7.2.1. touched _position_](#721-touched-_position_)
    - [7.2.2. interacted](#722-interacted)
    - [7.2.3. killed](#723-killed)
    - [7.2.4. died because](#724-died-because)
    - [7.2.5. collected](#725-collected)
    - [7.2.6. used](#726-used)
  - [7.3. Requirements and considerations](#73-requirements-and-considerations)
  - [7.4. Metrics](#74-metrics)
- [8. Event](#8-event)
  - [8.1. Predefine types](#81-predefine-types)
  - [8.2. Actions](#82-actions)
    - [8.2.1. performed](#821-performed)
  - [8.3. Requirements and considerations](#83-requirements-and-considerations)
  - [8.4. Metrics](#84-metrics)
- [9. Compound interaction](#9-compound-interaction)
  - [9.1. Predefined types](#91-predefined-types)
  - [9.2. Actions](#92-actions)
    - [9.2.1 began](#921-began)
    - [9.2.2 ended](#922-ended)
  - [9.3. Requirements and considerations](#93-requirements-and-considerations)
  - [9.4. Metrics](#94-metrics)
- [10. Measure](#10-measure)
  - [10.1. Predefined types](#101-predefined-types)
  - [10.2. Actions](#102-actions)
    - [10.2.1. measured](#1021-measured)
  - [10.3. Requirements and considerations](#103-requirements-and-considerations)
  - [10.4. Metrics](#104-metrics)
- [11. Game Message](#11-game-message)
  - [11.1. Predefined types](#111-predefined-types)
  - [11.2. Actions](#112-actions)
    - [11.2.1 threw](#1121-threw)
  - [11.3. Requirements and considerations](#113-requirements-and-considerations)
  - [11.4. Metrics](#114-metrics)
- [12. Summary](#12-summary)
- [13. xAPI Mapping](#13-xapi-mapping)
  - [13.1. Objects](#131-objects)
  - [13.2. Verbs](#132-verbs)
  - [13.3 Values](#133-values)
  - [13.4 Example statements](#134-example-statements)
    - [13.4.1 Completable](#1341-completable)
    - [13.4.1 Reachable](#1341-reachable)
    - [13.4.2. Variables](#1342-variables)
    - [13.4.3. Alternatives](#1343-alternatives)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# 1. Interactions Model

A serious game is defined by a finite set of **game objects**. A game object represents a semantic piece of the game on which players can perform one or several types of interactions. A player can, among others:

* start or complete (interactions) a level (game object)
* increase or decrease (interactions) the number of coins (game object)
* select or unlock (interactions) a power-up (game object)

A **gameplay** is the flow of interactions that a player performs over these game objects in a sequential order.

Using [JsonSchema](http://json-schema.org/), a single interaction has the following structure:

```json
{
	"title": "Interaction",
	"type": "object",
	"properties": {
		"player": {
			"type": "object",
			"description": "The player that generated the interaction"
		},
		"action": {
			"type": "string",
			"description": "The type of interaction performed by the player"
		},
		"object": {
			"type": "string",
			"description": "Objective of the player's action"
		},
		"value": {
			"type": "object",
			"description": "Parameters of the action"
		},
		"timestamp": {
			"type": "string",
			"description": "The time at which the interaction occurred, formatted according to ISO 8601"
		}
	}
}
```

The rest of the document defines the set of game objects and interactions considered by the RAGE Serious Game Interactions Model.

# 2. Completable

A **completable** is something a player can start, progress and complete in a game, maybe several times.

## 2.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Game_|Represents the game as a whole. A game is started the first time you play it, and is completed when you complete a basic story loop|
|_Session_|Represents a play session. Starts when the player connects to the game and ends with she disconnects.|
|_Level_|Represents a level within a structure level in the game.|
|_Quest_| ... |
|_Stage_| ... |
|_Combat_| ... |
|_Story Node_| ... |
|_Race_| ... |
|_Completable_| A completable with no special semantics |

## 2.2. Actions

### 2.2.1. started

The player starts the completable.

```
	John Doe started "Levels/World 1-1" at "15:03:87 May 24, 2016"
```

### 2.2.2. progressed _progress_

The player makes progress in a completable.

* `value` is a mandatory float indicating the absolute progress in the completion. Its value should be between `[0, 1] `.

```
	John Doe progressed 0.5 in "Levels/World 1-1" at "15:05:69 May 24, 2016"
```

### 2.2.3. completed _ending_

The player finished a completable.

* `value` is an optional identifier indicating the ending of the completion, in the case a completable can be finished in several ways. Each identifier should represent and independent ending.

```
	// John Doe completed the game accessing to a good ending
	John Doe completed with "Princess Rescued" in "Super Mario Bros." at "12:35:13 Jan 20, 2016"

	// John Doe game overed in the game
	John Doe completed with "Game Over" in "Super Mario Bros." at "12:35:13 Jan 20, 2016"
```

## 2.3. Requirements and considerations

* A _completed_ action MUST be preceded by a _started_ action of the same completable object.
* A _completed_ action MUST be emitted before emitting a _started_ action of an already _started_ completable object.
* A _progressed_ action with value `0` is not equivalent to a _started_ action.
* A _progressed_ action with value `1` is not equivalent to a _completed_ action.

## 2.4. Metrics

* Is completed / Times completed
* Progress evolution
* Endings count
* Times to complete
* Mean, max and min time to complete

# 3. Reachable

A **reachable** is a virtual space inside the game world a player can access or skip once or multiple times.

## 3.1. Predefined types

|Identifier|Definition|
|----------|----------|
| _Screen_ | A screen in the game, e.g., the start menu, the options menu |
| _Area_ | A general area within the game, that can contain several zones |
| _Zone_ | A concrete zone within the game |
| _Cutscene_ | A non-interactive cutscene in the game (e.g., a video)|
| _Reachable_ | An accessible with no special semantics |

## 3.2. Actions

### 3.2.1. accessed

The player enters in the reachable.

``
	John Doe accessed "Screens/Sound Menu" at "7:47:47 Jan 10, 2016"
``

### 3.2.2 skipped

The player skips a reachable deliberately.

``
	John Doe skipped "Cutscenes/Intro video" at "9:17:37 Sep 3, 2016"
``

## 3.3. Requirements and considerations

* A _skipped_ action MUST be preceded by a _accessed_ action of the same reachable.

## 3.4. Metrics

* Times accessed
* Time spent in it
* Times skipped
* Time to be skipped
* Access order (navigation tree)

# 4. Variable

A **variable** is a meaningful value inside the game world a player can set, increase or decrease.

## 4.1. Predefined types

|Identifier|Definition|
|----------|----------|
| _Score_ | Value indicating the level of success of the player in the game|
| _Currency_ | E.g., coins |
| _Health_ | ... |
| _Attempt_ | E.g., remaining lives|
| _Preference_ | E.g., music off |
| _Position_ | x, y, z the position in the map |
| _Variable_ | A variable with no special semantics |

## 4.2. Actions

### 4.2.1. set _value_

The player sets a value in a variable.

* `value` is a string, a boolean, a number or an object, with the current value for the variable.

```
	// John Doe turned off music
	John Doe set false "Preferences/Music" at "11:22:57 May 7, 2016"
```

### 4.2.2. increased/decreased _value_

The player increases/decreases a value in a variable.

* `value` is a number with the increase/decrease for the variable.

```
	// John Doe took 2 coins
	John Doe increased 2 "Currencies/Coins" at "11:22:57 May 7, 2016"
	// John Doe lost a life
	John Doe decreased 1 "Attempts/Lives" at "11:24:67 May 7, 2016"
```

## 4.3. Requirements and considerations

## 4.4. Metrics

# 5. Alternative

An **alternative** is a decision the player faces in the game, where she has to choose only one option among several. Options in alternatives can be unlocked.

## 5.1. Predefined types

|Identifier|Definition|
|----------|----------|
| _Question_ | A question with several options |
| _Menu_ | An options menu |
| _Dialog_ | ... |
| _Path_ | ... |
| _Arena_ | E.g., the race in course in a race game, the stadium in a football game, a mini-game in Mario Party |
| _Alternative_ | An alternative with no special semantics |

## 5.2. Actions

### 5.2.1. selected

The player selected an option in an alternative.

* `value` is the identifier of the selected option.

```
	John Doe selected "Tutorial Mode" "Menu/Start" at "13:05:12 Dec 31, 2016"	
```

### 5.2.2. unlocked

The player unlocked an unavailable option in an alternative.

* `value` is the identifier of the unlocked option.

```
	John Doe unlocked "Combat Mode" "Menues/Start" at "14:13:12 Sep 13, 2016"
```

## 5.3. Requirements and considerations

## 5.4. Metrics

# 6. Device

A **device** is a piece of hardware the player interacts with to control the outputs of the game.

## 6.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Mouse Button 1_| Main button in a mouse (usually left button) |
|_Mouse Button 2_| Secondary button in a mouse (usually right button) |
|_Keyboard_| A keyboard with keys |
|_Controller_| A game pad with several buttons and pads |
|_Touch Screen N_| A touch screen, usually in a mobile device. N is the finger index (for multi touch)|

## 6.2. Actions

### 6.2.1. pressed _button/key/position_

The player pressed a button, a key or a position in a device.

* `value` is the value of the button, key or position pressed by the player. If the value is a position, it should be in the game coordinates system, not in the screen coordinates system.

```
	John Doe pressed (50, 247) "Mouse Button 1"  at "19:43:82 Jan 21, 2016"
	John Doe pressed "Button_X" "Controller"  at "19:43:82 Jan 21, 2016"
```

### 6.2.2. released _button/key/position_

The player released a button, a key or a position in a device.

* `value` of the button, key or position released by the player. If the value is a position, it should be in the game coordinates system, not in the screen coordinates system.

```
	John Doe released (59, 267) "Mouse Button 1" at "19:43:82 Jan 21, 2016"
	John Doe released "Button_X" "Controller" at "19:43:82 Jan 21, 2016"
```

## 6.3. Requirements and considerations

* A _pressed_ action must be eventually followed by a _released_ action over the same device. A _pressed_ cannot be emitted if there is a pending _released_ action.

## 6.4. Metrics

# 7. Target

A **target** is a game element the player can interact with.

## 7.1. Predefined Types

|Identifier|Definition|
|----------|----------|
|_UI_| A control within the UI |
|_Enemy_| An opponent inside the game |
|_NPC_| Non-player character |
|_Item_| A collectable |
|_Weapon_| ... |
|_Vehicle_| ... |

## 7.2. Actions

### 7.2.1. touched _position_

The player touched (or clicked) a target inside the game world (e.g., an UI control).

* `value` is the optional position of the player touch/click. It should be in the game coordinates system.

```
	John Doe touched "UI/StartButton" at "19:43:82 May 15, 2016"
```
### 7.2.2. interacted 

The player interacted with a target inside the game world.

```
	John Doe interacted "NPC/Villager" at "19:43:82 May 1, 2016"
```

### 7.2.3. killed

The player eliminated a target inside the game world.

```
	John Doe killed "Enemy/Goomba" at "19:43:82 May 24, 2016"
```

### 7.2.4. died because

The player lost a life/attempt.

```
	John Doe died because "Enemy/Goomba" at "19:43:82 May 24, 2016"
```

### 7.2.5. collected

The player collected a target inside the game world.

```
	John Doe collected "Weapon/LightSword" at "19:43:82 May 24, 2016"
```

### 7.2.6. used

The player used a a target inside the game world.

```
	John Doe used "Item/HealthPotion" at "19:43:82 May 24, 2016"
```

## 7.3. Requirements and considerations

## 7.4. Metrics

# 8. Event

This type of action is intended to cover those custom interactions not covered in the rest of the model.

## 8.1. Predefine types

None.

## 8.2. Actions

### 8.2.1. performed

The player executed the custom interaction.

```
	John Doe performed "Event/Jump"	
```

## 8.3. Requirements and considerations

## 8.4. Metrics

# 9. Compound interaction

To express a complex interaction, formed by simple interactions.

## 9.1. Predefined types

None.

## 9.2. Actions

### 9.2.1 began

The complex interaction began. All subsequent interactions will belong to the compound interaction, until an ended action is emitted.

### 9.2.2 ended

Marks the end of tye complex interaction.

## 9.3. Requirements and considerations

Example:
```
	// John Doe bought a health potion and recovered health
	John Doe began "Buy health potion" at "19:43:82 May 24, 2016"
	John Doe decreased 20 "Currency/Coins" at "19:43:82 May 24, 2016"
	John Doe collected "Items/Health Potion" at "19:43:82 May 24, 2016"
	John Doe used "Items/Health Potion" at "19:43:82 May 24, 2016"
	John Doe increased 5 "Health/HP" at "19:43:82 May 24, 2016"
	John Doe ended "Buy health potion" at "19:43:82 May 24, 2016"
```

* All the interactions are emitted at the same exact timestamp
* A compound interaction can have sub-compound interaction

## 9.4. Metrics

# 10. Measure

Used by the game engine to log debug and performance data.

## 10.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Memory_| Memory usage. Value should be an absolute measure |
|_CPU_| CPU usage. Value should be a percentage measure |
|_Frame rate_| Frame rate of the game at a given moment |
|_Load time_| Load time for a concrete task, in seconds |

## 10.2. Actions

### 10.2.1. measured

The game engine measured a value for a given performance metric.

```
	John Doe measured "LoadTime/Scene1" 0.2 at "19:43:82 May 24, 2016"
```

## 10.3. Requirements and considerations

## 10.4. Metrics

# 11. Game Message

Used by the game engine to log some error in the game.

## 11.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Info_| Relevent events with no meaningful consequences for the game|
|_Debug_| A message with debug purposes |
|_Warning_| An undesired happening in the game |
|_Error_| Something that was not supposed to happen |
|_Critical_| Something that should never happen, and it is critical for the correct functioning of the game|

## 11.2. Actions

### 11.2.1 threw

```
	John Doe threw "Error/Exception" "ArrayIndexOutBounds es.eucm.countrix.Countrix.java:90"
```

## 11.3. Requirements and considerations

## 11.4. Metrics

# 12. Summary

Object | Action | Value | Value mandatory | Value Type | Value constraints |
---------|--------|-------|----------|------|------------|
**Completable**| _started_ | No
 | _progressed to_ | Progress | Yes | Float | between `[0, 1]`
 - | _completed_ | Ending Identifier | No | String | - |
**Accessible**| _accessed_ | No
 | _skipped_ | No
**Variable** | _set_ | value | Yes | Boolean, Number, String |
 | _increased_ | value | Yes | Number |
 | _decreased_ | value | Yes | Number |
**Alternative** | _selected_ | Option Id. | Yes | String |
 | _unlocked_ | Option Id. | Yes | String | 
**Device** | _pressed_ | Press value (button, key, position) | Yes | Integer, Position | Position must be in world coordinates |
 | _released_ | Press value (button, key, position) | Yes | String, Position | Position must be in world coordinates |
**Target** | _touched_ (clicked) | Touch position | No | Position | Position must be in world coordinates |
 | _interacted_ | No
 | _killed_ | No
 | _died because_ | No
 | _collected_ | No
 | _used_ | No
**Event** | _performed_ | Custom value
**Compound interaction**| _began_ | Compound interaction Id. | Yes | String 
 | _ended_ | No
**Measure**| _measured_ | Measure value | Yes | String
**Game Message**| _threw_ | Error message | No | String

# 13. xAPI Mapping

## 13.1. Objects

Identifier | IRI|
-------|----|
Game | http://activitystrea.ms/schema/1.0/game |
Session | https://rage.e-ucm.es/xapi/seriousgames/activities/Session |
Level | http://curatr3.com/define/type/level |
Quest | https://rage.e-ucm.es/xapi/seriousgames/activities/Quest |
Stage | https://rage.e-ucm.es/xapi/seriousgames/activities/Stage |
Combat | https://rage.e-ucm.es/xapi/seriousgames/activities/Combat |
Story Node | https://rage.e-ucm.es/xapi/seriousgames/activities/StoryNode |
Race | https://rage.e-ucm.es/xapi/seriousgames/activities/Race |
Completable | https://rage.e-ucm.es/xapi/seriousgames/activities/Completable |
Screen | https://rage.e-ucm.es/xapi/seriousgames/activities/Screen |
Area | https://rage.e-ucm.es/xapi/seriousgames/activities/Area |
Zone | https://rage.e-ucm.es/xapi/seriousgames/activities/Zone |
Cutscene | https://rage.e-ucm.es/xapi/seriousgames/activities/Cutscene |
Reachable | https://rage.e-ucm.es/xapi/seriousgames/activities/Reachable |
Score | https://rage.e-ucm.es/xapi/seriousgames/activities/Score |
Currency | https://rage.e-ucm.es/xapi/seriousgames/activities/Currency |
Health | https://rage.e-ucm.es/xapi/seriousgames/activities/Health |
Attempt | https://rage.e-ucm.es/xapi/seriousgames/activities/Attempt |
Preference | https://rage.e-ucm.es/xapi/seriousgames/activities/Preference |
Position | https://rage.e-ucm.es/xapi/seriousgames/activities/Position |
Variable | https://rage.e-ucm.es/xapi/seriousgames/activities/Variable |
Question | http://adlnet.gov/expapi/activities/question |
Menu | https://rage.e-ucm.es/xapi/seriousgames/activities/Menu |
Dialog | https://rage.e-ucm.es/xapi/seriousgames/activities/Dialog |
Path | https://rage.e-ucm.es/xapi/seriousgames/activities/Path |
Arena | https://rage.e-ucm.es/xapi/seriousgames/activities/Arena |
Alternative | https://rage.e-ucm.es/xapi/seriousgames/activities/Alternative |
Mouse Button 1 | https://rage.e-ucm.es/xapi/seriousgames/activities/MouseButton1 |
Mouse Button 2 | https://rage.e-ucm.es/xapi/seriousgames/activities/MouseButton2 |
Keyboard | https://rage.e-ucm.es/xapi/seriousgames/activities/Keyboard |
Controller | https://rage.e-ucm.es/xapi/seriousgames/activities/Controller |
Touch Screen N | https://rage.e-ucm.es/xapi/seriousgames/activities/TouchScreenN |
UI | https://rage.e-ucm.es/xapi/seriousgames/activities/UI |
Enemy | https://rage.e-ucm.es/xapi/seriousgames/activities/Enemy |
NPC | https://rage.e-ucm.es/xapi/seriousgames/activities/NPC |
Item | https://rage.e-ucm.es/xapi/seriousgames/activities/Item |
Weapon | https://rage.e-ucm.es/xapi/seriousgames/activities/Weapon |
Vehicle | https://rage.e-ucm.es/xapi/seriousgames/activities/Vehicle |
Memory | https://rage.e-ucm.es/xapi/seriousgames/activities/Memory |
CPU | https://rage.e-ucm.es/xapi/seriousgames/activities/CPU |
Frame rate | https://rage.e-ucm.es/xapi/seriousgames/activities/Framerate |
Load time | https://rage.e-ucm.es/xapi/seriousgames/activities/Loadtime |
Info | https://rage.e-ucm.es/xapi/seriousgames/activities/Info |
Debug | https://rage.e-ucm.es/xapi/seriousgames/activities/Debug |
Warning | https://rage.e-ucm.es/xapi/seriousgames/activities/Warning |
Error | https://rage.e-ucm.es/xapi/seriousgames/activities/Error |
Critical | https://rage.e-ucm.es/xapi/seriousgames/activities/Critical |

## 13.2. Verbs

Identifier | IRI|
-------|----|
started | http://activitystrea.ms/schema/1.0/start |
progressed | http://adlnet.gov/expapi/verbs/progressed |
completed | http://adlnet.gov/expapi/verbs/completed |
accessed | http://activitystrea.ms/schema/1.0/access |
skipped | http://id.tincanapi.com/verb/skipped |
set | https://rage.e-ucm.es/xapi/seriousgames/verbs/set |
increased | https://rage.e-ucm.es/xapi/seriousgames/verbs/increased |
decreased | https://rage.e-ucm.es/xapi/seriousgames/verbs/decreased |
selected | http://adlnet.gov/expapi/verbs/preferred |
unlocked | https://rage.e-ucm.es/xapi/seriousgames/verbs/unlocked |
pressed | http://future-learning.info/xAPI/verb/pressed |
released | http://future-learning.info/xAPI/verb/released |
touched | http://future-learning.info/xAPI/verb/pressed |
interacted | http://activitystrea.ms/schema/1.0/interact |
killed | https://rage.e-ucm.es/xapi/seriousgames/verbs/killed |
died because | https://rage.e-ucm.es/xapi/seriousgames/verbs/died |
collected | https://rage.e-ucm.es/xapi/seriousgames/verbs/collected |
used | http://activitystrea.ms/schema/1.0/use |
performed | https://rage.e-ucm.es/xapi/seriousgames/verbs/performed |
began | https://rage.e-ucm.es/xapi/seriousgames/verbs/began |
ended | https://rage.e-ucm.es/xapi/seriousgames/verbs/ended |
measured | https://rage.e-ucm.es/xapi/seriousgames/verbs/measured |
threw | https://rage.e-ucm.es/xapi/seriousgames/verbs/threw |

## 13.3 Values

Parameter | Extension IRI | Value |
----------|---------------|-------|
Progress | https://rage.e-ucm.es/xapi/ext/progress | Number between [0, 1]|
Variable value / Position / Device button | https://rage.e-ucm.es/xapi/ext/value | Number, String, Boolean, Object |
Variable increase/decrease | https://rage.e-ucm.es/xapi/ext/value | Number |
Measure label | https://rage.e-ucm.es/xapi/ext/label | String |

## 13.4 Example statements

### 13.4.1 Completable

**started**

```
	John Doe started "Levels/World 1-1" at "15:03:87 May 24, 2016"
```

```json
{
	"actor": { "..." },
	"verb": {
		"id": "http://activitystrea.ms/schema/1.0/start"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Levels/World1-1",
		"definition": {
			"type": "http://curatr3.com/define/type/level"
		}
	},
	"timestamp": "2016-05-24T15:03:87Z"	
}
```

**progressed**

```
	John Doe progressed 0.5 in "Levels/World 1-1" at "15:05:69 May 24, 2016"
```

```json
{
	"actor": { "..." },
	"verb": {
		"id": "http://adlnet.gov/expapi/verbs/progressed"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Levels/World1-1",
		"definition": {
			"type": "http://curatr3.com/define/type/level"
		}
	},
	"result": {
		"extensions": {
			"https://rage.e-ucm.es/xapi/ext/progress": 0.5
		}
	},
	"timestamp": "2016-05-24T15:05:69Z"	
}
```

**completed**

```
John Doe completed with "Game Over" in "Super Mario Bros." at "12:35:13 Jan 20, 2016"
```

```json
{
	"actor": { "..." },
	"verb": {
		"id": "http://adlnet.gov/expapi/verbs/completed"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Levels/World1-1",
		"definition": {
			"type": "http://curatr3.com/define/type/level"
		}
	},
	"result": {
		"extensions": {
			"https://rage.e-ucm.es/xapi/ext/value": "Game Over"
		}
	},
	"timestamp": "2016-01-20T15:05:69Z"
}
```

### 13.4.1 Reachable

**accessed**

``
	John Doe accessed "Screens/Sound Menu" at "7:47:47 Jan 10, 2016"
``

```json
{
	"actor": { "..." },
	"verb": {
		"id": "http://activitystrea.ms/schema/1.0/access"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Screens/SoundMenu",
		"definition": {
			"type": "https://rage.e-ucm.es/xapi/seriousgames/activities/Screen"
		}
	},
	"timestamp": "2016-01-10T07:47:47Z"
}
```

**skipped**

``
	John Doe skipped "Cutscenes/Intro video" at "9:17:37 Sep 3, 2016"
``

```json
{
	"actor": { "..." },
	"verb": {
		"id": "http://id.tincanapi.com/verb/skipped"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Cutscenes/IntroVideo",
		"definition": {
			"type": "https://rage.e-ucm.es/xapi/seriousgames/activities/Cutscene"
		}
	},
	"timestamp": "2016-09-03T09:17:37Z"
}
```

### 13.4.2. Variables

**set**

```
	John Doe set false "Preferences/Music" at "11:22:57 May 7, 2016"
```

```json
{
	"actor": { "..." },
	"verb": {
		"id": "https://rage.e-ucm.es/xapi/seriousgames/verbs/set"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Preferences/Music",
		"definition": {
			"type": "https://rage.e-ucm.es/xapi/seriousgames/activities/Preference"
		}
	},
	"result": {
		"extensions": {
			"https://rage.e-ucm.es/xapi/ext/value": false
		}
	},
	"timestamp": "2016-01-20T15:05:69Z"
}
```

**decreased**

```
	John Doe decreased 1 "Attempts/Lives" at "11:24:67 May 7, 2016"
```

```json
{
	"actor": { "..." },
	"verb": {
		"id": "https://rage.e-ucm.es/xapi/seriousgames/verbs/decreased"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Attempts/Lives",
		"definition": {
			"type": "https://rage.e-ucm.es/xapi/seriousgames/activities/Attempt"
		}
	},
	"result": {
		"extensions": {
			"https://rage.e-ucm.es/xapi/ext/value": 1
		}
	},
	"timestamp": "2016-01-20T15:05:69Z"
}
```

### 13.4.3. Alternatives

**selected**

```
	John Doe selected "Tutorial Mode" "Menu/Start" at "13:05:12 Dec 31, 2016"	
```

```json
{
	"actor": { "..." },
	"verb": {
		"id": "http://adlnet.gov/expapi/verbs/preferred"
	},
	"object": {
		"id": "http://example.com/games/SuperMarioBros/Alternatives/Menu_Start",
		"definition": {
			"type": "https://rage.e-ucm.es/xapi/seriousgames/activities/Alternative"
		}
	},
	"result": {
		"response": "Tutorial Mode"
	},
	"timestamp": "2016-12-31T13:05:12Z"
}
```
