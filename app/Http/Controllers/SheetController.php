<?php

namespace App\Http\Controllers;

use App\Sheet;
use App\Events\SheetUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sheet = Sheet::create([
            'name' => 'Untitled spreadsheet',
            'user_id' => Auth::id(),
            'content' => [[]],
        ]);
        return redirect(route('sheets.show', ['sheet' => $sheet]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sheet = Sheet::findOrFail($id);

        return view('sheet.show', ['sheet' => $sheet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sheet = Sheet::findOrFail($id);
        $change = request('change');
        // info($request->changes);
        [$rowIndex, $columnIndex, $oldValue, $newValue] = $change;
        $sheet->content = $this->updateCell($rowIndex, $columnIndex, $newValue, $sheet->content);
        $sheet->save();
        broadcast(new SheetUpdated($sheet, $change))->toOthers();
        return response()->json(['sheet' => $sheet]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sheet = Sheet::findOrFail($id);
        $sheet->delete();
        return back();
    }

    protected function updateCell($rowIndex, $columnIndex, $newValue, $sheetContent)
    {
        for ($row = 0; $row <= $rowIndex; $row++) {
            if (!isset($sheetContent[$row])){
                $sheetContent[$row] = [];
            }

            for ($column = 0; $column <= $columnIndex; $column++) {
                if (!isset($sheetContent[$row][$column])){
                    $sheetContent[$row][$column] = null;
                }
            }
        }
        $sheetContent[$rowIndex][$columnIndex] = $newValue;
        return $sheetContent;
    }
}
