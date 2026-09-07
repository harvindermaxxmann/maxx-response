@extends('layouts.frontLayout.front-layout')
@section('content')
<section class="page-section dasboard p-0 d-flex">
    @include('layouts.frontLayout.main-sidebar') 
    <div class="right-panel">
    <div class="container-fluid">
        <div class="text-center planline pad_top10 mar_bottom20">
                <span>Contacts</span>
            </div>
        
        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif

        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">x</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif

        <!-- <div class="row">
            <div class="col-xs-12 mar_bottom15">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Contacts</strong><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/add-contact/single')}}">Add Contact</a></li>
                            <li><a href="{{url('/add-contact/multiple')}}">Add Multiple Contacts</a></li>
                            <li><a href="{{url('/add-contact/import')}}">Import Contacts</a></li>
                            <li><a href="{{url('/export-contacts')}}">Export Contacts</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div> -->   
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Group Name</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Company Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($usercontacts)>0)
                    @foreach($usercontacts as $ckey=> $contact)
                        <tr>
                            <td>{{++$ckey}}</td>
                            <td>{{$contact['listname']['list_name']}}</td>
                            <td>{{$contact['email']}}</td>
                            <td>{{$contact['name']}}</td>
                            <td>{{$contact['company_name']}}</td>
                            <td>{{$contact['phone']}}</td>
                            <td>
                            <a title="View Contact"  href="javascript:;" data-contactid="{{$contact['id']}}" class="btn btn-default getContact"><i class="fa fa-file"></i></a>
                            <a title="Delete Contact" onclick="return confirm('Are you sure you want to delete this contact?');"  href="{{url('delete-contact/'.$contact['id'])}}" class="btn btn-default"><i class="fa fa-times"></i></a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">
                            No contacts found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
        <nav class="text-right">
            <ul class="pagination">
                {{$usercontacts->links('vendor.pagination.bootstrap-4')}}
            </ul>
        </nav>
    </div>
</div>
</section>
<!-- View Contacts Modal -->
<div class="modal fade" id="ContactDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Contact Details</h5>
            </div>
            <div class="modal-body" id="AppendContactDetails">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- View Contacts Modal -->
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','.getContact',function(){
            $('.loadingDiv').show();
            var contactid = $(this).data('contactid');
            $.ajax({
                url : '/view-user-contcat/'+contactid,
                type: 'get',
                success:function(resp){
                    $('#AppendContactDetails').html(resp);
                    $('#ContactDetailsModal').modal('show');
                    $('.loadingDiv').hide();
                },
                error:function(){
                }
            }) 
        });
    })
</script>
@stop