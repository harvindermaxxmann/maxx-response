@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard  p-0 d-flex">
    
    @include('layouts.frontLayout.main-sidebar')

     <div class="right-panel">

    <div class="container-fluid">
        
        <div class="text-center planline" style="padding:0;">
            <span>Drafts</span>
        </div>
        
        @if(Session::has('flash_message_error'))
        <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif

        <div class="row" style="display: none;">
            <div class="col-xs-12 mar_bottom15">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="btn btn-primary" href="{{url('/newsletter/choose-html-or-plain')}}">Create Newsletter</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="blocks_div">
           
            <!-- rightside -->
            <div class="h_dashmod">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">#</th>
                                <th width="150"></th>
                                <th>Name</th>
                                <th width="200">Type</th>
                                <th>Modified on</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($drafts))
                            @foreach($drafts as $dkey=> $draft)
                            <tr>
                                <td width="60" class="text-center"><strong>{{++$dkey}}</strong></td>
                                <td>
                                    @if(!empty($draft['page']))
                                    <img width="80" height="80" class="objectfit_contain" src="{{asset('images/PageImages/'.$draft['page']['image'])}}">
                                    @else
                                    <img width="80" height="80" class="objectfit_contain" src="{{asset('images/no-draft.png')}}">
                                    @endif
                                </td>
                                <td>
                                    <h4><a href="{{url('/newsletter/basic-settings?type='.$draft['draft_type']?? ''.'&ref='.$draft['unique_id'])}}">{{$draft['message_name'] ??''}}</a></h4>
                                    <p>{{$draft['linkedlist']['list_name'] ??''}}</p>
                                </td>
                                <td></td>
                                <td>{{date('F d, Y',strtotime($draft['updated_at']))}}
                                    <br>
                                    {{date('h:ia',strtotime($draft['updated_at']))}}
                                </td>
                                <td>
                                    <a title="Edit Draft" class="btn btn-primary" href="{{url('/newsletter/basic-settings?type='.$draft['draft_type'].'&ref='.$draft['unique_id'])}}"><i class="fa fa-edit"></i></a>
                                    @if(!empty($draft['newsletter_file']))
                                    <a target="_blank" title="Preview" class="btn btn-warning" href="{{url('/draft/preview/'.$draft['id'])}}"><i class="fa fa-eye"></i></a>
                                    @endif
                                    <a title="Delete Draft" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this draft?');" href="{{url('/delete-draft/'.$draft['id'])}}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    (none)
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- div close -->
        </div>
    </div>

</div>
</section>
@stop