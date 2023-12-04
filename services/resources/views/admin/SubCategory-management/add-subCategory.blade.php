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
                            <li class="breadcrumb-item active">{{$title}}</li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>     

        @if(session()->has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>    
                <strong> {{ session()->get('success') }}</strong>
            </div>
        @endif

        <!-- end page title -->
        <form  method="post" action="{{url('admin/subcategory')}}" enctype="multipart/form-data" >
            
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div  class="outer">
                                    <div data-repeater-item class="outer">
                                        <div class="form-group row mb-4">
                                            <label class="col-md-1 col-form-label priority_lable_color">Sub Category Title</label>
                                            <div class="col-md-2">
                                                    <input type="text" class="inner form-control" name="name"  placeholder="Enter Category"/>
                                            </div>
                                            <label class="col-md-1 col-form-label priority_lable_color">Sub Category Title</label>
                                            <div class="col-md-2">
                                                <select name="category_id" class="inner form-control">
                                                    <option>Choose Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" >{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="col-md-1 col-form-label priority_lable_color">Days</label>
                                            <div class="col-md-2">
                                                    <input type="number" class="inner form-control" name="days"  placeholder="Enter total days"/>
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
                            <h4 class="card-title mb-4 main_lable_color">Set Priority with Checkbox</h4>
                                <div  class="outer">
                                
                                        <div class="form-group row mb-4">
                                        
                                            <label class="col-md-1 col-form-label priority_lable_color ">Location</label>
                                            <div class="col-md-1">
                                                    <input type="checkbox" class="inner form-control" name="location" value="1"/>
                                            </div>
                                        
                                            <label class="col-md-2 col-form-label priority_lable_color ">Less Job Assign Providers</label>
                                            <div class="col-md-1">
                                                    <input type="checkbox" class="inner form-control" name="less_assign" value="1"/>
                                            </div>

                                            <label class="col-md-2 col-form-label priority_lable_color ">Last Job Assigned Providers</label>
                                            <div class="col-md-1">
                                                    <input type="checkbox" class="inner form-control" name="last_assign" value="1"/>
                                            </div>

                                            <label class="col-md-2 col-form-label priority_lable_color">Maximum Rating</label>
                                            <div class="col-md-1">
                                                    <input type="checkbox" class="inner form-control" name="maximum rating" value="1" />
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
                                <h4 class="card-title mb-4 main_lable_color">Image</h4>
                                    <div  class="outer">
                                    
                                            <div class="form-group row mb-8">
                                            
                                                <div class="col-md-6">
                                                        <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="image" />
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                                </div>
                                            
                                            </div> 
                                            
                                        
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                
                
                </div>
            </div>

          
      
        </form>




        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->



