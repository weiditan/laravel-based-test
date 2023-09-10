<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;

class UserController extends Controller
{
    public function user_listing(Request $request): View|RedirectResponse
    {
        if ($request->input("submit") == "reset") {
            return redirect(route("user.listing"));
        }

        $user_list = User::query()
            ->with(["address_list.address_type"])
            ->when($request->filled("keyword"), function (Builder $query_keyword) use ($request) {
                $query_keyword
                    ->where("email", "=", $request->input("keyword"))
                    ->orWhere("first_name", "like", "%" . $request->input("keyword") . "%")
                    ->orWhere("last_name", "like", "%" . $request->input("keyword") . "%");
            })
            ->orderBy("created_at")
            ->paginate(10);

        return view("user::user_listing", [
            "user_list" => $user_list,
        ]);
    }

    public function user_detail($user_id): View
    {
        $user = User::query()->findOrFail($user_id);

        return view("user::index", [
            "user" => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view("user::create");
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view("user::show");
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view("user::edit");
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
