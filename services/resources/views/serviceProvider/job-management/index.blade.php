  
<div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">{{$title}}</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Job</a></li>
                                            <li class="breadcrumb-item active">{{$title}}</li>
                                        </ol>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" style="width: 70px;">#</th>
                                                        <th scope="col">Job Title</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Time</th>
                                                        <th scope="col">Status</th>
                                                        <!-- <th scope="col">Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($jobs as $index => $item)
                                                    @php
                                                        $job_detail = App\Models\JobManagement::find($item->job_id);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="avatar-xs">
                                                                <span class="avatar-title rounded-circle">
                                                                    {{$index+1}}
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <td>{{$job_detail->title}}</td>
                                                        <td>{{$job_detail->date}}</td>
                                                        <td>{{$job_detail->time}}</td>
                                                        <td>{{$job_detail->status}}</td>
                                                       
                                                     
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            
            </div>

@push('scripts')
<script>
    function change_status(id){
        $('#jb').modal('show');
        // $.get("{{ url('jobManagement')}}" + '/' + id + '/edit', function (data) {
            
        //            $('#modal-details').modal('show');
        //         })

    }
</script>
@endpush
