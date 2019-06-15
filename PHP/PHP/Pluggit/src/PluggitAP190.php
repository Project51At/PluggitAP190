
<?php
/**
 * @author				Helge Klug
 * @copyright			Copyright (c) 2018 Helge Klug
 * @version				1.0.0
 */


	error_reporting(E_ALL);
	set_time_limit(0);
	require_once dirname(__FILE__) .'/../../Phpmodbus/Phpmodbus/ModbusMaster.php';

	// http://www.pluggit.com/fileserver/files/1413/609560454939420/21_10_2013_modbus_addresses.pdf
	// UINT
	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxT1",								"132");		// 40133 | prmRamIdxT1  				| UINT	| Read	|  Outdoor temperature T1, °C
	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxT2",								"134");		// 40135 | prmRamIdxT2 					| UINT	| Read	|  Supply  temperature T2, °C
	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxT3",								"136");		// 40137 | prmRamIdxT3  				| UINT	| Read	|  Extract temperature T3, °C
	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxT4",								"138");		// 40139 | prmRamIdxT4  				| UINT	| Read	|  Exhaust temperature T4, °C

	define("PLUGGIT_MODBUS_ADDR_PrmPreheaterDutyCycle",						"160");		// 40161 | prmPreheaterDutyCycle  		| UINT	| Read	|  Power of Preheater in %


	define("PLUGGIT_MODBUS_ADDR_PrmRomIdxSpeedLevel",						"324");		// 40325 | prmRomIdxSpeedLevel			| UINT	| Write	|	Speed level of Fans ->  Manual mode: Fan step can be set
																						// 40325 | prmRomIdxSpeedLevel			| UINT	| Read	|	Speed level of Fans ->  Other modes: Fan step can be read.


	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxUnitMode",							"168");		// 40169 | prmRamIdxUnitMode			| UINT	| Write	|	Active Unit mode:
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_DEMAND",				"2");		//																Demand Mode				0x0002		2
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_MANUAL",				"4");		//																Manual Mode				0x0004		4
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_WEEKPROGRAM",			"8");		//																WeekProgram Mode		0x0008		8

		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_AWAY_START",			"16");		//																Away Mode Start			0x0010		16
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_AWAY_STOP",			"40169");	//																Away Mode Start			0x8010		40169

		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_FIREPLACE_START",		"64");		//																Fireplace Mode Start	0x0040		64
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_FIREPLACE_STOP",		"32832");	//																Fireplace Mode End		0x8040		32832

		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_SUMMER_START",			"2048");	//																Summer Mode Start		0x0800		2048
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_SUMMER_STOP",			"40169");	//																Summer Mode End			0x8800		40169

		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_START",			"128");		//																Select manual bypass	0x0080		128
		define("PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_STOP",			"32896");	//																Deselect Manual bypass	0x8080		32896

	define("PLUGGIT_MODBUS_ADDR_PrmCurrentBLState",						"472");		// 40473 | prmCurrentBLState 			| UINT	| Read	|	Current unit mode:
																					//																0	Standby
																					//																1	Manual
																					//																2	Demand
																					//																3	Week program
																					//																4	Servo-flow
																					//																5	Away
																					//																6	Summer
																					//																7	DI Override
																					//																8	Hygrostat override
																					//																9	Fireplace
																					//																10	Installer
																					//																11	Fail Safe 1
																					//																12	Fail Safe 2
																					//																13	Fail Off
																					//																14	Defrost Off
																					//																15	Defrost
																					//																16	Night

	define("PLUGGIT_MODBUS_ADDR_PrmDateTime",							"108 ");	// 40109 | prmDateTime  				| UINT	| Read	|	Current Date/time in Unix time
	define("PLUGGIT_MODBUS_ADDR_DATETIME_SET",							"110 ");	// 40109 | prmDateTimeSet  				| UINT	| Write	|	New date/time in Unix time
	define("PLUGGIT_MODBUS_ADDR_PrmWorkTime",							"624 ");	// 40625 | prmWorkTime  				| UINT	| Read	|	Work time of system, in hours
	define("PLUGGIT_MODBUS_ADDR_PrmStartExploitationDateStamp",			"668 ");	// 40669 | prmStartExploitationDateStamp| UINT	| Read	|	Date Stamp of the system start time in Unix time

	define("PLUGGIT_MODBUS_ADDR_PrmFilterRemainingTime",				"554");		// 40555 | prmFilterRemainingTime  		| UINT	| Read	|	Remaining time of the Filter Lifetime (Days)
	define("PLUGGIT_MODBUS_ADDR_PrmFilterDefaultTime",					"556");		// 40555 | prmFilterDefaultTime  		| UINT	| Write	|	Filter Lifetime (Days)

	define("PLUGGIT_MODBUS_ADDR_PrmHALTaho1",							"100");		// 40101 | prmHALTaho1					| Float	| Read	|   Fan1 rpm
	define("PLUGGIT_MODBUS_ADDR_PrmHALTaho2",							"102");		// 40103 | prmHALTaho2					| Float	| Read	|	Fan2 rpm

	define("PLUGGIT_MODBUS_ADDR_PrmBypassTmin",							"444");		// 40445 | prmBypassTmin 				| Float	| Read	|	Min temperature for outdoor air (T1)
	define("PLUGGIT_MODBUS_ADDR_PrmBypassTmax",							"446");		// 40447 | prmBypassTmax 				| Float	| Read	|	Max temperature for extract air (T3)
	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxBypassActualState",			"198");		// 40199 | prmRamIdxBypassActualState	| UINT	| Read	|	Bypass state:
																					//																0	Closed		0x0000
																					//																1	In process	0x0001
																					//																32	Closing		0x0020
																					//																64	Opening		0x0040
																					//																255	Opened		0x00FF

	define("PLUGGIT_MODBUS_ADDR_PrmRamIdxBypassManualTimeout",			"264");			// 40265 | prmRamIdxBypassManualTimeout	| UINT	| Read	|	Manual bypass duration in minutes





	class PluggitAP190
	{
		//-------------------------------------------------------------------//
		// General
		//-------------------------------------------------------------------//
		public	$Host					= "192.168.1.1";
		public	$Protocol				= "TCP"; // Socket protocol (TCP, UDP)
		public	$TemperatureResulution	= 2;
		public	$SpeedResulution		= 0;

		public	$UnitData				=	[	"prmRamIdxT1"		=>	'0'	];

		/**
		* Pluggit
		*
		* This is the constructor that defines {$Host} IP address of the object.
		*
		* @param String $Host An IP address of a Modbus TCP device. E.g. "192.168.1.1"
		*/
		public function __construct($Host)
		{
			$this->Host = $Host;
		}

		/**
		* ReadUnitData
		*
		* Read all data from device
		*
		*/
		function GetUnitData()
		{
			// Time
			$this->UnitData["prmDateTime"]							= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmDateTime);
			$this->UnitData["prmWorkTime"]							= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmWorkTime);
			$this->UnitData["prmStartExploitationDateStamp"]		= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmStartExploitationDateStamp);

			// General
			$this->UnitData["prmCurrentBLState"]					= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmCurrentBLState);
			$this->UnitData["prmRamIdxUnitMode"]					= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmRamIdxUnitMode);
			$this->UnitData["prmRomIdxSpeedLevel"]					= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmRomIdxSpeedLevel);
			$this->UnitData["prmPreheaterDutyCycle"]				= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmPreheaterDutyCycle);

			// Temperature
			$this->UnitData["prmRamIdxT1"]							= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmRamIdxT1);
			$this->UnitData["prmRamIdxT2"]							= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmRamIdxT2);
			$this->UnitData["prmRamIdxT3"]							= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmRamIdxT3);
			$this->UnitData["prmRamIdxT4"]							= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmRamIdxT4);

			// Speed
			$this->UnitData["prmHALTaho1"]							= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmHALTaho1);
			$this->UnitData["prmHALTaho2"]							= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmHALTaho2);

			// Bypass
			$this->UnitData["prmRamIdxBypassActualState"]			= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmRamIdxBypassActualState);
			$this->UnitData["prmBypassTmin"]						= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmBypassTmin);
			$this->UnitData["prmBypassTmax"]						= $this->ModbusRead_Float		(PLUGGIT_MODBUS_ADDR_PrmBypassTmax);
			$this->UnitData["prmRamIdxBypassManualTimeout"]			= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmRamIdxBypassManualTimeout);

			// Filter
			$this->UnitData["prmFilterRemainingTime"]				= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmFilterRemainingTime);
			$this->UnitData["prmFilterDefaultTime"]					= $this->ModbusRead_UnsignedInt	(PLUGGIT_MODBUS_ADDR_PrmFilterDefaultTime);
		}



		//-------------------------------------------------------------------//
		// Section: SetParam
		//-------------------------------------------------------------------//
		function	SetParam($Param, $Value)
		{
			// Make a string's first character uppercase
			$FunctionName = 'SetParam_'.ucfirst ( $Param);

			return call_user_func_array(array($this, $FunctionName), array($Param, $Value) );
		}


		//----------------------------//
		private function SetParam_PrmRomIdxSpeedLevel($Param, $Value)
		{
			if ($Value >= 0 && $Value <= 4 )
			{
				// Set Current Mode to manual
				//$this->SetParam( 'prmRamIdxUnitMode',		PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_MANUAL);

				// Change Speed
				$this->ModbusWrite_UnsignedInt( PLUGGIT_MODBUS_ADDR_PrmRomIdxSpeedLevel,	$Value);

				return 0;

			} else
			{
				return 1;
			}
		}

		//----------------------------//
		private function SetParam_PrmRamIdxUnitMode($Param, $Value)
		{
			if (	$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_DEMAND			||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_MANUAL			||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_WEEKPROGRAM		||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_AWAY				||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_FIREPLACE		||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_SUMMER			||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_ENABLE	||
					$Value == PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_DISABLE		)
			{
				// Change Unit Mode
				$this->ModbusWrite_UnsignedInt( PLUGGIT_MODBUS_ADDR_PrmRamIdxUnitMode,	$Value);

				return 0;

			} else
			{
				return 1;
			}
		}



		//-------------------------------------------------------------------//
		// Section: GetParam
		//-------------------------------------------------------------------//
		function	GetParam($Param, $ViewOption)
		{
			// Make a string's first character uppercase
			$FunctionName = 'GetParam_'.ucfirst ( $Param);

			return call_user_func_array(array($this, $FunctionName), array($Param, $ViewOption) );
		}


		//----------------------------//
		private function GetParam_PrmDateTime($Param, $ViewOption)
		{
			return $this->Convert_Time($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmWorkTime($Param, $ViewOption)
		{
			return	$this->UnitData[$Param];
		}

		//----------------------------//
		private function GetParam_PrmStartExploitationDateStamp($Param, $ViewOption)
		{
			return $this->Convert_Time($this->UnitData[$Param], $ViewOption);
		}


		//----------------------------//
		private function GetParam_PrmCurrentBLState($Param, $ViewOption)
		{
			switch( strtolower ($ViewOption) )
			{
				case strtolower ('Clear') :

					switch( $this->UnitData[$Param] )
					{
						case 0	:	return 'Standby'							; break;
						case 1	:	return 'Manual'								; break;
						case 2	:	return 'Demand'								; break;
						case 3	:	return 'Week program'						; break;
						case 4	:	return 'Servo-flow'							; break;
						case 5	:	return 'Away'								; break;
						case 6	:	return 'Summer'								; break;
						case 7	:	return 'DI Override'						; break;
						case 8	:	return 'Hygrostat override'					; break;
						case 9	:	return 'Fireplace'							; break;
						case 10	:	return 'Installer'							; break;
						case 11	:	return 'Fail Safe 1'						; break;
						case 12	:	return 'Fail Safe 2'						; break;
						case 13	:	return 'Fail Off'							; break;
						case 14	:	return 'Defrost Off'						; break;
						case 15	:	return 'Defrost'							; break;
						case 16	:	return 'Night'								; break;
						default	:	return 'Unknwon '.$this->UnitData[$Param]	; break;
					}
					break;

				case strtolower ('Raw') :
				default:
					return $this->UnitData[$Param];
					break;
			}
		}

		//----------------------------//
		private function GetParam_PrmRamIdxUnitMode($Param, $ViewOption)
		{
			switch( strtolower ($ViewOption) )
			{
				case strtolower ('Clear') :

					switch( $this->UnitData[$Param] )
					{
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_DEMAND			:	return 'Demand'								; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_MANUAL			:	return 'Manual'								; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_WEEKPROGRAM		:	return 'WeekProgram'						; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_AWAY				:	return 'Away'								; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_FIREPLACE			:	return 'Fireplace'							; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_SUMMER			:	return 'Summer'								; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_ENABLE		:	return 'Bypass Enable'						; break;
						case PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_DISABLE	:	return 'Bypass Disable'						; break;
						default														:	return 'Unknwon '.$this->UnitData[$Param]	; break;
					}
					break;

				case strtolower ('Raw') :
				default:
					return $this->UnitData[$Param];
					break;
			}
		}

		//----------------------------//
		private function GetParam_PrmRomIdxSpeedLevel($Param, $ViewOption)
		{
			return $this->UnitData[$Param];
		}

		//----------------------------//
		private function GetParam_PrmPreheaterDutyCycle($Param, $ViewOption)
		{
			return $this->UnitData[$Param];
		}


		//----------------------------//
		private function GetParam_PrmRamIdxT1($Param, $ViewOption)
		{
			return $this->Convert_Temperature($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmRamIdxT2($Param, $ViewOption)
		{
			return $this->Convert_Temperature($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmRamIdxT3($Param, $ViewOption)
		{
			return $this->Convert_Temperature($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmRamIdxT4($Param, $ViewOption)
		{
			return $this->Convert_Temperature($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmHALTaho1($Param, $ViewOption)
		{
			return $this->Convert_Speed($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmHALTaho2($Param, $ViewOption)
		{
			return $this->Convert_Speed($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmRamIdxBypassActualState($Param, $ViewOption)
		{
			switch( strtolower ($ViewOption) )
			{
				case strtolower ('Clear') :

					switch( $this->UnitData[$Param] )
					{
						case 0	:	return 'Closed'								; break;
						case 1	:	return 'In process'							; break;
						case 32	:	return 'Closing'							; break;
						case 64	:	return 'Opening'							; break;
						case 255:	return 'Opened'								; break;
						default	:	return 'Unknwon '.$this->UnitData[$Param]	; break;
					}
					break;

				case strtolower ('Raw') :
				default:
					return $this->UnitData[$Param];
					break;
			}
		}

		//----------------------------//
		private function GetParam_PrmBypassTmin($Param, $ViewOption)
		{
			return $this->Convert_Temperature($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmBypassTmax($Param, $ViewOption)
		{
			return $this->Convert_Temperature($this->UnitData[$Param], $ViewOption);
		}

		//----------------------------//
		private function GetParam_PrmRamIdxBypassManualTimeout($Param, $ViewOption)
		{
			return $this->UnitData[$Param];
		}


		//----------------------------//
		private function GetParam_PrmFilterRemainingTime($Param, $ViewOption)
		{
			return $this->UnitData[$Param];
		}

		//----------------------------//
		private function GetParam_PrmFilterDefaultTime($Param, $ViewOption)
		{
			return $this->UnitData[$Param];
		}




		//-------------------------------------------------------------------//
		// Section: GetHtml
		//-------------------------------------------------------------------//
		function	GetHtml($Param)
		{
			// Make a string's first character uppercase
			$FunctionName = 'GetHtml_'.ucfirst ( $Param);

			return call_user_func(array($this, $FunctionName), $Param );
		}

		//----------------------------//
		private function GetHtml_PrmDateTime($Param)
		{
			return $this->CreateHtmlInput_Time($Param);
		}

		//----------------------------//
		private function GetHtml_PrmWorkTime($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw') );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear') ).'[h]';

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmStartExploitationDateStamp($Param)
		{
			return $this->CreateHtmlInput_Time($Param);
		}

		//----------------------------//
		private function GetHtml_PrmCurrentBLState($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw') );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear') );

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmRamIdxUnitMode($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw') );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear') );

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmRomIdxSpeedLevel($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw') );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear') );

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmPreheaterDutyCycle($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw') );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear') ).'[%]';

			return $Html;

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmRamIdxT1($Param)
		{
			return $this->CreateHtmlInput_Temperature($Param);
		}

		//----------------------------//
		private function GetHtml_PrmRamIdxT2($Param)
		{
			return $this->CreateHtmlInput_Temperature($Param);
		}

		//----------------------------//
		private function GetHtml_PrmRamIdxT3($Param)
		{
			return $this->CreateHtmlInput_Temperature($Param);
		}

		//----------------------------//
		private function GetHtml_PrmRamIdxT4($Param)
		{
			return $this->CreateHtmlInput_Temperature($Param);
		}

		//----------------------------//
		private function GetHtml_PrmHALTaho1($Param)
		{
			return $this->CreateHtmlInput_Speed($Param);
		}

		//----------------------------//
		private function GetHtml_PrmHALTaho2($Param)
		{
			return $this->CreateHtmlInput_Speed($Param);
		}

		private function GetHtml_PrmRamIdxBypassActualState($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw') );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear') );

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmBypassTmin($Param)
		{
			return $this->CreateHtmlInput_Temperature($Param);
		}

		//----------------------------//
		private function GetHtml_PrmBypassTmax($Param)
		{
			return $this->CreateHtmlInput_Temperature($Param);
		}

		private function GetHtml_PrmRamIdxBypassManualTimeout($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw'	) );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear'	) ).'[min]';

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmFilterRemainingTime($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw'	) );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear'	) ).'[days]';

			return $Html;
		}

		//----------------------------//
		private function GetHtml_PrmFilterDefaultTime($Param)
		{
			$Html  =	$this->CreateHtmlInput('hidden',	$Param,				$this->GetParam($Param, 'Raw'	) );
			$Html .=	$this->CreateHtmlInput('text',		$Param.'_Clear',	$this->GetParam($Param, 'Clear'	) ).'[days]';

			return $Html;
		}


		//-------------------------------------------------------------------//
		// Section: Convert
		//-------------------------------------------------------------------//
		function Convert_Time($UnixTime, $Option)
		{
			switch(strtolower ($Option) )
			{
				case strtolower ('DateTime_Year')		:	return gmdate("Y",						$UnixTime)	;	break;
				case strtolower ('DateTime_Month')		:	return gmdate("m",						$UnixTime)	;	break;
				case strtolower ('DateTime_Day')		:	return gmdate("d",						$UnixTime)	;	break;
				case strtolower ('DateTime_Hours')		:	return gmdate("H",						$UnixTime)	;	break;
				case strtolower ('DateTime_Minutes')	:	return gmdate("i",						$UnixTime)	;	break;
				case strtolower ('DateTime_Seconds')	:	return gmdate("s",						$UnixTime)	;	break;
				case strtolower ('LoxTime')				:	return $UnixTime - (14245 * 24 *60 *60)				;	break;
				case strtolower ('Clear')				:	return gmdate("Y-m-d; H:i:s",			$UnixTime)	;	break;
				case strtolower ('Raw')					:
				default									:	return $UnixTime;									;	break;
			}
		}

		//-----------------------------------------------------------------------//
		function Convert_Temperature($Temperature, $Option)
		{
			switch(strtolower ($Option) )
			{
				case strtolower ('Clear')				:	return round($Temperature, $this->TemperatureResulution);	;	break;
				case strtolower ('Raw')					:
				default									:	return $Temperature;										;	break;
			}
		}

		//-----------------------------------------------------------------------//
		function Convert_Speed($Speed, $Option)
		{
			switch(strtolower ($Option) )
			{
				case strtolower ('Clear')				:	return round($Speed, $this->SpeedResulution);	;	break;
				case strtolower ('Raw')					:
				default									:	return $Speed;									;	break;
			}
		}

		//-------------------------------------------------------------------//
		// Section: ModBus
		//-------------------------------------------------------------------//
		private function ModbusRead_Float($Register)
		{
			$Modbus = new ModbusMaster($this->Host, $this->Protocol);
			$RecData = $Modbus->readMultipleRegisters(0, $Register, 2);

			$Values = array_chunk($RecData, 4);

			foreach($Values as $Bytes)
				return PhpType::bytes2float($Bytes);
		}

		private function ModbusRead_UnsignedInt($Register)
		{
			$Modbus = new ModbusMaster($this->Host, $this->Protocol);
			$RecData = $Modbus->readMultipleRegisters(0, $Register, 20);

			$Values = array_chunk($RecData, 4);

			foreach($Values as $Bytes)
				return PhpType::bytes2unsignedInt($Bytes);
		}

		private function ModbusWrite_UnsignedInt($Register, $Value)
		{
			$Modbus = new ModbusMaster($this->Host, $this->Protocol);

			$Data		= array($Value, 0);
			$DataTypes	= array("INT", "INT");

			try
			{
				$Modbus->writeMultipleRegister(0, $Register, $Data, $DataTypes);
			}
			catch (Exception $E)
			{
				// Print error information if any
				echo $Modbus;
				echo $E;
				exit;
			}

			return 0;
		}

		//-------------------------------------------------------------------//
		// HTML Section
		//-------------------------------------------------------------------//
		private function CreateHtmlInput($Type, $Name, $Value)
		{
			$Html	 =	"\n";
			$Html	.=	'<input type="'.$Type.'"	name="'.$Name.'" value="'.$Value.'"/>';

			return $Html;
		}

		private function CreateHtmlInput_Time($Param)
		{
			$Html	 =	$this->CreateHtmlInput('hidden',	$Param,						$this->GetParam($Param, 'Raw'				) );
			$Html	.=	$this->CreateHtmlInput('text',		$Param.'_Clear',			$this->GetParam($Param, 'Clear'				) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_LoxTime',			$this->GetParam($Param, 'LoxTime'			) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_DateTime_Year',	$this->GetParam($Param, 'DateTime_Year'		) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_DateTime_Month',	$this->GetParam($Param, 'DateTime_Month'	) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_DateTime_Day',		$this->GetParam($Param, 'DateTime_Day'		) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_DateTime_Hours',	$this->GetParam($Param, 'DateTime_Hours'	) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_DateTime_Minutes',	$this->GetParam($Param, 'DateTime_Minutes'	) );
			$Html	.=	$this->CreateHtmlInput('hidden',	$Param.'_DateTime_Seconds',	$this->GetParam($Param, 'DateTime_Seconds'	) );

			return $Html;
		}

		private function CreateHtmlInput_Temperature($Param)
		{
			$Html	 =	$this->CreateHtmlInput('hidden',	$Param,						$this->GetParam($Param, 'Raw'				) );
			$Html	.=	$this->CreateHtmlInput('text',		$Param.'_Clear',			$this->GetParam($Param, 'Clear'				) ).'[&deg;C]';
			return $Html;
		}

		private function CreateHtmlInput_Speed($Param)
		{
			$Html	 =	$this->CreateHtmlInput('hidden',	$Param,						$this->GetParam($Param, 'Raw'				) );
			$Html	.=	$this->CreateHtmlInput('text',		$Param.'_Clear',			$this->GetParam($Param, 'Clear'				) ).'[rpm]';
			return $Html;
		}

	} // class PluggitAP190
?>
