@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\LinkedList; ?>
<?php $lists = LinkedList::lists(); ?>
<section class="page-section dasboard p-0 d-flex">

    @include('layouts.frontLayout.main-sidebar')

    <div class="right-panel">
    <div class="container-fluid">
        @foreach($errors->all() as $error)
        <div class="text-center">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!!   $error !!}
            </div>
        </div>
        @endforeach
        <h2 class="text-center">Newsletter Settings</h2>
        <div class="pad_top30 blocks_div">
            
            <!-- rightside -->
            <div>
                @if(isset($_GET['ref']))
                <?php $ref= '?ref='.$_GET['ref']; ?>
                @else
                <?php $ref= ''; ?>
                @endif
                <form class="camp-form" autocomplete="off" method="post" action="{{url('newsletter/basic-settings'.$ref)}}">
                    @csrf
                    <div class="form-group">
                        <label for="LinkedList">Linked list<span class="red">*</span></label>
                      <select class="form-control" id="LinkedList" name="list_id" required>
                        @foreach($lists as $list)
                        <option value="{{$list['id']}}" {{((!empty($draftdetails) && $draftdetails['linked_list_id']== $list['id'])? 'selected' :'')}}>{{$list['list_name']}}</option>
                        @endforeach
                        </select> 

                        <!-- Build your select: -->
                        <!--<select class="selectpicker" multiple name="cat[]">
                                  <option value="SMS Test Final">SMS Test Final</option>
                                  <option value="Freshlist">Freshlist</option>
                                  <option value="ListNew">ListNew</option>
                                  <option value="MXMLST">MXMLST</option>
                        </select>-->
                    </div>
                    <input  type="hidden"  name="type" value="{{$type}}" value="{{old('type')}}">
                    <div class="form-group">                    
                        <label for="messageName">Message name<span class="red">*</span></label>
                        <input type="text" name="message_name" class="form-control" id="messageName" placeholder="Message name will appear in the list of your messages. It will not be seen by your subscribers." value="{{(!empty($draftdetails)?$draftdetails['message_name'] :'')}}" required>                    
                    </div>
                    <div class="form-group">
                        <label for="Subject">Subject<span class="red">*</span></label>
                        <input type="text" class="form-control" name="subject" id="Subject" placeholder="This is the subject line of your email." value="{{(!empty($draftdetails)?$draftdetails['subject'] :'')}}" required>
                    </div>
                    <div class="form-group from_email_sel">
                        <label for="From">From<span class="red">*</span></label>
                         <select class="form-control" name="from_email" id="From" required>
                            <option value="{{Auth::user()->email}}">{{Auth::user()->name}} < {{Auth::user()->email}} ></option>
                        </select> 
                        <!--<select class="selectpicker" multiple name="cat[]">
                                  <option value="Devesh Sharma">maxxmann.digital@gmail.com</option>
                                  
                        </select>-->
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary center-block">Next Step</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('select').selectpicker();
    });
</script>

@stop