<x-user-layout title="Analytics">

  <x-slot name="content">
    <div class="container mt-5">
      <div class="row">
  
        <h2 class="text-center mt-5"><strong>Room Analytics</strong></h2>

        <!-- Analytics form starts-->
        <form id="analyticsForm" method="post">
          @csrf
          <div class="form-group">
            <div class="d-flex justify-content-center gap-3">
              <label for="startingDate"><h5>Starting Date:</h5></label>
              <input type="date" name="startingDate" id="startingDate" class="form-control">
            </div>

          </div>

         <div class="form-group">
              <div class="d-flex justify-content-center mt-4 gap-3">
                  <label for="endingDate"><h5>Ending Date:</h5></label>
                  <input type="date" name="endingDate" id="endingDate" class="form-control">

              </div>

          </div>
          <input type="submit" class="btn reg_btn text-light mx-auto d-block mt-4" value="Fetch Analytics" id="fetchAnalyticsBtn"> 
        </form>
        <!-- Analytics form ends-->


        <!-- <form id="roomMonthlyAnalyticsSearch" method="post">
          @csrf
          <input type="hidden" name="year2" id="year2">
          <input type="hidden" name="month2" id="month2">
            <div class="col-11 col-sm-8 mt-4 mx-auto d-block">
              <div class="input-group my-4" id="roomSearch">
                <input 
                type="text" 
                id="roomAnalyticsSearch" 
                name="search" 
                value=""
                class="bg-white form-control"
                placeholder="Type room name..."
              >
              <input type="submit" class="btn reg_btn text-light input-group-text" value="Search" name="search" id="searchRoomAnalyticsBtn">
             </div>
            </div> 
        </form>
        <div class="search_error text-danger text-center"></div> -->

        <div class="col-12 text-center mt-3" id="analyticsTable"></div>
        <div class="col-12 col-md-10 mx-auto d-block mt-5" id="chartDiv" style="position: relative; height: 500px;">
        </div>
      </div>
    </div>
  </x-slot>
  
</x-user-layout>

