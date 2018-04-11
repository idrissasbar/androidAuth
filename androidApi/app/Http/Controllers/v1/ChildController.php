<?php

namespace App\Http\Controllers\v1;

use App\Services\v1\ChildrensService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected  $childrens;

    public function  __construct(ChildrensService $service)
    {
        $this->childrens = $service;
    }
    public function index()
    {
        $params = request()->input();
        $data = $this->childrens->getChildrens($params);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         try{
             $child = $this->childrens->createChild($request);
             if($child!=null){
                return response()->json(ChildrensService::staticFilterChildrens([$child],[])[0],201);
             }else{
                return response()->json($child,421);
             }
        }catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $params = request()->input();
        $params['id'] = $id;
        $data = $this->childrens->getChildrens($params);
        return response()->json($data);
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
        try{
            $child = $this->childrens->updateChild($request,$id);
            return response()->json($child,200);
        }catch (ModelNotFoundException $ex){
            return  response()->json(['error'=>$ex->getMessage()],421);
        }
        catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->childrens->deleteChild($id);
            return response()->json('',204);
        }catch (ModelNotFoundException $ex){
            return  response()->json(['error'=>$ex->getMessage()],421);
        }
        catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
    }

}
