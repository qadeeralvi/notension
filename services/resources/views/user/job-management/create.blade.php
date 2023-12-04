<div class="main-content">
<div class="page-content">
<div class="wizard-heading">{{$title}} form</div>
<div class="col-md-offset-4 col-md-12 ">
        <form id="msform">
            @csrf
            <ul id="progressbar">
                <li class="active">Personal Details</li>
                <li>Social Profiles</li>
                <li>Account Setup</li>
            </ul>
            <fieldset>
                <h2 class="fs-title">Personal Details</h2>
                <h3 class="fs-subtitle">Tell us something more about you</h3>
                <input type="text" name="title" placeholder="Job Title" id="title"/>
                <Select name="category" id="category" onchange="get_subcategory(this.value)">
                    <option >Select Category</option>
                    @foreach($categoris as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </Select>
                <Select name="sub_category" id="sub_category">
                    <option >Select Sub Category</option>
                    <option value="Mass Transport">Mass Transport</option>
                    <option value="Freight Transport">Freight Transport</option>
                </Select>
                <textarea  name="description" placeholder="Job Title" rows="5"/></textarea>
                <input type="button" name="next" class="next action-button" value="Next"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">Who should the company contact?</h2>
                <h3 class="fs-subtitle">Why do we do this?</h3>
                <input type="text" name="phone" placeholder="Telephone number" id="phone" value="03051478489"/>
                <input type="text" name="name" placeholder="name" value="Junaid Akhtar"/>
                <input type="text" name="city" placeholder="City" id="city" value="Rawalpindi"/>
                <input type="text" name="address" placeholder="Address" value="Po/teh Rawalpindi"/>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="button" name="next" class="next action-button" value="Next"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">Post Job</h2>
                <h3 class="fs-subtitle">Fill in your credentials</h3>
                <input type="text" name="text" readonly  id="title-val"/>
                <input type="text" name="text" readonly  id="category-val"/>
                <input type="text" name="text" readonly  id="sub_category-val"/>
                <input type="text" name="text" readonly  id="city-val"/>
                <input type="text" name="text" readonly  id="phone-val"/>
              
                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                <input type="submit" name="submit" class="submit action-button" value="Submit"/>
            </fieldset>
        </form>
        
    </div>
</div>
<script>

    function get_subcategory(id){

        $.get("{{ route('category.fetch')}}",{id}, 
		function(data)
		{
            alert();
			// $("#extraBoday").html(data); 	
			// //$
            // ('#myModal').modal('hide');
		});

    }

</script>
