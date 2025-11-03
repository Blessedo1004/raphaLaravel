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
        closeReservationModal.addEventListener('click', ()=>{
        const modalContainer = document.querySelector('.modal_container')
        modalContainer.classList.add('fade-out')
        modalContainer.addEventListener('animationend', () => {
        modalContainer.classList.add('d-none');
    });
        })
}
