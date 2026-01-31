// Select all necessary elements from the DOM
const yearSelect = document.querySelector('#yearSelect');
const monthSelect = document.querySelector('#monthSelect');
const hiddenYear = document.querySelector('#year');
const hiddenMonth = document.querySelector('#month');
const filterClientReviews = document.querySelector('#filterClientReviews');
const clientReviewsForm = document.querySelector('#client-reviews');
const reviewDiv = document.querySelector('#reviews');
const allRadio = document.querySelector('#all');
const paginationContainer = document.querySelector('#pagination-container');
const reviewsTotal = document.querySelector('.reviews-total');

// --- State Management ---
// Global variable to store the current state of filters
let currentFilterParams = {
    year: '',
    month: '',
    rating: 'all'
};

// --- Initial Page Setup ---

// Set the "All" radio button to be checked by default
if (allRadio) {
    allRadio.checked = true;
}

// Function to enable/disable the filter button based on input
function checkFilterData() {
    if (filterClientReviews && hiddenYear && hiddenMonth) {
        const isYearSelected = hiddenYear.value && hiddenYear.value.length > 0;
        const isMonthSelected = hiddenMonth.value && hiddenMonth.value.length > 0;
        filterClientReviews.disabled = !(isYearSelected && isMonthSelected);
    }
}

// Set the initial value for the hidden year and month inputs from the dropdowns
if (yearSelect && yearSelect.value && hiddenYear) {
    hiddenYear.value = yearSelect.value;
}
if (monthSelect && monthSelect.value && hiddenMonth) {
    hiddenMonth.value = monthSelect.value;
}
checkFilterData(); // Initial check on page load


// --- Event Listeners ---

if (yearSelect) {
    yearSelect.addEventListener('change', () => {
        if (hiddenYear) hiddenYear.value = yearSelect.value;
        checkFilterData();
    });
}

if (monthSelect) {
    monthSelect.addEventListener('change', () => {
        if (hiddenMonth) hiddenMonth.value = monthSelect.value;
        checkFilterData();
    });
}

// Main form submission handler
if (clientReviewsForm) {
    clientReviewsForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent full page reload

        // Update the global filter state from the form inputs
        currentFilterParams.year = hiddenYear ? hiddenYear.value : '';
        currentFilterParams.month = hiddenMonth ? hiddenMonth.value : '';
        const selectedRating = clientReviewsForm.querySelector('input[name="rating"]:checked');
        currentFilterParams.rating = selectedRating ? selectedRating.value : 'all';

        // Fetch results for the first page with the new filters
        fetchReviews('/admin/client-reviews?page=1');
    });
}

// Pagination link click handler (using event delegation)
if (paginationContainer) {
    paginationContainer.addEventListener('click', (e) => {
        const target = e.target.closest('.page-link'); // Find the link even if a child element is clicked
        if (target && target.tagName === 'A') {
            e.preventDefault();
            const url = target.getAttribute('href');
            if (url && !target.closest('.page-item.disabled, .page-item.active')) {
                fetchReviews(url);
            }
        }
    });
}

// --- Core AJAX and Rendering Logic ---

// Central function to fetch and render reviews
async function fetchReviews(url) {
    // 1. Show loading indicators
    if (reviewDiv) reviewDiv.innerHTML = '<div class="spinner-grow col-3 mx-auto d-block mt-5" role="status"></div>';
    if (paginationContainer) paginationContainer.innerHTML = '';
    if (reviewsTotal) reviewsTotal.innerHTML = '';

    try {
        // 2. Fetch data from the server
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(currentFilterParams) // Always send the current filter state
        });

        if (!response.ok) {
            throw new Error(`Network response was not ok, status: ${response.status}`);
        }

        const data = await response.json();
        
        // 3. Render the results
        renderReviews(data.data);
        renderPagination(data.links);
        if (reviewsTotal) {
            reviewsTotal.textContent = `Total Reviews: ${data.total}`;
        }

    } catch (error) {
        console.error('Error fetching reviews:', error);
        if (reviewDiv) reviewDiv.innerHTML = `<p class="text-center text-danger mt-5">Couldn't fetch reviews. Please try again.</p>`;
    }
}

// Function to render the list of reviews
function renderReviews(reviews) {
    if (!reviewDiv) return;

    if (reviews && reviews.length > 0) {
        reviewDiv.innerHTML = reviews.map(review => {
            const ratingPhoto = review.rating?.rating_photo || 'default.webp';
            const imagePath = `/images/${ratingPhoto}`;
            return `
                <div class="review_container mt-5 bg-light col-12 col-xl-9 mx-auto d-block">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-6 col-sm-3 col-md-2">
                            <img src="${imagePath}" alt="rating" class="reviews-rating">
                        </div>
                    </div>
                    <h4 class="mb-4 fadeInUp col-11 col-md-9 mx-auto d-block text-center mt-3">${review.content}</h4>
                </div>
            `;
        }).join('');
    } else {
        reviewDiv.innerHTML = '<h5 class="text-center mt-5">No reviews found for the selected criteria.</h5>';
    }
}

// Function to render the pagination links
function renderPagination(links) {
    if (!paginationContainer) return;

    paginationContainer.innerHTML = `
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                ${links.map(link => `
                    <li class="page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}">
                        <a class="page-link" href="${link.url || '#'}">${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}</a>
                    </li>
                `).join('')}
            </ul>
        </nav>
    `;
}