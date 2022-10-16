<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $string = file_get_contents($url);

        if (stristr($string, 'BEGIN:VCALENDAR') === false) {
            return false;
        }

        $this->makeArrayFromAirbnbString($string);

        return $this;
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

        return $this->setAirbnbArray($data);
    }


    /**
     * @param array $data
     *
     * @return array
     */
    private function setAirbnbArray(array $data): array
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
