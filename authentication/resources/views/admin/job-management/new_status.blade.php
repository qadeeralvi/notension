@section('styles')
<link href="{{asset('admin_assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

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
        <form  method="post" action="{{route('admin.update')}}">
            
            @csrf
        <input type="hidden" name="job_id" value="{{$jobs->id}}">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 main_lable_color">{{$title}}</h4>
                                <div  class="outer">
                                    <div data-repeater-item class="outer">
                                        <div class="form-group row mb-4">
                                            <label class="col-md-1 col-form-label priority_lable_color">Status</label>
                                            <div class="col-md-2">
                                                <select class="form-control" name="status">
                                                    <option value="pending" {{($jobs->status=='pending'?'selected':'')}}>Pending</option>
                                                    <option value="active" {{($jobs->status=='active'?'selected':'')}}>Active</option>
                                                    <option value="assigned" {{($jobs->status=='assigned'?'selected':'')}}>Assigned</option>
                                                    <option value="cancelled" {{($jobs->status=='cancelled'?'selected':'')}}>Cancelled</option>
                                                </select>
                                            </div>
                                            <label class="col-md-1 col-form-label priority_lable_color">End Date</label>
                                            <div class="col-md-2">
                                                    <input type="date" class="inner form-control" name="end_date" value="{{$jobs->end_date}}" placeholder="Enter end date"/>
                                            </div>
                                            <label class="col-md-1 col-form-label priority_lable_color">End time</label>
                                            <div class="col-md-2">
                                                    <input type="time" class="inner form-control" name="end_time" placeholder="Enter end date"/>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 main_lable_color">Minimum/Maximum Service Provider that Assign by system</h4>
                        
                                <div  class="outer">
                                    <div data-repeater-item class="outer">
                                    
                                        <div class="form-group row mb-4">
                                                <label class="col-md-1 col-form-label priority_lable_color">Minimum</label>
                                                <div class="col-md-2">
                                                    <input type="number" class="inner form-control" name="minimum" placeholder="Mimimum ..." >
                                                </div>
                                                <label class="col-md-1 col-form-label priority_lable_color">Maximum</label>
                                                <div class="col-md-2">
                                                    <input type="number" class="inner form-control" name="maximum" placeholder="Maximum..."/>
                                                </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                                
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 main_lable_color">Set Priority with Number</h4>
                                <div  class="outer">
                                
                                        <div class="form-group row mb-4">
                                        
                                            <label class="col-md-1 col-form-label priority_lable_color ">Location</label>
                                            <div class="col-md-1">
                                                    <input type="number" class="inner form-control" name="location" placeholder="Enter No"/>
                                            </div>
                                        
                                            <label class="col-md-2 col-form-label priority_lable_color ">Less Job Assign Providers</label>
                                            <div class="col-md-1">
                                                    <input type="number" class="inner form-control" name="less_assign" placeholder="Enter No"/>
                                            </div>

                                            <label class="col-md-2 col-form-label priority_lable_color ">Last Job Assigned Providers</label>
                                            <div class="col-md-1">
                                                    <input type="number" class="inner form-control" name="last_assign" placeholder="Enter No"/>
                                            </div>

                                            <label class="col-md-2 col-form-label priority_lable_color">Maximum Rating</label>
                                            <div class="col-md-1">
                                                    <input type="number" class="inner form-control" name="maximum rating" placeholder="Enter No"/>
                                            </div>
                                        </div> 
                                        
                                    
                                    </div>
                                </div>
                            <!-- </form>
                            <div class="row justify-content-end">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4 main_lable_color">Service Provider ID</h4>
                            <input  type="button" class="btn btn-success inner add_more" value="Add More"/>
                            
                                <div  class="outer">
                                    <div  class="outer">

                                        <div class="inner-repeater mb-4">
                                            <div data-repeater-list="inner-group" class="inner form-group">
                                                <div class="inner mb-3 mt-2 row userdiv1">
                                                    <div class="col-md-2 col-8">
                                                        <input type="text" name="provider_id[]" class="inner form-control provider_id" placeholder="Enter ID..."/>
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <div class="row">
                                                            <div class="col-md-6 col-4">
                                                                <input type="button" class="btn btn-primary btn-block inner" onclick="fetch_data('1')" value="show"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="col-md-1 col-form-label priority_lable_color" >Name</label>
                                                    <div class="col-md-2">
                                                            <input type="text" class="inner form-control" id="provider_name"  readonly/>
                                                    </div>
                                                    <label class="col-md-1 col-form-label priority_lable_color">Email</label>
                                                    <div class="col-md-3">
                                                            <input type="text" class="inner form-control" id="provider_email" readonly/>
                                                    </div>
                                                </div>
                                                <div class="copy_div"></div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        </form>




        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->



@push('scripts')
<<script>

$(function(){

    $('.add_more').click(function(){
        let count = Math.floor((Math.random() * 100) + 1);

    var fieldHTML='';

 	var wrapper = $('.copy_div');

	var fieldHTML = `<div class="inner mb-3 mt-2 row userdiv`+count+`">
                            <div class="col-md-2 col-8">
                                <input type="text" value="`+count+`" name="provider_id[]" class="inner form-control" placeholder="Enter ID..."//>
                            </div>
                            <div class="col-md-2 col-4">
                            <div class="row">
                                <div class="col-md-6 col-4">
                                    <input type="button" class="btn btn-primary btn-block inner"  onclick="fetch_data('1',`+count+`)" value="show"/>
                                </div>
                                <div class="col-md-6 col-4">
                                    <input type="button" onclick="delete_div(`+count+`)" class="btn btn-danger btn-block inner" value="delete"/>
                                </div>
                                
                            </div>
                            </div>
                            <label class="col-md-1 col-form-label priority_lable_color" >Name</label>
                            <div class="col-md-2">
                                    <input type="text" class="inner form-control" id="provider_name`+count+`"  readonly/>
                            </div>
                            <label class="col-md-1 col-form-label priority_lable_color">Email</label>
                            <div class="col-md-3">
                                    <input type="text" class="inner form-control" id="provider_email`+count+`" readonly/>
                            </div>
                    </div>`;
					 $(wrapper).last().append(fieldHTML); //Add field html

    });


    

});

function delete_div(div_class){
    
    $('.userdiv'+div_class).hide();

}

function fetch_data(id,count)
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ route('admin.provider_data') }}",
        data : {'_token' : "{{ csrf_token() }}" ,'id':id},
        type : 'GET',
        dataType : 'json',
        success : function(result){
            if(count==null){
                $('#provider_email').val(result.email);
                $('#provider_name').val(result.name);
            }
            else{

                $('#provider_email'+count).val(result.email);
                $('#provider_name'+count).val(result.name);

            }
          

        }
    });

   
}


</script>

@endpush
