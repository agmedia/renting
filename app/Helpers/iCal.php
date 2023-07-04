<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class iCal
{

    /**
     * @var array
     */
    public $events = [];

    /**
     * @var int
     */
    public $event_count = 0;

    /**
     * @var string
     */
    public $target = 'airbnb';


    /**
     * @param string|null $filename
     * @param string|null $target
     */
    public function __construct(string $filename = null, string $target = null)
    {
        if ($target) {
            $this->target = $target;
        }

        if ($filename) {
            return $this->url($filename);
        }

        return $this;
    }


    /**
     * @param string $url
     *
     * @return $this|false
     */
    public function url(string $url)
    {
        if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $string = file_get_contents($url);

        if (stristr($string, 'BEGIN:VCALENDAR') === false) {
            return false;
        }

        if ($this->target == 'booking') {
            $this->makeArrayFromBookingString($string);
        }

        if ($this->target == 'airbnb') {
            $this->makeArrayFromAirbnbString($string);
        }

        return $this;
    }


    /**
     * @param array $events
     *
     * @return string
     */
    public function createFrom(array $events): string
    {
        $str = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\n";

        foreach ($events as $event) {
            $str .= "BEGIN:VEVENT\n";
            $str .= "DTEND;VALUE=DATE:" . Carbon::make($event['to'])->format('Ymd') . "\n";
            $str .= "DTSTART;VALUE=DATE:" . Carbon::make($event['from'])->format('Ymd') . "\n";
            $str .= "UID:" . $event['uid'] . "\n";
            $str .= "DESCRIPTION:Reservation\n";
            $str .= "SUMMARY:Reserved\n";
            $str .= "END:VEVENT\n";
        }

        $str .= "END:VCALENDAR\n";

        return $str;
    }


    /**
     * @return string
     */
    public function returnEmpty(): string
    {
        return "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nEND:VCALENDAR\n";
    }


    /**
     * @param string $string
     *
     * @return array
     */
    private function makeArrayFromAirbnbString(string $string): array
    {
        $data = [];
        // First make sure to find any lines from the .ics that are broken up by a hard return,
        // and append the broken line to the line above.
        // Then break up each line from the .ics file into the array $total_entries
        $string        = preg_replace("'([\r\n])[\s]+'", '', $string);
        $total_entries = preg_split("/[\r\n]+/", $string);

        $event_subcount = 0;

        foreach ($total_entries as $line) {
            if (substr_count($line, 'BEGIN:VEVENT') || $event_subcount > 0) {
                if ($event_subcount > 0 && $event_subcount < 6) {
                    $arr                               = explode(':', $line);
                    $data[$this->event_count][$arr[0]] = $arr[1] . (isset($arr[2]) ? $arr[2] : '') . (isset($arr[3]) ? $arr[3] : '');
                }

                $event_subcount++;

                if ($event_subcount > 5) {
                    $event_subcount = 0;
                    $this->event_count++;
                }
            }
        }

        return $this->setOrderArray($data);
    }


    /**
     * @param string $string
     *
     * @return array
     */
    private function makeArrayFromBookingString(string $string): array
    {
        $data = [];
        $count = 0;
        $events = explode('BEGIN:VEVENT', $string);

        foreach ($events as $i => $event) {
            if ($i) {
                $total_entries = preg_split("/[\r\n]+/", $event);

                foreach ($total_entries as $line) {
                    $get = ['UID:', 'DTSTART;VALUE=DATE:', 'DTEND;VALUE=DATE:', 'SUMMARY:'];

                    foreach ($get as $item) {
                        if (substr_count($line, $item)) {
                            $data[$count][substr($item, 0, -1)] = substr($line, strpos($line, $item) + strlen($item));
                        }
                    }
                }

                $count++;
            }
        }

        return $this->setOrderArray($data);
    }


    /**
     * @param array $data
     *
     * @return array
     */
    private function setOrderArray(array $data): array
    {
        foreach ($data as $key => $event) {
            $sup = [];

            if (isset($event['UID'])) {
                $sup['uid'] = $event['UID'];
            }
            if (isset($event['DTSTART;VALUE=DATE'])) {
                $sup['start'] = $this->getDateString($event['DTSTART;VALUE=DATE']);
            }
            if (isset($event['DTEND;VALUE=DATE'])) {
                $sup['end'] = $this->getDateString($event['DTEND;VALUE=DATE']);
            }
            if (isset($event['SUMMARY'])) {
                $sup['summary'] = $event['SUMMARY'];
            }
            if (isset($event['DESCRIPTION'])) {
                $description = substr($event['DESCRIPTION'], 0, strpos($event['DESCRIPTION'], ' URL '));
                $url         = substr($event['DESCRIPTION'], strpos($event['DESCRIPTION'], ' URL ') + 5, 61);

                $sup['description'] = $description;
                $sup['url']         = $url;
            }

            array_push($this->events, $sup);
        }

        return $this->events;
    }


    /**
     * @param string $string
     * @param bool   $make_date
     *
     * @return Carbon|string|null
     */
    private function getDateString(string $string, bool $make_date = false)
    {
        if ($make_date) {
            return Carbon::make(substr($string, 0, 4) . '-' . substr($string, 4, 2) . '-' . substr($string, 6, 2));
        }

        return substr($string, 0, 4) . '-' . substr($string, 4, 2) . '-' . substr($string, 6, 2);
    }

}
