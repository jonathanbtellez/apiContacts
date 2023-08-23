<?php

namespace App\Http\Controllers;

use  App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactResource::collection(Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request): JsonResource
    {
        // $contact = new Contact();
        // $contact->name = $request->name;
        // $contact->number = $request->number;
        // $contact->save();

        $contact = Contact::create($request->all());

        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResponse
    {
        $contact = Contact::find($id);
        // return response()->json($contact);
        $response = null;
        if($contact){
            $response = response()->json([
                'success' => true,
                'data' => new ContactResource($contact)
            ], 200);
        }else{
            $response = response()->json([], 404);
        }
        return $response;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, string $id):JsonResponse
    {
        $contact = Contact::find($id);
        $contact->update($request->all());
        return response()->json([
            'success' => true,
            'data' => new ContactResource($contact)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        $contact = Contact::find($id);
        $contact->delete();
        return response()->json(['success' => true],204);
    }
}
