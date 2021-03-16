// const title = document.querySelector("#event-title");
// const date_time = document.querySelector("#event-title");
// const title = document.querySelector("#event-title");

// //Validate Form
// function formValidation(){

// }


// // Save New Event
// function saveEvent(){
//     alert("dddd");
// }


//Delete Event


function dropEvent(id){
    const data = { id: id };

        fetch('http://practice.local/wp-json/z-event-rsvp/v1/event/drop', {
        method: 'POST', // or 'PUT'
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
        })
        .then(data => {
            location.reload();
        })
        .catch((error) => {
        console.error('Error:', error);
        });
}

//This Function use Fetch Api to get the RSVP data from the API
function showRsvpList(e,id){
    e.preventDefault();
    fetch(`http://practice.local/wp-json/z-event-rsvp/v1/event/rsvp/${id}`)
    .then(response => response.json())
    .then(data => rsvpListHtml(data));
}

//This function selects the htm table tbody and output rows of rsvp list inside the tbody element
function rsvpListHtml(data){
    const tbody = document.querySelector('#rsvp-list-table-tbody');
    tbody.innerHTML = '';
    for(let i = 0; i< data.length; i++ ){
        tbody.innerHTML += `  <tr>
                            <th scope="row">${i+1 }</th>
                            <td>${data[i].attendee_name}</td>
                            <td>${data[i].attendee_email }</td>
                        </tr>`
    }
}


//Delete Event Confirmation Pop Up Window
function deleteEventConfirmation(event_title){
    const delete_event_confirmation = document.querySelector('.delete-event-confirmation');
    delete_event_confirmation.innerHTML = `<div class="modal-content">
    <div class="media-body p-4">
      <h5>Are you sure you want to delete ${event_title} Event?</h5>
    </div>
    <div class="modal-footer">              
      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button onclick="dropEvent(<?php echo get_the_ID()  ?>)"  class="btn btn-danger">Yes, Delete Event</button>
    </div>
    </div>`
}

