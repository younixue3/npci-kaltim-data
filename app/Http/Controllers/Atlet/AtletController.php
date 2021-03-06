<?php

namespace App\Http\Controllers\Atlet;

use App\Imports\AtletImport;
use App\Exports\AtletExport;
use App\Http\Controllers\Controller;
use App\Models\CabangOlahraga;
use Illuminate\Http\Request;
use App\Models\Atlet;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Atlet\Data\AtletController as DataController;

use Session, Storage;

class AtletController extends Controller
{
    public function __construct(Request $request, DataController $data)
    {
        $this->middleware('auth');
        $this->data = $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($request);
        $atlet = $this->data->get_data($request);
        $data = compact('atlet');

        return view('atlet/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('atlet/add');
    }

    public function formCreate()
    {
        $cabor = CabangOlahraga::get();
        $data = compact('cabor');
        return view('atlet/add_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->data->store_data($request)) {
            Session::forget('no_ktp');
            return redirect()->route('atlet.add')->with('success', 'sukses');
        }
        return redirect()->back()->with('error', 'gagal');
    }

    public function simpan(Request $request)
    {
//        return response($request);
//        return response()->json([ 'data' => $request ]);
        return $this->data->form_store_data($request);
    }

    public function uploadgambar(Request $request)
    {
        $atlet = Atlet::find($request->atlet_id);
        $filename = $atlet->no_ktp . '_' . rand('00000','99999').'.png';
        Storage::disk('upload')->putFileAs('kk', $request->gambar_kk , $filename);
        $atlet->link_kartu_keluarga = $filename;
        $filename = $atlet->no_ktp . '_' . rand('00000','99999').'.png';
        Storage::disk('upload')->putFileAs('ktp', $request->gambar_ktp , $filename);
        $atlet->link_ktp = $filename;
        $filename = $atlet->no_ktp . '_' . rand('00000','99999').'.png';
        Storage::disk('upload')->putFileAs('pasfoto', $request->gambar_pasfoto , $filename);
        $atlet->link_pas_foto = $filename;
        $atlet->save();
        return redirect()->route('atlet.form_add')->with('success', 'sukses');

    }

    public function store_sevent(Request $request)
    {
//        return response($request);
        return $this->data->form_store_sevent_data($request);
    }

    public function store_mevent(Request $request)
    {
        return $this->data->form_store_mevent_data($request);
    }

    public function export(Request $request)
    {
//        return Excel::import([AtletImport::class, 'SingleEventExport'], public_path('/DataAtlet/atlet.xlsx'));;
//        return Atlet::all();
        return Excel::download(new AtletExport, 'export.xlsx');
    }

    public function export_atlet($id)
    {
        $data = $this->data->get_show_data($id);
        $single_event =  $this->data->get_single_event_data($id);
        $multi_event =  $this->data->get_multi_event_data($id);
//        dd($data->);
        $data = compact('data', 'single_event', 'multi_event');
        return view('atlet/output/pdf', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $atlet = $this->data->edit_data($id);
        return view('atlet/edit_form', $atlet);
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
        $atlet = $this->data->update_data($request, $id);
        return $atlet;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $atlet = $this->data->destroy_data($id);
        return redirect(route('atlet.index'));
    }

    public function download()
    {
        $file = public_path(). "/format_biodata.xlsx";

        $headers = array(
            'Content-Type: application/vnd.ms-excel',
        );

        return response()->download($file, 'format_biodata.xlsx', $headers);
    }
}
