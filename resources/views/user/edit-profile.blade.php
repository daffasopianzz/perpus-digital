@extends('layouts.app')

@section('content')
    <div class="container">
    @include('sweetalert::alert')
        <div class="row justify-content-center">
            <div class="container-xl px-4 mt-4">
                <h2>
                <a href="{{route('home')}}">Dasboard</a>/
                Edit Profile
                </h2>
                <hr class="mt-0 mb-4">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/foto_user.png') }}" alt="cover" height="280" width="280">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <form action="{{route('editProfile')}}" method="post">
                                @csrf
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-12">
                                            <label class="small mb-1" for="name">Nama</label>
                                            <input class="form-control" id="name" name="name" type="text" placeholder="Enter your first name" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-12">
                                            <label class="small mb-1" for="name">Email</label>
                                            <input class="form-control" id="email" name="email" type="text" placeholder="Enter your first email" value="{{ $user->email }}"  readonly>
                                        </div>
                                    </div>
                                    @if ($user->role != 4)
                                        <div class="row gx-3 mb-3">
                                            <!-- Form Group (phone number)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="no_hp">No Hp</label>
                                                <input type="hidden" name="id" class="form-control" value="{{ $user->id }}">
                                                <input class="form-control" id="no_hp" type="text" name="no_hp" placeholder="Enter your phone number" value="{{ $user->no_hp }}">
                                            </div>
                                            <!-- Form Group (birthday)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputBirthday">Alamat</label>
                                                <input class="form-control" id="inputAlamat" type="text" name="alamat" placeholder="Enter your Adress" value="{{ $user->alamat }}">
                                            </div>
                                        </div>
                                    @else
                                    <small class="text-muted">
                                        Anda Harus Daftar Member dulu untuk mengisi field
                                    </small>
                                    <div class="row gx-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="no_hp">No Hp</label>
                                                <input class="form-control" id="no_hp" type="text" name="no_hp" placeholder="Enter your phone number" value="{{ $user->no_hp }}" readonly>
               
                                            </div>
                                            <!-- Form Group (birthday)-->
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputBirthday">Alamat</label>
                                                <input class="form-control" id="inputAlamat" type="text" name="Alamat" placeholder="Enter your Adress" value="{{ $user->alamat }}" readonly>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })
    </script>
@endsection
