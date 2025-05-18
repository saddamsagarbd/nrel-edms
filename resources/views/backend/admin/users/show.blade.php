@extends('layouts.backend')
@section('title','Projects')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
<style>
    .table th,
    .datepicker table th,
    .table td,
    .datepicker table td {
        white-space: normal !important;
    }

    body.modal-open {
        overflow: auto;
    }
</style>
@endpush

@section('content')

<div class="page-content">
    <div class="profile-page tx-13">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="position-relative">
                        <div class="gray-shade"></div>
                        <div class="cover-body d-flex justify-content-between align-items-center">
                            <div class="profile d-flex p-3">
                                <div class="float-left my-auto me-3">
                                    <img class="profile-pic wd-100 rounded-circle" src="http://helpdesk.navana.com/uploads/img/default.jpg" alt="profile">
                                </div>
                                <div class="float-left mx-auto mt-4">
                                    <span class="profile-name ml-0">{{$employee->name}}</span><br>
                                    <span>Email: {{$employee->email}}</span> <br>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12">
                @include('backend.slices.messages')
            </div>
        </div>
        <div class="row profile-body">
            <div class="d-md-block col-md-12 col-xl-12 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <ul class="nav nav-tabs nav-tabs-line mb-3" id="lineTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-line-tab" data-bs-toggle="tab" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-line-tab" data-bs-toggle="tab" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Team Members</a>
                                </li>
                            </ul>

                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                @foreach($modules as $module)
                                @if(count($module->modulePages) > 0)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title">{{$module->name}}</h6>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped table-perm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Module Menus</th>
                                                        <th class="text-center">Create </th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Update</th>
                                                        <th class="text-center">Delete</th>
                                                        <th class="text-center">Cancel</th>
                                                        <th class="text-center">approval</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($module->modulePages as $m_page)

                                                    <?php $perms = App\Models\Permission::where([['module_id', '=', $m_page->id], ['user_id', '=', $employee->id]])->first() ?>

                                                    <tr>
                                                        <th>{{$m_page->id}}</th>
                                                        <td>{{$m_page->name}}</td>
                                                        <td class="text-center"> <input type="checkbox" name="create[]" id="create_{{$m_page->id}}" class="form-check-input" {{ !empty($perms->create) ? 'checked': ''}} disabled></td>
                                                        <td class="text-center"> <input type="checkbox" name="read[]" id="read_{{$m_page->id}}" class="form-check-input" {{ !empty($perms->read) ? 'checked': ''}} disabled></td>
                                                        <td class="text-center"><input type="checkbox" name="update[]" id="update_{{$m_page->id}}" class="form-check-input" {{ !empty($perms->update) ? 'checked': ''}} disabled></td>
                                                        <td class="text-center"><input type="checkbox" name="delete[]" id="delete_{{$m_page->id}}" class="form-check-input" {{ !empty($perms->delete) ? 'checked': ''}} disabled></td>
                                                        <td class="text-center"><input type="checkbox" name="Cancel[]" id="cancel_{{$m_page->id}}" class="form-check-input" {{ !empty($perms->cancel) ? 'checked': ''}} disabled></td>
                                                        <td class="text-center"><input type="checkbox" name="approval[]" id="approval_{{$m_page->id}}" class="form-check-input" {{ !empty($perms->approval) ? 'checked': ''}} disabled></td>
                                                        <input type="hidden" name="module_id[]" value="{{$m_page->id}}" />
                                                        <input type="hidden" name="user_id" value="{{$employee->id}}" />
                                                        <td>
                                                            <button type="button" data-uid="{{$employee->id}}" data-mname="{{$m_page->name}}" data-mid="{{$m_page->id}}" data-create="{{ !empty($perms->create) ? $perms->create: '0'}}" data-read="{{ !empty($perms->read) ? $perms->read: '0'}}" data-update="{{ !empty($perms->update) ? $perms->update: '0'}}" data-delete="{{ !empty($perms->delete) ? $perms->delete: '0'}}" data-cancel="{{ !empty($perms->cancel) ? $perms->cancel: '0'}}" data-approval="{{ !empty($perms->approval) ? $perms->approval: '0'}}" class="btn btn-light btn-sm btn-sm-custom" data-bs-toggle="modal" data-bs-target="#permissionModal">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach

                            </div>

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="row">
                                    <div class="col-lg-4 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
                                        <div class="card">
                                            <div class="card-body">

                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModal" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalLabel">Change Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="{{route('admin.user.permission')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- <h5>Are you sure?</h5>   -->
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="create" id="create" class="form-check-input">
                                    Create
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="read" id="read" class="form-check-input">
                                    Read
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="update" id="update" class="form-check-input">
                                    Update
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="mdelete" id="mdelete" class="form-check-input">
                                    Delete
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="cancel" id="cancel" class="form-check-input">
                                    Cancel
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" name="approval" id="approval" class="form-check-input">
                                    Approval
                                </label>
                            </div>
                            <input type="hidden" value="" name="module_id" id="module_id">
                            <input type="hidden" value="" name="user_id" id="user_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function printErrorMsg(msg) {
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
            };
            var error_html = '';
            for (var count = 0; count < msg.length; count++) {
                error_html += '<p>' + msg[count] + '</p>';
            }
            toastr.error(error_html);
        }

        function printSuccessMsg(msg) {
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
            };
            toastr.success(msg);
        }

        $('#permissionModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var module_name = button.data("mname");
            var module_id = button.data("mid");
            var user_id = button.data("uid");
            var create = button.data("create");
            var read = button.data("read");
            var update = button.data("update");
            var mdelete = button.data("delete");
            var cancel = button.data("cancel");
            var approval = button.data("approval");

            var modal = $(this);
            modal.find('#permissionModalLabel').text(module_name);
            modal.find('.modal-body #module_id').val(module_id);
            modal.find('.modal-body #user_id').val(user_id);

            if (create == 1) {
                modal.find('.modal-body #create').attr('checked', true);
            } else {
                modal.find('.modal-body #create').attr('checked', false);
            }
            if (read == 1) {
                modal.find('.modal-body #read').attr('checked', true);
            } else {
                modal.find('.modal-body #read').attr('checked', false);
            }
            if (update == 1) {
                modal.find('.modal-body #update').attr('checked', true);
            } else {
                modal.find('.modal-body #update').attr('checked', false);
            }
            if (mdelete == 1) {
                modal.find('.modal-body #mdelete').attr('checked', true);
            } else {
                modal.find('.modal-body #mdelete').attr('checked', false);
            }
            if (cancel == 1) {
                modal.find('.modal-body #cancel').attr('checked', true);
            } else {
                modal.find('.modal-body #cancel').attr('checked', false);
            }
            if (approval == 1) {
                modal.find('.modal-body #approval').attr('checked', true);
            } else {
                modal.find('.modal-body #approval').attr('checked', false);
            }

        })


    });
</script>
@endpush