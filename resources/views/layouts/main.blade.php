<!DOCTYPE html>
<html lang="pt-br">

    @include('components.head')

    <body class="{{ $background ?? '' }}">

        @php
            $route = Route::current()->getName();
        @endphp

        @if ($route != "login" && $route != "register" && $route != "password.reset" && $route != "password.request")

            @include('components.header')

        @endif


        @if (Auth::user() !== null)
            @php

                $user = Auth::user();

            @endphp

            {{-- @if ($user->role == 0 && $user->employee->is_new)

                <div class="modal fade new-employee" id="exampleModal">

                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">

                            <div class="modal-header d-flex justify-content-center">

                                <h5 class="modal-title align-content-center" id="exampleModalLabel">Complete seu cadastro</h5>

                            </div>

                            <div class="modal-body">

                                @include('components.alert')

                                <div class="page page-form">

                                    <form action="{{ url('employee') }}" method="POST">

                                        @csrf

                                        @method('PUT')

                                        <div class="row justify-content-center">

                                            <div class="col-md-12">

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="name" class="col-md-2 col-form-label text-md-end">Nome: </label>

                                                    <div class="col-md-10">

                                                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" readonly>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="email" class="col-md-2 col-form-label text-md-end">E-mail: </label>

                                                    <div class="col-md-10">

                                                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="cpf" class="col-md-2 col-form-label text-md-end">CPF: </label>

                                                    <div class="col-md-10">

                                                        <input type="text" name="cpf" id="cpf" class="form-control" value="{{ $user->employee->cpf }}" readonly>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="address" class="col-md-2 col-form-label text-md-end">Endereço: </label>

                                                    <div class="col-md-10">

                                                        <input type="text" name="address" id="address" class="form-control" required>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="rg" class="col-md-2 col-form-label text-md-end">RG: </label>

                                                    <div class="col-md-10">

                                                        <input type="text" name="rg" id="rg" class="form-control" required>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="phone" class="col-md-2 col-form-label text-md-end">Telefone: </label>

                                                    <div class="col-md-10">

                                                        <input type="text" name="phone" id="phone" class="phone form-control" required>

                                                    </div>

                                                </div>

                                                <div class="row mb-3 d-flex justify-content-center">

                                                    <label for="work_code" class="col-md-4 col-form-label text-nowrap">Carteira de trabalho:</label>

                                                    <div class="col-md-8">

                                                        <input type="text" name="work_code" id="work_code" class="work-code form-control" required>

                                                    </div>

                                                </div>

                                                <input type="hidden" name="id" value="{{ $user->employee->id }}">

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                            <div class="modal-footer d-flex justify-content-center"> --}}
                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                                {{-- <button type="button" class="btn btn-primary btn-save-employee">Save changes</button>

                            </div>

                        </div>

                    </div>

                </div>

            @endif --}}

        @endif

        <div class="container pt-4 pb-4 {{$teste ?? ''}}">
            @yield('content')
        </div>

        <link  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/sales.js') }}"></script>
        <script src="{{ asset('assets/js/alert.js') }}"></script>
        <script src="{{ asset('assets/js/mask.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.mask.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/user.js') }}"></script>
        <script src="{{ asset('assets/js/admin.js') }}"></script>
        <script src="{{ asset('assets/js/employee.js') }}"></script>
        <script src="{{ asset('assets/js/customer.js') }}"></script>
        <script src="{{ asset('assets/js/product.js') }}"></script>

    </body>


</html>
