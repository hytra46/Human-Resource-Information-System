@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

            <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Leave Requests</h3>
                    <p class="text-subtitle text-muted">Handle data leave requests</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leave Requests</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        View Leave Requests
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <a href="{{ route('leave-requests.create') }}" class="btn btn-primary mb-3 ms-auto">New Leave Request</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show auto-dismiss-alert"><i class="bi bi-check-circle"></i> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                    @endif
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                @if (session('department') == 'HR')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveRequests as $leaveRequest)
                            <tr>
                                <td>{{ $leaveRequest->employee->fullname }}</td>
                                <td>{{ $leaveRequest->leave_type }}</td>
                                <td>{{ $leaveRequest->start_date }}</td>
                                <td>{{ $leaveRequest->end_date }}</td>
                                <td>
                                @if ($leaveRequest->status == 'confirm')
                                    <span class="text-success">{{ ucfirst($leaveRequest->status) }}</span>
                                @elseif ($leaveRequest->status == 'reject')
                                    <span class="text-danger">{{ ucfirst($leaveRequest->status) }}</span>
                                @else
                                    <span class="text-warning">{{ ucfirst($leaveRequest->status) }}</span>
                                @endif
                                </td>
                                <td>
                                    @if (session('department') == 'HR')
                                    @if ($leaveRequest->status == 'pending' || $leaveRequest->status == 'reject')
                                    <a href="{{ route('leave-requests.confirm', $leaveRequest->id) }}" class="btn btn-success btn-sm">Confirm</a>
                                    @else
                                    <a href="{{ route('leave-requests.reject', $leaveRequest->id) }}" class="btn btn-secondary btn-sm">Reject</a>
                                    @endif
                                    <a href="{{ route('leave-requests.edit', $leaveRequest->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('leave-requests.destroy', $leaveRequest->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection
