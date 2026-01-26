let logoutTimer;
const logoutAfter = 60 * 10000; 

//Redirects user to login page after 10 minutes of inactivity
function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(() => {
        // Send a request to the server to log out the user
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = loginUrl; // Redirect after successful logout
            } else {
                // Handle error if logout fails on server
                console.error('Server logout failed.');
                window.location.href = loginUrl; // Still redirect even if server logout fails
            }
        })
        .catch(error => {
            console.error('Network error during logout:', error);
            window.location.href = loginUrl; // Redirect on network error
        });
    }, logoutAfter);
}

window.onload = resetLogoutTimer;
document.onmousemove = resetLogoutTimer;
document.onkeydown = resetLogoutTimer;
document.onclick = resetLogoutTimer;
document.onscroll = resetLogoutTimer;

// Logic for closing reservation modal
const closeReservationModal = document.querySelector('#reservationModalClose')
    if (closeReservationModal){
        document.body.style.overflow="hidden"
        closeReservationModal.addEventListener('click', ()=>{
           document.body.style.overflow="visible"
           const modalContainer = document.querySelector('.modal_container')
           modalContainer.classList.add('fade-out')
           modalContainer.addEventListener('animationend', () => {
              modalContainer.classList.add('d-none');
            });
        })
}
      
// Logic for edit reservation form
    const hiddenRoom = document.querySelector('#hiddenRoom');
    const hiddenCheckIn = document.querySelector('#hiddenCheckIn');
    const hiddenCheckOut = document.querySelector('#hiddenCheckOut');
    const roomSelect = document.querySelector('.edit_select');
    const checkInInput = document.querySelector('#check_in_date');
    const checkOutInput = document.querySelector('#check_out_date');
    const submitButton = document.querySelector('.submit_edit_reservation');
    const hiddenNumberOfRooms = document.querySelector('#hiddenNumberOfRooms');
    const editNumberOfRoomsInput = document.querySelector('#number_of_rooms_input')

    function checkFormChanges() {
        if (hiddenRoom && hiddenCheckIn && hiddenCheckOut && roomSelect && checkInInput && checkOutInput && submitButton && hiddenNumberOfRooms &&editNumberOfRoomsInput) {
        const roomChanged = hiddenRoom.value !== roomSelect.value;
        const checkInChanged = hiddenCheckIn.value !== checkInInput.value;
        const checkOutChanged = hiddenCheckOut.value !== checkOutInput.value;
        const numberOfRoomsChanged = Number(hiddenNumberOfRooms.value) !== Number(editNumberOfRoomsInput.value)
        if (roomChanged || checkInChanged || checkOutChanged || numberOfRoomsChanged) {
            submitButton.disabled = false;
        } 
        else {
            submitButton.disabled = true;
        }
    

    // Add event listeners to the form elements
    roomSelect.addEventListener('change', checkFormChanges);
    checkInInput.addEventListener('change', checkFormChanges);
    checkOutInput.addEventListener('change', checkFormChanges);
    }

    }
    // Run the check once on page load
    checkFormChanges();

    // Review action toggle logic
    const reviewActionToggle = document.querySelectorAll('#review_action_toggle').forEach(toggle=>{
    let clicked = false;    
        if(toggle){
            toggle.addEventListener('click', ()=>{
                const {id} = toggle.dataset;
                if(!clicked){
                    document.querySelector(`.action_${id}`).style.display = 'block';
                    clicked = true;
                }
                else{
                    document.querySelector(`.action_${id}`).style.display = 'none';
                    clicked = false;
                }
                
            })
        }
    });

            
            const roomSelectMain = document.getElementById('room_id');
            const availabilitySpan = document.getElementById('room-availability');
            const numberOfRoomsInput = document.querySelector('#number_of_rooms_input');
            const makeReservationBtn = document.querySelector('#makeReservationBtn');
            const editReservationBtn = document.querySelector('.submit_edit_reservation');
           //checks if the elements exist 
           if (roomSelectMain && availabilitySpan && numberOfRoomsInput && (makeReservationBtn || editReservationBtn)) { 
            const plusIcon= document.querySelector('#plus');
            const minusIcon= document.querySelector('#minus');
            const numberOfRoomsSpan = document.getElementById('number_of_rooms');

            //checks values of the number of rooms span to enable/disable plus and minus icons
            function checkValues(){
                const currentValue = Number(numberOfRoomsSpan.innerText);
                const currentAvailability = Number(availabilitySpan.textContent);

                if(currentValue <= 1){
                    minusIcon.style.opacity = 0.5;
                    minusIcon.style.cursor = "not-allowed";
                    minusIcon.style.pointerEvents = "none";
                } else {
                    minusIcon.style.opacity = 1;
                    minusIcon.style.cursor = "pointer";
                    minusIcon.style.pointerEvents = "auto";
                }

                if(currentValue >= currentAvailability){
                    plusIcon.style.opacity = 0.5;
                    plusIcon.style.cursor = "not-allowed";
                    plusIcon.style.pointerEvents = "none";
                } else {
                    plusIcon.style.opacity = 1;
                    plusIcon.style.cursor = "pointer";
                    plusIcon.style.pointerEvents = "auto";
                }
            }
            // increments for number of rooms
            plusIcon.addEventListener('click', ()=>{
                let currentValue = Number(numberOfRoomsSpan.innerText);
                const currentAvailability = Number(availabilitySpan.textContent);
                if(currentValue < currentAvailability){
                    currentValue++;
                    numberOfRoomsSpan.innerText = currentValue;
                    numberOfRoomsInput.value = currentValue;
                }
                checkValues();
                checkFormChanges()
            });


             // decrements for number of rooms
            minusIcon.addEventListener('click', ()=>{
                let currentValue = Number(numberOfRoomsSpan.innerText);
                if(currentValue > 1){
                    currentValue--;
                    numberOfRoomsSpan.innerText = currentValue;
                    numberOfRoomsInput.value = currentValue;
                }
                checkValues();
                checkFormChanges()
            });
    
           // Sets initial state for number of rooms selection
            function selectNumberOfRooms (){
                if (plusIcon && minusIcon){ 
                    const currentAvailability = Number(availabilitySpan.textContent);
                    if(makeReservationBtn){
                        numberOfRoomsSpan.innerText = 1;
                        numberOfRoomsInput.value = 1;
                    }
                    
                    if(!isNaN(currentAvailability) && currentAvailability > 1){
                            plusIcon.style.opacity = 1;
                            plusIcon.style.cursor = "pointer";
                            plusIcon.style.pointerEvents = "auto";
                            minusIcon.style.opacity = 0.5;
                            minusIcon.style.cursor = "not-allowed";
                            minusIcon.style.pointerEvents = "none";
                    } else {
                            plusIcon.style.opacity = 0.5;
                            plusIcon.style.cursor = "not-allowed";
                            plusIcon.style.pointerEvents = "none";
                            minusIcon.style.opacity = 0.5;
                            minusIcon.style.cursor = "not-allowed";
                            minusIcon.style.pointerEvents = "none";
                    }
                }
            }
    
            //Fetches a room's availability
            function fetchAvailability(roomId) {
              if (!roomId) {
                availabilitySpan.textContent = 'Select a room to see its availability';
                availabilitySpan.classList.remove('text-success', 'text-danger');
                availabilitySpan.classList.add('text-muted');
                if (makeReservationBtn){
                        makeReservationBtn.disabled = true;
                    }
                else if (editReservationBtn){
                        editReservationBtn.disabled = true;
                    }
                selectNumberOfRooms();
                return;
              }
                availabilitySpan.innerHTML = '<div class="spinner-grow col-1 mx-auto d-block"></div>';
              fetch(`/user/room-availability/${roomId}`)
                .then(response => response.json())
                .then(data => {
                  availabilitySpan.textContent = `${data.availability}`;
                  availabilitySpan.classList.remove('text-muted');
                  if (data.availability === 'Unavailable') {
                    availabilitySpan.classList.add('text-danger');
                    availabilitySpan.classList.remove('text-dark');
                    if (makeReservationBtn){
                        makeReservationBtn.disabled = true;
                    }

                    else if (editReservationBtn){
                        editReservationBtn.disabled = true;
                    }
                  } else {
                    availabilitySpan.classList.add('text-dark');
                    availabilitySpan.classList.remove('text-danger');
                    if (makeReservationBtn){
                        makeReservationBtn.disabled = false;
                    }

                    else if (editReservationBtn && Number(hiddenNumberOfRooms.value) !== Number(editNumberOfRoomsInput.value)){
                        editReservationBtn.disabled = false;
                    }
                    
                  }
                  selectNumberOfRooms();
                })
                .catch(error => {
                  console.error('Error fetching availability:', error);
                  availabilitySpan.textContent = 'Could not fetch availability';
                  availabilitySpan.classList.remove('text-muted');
                  availabilitySpan.classList.add('text-danger');
                  selectNumberOfRooms();
                });
            }
    
            // Fetch availability on page load if a room is already selected
            if (roomSelectMain.value) {
              fetchAvailability(roomSelectMain.value);
            }
    
            // Fetch availability when the user selects a different room
            roomSelectMain.addEventListener('change', function () {
              fetchAvailability(this.value);
              numberOfRoomsSpan.innerText = 1;
              numberOfRoomsInput.value = 1;
            });
         
        }

        //get year analytics
        const yearSelect = document.querySelector('#years');
        const analyticsTable = document.querySelector('#analyticsTable');
        const hiddenYear = document.querySelector('#year');
        const roomAnalyticsSearch = document.querySelector('#roomAnalyticsSearch');
         if (yearSelect && yearSelect.value) {
              fetchYearAnalytics(yearSelect.value);
              hiddenYear.value = yearSelect.value;
            }
            
        if(yearSelect){
        yearSelect.addEventListener('change', ()=>{
            fetchYearAnalytics(yearSelect.value)
            hiddenYear.value = yearSelect.value;
        })
    }
        function fetchYearAnalytics(year) {
            if (year) {
                // Clear previous results and show loading state
                analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';

                fetch(`/year/${year}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            let tableHtml = '<div class="col-9 mx-auto d-block mt-4"><table class="table table-bordered fade-in"><thead><tr><th>Room Name</th><th>Completed Reservations</th></tr></thead><tbody>';
                            let totalBookings = 0;
                            data.forEach(room => {
                                tableHtml += `<tr><td>${room.room_name}</td><td>${room.bookings_count}</td></tr>`;
                                totalBookings += room.bookings_count;
                            });

                            tableHtml += `</tbody><tfoot><tr><th>Total Completed Reservations</th><th> ${totalBookings}</th></tr></tfoot></table></div>`;
                            analyticsTable.innerHTML = tableHtml;
                        } else {
                            analyticsTable.innerHTML = '<h5>No booking data found for this year.</h5>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching admin analytics:', error);
                        analyticsTable.innerText = `Couldn't fetch analytics data.`;
                    });
            }
        }


         document.getElementById('roomAnalytics').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            if (hiddenYear.value.length > 0 && (roomAnalyticsSearch.value.trim()).length>0){
            analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';
            fetch('/admin/roomAnalytics', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                analyticsTable.innerHTML = `<div class="col-9 mx-auto d-block mt-4"><table class="table table-bordered fade-in"><thead><tr><th>Room Name</th><th>Completed Reservations</th></tr></thead><tbody><tr><td>${data.room}</td><td>${data.count}</td></tr></tbody>`
            })
            .catch(error => {
                console.error('Error fetching admin analytics:', error);
                analyticsTable.innerText = `Couldn't fetch analytics data.`;
            });
          }
        })     
