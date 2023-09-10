@extends('layouts.master')

@section('title')
    User Listing
@endsection

@section('content')
    <section class="section">
        <form id="form">
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-4">
                    <label for="keyword" class="form-label">Free Text</label>
                    <input type="text" class="form-control" id="keyword" name="keyword"
                           value="{{ request("keyword") }}">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary" onclick="submitForm('{{ route("user.listing") }}')">Search</button>
                <div class="dropdown">
                    <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Export
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="javascript:void(0);"
                               onclick="redirectUrl('{{ route("user.export") }}')">All</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"
                               onclick="submitForm('{{ route("user.export") }}')">Filter</a></li>
                    </ul>
                </div>
                <button class="btn btn-outline-secondary" onclick="redirectUrl('{{ route("user.listing") }}')">
                    Reset
                </button>
            </div>
        </form>
        <script>
            function submitForm(url) {
                event.preventDefault();

                const form = document.getElementById("form");
                form.action = url;
                form.submit();
            }

            function redirectUrl(url) {
                event.preventDefault();
                window.location = url;
            }
        </script>
    </section>

    <section class="section">
        <div class="d-flex justify-content-end mb-4">
            <a class="ms-auto" href="{{ route("user.add") }}">
                <button type="button" class="btn btn-success">
                    <span class="mdi mdi-plus"></span>
                    Add User
                </button>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th colspan="2">Details</th>
                </tr>
                </thead>
                <tbody>
                @forelse($user_list as $user)
                    <tr class="cursor-pointer"
                        onclick="window.location='{{ route("user.detail", ["user_id" => $user->id]) }}'">
                        <th>{{ $user->id }}</th>
                        <td style="min-width: 300px;">
                            <div class="d-flex gap-3">
                                @if($user->getFirstDocument("profile_image"))
                                    <img class="profile-image-round-70"
                                         src="{{ $user->getFirstDocument("profile_image")->url }}"
                                         alt="{{ $user->getFirstDocument("profile_image")->file_name }}"/>
                                @else
                                    <img class="profile-image-round-70"
                                         src="{{ asset('assets/images/profile-placeholder.jpg') }}"
                                         alt="profile-placeholder"/>
                                @endif

                                <div>
                                    <h6>{{ $user->full_name }}</h6>
                                    <p>{{ $user->email }}</p>
                                    <p>{{ date_format(date_create($user->birthdate),"d M Y") }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="min-width: 300px;">
                            <div class="d-flex flex-column gap-4">
                                @forelse($user->address_list->sortBy('address_type_id') as $address)
                                    @if($address->address_type->is_active)
                                        <div>
                                            <h6>{{ $address->address_type->name }}</h6>
                                            <p>{{ "$address->address," }}</p>
                                            <p>{{ "$address->zipcode $address->city," }}</p>
                                            <p>{{ "$address->state, $address->country." }}</p>
                                        </div>
                                    @endif
                                @empty
                                @endforelse
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No record found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($user_list->hasPages())
            <div class="mt-4">
                {{ $user_list->links() }}
            </div>
        @endif
    </section>

@endsection
