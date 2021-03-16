<?php
/**
 * @package zain
 */

self::handleNewEventForm();
?>


<div class="container-fluid py-4">

    <h2 class="my-4">Events Rsvp</h2>

    <!-- ALL EVENTS LISTING -->
    <div class="d-flex justify-content-between py-4">
            <h3>All Events</h3>
            <button class="btn btn-primary" id="create-new-event" data-bs-toggle="modal" data-bs-target="#createEventModal">Create New Event</button>
    </div>

    <!-- Table -->
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Title</th>
            <th scope="col">Date & Time</th>
            <th scope="col">Venue</th>
            <th scope="col">RSVP</th>
            <th scope="col">Dispay Shortcode</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
              $events = new WP_Query(['post_type'=> 'event']);
              if($events->have_posts()){

                while($events->have_posts()){
                  $events->the_post();
                  $event_id = get_the_ID(); 
          ?>
        <tr>
          <th scope="row"><?php the_title( )?></th>
          <td><?php echo get_post_meta(get_the_ID(),'event_date',true)  ?></td>
          <td><?php echo get_post_meta(get_the_ID(),'event_venue',true)  ?></td>
          <td><button data-bs-toggle="modal" data-bs-target="#exampleModalLong" onclick="showRsvpList(event, <?php echo get_the_ID() ?>)" class='btn btn-primary' <?php if(\Inc\Functions\Rsvp::getRsvpCount(get_the_ID()) < 1): echo 'disabled'; endif; ?>><?php echo \Inc\Functions\Rsvp::getRsvpCount(get_the_ID()) ?></button></td>
          <td>[z-event-rsvp id = <?php echo get_the_ID( )?>]</td>
          <td><button class='btn btn-danger' onclick="dropEvent(<?php echo get_the_ID()  ?>)" data-bs-toggle="modal" data-bs-target="#dropEventModal">Delete Event</button>
        </tr>
        
        <?php
              }
              }
        ?>
        <tbody>
    </table>


</div>


  <!-- Modal Create Event -->
  <div class="modal fade mt-4" id="createEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create New Event RSVP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="event-title" class="form-label">Event Title *</label>
                <input type="text" name="event-title" class="form-control" id="event-title" aria-describedby="eventTitle" requred>
                <span class="error"></span>
              </div>
              <div class="mb-3">
                <label for="event-date-time" class="form-label">Date & TIme *</label>
                <input type="text" name="event-date" class="form-control" id="event-date-time" aria-describedby="eventTitle" requred>
                <span class="error"></span>
              </div>
              <div class="mb-3">
                <label for="event-venue" class="form-label">Venue *</label>
                <input type="text" name="event-venue" class="form-control" id="event-venue" aria-describedby="eventTitle" requred>
                <span class="error"></span>
              </div>
              <div class="mb-3">
                <label for="event-venue" class="form-label">Event Poster *</label>
                <input type="file" name="event-poster" class="form-control" id="event-venue" aria-describedby="eventTitle" requred>
                <span class="error"></span>
              </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Event</button>
            </div>
            </form>
        </div>
      </div>
  </div>



<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">RSVP LIST</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <!-- RSVP Attendee List Modal -->
         <div id="rsvp-list-modal" class="">
            <table class="table table-dark">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody id="rsvp-list-table-tbody">
              </tbody>
            </table>

      </div>
    </div>
  </div>
</div