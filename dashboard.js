document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch data from the server and populate the table
    function fetchData() {
      fetch('dashboard.php')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          const tableBody = document.querySelector('.dashboard-container table tbody');
          tableBody.innerHTML = ''; // Clear existing table rows
  
          // Populate table with fetched data
          data.forEach(rowData => {
            const row = document.createElement('tr');
            // Loop through each key-value pair in rowData
            Object.entries(rowData).forEach(([key, value]) => {
              const cell = document.createElement('td');
              if (key === 'room_Amenities') {
                // Format room amenities as bullet points
                const amenitiesList = document.createElement('ul');
                const amenities = value.split(',');
                amenities.forEach(amenity => {
                  const amenityItem = document.createElement('li');
                  amenityItem.textContent = amenity.trim();
                  amenitiesList.appendChild(amenityItem);
                });
                amenitiesList.style.paddingLeft = '20px'; // Add padding to the left of the bullet list
                cell.appendChild(amenitiesList);
              } else {
                cell.textContent = value;
              }
              row.appendChild(cell);
            });

            // Add delete button to the last cell
            const deleteButtonCell = document.createElement('td');
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.style.padding = '0px 3px 0 3px'; // Add padding to the delete button
            deleteButton.style.fontSize = '15px';
            deleteButton.style.backgroundColor = 'lightcoral'; // Set background color to light red
            deleteButton.style.borderRadius = '10px'; // Add round border
            deleteButton.addEventListener('click', () => {
              deleteRow(rowData.room_id, row); // Pass the row element to deleteRow function
            });
            deleteButton.addEventListener('mouseenter', () => {
              deleteButton.style.backgroundColor = 'red'; // Dark red color on hover
            });
            deleteButton.addEventListener('mouseleave', () => {
              deleteButton.style.backgroundColor = 'lightcoral'; // Restore light red color when not hovered
            });
            deleteButtonCell.appendChild(deleteButton);
            row.appendChild(deleteButtonCell);

            tableBody.appendChild(row);
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    }

    // Function to delete a row
    function deleteRow(roomId, row) {
      fetch(`delete.php?id=${roomId}`, {
        method: 'DELETE'
      })
      .then(response => {
        if (response.ok) {
          // If deletion is successful, remove the row from the table
          row.remove();
          showDeleteSuccessMessage(roomId); // Show delete success message
        } else {
          console.error('Failed to delete row:', roomId);
        }
      })
      .catch(error => console.error('Error deleting row:', error));
    }

    // Function to display delete success message
    function showDeleteSuccessMessage(roomId) {
      const messageContainer = document.querySelector('.delete-message');
      messageContainer.textContent = `Row ${roomId} deleted.`;
      // Clear the message after 3 seconds
      setTimeout(() => {
        messageContainer.textContent = '';
      }, 3000);
    }
  
    // Call fetchData function when the document is fully loaded
    fetchData();
});
