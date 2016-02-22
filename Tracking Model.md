# Game Model

A game is defined by a set of **tangibles**. 

We define a **gameplay** as the **flow of interactions** that a player performs over the tangibles of the game.

An interaction is a player performing an action (with an optional value) over a game tangible at concrete moment. It has the form:

```
[player] [action] ([value]) [tangible] at [timestamp]
```

Thus, a gameplay is a timestamp ordered sequence of interactions:

```
...
[player] [action] ([value]) [tangible] at [timestamp]
[player] [action] ([value]) [tangible] at [timestamp]
[player] [action] ([value]) [tangible] at [timestamp]
...
```

## Summary

Tangible | Action | Value | Value mandatory | Value Type | Value constraints |
---------|--------|-------|----------|------|------------|
**Completable**| _started_ | No
 | _progressed_ | Progress | Yes | Float | between `[0, 1]`
 | _completed_ | Ending Id. | No. Default: `0` | Integer | Good endings `> 0`; Bad endings `< 0`|
**Accessible**| _accessed_ | No
 | _skipped_ | No
**Variable** | _set_ | value | Yes | Boolean, Number |
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

## 1. Completable
A **completable** is something the player can start, progress and complete in a game, maybe several times.

### 1.1. Model

```
{
	type: string // Type of the completable
	id: string, // An unique identifier for the completable
	repeatable: boolean, // whether it can be completed more than once
}

```
#### 1.1.1 Predefined types

|Identifier|Definition|
|----------|----------|
|_Game_|Represents the game as a whole. A game is started the first time you play it, and is completed when you complete a basic story loop|
|_Session_|Represents a play session. Starts when the player connects to the game and ends with she disconnects.|
|_Level_|Represents a level within a structure level in the game.|
|_Quest_| |
|_Stage_| |
|_Combat_| |
|_Story Node_| |
|_Race_| |
|_Completable_| A completable with no special semantics |

### 1.2. Actions

#### 1.2.1. started

The player starts the completion of a completable.

```
	John Doe started "Levels/World 1-1" at "15:03:87 May 24, 2016"
```

#### 1.2.2. progressed _progress_

The player makes progress in a completable.

* `value` is a mandatory float indicating the overall progress in the completion, and its value should be between `[0, 1] `.

```
	John Doe progressed 0.5 "Levels/World 1-1" at "15:05:69 May 24, 2016"
```

#### 1.2.3. completed _ending_

The player finished a completable.

* `value` is an optional integer indicating the ending of the completion, in the case a completable can be finished in several ways. Each integer should represent and independent ending. Positive values represent good results, and negative values represent bad ones (e.g., game over). `value` is `0` by default.

```
	// John Doe completed the game accessing to a good ending
	John Doe completed 1 "Game" at "12:35:13 Jan 20, 2016"

	// John Doe game overed in the game
	John Doe completed -1 "Game" at "12:35:13 Jan 20, 2016"
```

### 1.3. Requirements and considerations

* A _completed_ action MUST be preceded by a _started_ action of the same completable.
* A _completed_ action MUST be emitted before emitting a _started_ action of an already _started_ completable.
* A _progressed_ action with value `0` is not equivalent to a _started_ action.
* A _progressed_ action with value `1` is not equivalent to a _completed_ action.

### 1.4. Completable metrics

* `repeatable = false`
	* Is completed
	* Progress evolution
	* Ending
	* Time to complete
* `repeatable = true`
	* Times completed
	* Good endings count
	* Bad endings count
	* Good/Bad endings ratio
	* Mean, max and min time to complete

## 2. Accessible
An **accessible** is a virtual space inside the game world the player can access or skip once or multiple times.

### 2.1. Model

```
{
	type: string // Type of accessible
	id: string // An unique identifier for the accessible
}
```

#### 2.1.1. Predefined types

|Identifier|Definition|
|----------|----------|
| _Screen_ | A screen in the game, e.g., the start menu, the options menu |
| _Area_ | A general area within the game, that can contain several zones |
| _Zone_ | A concrete zone within the game |
| _Cutscene_ | A non-interactive cutscene in the game (e.g., a video)|
| _Accessible_ | An accessible with no special semantics |

### 2.2. Actions

#### 2.2.1. accessed

The player enters in the accessible.

``
	John Doe accessed "Screens/Sound Menu" at "7:47:47 Jan 10, 2016"
``

#### 2.2.2 skipped

The player skips an accessible deliberately.

``
	John Doe skipped "Cutscenes/Intro video" at "9:17:37 Sep 3, 2016"
``

### 2.3. Requirements and considerations

* A _skipped_ action MUST be preceded by a _accessed_ action of the some accessible.

### 2.4. Accessible metrics

* Times accessed
* Time spent in it
* Times skipped
* Time to be skipped
* Access order (navigation tree)

## 3. Variable

A **variable** is a meaningful value inside the game world the player can set, increased or decreased.

### 3.1. Model

```
{
	type: string, // Type of variable,
	id: string, // An unique identifier for the accessible,
	class: "string" | "number" | "boolean", // Value class
	max: number, // (Optional) The maximum value this variable should take
	min: number // The minimum value this variable should take
}
```

#### 3.1.1. Predefined types

|Identifier|Definition|
|----------|----------|
| _Score_ | |
| _Currency_ | E.g., coins |
| _Health_ | |
| _Attempts_ | E.g., remaining lives|
| _Preference_ | e.g., music off |
| _Position_ | x, y, z the position in the map |
| _Variable_ | A variable with no special semantics |

### 3.2. Actions

#### 3.2.1. set _value_

The player sets a value in a variable.

* `value` is a string, boolean or number, with the current value for the variable.

```
	// John Doe turned off music
	John Doe set false "Preferences/Music" at "11:22:57 May 7, 2016"
```

#### 3.2.1. increased/decreased _value_

The player increases/decreases a value in a variable.

* `value` is a number with the increase/decrease for the variable.

```
	// John Doe took 2 coins
	John Doe increased 2 "Currencies/Coins" at "11:22:57 May 7, 2016"
	// John Doe lost a life
	John Doe decreased 1 "Attempts/Lives" at "11:24:67 May 7, 2016"
```

### 3.3. Requirements and considerations

### 3.4. Metrics

## 4. Alternative

An **alternative** is a decision the player faces in the game, where she has to choose only one option among several. Options in alternatives can be unlocked.

### 4.1. Model

```
{
	type: string, // Alternative type
	id: string // An unique identifier for the alternative
	options: [ // A list with the possible options
	{ 
		id: string, // an unique identifier for the option
		locked: boolean // whether the option is initially available
	},
	...
	]
}
```

#### 4.1.1. Predefined types

|Identifier|Definition|
|----------|----------|
| _Menu_ | An options menu |
| _Dialog_ | |
| _Path_ | |
| _Arena_ | e.g., the race in course in a race game, the stadium in a football game, a mini-game in Mario Party |
| _Alternative_ | An alternative with no special semantics |

### 4.2. Actions

#### 4.2.1. selected

The player selected an option in an alternative.

* `value` is the identifier of the selected option.

```
	John Doe selected "Tutorial Mode" "Menues/Start" at "13:05:12 Dec 31, 2016"	
```

#### 4.2.2. unlocked

The player unlocked an unavailable option in an alternative.

* `value` is the identifier of the unlocked option.

```
	John Doe unlocked "Combat Mode" "Menues/Start" at "14:13:12 Sep 13, 2016"
```

### 4.3. Requirements and considerations

### 4.4. Metrics

## 5. Device

A **device** is a piece of hardware the player interacts with to control the outputs of the game.

### 5.1. Model

```
{
	type: string // Device type
}
```

#### 5.1.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Mouse Button 1_| Main button in a mouse (usually left button) |
|_Mouse Button 2_| Secondary button in a mouse (usually right button) |
|_Keyboard_| A keyboard with keys |
|_Controller_| A game pad with several buttons and pads |
|_Touch Screen N_| A touch screen, usually in a mobile device. N is the finger index (for multi touch)|

### 5.2. Actions

#### 5.2.1. pressed _button/key/position_

The player pressed a button, a key or a position in a device.

* `value` is the value of the button, key or position pressed by the player. If the value is a position, it should be in the game coordinates system, not in the screen coordinates system.

```
	John Doe pressed (50, 247) "Mouse Button 1"  at "19:43:82 Jan 21, 2016"
	John Doe pressed "Button_X" "Controller"  at "19:43:82 Jan 21, 2016"
```

#### 5.2.2. released (_button/key/position_)

The player released a button, a key or a position in a device.

* `value` of the button, key or position released by the player. If the value is a position, it should be in the game coordinates system, not in the screen coordinates system.

```
	John Doe released (59, 267) "Mouse Button 1" at "19:43:82 Jan 21, 2016"
	John Doe released "Button_X" "Controller" at "19:43:82 Jan 21, 2016"
```

### 5.3. Requirements and considerations

* A _pressed_ action must be eventually followed by a _released_ action over the same device. A _pressed_ cannot be emitted if there is a pending _released_ action.

### 5.4. Metrics

## 6. Target

A **target** is a game element the player can interact with.

### 6.1. Model

```
{
	type: String, // The type of the target
	id: String // An unique identifier for the target 
}
```

#### 6.1.1. Predefined Types

|Identifier|Definition|
|----------|----------|
|_UI_| An opponent inside the game |
|_Enemy_| An opponent inside the game |
|_NPC_| Non-player character |
|_Item_| A collectable |
|_Weapon_| |
|_Vehicle_| |

### 6.2. Actions

#### 6.2.1. touched _position_

The player touched (or clicked) a target inside the game world (e.g., an UI element).

* `value` is the optional position of the player touch/click. It should be in the game coordinates system.

```
	John Doe touched "UI/StartButton" at "19:43:82 May 15, 2016"
```
#### 6.2.2. interacted 

The player interacted with a target inside the game world.

```
	John Doe interacted "NPC/Villager" at "19:43:82 May 1, 2016"
```

#### 6.2.3. killed

The player eliminated a target inside the game world.

```
	John Doe killed "Enemy/Goomba" at "19:43:82 May 24, 2016"
```

#### 6.2.4. died because

The player lost a life/attempt/try because a target.

```
	John Doe died "Enemy/Goomba" at "19:43:82 May 24, 2016"
```

#### 6.2.5. collected

The player collected a target inside the game world.

```
	John Doe collected "Weapon/LightSword" at "19:43:82 May 24, 2016"
```

#### 6.2.6. used

The player used a a target inside the game world.

```
	John Doe used "Item/HealthPotion" at "19:43:82 May 24, 2016"
```

### 6.3. Requirements and considerations

### 6.4. Metrics

## 7. Event

This type of action is intended to cover those custom interactions not covered in the rest of the model.

## 7.1. Model

```
{
	id: String // An unique identifier for the custom interaction
}
```

### 7.2. Actions

#### 7.2.1. performed

The player executed the custom interaction.

```
	John Doe performed "Event/Jump"	
```

### 7.3. Requirements and considerations

### 7.4. Metrics

## 8. Compound interaction

To express a complex interaction, formed by simple interactions.

### 8.1. Model

```
{
	id: String // An unique identifier for the custom interaction
}
```

#### 8.1.1. 
|Identifier|Definition|
|----------|----------|
|_UI_| An opponent inside the game |
|_Enemy_| An opponent inside the game |
|_NPC_| Non-player character |
|_Item_| A collectable |
|_Weapon_| |
|_Vehicle_| |

### 8.2. Actions

#### 8.2.1 began

The complex interaction began. All subsequent interactions will belong to the compound interaction, until an ended action is emitted.

#### 8.2.2 ended

Marks the end of tye complex interaction.

### 8.3. Requirements and considerations

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
* A compound interaction can have sub-compund interaction

### 8.4. Metrics

## 9. Measure

Used by the game engine to log some performance measure.

### 9.1. Model

```
{
	type: String // Type of the performance measure
	id: String // (Optional) an identifier for the concrete measure
}
```
#### 9.1.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Memory_| Memory usage. Value should be an absoulte measure |
|_CPU_| CPU usage. Value should be a percentage measure |
|_Frame rate_| Frame rate of the game at a given moment |
|_Load time_| Load time for a concrete task, in seconds |

### 9.2. Actions

#### 9.2.1. measured

The game engine measured a value for a given performance metric.

```
	John Doe measured "LoadTime/Scene1" 0.2 at "19:43:82 May 24, 2016"
```

### 9.3. Requirements and considerations

### 9.4. Metrics

## 10. Game Message

Used by the game engine to log some error in the game.

### 10.1. Model

{
	type: String // Type of the error
	id: String // An unique identifier for the error
}

#### 10.1.1. Predefined types

|Identifier|Definition|
|----------|----------|
|_Info_| Relevent events with no meaningful consequences for the game|
|_Debug_| A message with debug purposes |
|_Warning_| An undesired happening in the game |
|_Error_| Something that was not supposed to happen |
|_Critical_| Something that should never happen, and it is critical for the correct functioning of the game|

### 10.2. Actions

#### 10.2.1 threw

```
	John Doe threw "Error/Exception" "ArrayIndexOutBounds es.eucm.lostinspace.LIS.java:90"
```

### 10.3. Requirements and considerations

### 10.4. Metrics
