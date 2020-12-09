<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvents;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CalendarEventsController extends Controller
{
    public function saveEvents(Request $request)
    {
        $params = $request->all();
        $eventName = Arr::get($params, 'event', '');
        $to = Arr::get($params, 'to', '');
        $from = Arr::get($params, 'from', '');
        $day = Arr::get($params, 'day', '');

        if (empty($eventName) || empty($to) || empty($from) || empty($day)) {
            return 0;
        }

        $start = new DateTime($from);
        $end = new DateTime($to);
        $end = $end->modify('+1 day');

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $end);

        CalendarEvents::query()->truncate();

        foreach ($period as $dt) {
            $dayName = $dt->format("D");
            $date = $dt->format("Y-m-d");

            if (strpos($day, $dayName) !== false) {
                $arr = array();
                $arr = Arr::add($arr, 'event_name', $eventName);
                $arr = Arr::add($arr, 'date', $date);
                CalendarEvents::query()
                    ->create($arr);
            }
        }

        return 1;
    }

    public function getEvents(Request $request)
    {
        $params = $request->all();
        $to = Arr::get($params, 'to', '');
        $from = Arr::get($params, 'from', '');

        if (empty($to) || empty($from)) {
            $currentDate = date('Y-m-d');
            $d = new DateTime($currentDate);
            // todo can be replace end date by requested date
            $endDate = $d->format('Y-m-t');
            $beginDate = $d->format('Y-m-01');

            $to = $endDate;
            $from = $beginDate;
        }

        $datediff = strtotime($to) - strtotime($from);
        $length = round($datediff / (60 * 60 * 24));
        $d = $from;
        $arr = array();
        for ($i = 0; $i <= $length; $i++) {

            $query = CalendarEvents::query()
                ->select('event_name')
                ->where('date', '=', $d)
                ->get();

            $arr[$i] = array(
                'date' => date('d D', strtotime($d)),
                'eventName' => ($query->isEmpty() ? '' : $query->first()->event_name),
            );

            $d = date('Y-m-d', strtotime($d . " + 1 day"));
        }

        return $arr;
    }

    public function getMonth(Request $request)
    {
        $params = $request->all();
        $to = Arr::get($params, 'to', '');
        $from = Arr::get($params, 'from', '');

        if (!empty($to) || !empty($from)) {
            $date = !empty($to) ? $to : $from;
            return date('F Y', strtotime($date));
        }
        return date('F Y');
    }
}
