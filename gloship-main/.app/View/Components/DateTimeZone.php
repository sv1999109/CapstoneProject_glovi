<?php

namespace App\View\Components;
use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\View\Component;
class DateTimeZone extends Component
{
    public $date;
    public $format;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Carbon $date, $format = null)
    {
        $this->date = $date->setTimezone(\Helpers::getUserTimeZone());
        $this->format = $format;
    }
    protected function format()
    {
        return $this->format ?? 'Y-m-d H:i:s';
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return $this->date->format($this->format());
    }
}
