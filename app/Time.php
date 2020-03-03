<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Time extends Model {

    protected $table = 'time';
    protected $dates = ['date'];
    public $timestamps = true;

    public function projects() {
        return $this->belongsTo(Projects::class);
    }

    function time_to_decimal($time) {

        $timesplit = explode(':', $time);
        $min = ($timesplit[0] * 60) + ($timesplit[1]) + ($timesplit[2] > 30 ? 1 : 0);
        return $min;
    }

    public function convertToHoursMins($time, $format = '%d Hours and %02d Minutes') {

        if ($time < 1) {
            return;
        }

        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public function getMonthTime($project, $months) {

        $startDay = $project->start;
        $endDay = $project->end;
        $projectHours = $project->hours;
        $percentComplete = array();
        $hoursComplete = array();
        
        $from = Carbon::now()->day($startDay)->startOfDay()->addMonth(1);
        $to = Carbon::now()->day($endDay)->startOfDay()->addMonth(2);
        
        foreach ($months as $month) {
            
            $from->subMonth(1)->toDateTimeString();
            $to->subMonth(1)->toDateTimeString();
            
            $totalMins = $project->time()->whereBetween('date', [$from, $to])->sum('time_logged');

            $hoursToMins = $projectHours * 60;
            $percent = round(( $totalMins / $hoursToMins ) * 100);
            $hoursCompleted = $this->convertToHoursMins($totalMins);
            
            array_push($percentComplete, $percent);
            array_push($hoursComplete, $hoursCompleted);
        }
        
        $result = array();
        $result['percent_complete'] = $percentComplete;
        $result['project_hours'] = $hoursComplete;
        $result['start'] = Carbon::now()->day($startDay)->format('d/m/Y');
        $result['end'] = Carbon::now()->day($endDay)->addMonth(1)->format('d/m/Y');

        return $result;
    }

}
