<?php
/**
 * Sidebar
 *
 * Content for our sidebar, provides prompt for logged in users to create widgets
 */
?>

<?php //dynamic_sidebar( 'Sidebar Right' ); ?><!-- -->

<div class="date-picker">
    <label>Events Starts:</label>
    <input id="start_date" type="date" placeholder="Select start date" required>

    <label>Events Ends:</label>
    <input id="end_date" type="date" placeholder="Select end date" required>

    <button id="btn-filter">Filter Button</button>
</div>