<?php

if (! empty($greeting)) {
    echo $greeting, "\n\n";
} else {
    echo $level == 'error' ? 'Whoops!' : 'Hello!', "\n\n";
}

if (! empty($introLines)) {
    echo implode("\n", $introLines), "\n\n";
}

if (isset($customerMessage) && count($customerMessage)>=1){
    echo implode("\n", $customerMessage), "\n\n";
    echo implode("\n", $customerContact), "\n\n";
}

if (isset($actionText)) {
    echo "{$actionText}: {$actionUrl}", "\n\n";
}

if (! empty($outroLines)) {
    echo implode("\n", $outroLines), "\n\n";
}

echo trans('strings.notification_regards1') , "\n";
echo trans('strings.notification_regards2',['teamname' => config('app.name')]), "\n";
