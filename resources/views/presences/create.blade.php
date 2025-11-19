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
                    <h3>Presences</h3>
                    <p class="text-subtitle text-muted">Handle data presences</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('presences.index') }}">Presences</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Create Presence
                    </h5>
                </div>
                <div class="card-body">
                    @if (session('department') == 'HR')
                    <form action="{{ route('presences.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Check In</label>
                            <input type="text" class="form-control datetime" name="check_in" required>
                            @error('check_in')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Check Out</label>
                            <input type="text" class="form-control datetime" name="check_out" required>
                            @error('check_out')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Date</label>
                            <input type="text" class="form-control date" name="date" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="leave">Leave</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                    </form>
                    @else
                    <form action="{{ route('presences.store') }}" method="post">
                        @csrf
                        <div class="mb-3"><b>Note </b>: Mohon izinkan akses lokasi untuk melakukan presensi.</div>
                        <div class="mb-3">
                            <label for="" class="form-label">Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" disabled required>
                            <input type="hidden" name="latitude" id="latitude">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" disabled required>
                            <input type="hidden" name="longitude" id="longitude">
                        </div>
                        <div class="mb-3">
                            <div class="ratio ratio-16x9">
                                <iframe src="" allowfullscreen></iframe>
                            </div>
                        </div>
                        @if (!$todayPresence)
                            {{-- Jika BELUM check in --}}
                            <button class="btn btn-primary" type="submit" id="btn-present" disabled>Check In</button>
                        @elseif ($todayPresence && !$todayPresence->check_out)
                            {{-- Jika SUDAH check in tapi BELUM check out --}}
                            <button class="btn btn-success" type="submit">Check Out</button>
                        @else
                            {{-- Jika sudah check out --}}
                            <div class="alert alert-info">Kamu sudah menyelesaikan presensi hari ini.</div>
                        @endif
                    </form>

                    @endif
                </div>
            </div>

        </section>
    </div>

    <script>
        const iframe = document.querySelector('iframe');

        const officeLat = -6.310818530118753; //PPKPI
        const officeLon = 106.8632994532792;
        const threshold = 0.01;

        // -6.3029068299195545, 106.87665023793546 (Rumah Hadi)

        navigator.geolocation.getCurrentPosition(function(position){
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            iframe.src = `https://www.google.com/maps?q=${lat},${lon}&output=embed`;
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;

                    const distance = Math.sqrt(Math.pow(lat - officeLat, 2) + Math.pow(lon - officeLon, 2));

                    if (distance <= threshold) {
                        alert('Kamu berada di kantor, selamat bekerja!');
                        document.getElementById('btn-present').removeAttribute('disabled');
                    } else {
                        alert('Kamu tidak berada di kantor, pastikan kamu berada di kantor untuk melakukan presensi');
                    }
                });
            }
        });
    </script>
@endsection
