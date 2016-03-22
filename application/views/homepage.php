<div class="search">
  <p>Search for a booking on
    <select>
      {days}
        <option value="{day}">{day}</option>
      {/days}
    </select>
    at
    <select>
      {times}
        <option value="{time}">{time}</option>
      {/times}
    </select>
    <a href="welcome/search/"
  </p>
</div>
</div>
<div class="facets">
  {facets}
  <div class="facet">
    <a href="welcome/showTimetable/{facet}">{facet} facet</a>
  </div>
  {/facets}
</div>
