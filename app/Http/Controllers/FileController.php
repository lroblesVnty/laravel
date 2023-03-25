<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    function store(Request $request){
        
        $request->validate([
            'file'=>'required|mimes:jpg,png,pdf|max:2048'
        ]);

        $uploadedFile=$request->file('file');
        //$filename=date("Y-m-d-").$uploadedFile->getClientOriginalName();
        $filename=time().'_'.$uploadedFile->getClientOriginalName();

        Storage::putFileAs('files/',$uploadedFile,$filename);

        $upload = new File();
        $upload->filename = $filename;
        $upload->save();

        return response(['success'=>true,'msg'=>'Your file was submitted successfully'],201);


    }

    public function find($file){
        $arch=File::findOrFail($file,['id','filename']);
        
       
       // $exists = Storage::url($arch->filename);
        return $arch;
        //return Storage::response("files/$arch->filename"); return image

        //return $arch;
        /*try {
            $arch=File::findOrFail($file)->get();
            return  $arch;
                   
        } catch (ModelNotFoundException $e) {
             //return response(['error' => true, 'message' => $e],204);
             return response(['error' => true, 'message' => 'Sin coincidencias'],204);
        }*/
    }

    //public function destroy($file){
    public function destroy(File $file){
       
        $ruta="files/".$file->filename;
        if(Storage::exists($ruta)){
            //return $file;
            Storage::delete($ruta);
            $del=$file->delete();
            if ($del>=1) {
                return response(['success' => true, 'message' => 'Eliminado exitosamente'],200);
            }
            return $del;

            /*
                Delete Multiple files this way
                Storage::delete(['upload/test.png', 'upload/test2.png']);
            */
        }else{
            return response(['error' => true, 'message' => 'La imagen no existe'],204);
        }
        
        /*try {
            $arch=File::findorFail($file);
            return $arch;
        }  catch (ModelNotFoundException $e) {
            return response(['error' => true, 'message' => $e],204);
        }*/
        
       
        
        
    }
}
