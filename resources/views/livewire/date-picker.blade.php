<div class="{{ $this->wrapperClasses() }}">
  <div class="litepicker">
    <div class="container__main">
      <div class="container__months">
        <div class="month-item">
          <div class="month-item-header">
            <button type="button" class="button-previous-month" wire:click="goPreviousMonth">
              @lang('Previous month')
            </button>
            <div>
              <strong class="month-item-name">{{ $monthName }}</strong>
              <span class="month-item-year">{{ $year }}</span>
            </div>
            <button type="button" class="button-next-month" wire:click="goNextMonth">
              @lang('Next month')</span>
            </button>
          </div>
          <div class="month-item-weekdays-row">
            @foreach ($weekDays as $index => $name)
            <div title="{{ $name }}">
              {{ \Illuminate\Support\Str::substr($name, 0, 1) }}
            </div>
            @endforeach
          </div>
          <div class="container__days">
            @foreach ($dates as $index => $day)
              @php
                /** @var \Haringsrob\LivewireDatepicker\Dto\DatePickerDayData $dayData */
                $dayData = $this->getAvailabilityFor($day);
              @endphp
              @if ($loop->first)
                @php
                  $skipDays = $this->startWeekOnSunday ? 7 : 6;
                @endphp
                @for ($i = 0; $i < ($day->dayOfWeek === 0 ? $skipDays : ($day->dayOfWeek - ($this->startWeekOnSunday ? 0 : 1))); $i++)
                  <div></div>
                @endfor
              @endif
              <div wire:key="{{$dayData->date->format('ymd')}}"
                class="@if ($this->type === self::TYPE_RANGE_SINGLE) !rounded-l-full !rounded-r-full @endif @if ($this->isStartRange($day)) is-start-date 
                @elseif ($this->isEndRange($day)) is-end-date
                @elseif ($this->isInRange($day)) is-today @endif @if (!$dayData->disabled && !$this->isDisabled($day)) cursor-pointer
                @else
                  cursor-not-allowed
                  opacity-25 
                @endif 
                day-item"
                @if ($dayData->toolTip) x-tooltip.raw.html="{{ $dayData->toolTip }}" @endif
                @if (!$dayData->disabled && !$this->isDisabled($day)) wire:click="triggerDate('{{ $day->format(config('livewire-datepicker.event_date_format')) }}')" @endif>
                <div
                  class="@if ($this->isSelected($day)) border-2 !border-primary-900 text-white shadow-lg
                  @elseif ($day->isToday()) font-bold @endif {{ $dayData->classes ?? '' }} mx-auto flex h-7 w-7 items-center justify-center rounded-full">
                  {{ $day->format('j') }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="container__tooltip"></div>
  </div>
</div>
