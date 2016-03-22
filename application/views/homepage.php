<div class="search">
  <form method="post" action="welcome/search">
    Search for a booking on
    <select name="daySelect">
      {days}
        <option value="{day}">{day}</option>
      {/days}
    </select>
    at
    <select name="timeSelect">
      {times}
        <option value="{time}">{time}</option>
      {/times}
    </select>
    <input type='submit' value='Search'>
  </form>
</div>
<div class="facets">
  {facets}
  <div class="facet">
    <a href="welcome/showTimetable/{facet}">{facet} facet</a>
  </div>
  {/facets}
</div>
