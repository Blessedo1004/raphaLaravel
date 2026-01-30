        //get year analytics
        const yearSelect = document.querySelector('#years');
        const yearSelect2 = document.querySelector('#yearSelect');
        const monthSelect = document.querySelector('#monthSelect');
        const analyticsTable = document.querySelector('#analyticsTable');
        const hiddenYear = document.querySelector('#year');
        const hiddenYear2 = document.querySelector('#year2');
        const hiddenMonth = document.querySelector('#month');
        const hiddenMonth2 = document.querySelector('#month2');
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
                            analyticsTable.innerHTML = '<h5>No reservation data found for this year.</h5>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching  analytics:', error);
                        analyticsTable.innerText = `Couldn't fetch analytics data.`;
                    });
            }
        }


        if (document.getElementById('roomAnalytics')) {
         document.getElementById('roomAnalytics').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);

            if (hiddenYear.value.length > 0 && (roomAnalyticsSearch.value.trim()).length>0){
            analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';
            searchError.innerText=''
            //Submit search form and get the analytics
            fetch('/roomYearlyAnalyticsSearch', {
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
                console.error('Error fetching analytics:', error);
                analyticsTable.innerText = `Couldn't fetch analytics data.`;
            });
          }

          else{
            analyticsTable.innerHTML = '';
            searchError.innerText = "Please ensure year is selected and search bar is not empty"
          }
        })     
    }

        //get year and month analytics
        const fetchMonthyAnalyticsBtn = document.querySelector("#fetchMonthyAnalyticsBtn")
        const searchRoomAnalyticsBtn = document.querySelector("#searchRoomAnalyticsBtn")
        if(fetchMonthyAnalyticsBtn && searchRoomAnalyticsBtn){
            fetchMonthyAnalyticsBtn.disabled = true
            searchRoomAnalyticsBtn.disabled = true
        }

        if(yearSelect2 && yearSelect2.value && hiddenYear && hiddenYear2){
            hiddenYear.value = yearSelect2.value;
            hiddenYear2.value = yearSelect2.value;
            checkFirstHiddenValues()
            checkSecondHiddenValues()
    }

        if(yearSelect2 && hiddenYear && hiddenYear2){
            yearSelect2.addEventListener('change', ()=>{
            hiddenYear.value = yearSelect2.value;
            hiddenYear2.value = yearSelect2.value;
            checkFirstHiddenValues()
            checkSecondHiddenValues()
        })
    }
        if(monthSelect && hiddenMonth && hiddenMonth2){
            monthSelect.addEventListener('change', ()=>{
            hiddenMonth.value = monthSelect.value;
            hiddenMonth2.value = monthSelect.value;
            checkFirstHiddenValues()
            checkSecondHiddenValues()
        })
    }

    //checks if both hidden inputs have values in the forms
    function checkFirstHiddenValues (){
         if (hiddenYear.value.length > 0 && hiddenMonth.value.length > 0){
        fetchMonthyAnalyticsBtn.disabled = false
    }
    else{
        fetchMonthyAnalyticsBtn.disabled = true
    }
    }
    
    function checkSecondHiddenValues (){
         if (hiddenYear2.value.length > 0 && hiddenMonth2.value.length > 0 && roomAnalyticsSearch.value.trim().length>0){
        searchRoomAnalyticsBtn.disabled = false
    }

    else{
        searchRoomAnalyticsBtn.disabled = true
    }
    }

    //check if search input has a value
    if(roomAnalyticsSearch){
        roomAnalyticsSearch.addEventListener('keyup' , ()=>{
            checkSecondHiddenValues()
    })
    }
        const roomMonthlyAnalytics = document.getElementById('roomMonthlyAnalytics')
        if (roomMonthlyAnalytics) {
         roomMonthlyAnalytics.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            
            analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';
            //Submit form
            fetch('/roomMonthlyAnalytics', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
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
                            analyticsTable.innerHTML = '<h5>No reservation data found for this year and month.</h5>';
                        }
            })
            .catch(error => {
                console.error('Error fetching analytics:', error);
                analyticsTable.innerText = `Couldn't fetch analytics data.`;
            });
    
        })     
    }

    //search

        const roomMonthlyAnalyticsSearch = document.getElementById('roomMonthlyAnalyticsSearch')
        if (roomMonthlyAnalyticsSearch) {
         roomMonthlyAnalyticsSearch.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            
            analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';
            //Submit form
            fetch('/roomMonthlyAnalyticsSearch', {
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
                console.error('Error fetching analytics:', error);
                analyticsTable.innerText = `Couldn't fetch analytics data.`;
            });
    
        })     
    }