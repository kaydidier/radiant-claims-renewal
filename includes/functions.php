<?php
function convert($indate)
{
	$seconds = strtotime($indate);

	$nowsec = strtotime(date("Y-m-d"));
	$diff = $seconds - $nowsec;


	$minutes = "";
	$hour = "";
	$days = "";
	$years = "";
	$months = "";
	$flag = "seconds";

	if ($diff > 59) {
		$minutes = round($diff / 60);
		$flag = "minutes";


		if ($minutes > 59) {

			$hours = round($minutes / 60);
			$flag = "hours";

			if ($hours > 23) {

				$days = round($hours / 24);

				$flag = "days";
				if ($days > 30) {
					$months = round($days / 30);
					$flag = "months";


					if ($months > 12) {
						$years = round($months / 12);
						$flag = "years";
					}
				}
			}
		}
	}

	switch ($flag) {
		case 'seconds':
			if ($diff < 0) {
				return "expired";
			} else {
				return "today";
			}
			break;
		case 'minutes':
			return $minutes . " " . $flag;
			break;
		case 'hours':
			return $hours . " " . $flag;
			break;
		case 'days':
			return $days . " " . $flag;
			break;
		case 'months':
			return $months . " " . $flag;
			break;
		case 'years':
			return $years . " " . $flag;
			break;
	}
}

function getInsuranceStatus($startDate, $endDate)
{

	if (date($startDate) > date("Y-m-d")) {
		return "insurance plan has not yet been started";
		/*echo date($row['start_date']);
										echo date("Y-m-d");*/
	} elseif (date($endDate) > date("Y-m-d")/* and date($endDate)>date("Y-m-d")*/) {

		return convert($endDate);
		//echo date($row['start_date']);

	} elseif (date($endDate) == date("Y-m-d")) {
		return "your insurance will end by today";
	} elseif (date($endDate) < date("Y-m-d")) {
		return "your insurance has ended";
	}
}
