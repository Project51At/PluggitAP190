
<?php
	/**
	 * @author				Helge Klug
	 * @copyright			Copyright (c) 2018 Helge Klug
	 * @version				1.0.0
	 */



	error_reporting( E_ALL );
	ini_set( 'display_errors', 1 );
	ini_set( 'html_errors', 'On' );

	set_time_limit(0);
	require_once dirname(__FILE__) .'/Pluggit/src/PluggitAP190.php';

	$Mode				=	isset( $_GET["Mode"])		? htmlspecialchars($_GET["Mode"])		: 'GetHTML';	// GetHTML
																												// GetJSON
																												// SetParam



	$SetParam			=	isset( $_GET["Param"])		? htmlspecialchars($_GET["Param"])		: 0;
	$SetValue			=	isset( $_GET["Value"])		? htmlspecialchars($_GET["Value"])		: 0;


	$Pluggit = new PluggitAP190('192.168.199.70');
	$Pluggit->GetUnitData();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Pluggit data read/write via Modbus</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="./../_Common/css/default.css"/>
	</head>
	<body>
		<form class="register" method="POST">
			<h1>Pluggit - Ventilation unit</h1>

			<?php if (strtolower ($Mode) == strtolower ('GetHTML')){ ?>
				<!-- --------------------------------------------------------->
				<fieldset class="row1">
					<legend>Time</legend>
					<p>
						<label>Current Date</label>
						<?php echo $Pluggit->GetHtml('prmDateTime')	?>
					</p>
					<p>
						<label>Work time of system</label>
						<?php echo $Pluggit->GetHtml('prmWorkTime')	?>
					</p>
					<p>
						<label>Date Stamp of the system start</label>
						<?php echo $Pluggit->GetHtml('prmStartExploitationDateStamp')	?>
					</p>

					<div class="clear"></div>
				</fieldset>

				<!-- --------------------------------------------------------->
				<fieldset class="row1">
					<legend>General</legend>
					<p>
						<label>Current unit state</label>
						<?php echo $Pluggit->GetHtml('prmCurrentBLState')	?>
					</p>

					<p>
						<label>Active unit mode</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxUnitMode')	?>
					</p>

					<p>
						<label>Speed level of Fans</label>
						<?php echo $Pluggit->GetHtml('prmRomIdxSpeedLevel')	?>
					</p>
					<p>
						<label>Power of Preheater</label>
						<?php echo $Pluggit->GetHtml('prmPreheaterDutyCycle')	?>
					</p>

					<div class="clear"></div>
				</fieldset>


				<!-- --------------------------------------------------------->
				<fieldset class="row1">
					<legend>Temperature</legend>
					<p>
						<label>Outdoor temperature (T1)</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxT1')	?>
					</p>
					<p>
						<label>Supply  temperature (T2)</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxT2')	?>
					</p>
					<p>
						<label>Extract temperature (T3)</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxT3')	?>
					</p>
					<p>
						<label>Exhaust temperature (T4)</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxT4')	?>
					</p>

					<div class="clear"></div>
				</fieldset>

				<!-- --------------------------------------------------------->
				<fieldset class="row1">
					<legend>Fan</legend>

					<p>
						<label>Fan1</label>
						<?php echo $Pluggit->GetHtml('prmHALTaho1')	?>
					</p>

					<p>
						<label>Fan2</label>
						<?php echo $Pluggit->GetHtml('prmHALTaho2')	?>
					</p>
					<div class="clear"></div>
				</fieldset>


				<!-- --------------------------------------------------------->
				<fieldset class="row1">
					<legend>Bypass</legend>

					<p>
						<label>Bypass state</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxBypassActualState')	?>
					</p>
					<p>
						<label>Min temperature for outdoor air (T1)</label>
						<?php echo $Pluggit->GetHtml('prmBypassTmin')	?>
					</p>
					<p>
						<label>Max temperature for extract air (T3)</label>
						<?php echo $Pluggit->GetHtml('prmBypassTmax')	?>
					</p>

					<p>
						<label>Manual bypass duration in minutes</label>
						<?php echo $Pluggit->GetHtml('prmRamIdxBypassManualTimeout')	?>
					</p>
					<div class="clear"></div>
				</fieldset>


				<!-- --------------------------------------------------------->
				<fieldset class="row1">
					<legend>Filter</legend>

					<p>
						<label>Filter Lifetime</label>
						<?php echo $Pluggit->GetHtml('prmFilterDefaultTime')	?>
					</p>

					<p>
						<label>Remaining time of the Filter Lifetime</label>
						<?php echo $Pluggit->GetHtml('prmFilterRemainingTime')	?>
					</p>
					<div class="clear"></div>
				</fieldset>

			<?php } else if (strtolower ($Mode) == strtolower ('GetJSON')){ ?>

				<fieldset class="row1">
					<legend>JSON</legend>

					<p>
						Not Implemented
					</p>

					<div class="clear"></div>
				</fieldset>


			<?php
			}
			elseif (	(strtolower ($Mode) == strtolower ('SetParam'))		)
			{
				switch( strtolower ($SetParam) )
				{
					case strtolower ('SetSpeedLevel')		:
					case strtolower ('prmRomIdxSpeedLevel') :
						$SetReturn = $Pluggit->SetParam('prmRomIdxSpeedLevel', $SetValue);
						break;

					//-----------------------------------------------//
					case strtolower ('SetUnitMode') :
					case strtolower ('prmRamIdxUnitMode') :
						$SetReturn = $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeManual') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_MANUAL;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeWeekProgram') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_WEEKPROGRAM;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeAwayStart') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_AWAY_START;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeAwayStop') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_AWAY_STOP;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeFirePlaceStart') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_FIREPLACE_START;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeFirePlaceStop') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_FIREPLACE_STOP;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeSummerStart') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_SUMMER_START;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeSummerStop') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_SUMMER_STOP;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeBypassStart') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_START;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;

					case strtolower ('SetUnitModeBypassStop') :
						$SetValue	= PLUGGIT_MODBUS_SET_PrmRamIdxUnitMode_BYPASS_STOP;
						$SetReturn	= $Pluggit->SetParam('prmRamIdxUnitMode', $SetValue);
						break;


					default:
						$SetReturn	= 1;
					break;
				} // Switch

			?>

				<fieldset class="row1">
					<legend>Changed Parameter</legend>
						<p>
							<label>SetParam</label>
							<input type="text"		name="SetParam"				value="<?php echo $SetParam?>"/>
						</p>

						<p>
							<label>SetValue</label>
							<input type="text"		name="SetValue"				value="<?php echo $SetValue?>"/>
						</p>

						<p>
							<label>SetReturn</label>
							<input type="text"		name="SetReturn"			value="<?php echo $SetReturn?>"/>
						</p>

						<p>
							<label>DateTime</label>
							<input type="text"		name="CallDateTime"			value="<?php echo Convert_Time("CLEAR", date('U')) ?>"/>
						</p>

					<div class="clear"></div>

				</fieldset>


			<?php } else { ?>
				<fieldset class="row1">
					<legend>JSON</legend>

					<p>
						Unknown Mode
					</p>

					<div class="clear"></div>
				</fieldset>
			<?php } ?>

			<!-- ------------------------------------------------------------->
			<div class="clear"></div>


		</form>
	</body>
</html>


