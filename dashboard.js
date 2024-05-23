document.addEventListener('DOMContentLoaded', function () {
    const roomTableBody = document.getElementById('room-table-body');
    const roomTypeDropdown = document.getElementById('room-type-dropdown');
    
    roomTypeDropdown.addEventListener('change', filterRoomsByType);

    // Load rooms from local storage
    function loadRooms() {
      const rooms = JSON.parse(localStorage.getItem('rooms')) || [];
      rooms.forEach(room => addRoomToTable(room));
    }
    
    // Add room to table
    function addRoomToTable(room) {
      const row = document.createElement('tr');
      row.dataset.roomType = room.roomType;
      row.innerHTML = `
        <td>${room.room_id}</td>
        <td>${room.roomType}</td>
        <td>${room.roomName}</td>
        <td>${room.roomCapacity}</td>
        <td class="room-status">${room.roomAvailable}</td>
        <td>${room.roomAmenities}</td>
        <td>${room.roomRate}</td>
        <td><button class="update-button">Update</button></td>
        <td><button class="delete-button">Delete</button></td>
      `;
      roomTableBody.appendChild(row);
    
      // Update button functionality
      row.querySelector('.update-button').addEventListener('click', () => editRoom(row, room.room_id));
      // Delete button functionality
      row.querySelector('.delete-button').addEventListener('click', () => deleteRoom(row, room.room_id));
    }
    
    // Edit room
    function editRoom(row, roomId) {
      const cells = row.querySelectorAll('td');
      const roomData = {
        room_id: cells[0].textContent,
        roomType: cells[1].textContent,
        roomName: cells[2].textContent,
        roomCapacity: cells[3].textContent,
        roomAvailable: cells[4].textContent,
        roomAmenities: cells[5].textContent,
        roomRate: cells[6].textContent
      };
    
      row.innerHTML = `
        <td><input type="number" class="edit-input" value="${roomData.room_id}" disabled></td>
        <td><input type="text" class="edit-input" value="${roomData.roomType}"></td>
        <td><input type="text" class="edit-input" value="${roomData.roomName}"></td>
        <td><input type="number" class="edit-input" value="${roomData.roomCapacity}"></td>
        <td>
          <select class="edit-select">
            <option value="AVAILABLE" ${roomData.roomAvailable === 'AVAILABLE' ? 'selected' : ''}>Available</option>
            <option value="RESERVED" ${roomData.roomAvailable === 'RESERVED' ? 'selected' : ''}>Reserved</option>
          </select>
        </td>
        <td><input type="text" class="edit-input" value="${roomData.roomAmenities}"></td>
        <td><input type="number" step="0.01" class="edit-input" value="${roomData.roomRate}"></td>
        <td><button class="save-button">Save</button></td>
        <td><button class="cancel-button">Cancel</button></td>
      `;
    
      row.querySelector('.save-button').addEventListener('click', () => saveRoom(row, roomId));
      row.querySelector('.cancel-button').addEventListener('click', () => cancelEditRoom(row, roomData));
    }
    
    // Save room
    function saveRoom(row, roomId) {
      const inputs = row.querySelectorAll('.edit-input, .edit-select');
      const updatedRoomData = {
        room_id: inputs[0].value,
        roomType: inputs[1].value,
        roomName: inputs[2].value,
        roomCapacity: inputs[3].value,
        roomAvailable: inputs[4].value,
        roomAmenities: inputs[5].value,
        roomRate: inputs[6].value
      };
    
      let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
      rooms = rooms.map(room => room.room_id === roomId ? updatedRoomData : room);
      localStorage.setItem('rooms', JSON.stringify(rooms));
    
      // Replace row content with updated data
      row.innerHTML = `
        <td>${updatedRoomData.room_id}</td>
        <td>${updatedRoomData.roomType}</td>
        <td>${updatedRoomData.roomName}</td>
        <td>${updatedRoomData.roomCapacity}</td>
        <td class="room-status">${updatedRoomData.roomAvailable}</td>
        <td>${updatedRoomData.roomAmenities}</td>
        <td>${updatedRoomData.roomRate}</td>
        <td><button class="update-button">Update</button></td>
        <td><button class="delete-button">Delete</button></td>
      `;
    
      row.querySelector('.update-button').addEventListener('click', () => editRoom(row, updatedRoomData.room_id));
      row.querySelector('.delete-button').addEventListener('click', () => deleteRoom(row, updatedRoomData.room_id));
    }
    
    // Cancel edit room
    function cancelEditRoom(row, roomData) {
      row.innerHTML = `
        <td>${roomData.room_id}</td>
        <td>${roomData.roomType}</td>
        <td>${roomData.roomName}</td>
        <td>${roomData.roomCapacity}</td>
        <td class="room-status">${roomData.roomAvailable}</td>
        <td>${roomData.roomAmenities}</td>
        <td>${roomData.roomRate}</td>
        <td><button class="update-button">Update</button></td>
        <td><button class="delete-button">Delete</button></td>
      `;
    
      row.querySelector('.update-button').addEventListener('click', () => editRoom(row, roomData.room_id));
      row.querySelector('.delete-button').addEventListener('click', () => deleteRoom(row, roomData.room_id));
    }
    
    // Delete room
    function deleteRoom(row, roomId) {
      row.remove();
      let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
      rooms = rooms.filter(r => r.room_id !== roomId);
      localStorage.setItem('rooms', JSON.stringify(rooms));
    }
    
    // Filter rooms by type
    function filterRoomsByType() {
      const selectedType = roomTypeDropdown.value;
      const rows = roomTableBody.querySelectorAll('tr');
      rows.forEach(row => {
        if (selectedType === 'all' || row.dataset.roomType === selectedType) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
    
    loadRooms();
  });
