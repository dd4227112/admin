<?php

function mailConfig() {
   
}

function timeAgo($datetime, $full = false) {
    return \Carbon\Carbon::createFromTimeStamp(strtotime($datetime))->diffForHumans();
}