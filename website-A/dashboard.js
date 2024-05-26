document.addEventListener("DOMContentLoaded", function() {
  function fetchData() {
    fetch('dashboard.php')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.text();
      })
      .then(data => {
        document.querySelector('.dashboard-container table tbody').innerHTML = data;
      })
      .catch(error => console.error('Error fetching data:', error));
  }

  function deleteRow(roomId, row) {
    fetch('delete.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `room_id=${roomId}`
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to delete row');
        }
        return response.json();
      })
      .then(data => {
        if (data.message === 'Row deleted successfully.') {
          row.remove(); // Remove the row from the DOM
          showDeleteSuccessMessage(); // Show delete success message
        } else {
          console.error('Failed to delete row:', data.message);
        }
      })
      .catch(error => console.error('Error deleting row:', error));
  }

  fetchData();

  document.querySelector('.dashboard-container table tbody').addEventListener('click', function(event) {
    if (event.target.classList.contains('delete')) {
      event.preventDefault(); // Prevent the default behavior of the anchor tag or button
      const roomId = event.target.parentNode.querySelector('[name="room_id"]').value;
      const row = event.target.closest('tr');
      deleteRow(roomId, row);
    }

    if (event.target.classList.contains('edit')) {
      event.preventDefault();
      const roomId = event.target.parentNode.querySelector('[name="room_id"]').value;
      window.location.href = `edit.html?room_id=${roomId}`;
    }
  });

  // Function to show delete success message
  function showDeleteSuccessMessage() {
    const messageContainer = document.querySelector('.delete-message');
    messageContainer.textContent = 'Room deleted successfully.';
    // Clear the message after 3000ms (3 seconds)
    setTimeout(() => {
      messageContainer.textContent = '';
    }, 3000);
  }
});


function updateRoomAmenities() {
  // Get all checked checkboxes
  const checkedBoxes = document.querySelectorAll('input[type="checkbox"]:checked');

  // Convert the NodeList of checked checkboxes to an array
  // Map over the array and get the value of each checkbox
  // Join the array into a comma-separated string
  const amenities = Array.from(checkedBoxes).map(checkbox => checkbox.value).join(',');

  // Send a POST request to update the room amenities
  fetch('update.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `room_id=${roomId}&amenities=${amenities}`
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Failed to update room amenities');
    }
    return response.json();
  })
  .then(data => {
    if (data.message === 'Room amenities updated successfully.') {
      console.log('Room amenities updated successfully');
    } else {
      console.error('Failed to update room amenities:', data.message);
    }
  })
  .catch(error => console.error('Error updating room amenities:', error));
}
