<?php

namespace App\Http\Controllers;

use App\Common\UserList;
use App\Common\ListEnum;
use App\Http\Requests\PrestationRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Prestation;

class PrestationController extends Controller
{

    private $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth', ['except' => ['pdf']]);
        $this->middleware('admin', ['except' => ['pdf']]);
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestations = Prestation::where('isObsolete', '=', 'false')->orderBy('name', 'DESC')->get();
        return view('admin.prestation.index', compact('prestations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prestation = new Prestation();
        return view('admin.prestation.create', compact('prestation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrestationRequest $request)
    {
        $prestation = new Prestation($request->only(['name', 'duration', 'description', 'url']));
        $prestation->save();
        return redirect(route('admin.prestation.edit', ['id' => $prestation->id]))->with('success', 'Prestation enregistrées. Elle ne sera visible qu\'après publication');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prestation = Prestation::findOrFail($id);
        return response()->json($prestation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prestation = Prestation::findOrFail($id);
        return view('admin.prestation.edit', compact('prestation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrestationRequest $request, $id)
    {
        $prestation = Prestation::findOrFail($id);
        if($prestation->canEdit()){
            $prestation->update($request->only(['name', 'duration', 'description', 'url']));
            return redirect(route('admin.prestation.edit', ['id' => $id]))->with('success', 'Prestation modifiée avec succés');
        }

        return redirect()->back()->withErrors('Interdiction de modifier cette prestation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prestation = Prestation::findOrFail($id);
        if($prestation->canEdit()){
            $prestation->delete();
            return redirect(route('admin.prestation.index'))->with('success', 'Prestation supprimée');
        }

        return redirect()->back()->withErrors('Interdiction de modifier cette prestation');
    }

    public function publish($id) {
        $prestation = Prestation::findOrFail($id);
        if($prestation->canEdit()){
            $prestation->isPublished = true;
            $prestation->save();
            return redirect(route('admin.prestation.edit', ['id' => $id]))->with('success', 'Prestation publiée avec succés');
        }

        return redirect()->back()->withErrors('Interdiction de publier cette prestation');
    }

    public function toObsolete($id) {
        $prestation = Prestation::findOrFail($id);
        if($prestation->isPublished && !$prestation->isObsolete){
            $prestation->isObsolete = true;
            $prestation->save();
            return redirect(route('admin.prestation.edit', ['id' => $id]))->with('success', 'Prestation passée en statut Obsolete');
        }

        return redirect()->back()->withErrors('Interdiction de rendre obsolete cette prestation');
    }

    public function toNotObsolete($id) {
        $prestation = Prestation::findOrFail($id);
        if($prestation->isPublished && $prestation->isObsolete){
            $prestation->isObsolete = false;
            $prestation->save();
            return redirect(route('admin.prestation.edit', ['id' => $id]))->with('success', 'Prestation passée en statut NON Obsolete');
        }

        return redirect()->back()->withErrors('Interdiction de rendre non obsolete cette prestation');
    }

    public function pdf() {
        $prestations = Prestation::where('isObsolete', '=', 'false')->orderBy('name', 'DESC')->get();
        $content = view('pdf.prestation.index', compact('prestations'))->__toString();
        $header = view('pdf.header.view', compact('prestations'))->__toString();
        $footer = view('pdf.footer.view')->__toString();
        $css = file_get_contents(asset('css/pdf.min.css'),false,stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));

        $mpdf = new \mPDF();

        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        //$mpdf->Bookmark('Start of the document');
        $mpdf->AddPageByArray([
            'margin-left' => 10,
            'margin-right' => 10,
            'margin-top' => 30,
            'margin-bottom' => 30,
            'margin-header' => 10,
            'margin-footer' => 10
        ]);
        $mpdf->WriteHTML($css,1);
        $mpdf->WriteHTML($content,2);
        $mpdf->Output();
    }

}
