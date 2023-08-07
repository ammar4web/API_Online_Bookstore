<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::all()->load(['books']);
        return $publishers;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublisherRequest $request)
    {
        try {
            $publisher = new Publisher($request->validated());
            $publisher->save();

            $data = [
                'message' => 'publisher was added successfully',
                'publisher' => $publisher,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the publisher.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return $publisher->load(['books']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        try {

            $publisher->update($request->validated());
            $data = [
                'message' => 'publisher was updated successfully',
                'newPublisher' => $publisher,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the publisher.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        try {

            $publisher_delete = $publisher;
            $publisher->delete();
            $data = [
                'message' => 'publisher was deleted successfully',
                'new publisher' => $publisher_delete,
            ];

            return $data;

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Failed to add the publisher.',
                'erorr' => $e->getMessage(),
            ], 500);

        }
    }

    public function result(Publisher $publisher)
    {
        $books = $publisher->books()->paginate(12)->load(['category', 'authors']);
        $title = 'الكتب التابعة للناشر: ' . $publisher->name;

        $data = [
            'title' => $title,
            'books' => $books,
        ];

        return $data;
    }

    function list() {
        $publishers = Publisher::all()->sortBy('name')->load(['books']);
        $title = 'الناشرون';

        $data = [
            'title' => $title,
            'publishers' => $publishers,
        ];

        return $data;
    }

    public function search(Request $request)
    {
        $publishers = Publisher::where('name', 'like', "%{$request->term}%")->get()->sortBy('name')->load(['books']);
        $title = ' نتائج البحث عن: ' . $request->term;

        $data = [
            'title' => $title,
            'publishers' => $publishers,
        ];

        return $data;
    }
}
