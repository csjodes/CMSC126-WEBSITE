document.getElementById('create-room-form').addEventListener('submit', function(event) {
    event.preventDefault();
  
    const roomData = {
        room_id: document.getElementById('room_id').value,
        roomType: document.getElementById('roomType').value,
        roomName: document.getElementById('roomName').value,
        roomCapacity: document.getElementById('roomCapacity').value,
        roomAvailable: document.getElementById('roomAvailable').value === 'true',
        roomAmenities: Array.from(document.getElementById('roomAmenities').selectedOptions).map(option => option.value),
        roomRate: document.getElementById('roomRate').value
    };
  
    console.log('Room Data:', roomData);
  
    // Retrieve existing rooms from local storage or initialize empty array
    const rooms = JSON.parse(localStorage.getItem('rooms')) || [];
    
    // Add new room data to the array
    rooms.push(roomData);
    
    // Save updated array back to local storage
    localStorage.setItem('rooms', JSON.stringify(rooms));
  
    // Optionally, redirect to the dashboard page
    window.location.href = 'dashboard.html';
});
