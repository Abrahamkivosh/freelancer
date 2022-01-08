<div>
    <div class="row">
        <div class="col-md-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="uil uil-moneybag float-right"></i>
                    <h6 class="mt-0">Wallet Balance</h6>
                    <h2 class="my-2" id="active-users-count">{{ Auth::user()->balance }}</h2>
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div>
        <div class="col-md-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="uil uil-moneybag float-right"></i>
                    <h6 class=" mt-0">Active Jobs</h6>
                    <h2 class="my-2" id="active-users-count">{{ Auth::user()->activeJobs()->count() }}</h2>
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div>
        <div class="col-md-4">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="uil uil-moneybag float-right"></i>
                    <h6 class="mt-0">Held Balance</h6>
                    <h2 class="my-2" id="active-users-count">{{ Auth::user()->activeJobs()->sum('budget') }}</h2>
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div>
    </div>
</div>
