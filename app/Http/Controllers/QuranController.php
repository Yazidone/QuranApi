<?php

namespace App\Http\Controllers;

use App\Models\Quran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quran = Quran::all();
        return response()->json($quran);
    }<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qurans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('voice_reader');
            $table->string('audio_file');
            $table->time('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qurans');
    }
};


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('audio_file')){
            $file = $request->file('audio_file');
            $destinationPath = public_path('mp3');
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
        }else{
            $fileName = $request->audio_file;
            // return response()->json([
            //     'message' => 'created'
            // ]); 
        }
        $quran = Quran::create([
            'title' => $request->title,
            'voice_reader' => $request->voice_reader,
            'duration' => $request->duration,
            'audio_file' => $fileName
        ]);
        return response()->json([
            'message' => 'created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quran = Quran::find($id);
        return response()->json($quran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $quran = Quran::find($id);
        $quran->update($request->all());
        return response()->json([
           'message' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $quran = Quran::find($id);
        $quran->delete();
        return response()->json([
            'message' => 'deleted'
        ]);
    }
}
