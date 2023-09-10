@extends('layouts.master')

@section('title')
    User Detail
@endsection

@section('content')
    <section class="section">
        <div class="d-flex justify-content-end mb-4">
            <a class="ms-auto" href="{{ route("user.edit",["user_id" => $user->id]) }}">
                <button type="button" class="btn btn-warning">
                    <span class="mdi mdi-account-edit"></span>
                    Edit User
                </button>
            </a>
        </div>

        <div class="row row-gap-4">
            <div class="col-12 col-xl-4">
                <div class="d-flex flex-column gap-4">

                    @if($profile_image = $user->getFirstDocument("profile_image"))
                        <a href="{{ $profile_image->url }}" target="_blank">
                            <img class="profile-image"
                                 src="{{ $profile_image->url }}"
                                 alt="{{ $profile_image->file_name }}"/>
                        </a>
                    @else
                        <img class="profile-image"
                             src="{{ asset('assets/images/profile-placeholder.jpg') }}"
                             alt="profile-placeholder"/>
                    @endif
                    <div>
                        <h5 class="mb-1">{{ $user->full_name }}</h5>
                        <p>{{ $user->email }}</p>
                        <p>{{ date_format(date_create($user->birthdate),"d M Y") }}</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="d-flex flex-column gap-4">
                    @forelse($user->address_list->sortBy('address_type_id') as $address)
                        <div>
                            <h5 class="mb-1">{{ $address->address_type->name }}</h5>
                            <p>{{ "$address->address," }}</p>
                            <p>{{ "$address->zipcode $address->city," }}</p>
                            <p>{{ "$address->state, $address->country." }}</p>
                            @if($proof_document = $address->getFirstDocument("proof_document"))
                                <a href="{{ $proof_document->url }}" target="_blank">
                                    <span class="mdi mdi-file mdi-18px"></span>
                                    {{ $proof_document->file_name }}
                                </a>
                            @endif
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
