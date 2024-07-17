@extends('sms::layouts.main')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{"Messages"}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{"Messages"}}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">A list of messages</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i>  {{ "Add a message" }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(count($messages)>0)
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                 <thead class="text-muted table-light">
                                     <tr class="text-uppercase">
                                        <th>{{ '#' }}</th>
                                        <th>{{ 'Title' }}</th>
                                        <th>{{ 'Body' }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach($messages as $key => $message)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td> {{ $message->title }}</td>
                                        <td> {{ $message->body }}</td>
                                        <td>
                                            <ul class="list-inline hstack mb-0">
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top">
                                                    <a href="#showupdateModal" class="edit-btn btn btn-outline-success" data-id="{{$message->id}}" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top">
                                                    <a class="btn btn-outline-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder{{$message->id}}">
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @php $i++;@endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--create modal -->
 <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Add a message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('message.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3" id="modal-id">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="" placeholder="Title" />
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Message</label>
                        <textarea class="form-control" name="body" rows="4" cols="50"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-soft-success" id="add-btn">Add a message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--create modal ends-->
<!--update modal -->
 <div class="modal fade" id="showupdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Update message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{route('message.update')}}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="msgid" name="msgid">	
                    <div class="mb-3" id="modal-id">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="msgtitle" name="title" class="form-control" placeholder="Title" />
                    </div>

                    <div class="mb-3">
                        <label for="customername-field" class="form-label">Message</label>
                        <textarea class="form-control" id="msg" name="body" rows="4" cols="50"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-soft-success" id="add-btn">Update message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--update modal ends-->
<!--delete modal -->
@foreach ($messages as $message)
<div class="modal fade flip" id="deleteOrder{{ $message->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                <div class="mt-4 text-center">
                    <h4>You are about to delete a item ?</h4>
                    <p class="text-muted fs-14 mb-4">Deleting your items will remove all of
                        your information from our database.</p>

                    <div class="hstack gap-2 justify-content-center remove">
                        <button class="btn btn-link btn-ghost-success fw-medium text-decoration-none"
                            id="deleteRecord-close" data-bs-dismiss="modal"><i
                                class="ri-close-line me-1 align-middle"></i> Close</button>
                        <form method="POST" action="{{ route('message.delete', $message->id) }}"
                            style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" id="delete-record">Yes, Delete
                                It</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- delete modal ends-->
@endsection
@section('scripts')
<script>
	$('.edit-btn').on('click',function(){
		
		var currRow = $(this).closest("tr");
		var currId = $(this).attr('data-id');
		var currTitle = currRow.find('td:eq(1)').text();
		var currBody = currRow.find('td:eq(2)').text();
		
		$('#msgid').val(currId);
		$('#msgtitle').val(currTitle);
		
		$('#msg').text(currBody);
	});
</script>
@endsection