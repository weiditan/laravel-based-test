@extends('layouts.master')

@section('title')
    User {{ $action == "update" ? "Edit" : "Add" }}
@endsection

@section('content')
    <form method="post" action="{{ route("user.update") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="action" value="{{ $action }}">
        <input type="hidden" name="user_id" value="{{ $user?->id }}">

        <section class="section">
            <h5 class="mb-4">User Detail</h5>
            <div class="row row-gap-3">
                <div class="col-12 col-xl-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old("email", $user?->email) }}">
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                           value="{{ old("first_name", $user?->first_name) }}">
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                           value="{{ old("last_name", $user?->last_name) }}">
                </div>
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="text" class="form-control" id="birthdate" name="birthdate"
                           value="{{ old("birthdate", $user?->birthdate) }}">
                </div>
                <div class="col-12 col-xl-6">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <div class="mb-2">
                        @if($profile_image = $user?->getFirstDocument("profile_image"))
                            <a href="{{ $profile_image->url }}" target="_blank">
                                <img class="profile-image"
                                     src="{{ $profile_image->url }}"
                                     alt="{{ $profile_image->file_name }}"/>
                            </a>
                        @endif
                    </div>
                    <input class="form-control" type="file" id="profile_image" name="profile_image">
                </div>
            </div>
        </section>

        @forelse($address_type_list as $address_type)
            <section class="section">
                <h5 class="mb-4">{{ $address_type->name }}</h5>
                <input type="hidden" name="address_list[{{ $address_type->id }}][address_type_id]"
                       value="{{ $address_type->id }}">
                <div class="row row-gap-3">
                    <div class="col-12 col-xl-4">
                        <label for="address_{{ $address_type->id }}" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address_{{ $address_type->id }}"
                               name="address_list[{{ $address_type->id }}][address]"
                               value="{{ old("address_list")[$address_type->id]["address"] ?? $user->input_address_list[$address_type->id]["address"] ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <label for="zipcode_{{ $address_type->id }}" class="form-label">Zipcode</label>
                        <input type="text" class="form-control" id="zipcode_{{ $address_type->id }}"
                               name="address_list[{{ $address_type->id }}][zipcode]"
                               value="{{ old("address_list")[$address_type->id]["zipcode"] ?? $user->input_address_list[$address_type->id]["zipcode"] ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <label for="city_{{ $address_type->id }}" class="form-label">City</label>
                        <input type="text" class="form-control" id="city_{{ $address_type->id }}"
                               name="address_list[{{ $address_type->id }}][city]"
                               value="{{ old("address_list")[$address_type->id]["city"] ?? $user->input_address_list[$address_type->id]["city"] ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <label for="state_{{ $address_type->id }}" class="form-label">State</label>
                        <input type="text" class="form-control" id="state_{{ $address_type->id }}"
                               name="address_list[{{ $address_type->id }}][state]"
                               value="{{ old("address_list")[$address_type->id]["state"] ?? $user->input_address_list[$address_type->id]["state"] ?? '' }}">
                    </div>
                    <div class="col-12 col-lg-6 col-xl-4">
                        <label for="country_{{ $address_type->id }}" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country_{{ $address_type->id }}"
                               name="address_list[{{ $address_type->id }}][country]"
                               value="{{ old("address_list")[$address_type->id]["country"] ?? $user->input_address_list[$address_type->id]["country"] ?? '' }}">
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="proof_document_{{ $address_type->id }}" class="form-label">Proof Document</label>
                        <div class="mb-2">
                            @if(!empty($user->input_address_list[$address_type->id]) && $proof_document = $user->input_address_list[$address_type->id]->getFirstDocument("proof_document"))
                                <a href="{{ $proof_document->url }}" target="_blank">
                                    <span class="mdi mdi-file mdi-18px"></span>
                                    {{ $proof_document->file_name }}
                                </a>
                            @endif
                        </div>
                        <input class="col-6 form-control" type="file" id="proof_document_{{ $address_type->id }}"
                               name="address_list[{{ $address_type->id }}][proof_document]">


                    </div>
                </div>
            </section>
        @empty
        @endforelse

        <section class="section">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button
                onclick="event.preventDefault(); window.location='{{ $user?->id ? route("user.detail", ["user_id" => $user->id]) : route("user.listing") }}'"
                class="btn btn-outline-secondary">Back
            </button>
        </section>
    </form>
@endsection
