document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("create-room-form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Validate the form inputs
        var room_id = parseFloat(document.getElementById("room_id").value);
        var roomType = document.getElementById("roomType").value;
        var roomCapacity = parseFloat(document.getElementById("roomCapacity").value);
        var roomAvailable = document.getElementById("roomAvailable").value;
        var roomAmenities = document.querySelectorAll('input[type="checkbox"]:checked'); // Get all checked checkboxes
        var roomRate = parseFloat(document.getElementById("roomRate").value);

        // Check for empty fields
        if (!room_id || roomType === "" || !roomCapacity || roomAvailable === "" || roomAmenities.length === 0 || !roomRate) {
            alert("Please fill out all fields and select at least one amenity.");
            return; // Exit the function if any field is empty or no amenity is selected
        }

        // If all fields are filled and values are valid, proceed with form submission
        this.submit();
    });
});