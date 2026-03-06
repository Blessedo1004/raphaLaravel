    //     //get analytics
            const analyticsTable = document.querySelector('#analyticsTable');
            const analyticsForm = document.querySelector('#analyticsForm');
            const fetchAnalyticsButton = document.querySelector('#fetchAnalyticsBtn');
            const startingDate = document.querySelector('#startingDate');
            const endingDate = document.querySelector('#endingDate');
            const chartDiv = document.querySelector('#chartDiv');
    //     const roomAnalyticsSearch = document.querySelector('#roomAnalyticsSearch');
    //     const searchError = document.querySelector('.search_error');

            let myChart = null;

            function toggleButton() {
                if (startingDate.value && endingDate.value) {
                    fetchAnalyticsButton.disabled = false;
                } else {
                    fetchAnalyticsButton.disabled = true;
                }
            }

            if(startingDate && endingDate && fetchAnalyticsButton){
                toggleButton();
                startingDate.addEventListener('change', toggleButton);
                endingDate.addEventListener('change', toggleButton);
            }

            analyticsForm.addEventListener('submit', async (e)=>{
                e.preventDefault()
                const formData = new FormData(e.target)

                //loading state
                analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';
                chartDiv.innerHTML = '<div class="spinner-grow col-3"></div>';

                try {
                    const response = await fetch('/roomAnalytics',{
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })

            if (!response.ok) {
                throw new Error(`Network response was not ok, status: ${response.status}`);
            }

                const data = await response.json();
                if (data && data.length > 0) {
                    let tableHtml = '<div class="col-9 mx-auto d-block mt-4"><table class="table table-bordered fade-in"><thead><tr><th>Room Name</th><th>Completed Reservations</th></tr></thead><tbody>';
                    let totalBookings = 0;
                    
                    const labels = [];
                    const bookingsData = [];

                    data.forEach(room => {
                     tableHtml += `<tr><td>${room.room_name}</td><td>${room.bookings_count}</td></tr>`;
                     totalBookings += room.bookings_count;

                     labels.push(room.room_name);
                     bookingsData.push(room.bookings_count);
                    });

                    tableHtml += `</tbody><tfoot><tr><th>Total Completed Reservations</th><th> ${totalBookings}</th></tr></tfoot></table></div>`;
                    analyticsTable.innerHTML = tableHtml;

                    // Re-insert canvas and initialize chart
                    chartDiv.innerHTML = '<canvas id="myChart"></canvas>';
                    const ctx = document.getElementById('myChart');

                    if (myChart) {
                        myChart.destroy();
                    }

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Number of Completed Reservations',
                                data: bookingsData,
                                borderWidth: 1,
                                backgroundColor: [
                                    'rgba(158, 123, 79, 0.8)',
                                    'rgba(125, 97, 62, 0.8)',
                                    'rgba(92, 71, 45, 0.8)',
                                    'rgba(191, 165, 131, 0.8)',
                                    'rgba(214, 196, 170, 0.8)',
                                    'rgba(142, 107, 63, 0.8)',
                                    'rgba(110, 81, 47, 0.8)',
                                    'rgba(175, 140, 96, 0.8)'
                                ],
                                borderColor: [
                                    '#9e7b4f',
                                    '#7d613e',
                                    '#5c472d',
                                    '#bfa583',
                                    '#d6c4aa',
                                    '#8e6b3f',
                                    '#6e512f',
                                    '#af8c60'
                                ],
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
             } 
                else {
                 analyticsTable.innerHTML = '<h5>No reservation data found for this period.</h5>';
                 chartDiv.innerHTML = '';
                 if (myChart) {
                    myChart.destroy();
                    myChart = null;
                 }
                }
        
                }
                    catch(error) {
                     console.error('Error fetching  analytics:', error);
                     analyticsTable.innerText = `Couldn't fetch analytics data.`;
                     };
            })


    // //search

    //     const roomMonthlyAnalyticsSearch = document.getElementById('roomMonthlyAnalyticsSearch')
    //     if (roomMonthlyAnalyticsSearch) {
    //      roomMonthlyAnalyticsSearch.addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         const formData = new FormData(this);

            
    //         analyticsTable.innerHTML = '<div class="spinner-grow col-3"></div>';
    //         //Submit form
    //         fetch('/roomMonthlyAnalyticsSearch', {
    //             method: 'POST',
    //             body: formData,
    //             headers: {
    //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //             }
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             analyticsTable.innerHTML = `<div class="col-9 mx-auto d-block mt-4"><table class="table table-bordered fade-in"><thead><tr><th>Room Name</th><th>Completed Reservations</th></tr></thead><tbody><tr><td>${data.room}</td><td>${data.count}</td></tr></tbody>`

    //         })
    //         .catch(error => {
    //             console.error('Error fetching analytics:', error);
    //             analyticsTable.innerText = `Couldn't fetch analytics data.`;
    //         });
    
    //     })     
    // }