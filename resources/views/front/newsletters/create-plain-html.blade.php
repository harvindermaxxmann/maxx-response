@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">
    @include('layouts.frontLayout.main-sidebar')
    <div class="right-panel">
    <div class="container-fluid">
        <h1 class="text-center planline"><span>Create Newsletter</span></h1>  
<div class="form-group">
                        <label for="servicespecific">Jobs</label>
                        <select class="form-control" name="job22" id="job22">
                            <option value="">Select List</option>
                       @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                         @endforeach          
                        </select>
                    </div>
        </div>
		<div class="row mar_top20 blocks_div">

			<!-- rightside -->
			<div class="col-xs-12">
                <form method="post" action="{{url('create-plain-html?ref='.$uniqid)}}">@csrf



                    <div class="form-group">
                    <textarea type="text" rows='24' id="FetchHTML" name="html" style="font-family: Arial; font-size: 12pt; background-color: #333; color: #fff;" class="form-control"><?php echo $html; ?></textarea>
                    </div>
                    <div class="text-right">
                        <a class="btn btn-warning" id="PreviewHTML" href="javascript:;">Preview</a>
                        <button class="btn btn-success" type="submit">Save &amp; Next</button>
                    </div>
                </form>
            </div>

        </div>    
    </div>
    </div>

</section>
<style type="text/css">
    textarea {
      width: 100%;
      height: 80%;
    }
</style>
<!-- Preview Html Template -->
<div class="modal fade" id="PreviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
            </div>
            <div class="modal-body" id="AppendPreview">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Preview Html Template -->

@endsection