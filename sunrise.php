<?php
    header("Content-type: text/xml");

    $lat = 28.54655;
    $long = -81.33543;
    $zenith_angle = ini_get("date.sunrise_zenith");
    $gmt = date('Z')/3600;

    $twlt_begin = date_sunrise(time(),SUNFUNCS_RET_STRING,$lat,$long,$zenith_angle + 18,$gmt);
    $sunrise = date_sunrise(time(),SUNFUNCS_RET_STRING,$lat,$long,$zenith_angle,$gmt);
    $sunset = date_sunset(time(),SUNFUNCS_RET_STRING,$lat,$long,$zenith_angle,$gmt);
    $twlt_end = date_sunset(time(),SUNFUNCS_RET_STRING,$lat,$long,$zenith_angle + 18,$gmt);

    $rise = new DateTime($sunrise);
    $set = new DateTime($sunset);
    $diff = $rise->diff($set);
    $daylight = $diff->format("%H:%I");
    $hrs = date('H', strtotime($daylight));
    $min = date('i', strtotime($daylight));

    $sec_to_zenith = ($hrs * 60 + $min) * 60 / 2;

    $rise_hrs = date('h', strtotime($sunrise));
    $rise_min = date('i', strtotime($sunrise));
    $rise_sec = ($rise_hrs * 60 + $rise_min) * 60;

    date_default_timezone_set ('UTC');
    $zenith = date('H:i', $sec_to_zenith + $rise_sec);

    $y = 2020;
    $m = 4;
    $d = 6;

    $numdays = array(0,31,(28+date('L',strtotime($y))),31,30,31,30,31,31,30,31,30,31);
?>
<CiscoIPPhoneText>
    <Title>Sunrise/Sunset Times</Title>
    <Text>
<?php
    echo "Sunrise: $sunrise ($twlt_begin Twilight)\n";
    echo "Meridian: $zenith (Solar Noon)\n";
    echo "Sunset: $sunset ($twlt_end Twilight)\n";
    echo "Daylight: $hrs hrs $min min";
?>
    </Text>
    <Prompt>These change every day.</Prompt>
</CiscoIPPhoneText>

