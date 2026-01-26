        //get year analytics
        const yearSelect = document.querySelector('#years');
        const analyticsTable = document.querySelector('#analyticsTable');
        const hiddenYear = document.querySelector('#year');
        const roomAnalyticsSearch = document.querySelector('#roomAnalyticsSearch');
        const searchError = document.querySelector('.search_error');
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
                searchError.innerText=''
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
            searchError.innerText=''
            //Submit search form and get the analytics
            fetch('/roomAnalytics', {
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

          else{
            analyticsTable.innerHTML = '';
            searchError.innerText = "Please ensure year is selected and search bar is not empty"
          }
        })     
