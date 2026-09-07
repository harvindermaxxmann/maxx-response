@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\LinkedList; ?>
<?php $lists = LinkedList::lists(); ?>
<section class="page-section dasboard">
    <div class="container">
        @foreach($errors->all() as $error)
            <div class="text-center">
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {!!   $error !!}
                </div>
            </div>
        @endforeach
        <h2 class="text-center">Newsletter Settings</h2>
        <div class="col-xs-12 col-md-10 midlcenter">
            @if(isset($_GET['ref']))
                <?php $ref= '?ref='.$_GET['ref']; ?>
            @else
                <?php $ref= ''; ?>
            @endif
            <form autocomplete="off" method="post" action="{{url('newsletter/basic-settings'.$ref)}}">@csrf
                <div class="form-group">
                    <div class="row">
                        <label for="LinkedList" class="col-sm-3 col-form-label">Linked list</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="LinkedList" name="list_id" required>
                                @foreach($lists as $list)
                                    <option value="{{$list['id']}}" {{((!empty($draftdetails) && $draftdetails['linked_list_id']== $list['id'])? 'selected' :'')}}>{{$list['list_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <input  type="hidden"  name="type" value="{{$type}}" value="{{old('type')}}">
                <div class="form-group">
                    <div class="row">
                        <label for="messageName" class="col-sm-3 col-form-label">Message name</label>
                        <div class="col-sm-9">
                            <input type="text" name="message_name" class="form-control" id="messageName" placeholder="Message name will appear in the list of your messages. It will not be seen by your subscribers." value="{{(!empty($draftdetails)?$draftdetails['message_name'] :'')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="Subject" class="col-sm-3 col-form-label">Subject</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="subject" id="Subject" placeholder="This is the subject line of your email." value="{{(!empty($draftdetails)?$draftdetails['subject'] :'')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="From" class="col-sm-3 col-form-label">From</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="from_email" id="From">
                                <option value="{{Auth::user()->email}}">{{Auth::user()->name}} < {{Auth::user()->email}} ></option>
                            </select>
                        </div>
                    </div>
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
</section>
@stop