<!DOCTYPE html>
<html>
<head>
    <title>Laravel Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style type="text/css">
    .notification {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #28a745; /* Default to success (green) */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: 9999;
}

.notification.error {
    background-color: #dc3545; /* Red for errors */
}

</style>
<body>
    <div id="notification" class="notification" style="display: none;"></div>
    <div id="calendar"></div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    @include('calender.modal.eventmodal')
    @include('calender.modal.eventeditmodal')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/calendar-events',  // Fetch events from the backend
                selectable: true,            // Enable selection of date range
                select: function (info) {
                    // Populate hidden fields with selected dates (start and end)
                    document.getElementById('eventStart').value = info.startStr;
                    document.getElementById('eventEnd').value = info.endStr;

                    // Show the modal to create the event
                    var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    eventModal.show();
                },
                eventClick: function(info) {
                    $('#editEventId').val(info.event.id);
                    $('#editEventTitle').val(info.event.title);
                    var localDate = new Date(info.event.start);
                    var year = localDate.getFullYear();
                    var month = (localDate.getMonth() + 1).toString().padStart(2, '0');
                    var day = localDate.getDate().toString().padStart(2, '0');
                    var formattedDate = `${year}-${month}-${day}`;
                    $('#editEventStart').val(formattedDate);
                    var editModal = new bootstrap.Modal(document.getElementById('editEventModal'));
                    editModal.show();
                }
            });

            // Render the calendar
            calendar.render();

            document.getElementById('saveEventButton').addEventListener('click', function () {
                var title = document.getElementById('eventTitle').value;
                var start = document.getElementById('eventStart').value;

                if (title) {
                    // Send event to backend
                    $.ajax({
                        url: '/add/calendar-events', // Update with your route
                        type: 'POST',
                        data: {
                            title: title,
                            start: start,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (event) {
                            calendar.addEvent(event);
                            var eventModal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
                            eventModal.hide();
                            $('#eventForm')[0].reset();
                            showNotification('Event added successfully!', 'success');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            showNotification('Failed to add event. Please try again.', 'error');
                        }
                    });
                } else {
                    showNotification('Event title is required.', 'error');
                }
            });
        });

        $('#saveEditEvent').on('click', function () {
        var eventId = $('#editEventId').val();
        var title = $('#editEventTitle').val();
        var start = $('#editEventStart').val();
        var end = $('#editEventEnd').val();

        // Send AJAX request to update the event
        $.ajax({
            url: '/update/calendar-events/' + eventId, // Update URL with event ID
            type: 'PUT',
            data: {
                title: title,
                start: start,
                end: end,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (updatedEvent) {
                showNotification('Event updated successfully!', 'success');
                var eventModal = bootstrap.Modal.getInstance(document.getElementById('editEventModal'));
                eventModal.hide();
                $('#editEventForm')[0].reset();
                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showNotification('Failed to update event. Please try again.', 'error');
            }
        });
    });

    function showNotification(msg, status) {
        var notification = document.getElementById('notification');

        // Set the message text
        notification.textContent = msg;

        // Set the background color based on the status
        if (status === 'success') {
            notification.classList.remove('error');
            notification.classList.add('success');
        } else {
            notification.classList.remove('success');
            notification.classList.add('error');
        }

        // Show the notification and fade it in
        notification.style.display = 'block';
        setTimeout(function() {
            notification.style.opacity = 1;
        }, 10);  // Small delay to trigger fade-in effect

        // Hide the notification after 2 seconds
        setTimeout(function() {
            notification.style.opacity = 0;
            setTimeout(function() {
                notification.style.display = 'none';
            }, 500); // Wait for fade-out before hiding the element
        }, 2000); // Hide after 2 seconds
    }

    </script>
</body>
</html>
