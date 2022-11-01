<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Http\Resources\OfficeResource;
use App\Models\Office;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;


class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['create', 'update']);
    }

    public function index()
    {
        $offices = Office::query()->where(
            'approval_status',
            Office::APPROVAL_APPROVED
        )->where('hidden', false)->when(
            request('host_id'),
            fn(Builder $build) => $build->whereUserId(request('host_id'))
        )->when(
            request('visitor_id'),
            fn(Builder $build) => $build->whereRelation(
                'reservations',
                'user_id',
                '=',
                request('visitor_id')
            )
        )->when(
            request('lat') && request('lng'),
            fn(Builder $builder) => $builder->nearestTo(
                request('lat'),
                request('lng')
            ),
            fn(Builder $builder) => $builder->orderBy('id', 'ASC')
        )->latest('id')->with(['images', 'tags', 'user'])->withCount([
            'reservations' =>
                fn(Builder $builder) => $builder->where(
                    'status',
                    Reservation::STATUS_ACTIVE
                ),
        ])->paginate(20);

        return OfficeResource::collection($offices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreOfficeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest $request)
    {
        $office = Office::create(Arr::except($request->validated(), ['tags']));
        $office->tags()->sync($request->tags);

        return response()->json(
            OfficeResource::make($office->load(['images', 'tags', 'user']))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Office $office
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        $office->loadCount([
            'reservations' =>
                fn(Builder $builder) => $builder->where(
                    'status',
                    Reservation::STATUS_ACTIVE
                ),
        ]);

        return OfficeResource::make($office);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Office $office
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateOfficeRequest $request
     * @param \App\Models\Office                     $office
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $office->update($request->validated());
        $office->tags()->sync($request->tags);

        return response()->json(
            OfficeResource::make($office->load(['images', 'tags', 'user']))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Office $office
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }
}
