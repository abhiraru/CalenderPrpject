<div class="modal" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <div class="mb-3">
                        <label for="editEventTitle" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="editEventTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEventStart" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editEventStart" name="start" required>
                    </div>
                    <input type="hidden" id="editEventId" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deleteEvent()">Delete</button>
                <button type="button" class="btn btn-primary" id="saveEditEvent">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteEvent()
    {
        var eventId = $('#editEventId').val();
        if (!eventId) {
            console.error('Event ID is missing.');
            return;
        }
        $.ajax({
            url: '/delete/calendar-events/' + eventId, // Update URL with event ID
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (updatedEvent) {
                showNotification('Event deleted successfully!', 'success');
                var eventModal = bootstrap.Modal.getInstance(document.getElementById('editEventModal'));
                eventModal.hide();
                $('#editEventForm')[0].reset();
                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showNotification('Failed to delete event. Please try again.', 'error');
            }
        });
    }
</script>