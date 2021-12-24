@extends('layouts.app')
@section('content')
  <section>
    <div class="row">
        <div class="col">
            @if (Session::has('message'))
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="alert alert-success mt-3 mb-3">
                            {!! \Session::get('message') !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($errors->any())
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="alert alert-danger mt-3 mb-3">
                            {{ implode('', $errors->all(':message')) }}
                        </div>
                    </div>
                </div>
            </div>
                
            @endif
        </div>
    </div>
  </section>
  <section class="container">
      <div class="row">
         <div class="col">
            <table class="table">
                <thead class="bg-dark text-white">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                     @php
                         $count = 1;
                     @endphp
                    @foreach ($data as $user)
                        <tr>
                            <th scope="row">{{$count}}</th>
                            <td id="fname-{{$user->id}}" data-value="{{$user->name}}">{{$user->name}}</td>
                            <td  id="lname-{{$user->id}}" data-value="{{$user->lastname}}">{{$user->lastname}}</td>
                            <td id="email-{{$user->id}}" data-value="{{$user->email}}">{{$user->email}}</td>
                            <td> 
                                <span type="button" class="" data-toggle="modal" onclick="beforeModal({{$user->id}})" data-target="#editModal">
                                    <i class="bi bi-pencil-square"></i></a> 
                                </span>
                                / <a href={{url("wordfile/".$user->id)}}><i class="bi bi-printer"></i></a>
                            </td>
                        </tr>    
                        @php
                            $count++;
                        @endphp          
                    @endforeach
                </tbody>
              </table>
         </div>
      </div>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editUser" action="" method="POST">
                <input name="_method" type="hidden" value="PUT">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('First name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                    <div class="col-md-6">
                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"  name="lastname" required autocomplete="name" autofocus>

                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="mail" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Change Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-success">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
  </section>
@endsection
@section('scripts')
   <script>
       function beforeModal(id){
          $("#name").val($('#fname-'+id).attr('data-value'))
          $("#lastname").val($('#lname-'+id).attr('data-value'))
          $("#mail").val($('#email-'+id).attr('data-value'))
          $('#editUser').attr('action','{{url("users")}}/'+id)
       }
       $(document).ready(function(){
            setTimeout(function() {
                $('div.alert').hide();
            }, 4000);

        });
   </script>
@endsection
