<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Hazzard\Filepicker\Handler;
use Hazzard\Filepicker\Uploader;
use Intervention\Image\ImageManager;
use Hazzard\Config\Repository as Config;
use Illuminate\Support\Facades\Storage;
use File;

class FilepickerController extends Controller
{
    /**
     * @var \Hazzard\Filepicker\Handler
     */
    protected $handler;
    protected $config;

    /**
     * Create a new controller instance.
     */
    public function __construct(Request $request)
    {
        $data =$request->all();
        /* $codigo_prop = $data['codigo_prop']; */

        $this->config = new Config;
        $this->handler = new Handler(
            new Uploader($this->config , new ImageManager)
        );
        $this->config ['max_file_size'] = 5242880; //en bytes
        $this->config ['upload_dir'] =  public_path('img/productos/');
        $this->config ['upload_url'] = url('/img/productos/');
        $this->config ['accept_file_types'] = 'jpg|jpeg|png|gif';
        $this->config ['debug'] = config ('app.debug');
        $this->config ['keep_original_image'] = true;
        $this->config ['overwrite '] = false;
        $this->config ['name'] = 5;
        $this->config ['image_versions.thumb'] = array(
            'width' => 220,
            'height' => 220
        );

        //dd($config);exit;
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request)
    {
        /**
         * Fired before the file upload starts.
         *
         * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
         */
        $this->handler->on('upload.before', function ($file) use ($request){
            if(!$request->has('cod_fenovo') || $request->input('cod_fenovo') == '' ) throw new \Hazzard\Filepicker\Exception\AbortException('la imágen no fue subida correctamente, debe ingresar un código de fenovo para subirla correctamente!');
            $file->save =  $file->getClientOriginalName();
            //
        });

        /**
         * Fired on upload success.
         *
         * @param \Symfony\Component\HttpFoundation\File\File $file
         */
        $this->handler->on('upload.success', function ($file) {
        });

        /**
         * Fired on upload error.
         *
         * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
         */
        $this->handler->on('upload.error', function ($file) {

        });

        /**
         * Fired when fetching files.
         *
         * @param array &$files
         */
        $this->handler->on('files.fetch', function (&$files) {
            // Set the array of files to be returned.
            // $files = array('file1', 'file2', 'file3');
        });

        /**
         * Fired on file filtering.
         *
         * @param array &$files
         * @param int   &$total
         */
        $this->handler->on('files.filter', function (&$files, &$total) {

        });

        /**
         * Fired on file download.
         *
         * @param \Symfony\Component\HttpFoundation\File\File $file
         * @param string $version
         */
        $this->handler->on('file.download', function ($file, $version) {
        });

        /**
         * Fired on file deletion.
         *
         * @param \Symfony\Component\HttpFoundation\File\File $file
         */
        $this->handler->on('file.delete', function ($file) {

        });

        /**
         * Fired before cropping.
         *
         * @param \Symfony\Component\HttpFoundation\File\File $file
         * @param \Intervention\Image\Image $image
         */
        $this->handler->on('crop.before', function ($file, $image) {

        });

        /**
         * Fired after cropping.
         *
         * @param \Symfony\Component\HttpFoundation\File\File $file
         * @param \Intervention\Image\Image $image
         */
        $this->handler->on('crop.after', function ($file, $image) {

        });


        return $this->handler->handle($request);
    }

    public function deleteImg(Request $request)
    {
        if ($request->ajax()) {
            $data=$request->all();
            //$prop = Propiedades::select('codigo')->where('id',$data['codigo'])->first();

            $file = 'img/propiedades/'.$data['codigo'].'/'.$data['nombre'];
            if(File::exists($file)) File::delete($file);

            $thumb = 'img/propiedades/'.$data['codigo'].'/thumb/'. $data['nombre'];
            if(File::exists($thumb)) FIle::delete($thumb);
        }
    }
}
