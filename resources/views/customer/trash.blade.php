@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <!-- Card Header with Responsive Actions -->
                    <div class="card-header bg-white">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <h3 class="mb-3 mb-md-0">Customer Trash List</h3>

                            <div class="d-flex flex-column flex-md-row gap-3">
                                <a href="{{ route('customers.index') }}" class="btn mb-3"
                                    style="background-color: #4643d3; color: white;"><i class="fas fa-chevron-left"></i>
                                    Back</a>

                                <!-- Search Form -->
                                <form action="{{ route('customers.trash') }}" method="GET" class="flex-grow-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search customers..."
                                            name="search" value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Sort Dropdown -->
                                <form action="{{ route('customers.index') }}" method="GET" class="order-form">
                                    <select class="form-select" name="order" onchange="this.form.submit()">
                                        <option value="desc" @selected(request()->order == 'desc')>Newest First</option>
                                        <option value="asc" @selected(request()->order == 'asc')>Oldest First</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body with Responsive Table -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Birth Date</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Bank Account</th>
                                        <th width="12%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $customer->first_name }}</td>
                                            <td>{{ $customer->last_name }}</td>
                                            <td>{{ $customer->birth_date ? \Carbon\Carbon::parse($customer->birth_date)->format('M d, Y') : '-' }}
                                            </td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->bank_account_number }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- View Button -->
                                                    <a href="{{ route('customers.show', $customer->id) }}"
                                                        class="btn btn-sm" title="View">
                                                        <i class="far fa-eye"></i>
                                                    </a>

                                                    <form action="{{ route('customers.restore', $customer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm" title="Restore">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('customers.force-delete', $customer->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Delete Permanently Customer Data of {{ $customer->first_name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">No Trahsed customers
                                                found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        {{-- @if ($customers->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $customers->withQueryString()->links() }}
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header .d-flex {
                gap: 1rem !important;
            }

            .order-form {
                width: 100%;
            }

            .table-responsive {
                border: 0;
            }

            .table-responsive table {
                width: 100%;
                margin-bottom: 1rem;
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
            }
        }

        /* Hover effects */
        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-danger:hover {
            color: white !important;
        }

        /* Action buttons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
    </style>
@endpush
