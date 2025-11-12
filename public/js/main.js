let logoutTimer;
const logoutAfter = 60 * 10000; 

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

    function checkFormChanges() {
        if (hiddenRoom && hiddenCheckIn && hiddenCheckOut && roomSelect && checkInInput && checkOutInput && submitButton) {
        const roomChanged = hiddenRoom.value !== roomSelect.value;
        const checkInChanged = hiddenCheckIn.value !== checkInInput.value;
        const checkOutChanged = hiddenCheckOut.value !== checkOutInput.value;

        // If any value has changed, enable the button. Otherwise, disable it.
        if (roomChanged || checkInChanged || checkOutChanged) {
            submitButton.disabled = false;
        } else {
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

    const reviewActionToggle = document.querySelectorAll('#review_action_toggle').forEach(toggle=>{
    let clicked = false;    
        if(toggle){
            toggle.addEventListener('click', ()=>{
                const id = toggle.dataset.id;
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

   
