<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ImageUploadCreateRequest;
use App\Http\Requests\ImageUploadUpdateRequest;
use App\Repositories\ImageUploadRepository;
use App\Validators\ImageUploadValidator;
use App\Http\Controllers\API\BaseApiController;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

/**
 * Class ImageUploadsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ImageUploadsController extends BaseApiController
{
    /**
     * @var imageUploadRepo
     */
    protected $imageUploadRepo;

    /**
     * @var ImageUploadValidator
     */
    protected $validator;

    /**
     * ImageUploadsController constructor.
     *
     * @param ImageUploadimageUploadRepo $imageUploadRepo
     * @param ImageUploadValidator $validator
     */
    public function __construct(ImageUploadRepository $imageUploadRepo, ImageUploadValidator $validator)
    {
        $this->imageUploadRepo = $imageUploadRepo;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->imageUploadRepo->pushCriteria(app('Prettus\imageUploadRepo\Criteria\RequestCriteria'));
        $imageUploads = $this->imageUploadRepo->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $imageUploads,
            ]);
        }

        return view('imageUploads.index', compact('imageUploads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageUploadCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function fileStore(ImageUploadCreateRequest $request)
    {
        try {
            $requestData = $request->all();

            $this->validator->with($requestData)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $path = public_path('image_uploads');

            if(!\File::exists($path)) {
                $oldmask = umask(0);
                \File::makeDirectory($path, $mode = 0777, true, true);
                umask($oldmask);
            }

            $receiver = new FileReceiver("filename", $request, HandlerFactory::classFromRequest($request));

            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            $saveStt = $receiver->receive();
            if ($saveStt->isFinished()) {
                $fileName = $this->saveFile($saveStt->getFile(), $path);
                
                $imageUploaded = $this->imageUploadRepo->create([
                    'filename' => $fileName
                ]);
                
                return $this->responseSuccess('Upload Image Successfully');
            }else{
                return $this->responseSuccess('System Processing');
            }

        } catch (ValidatorException $e) {

            return $this->responseError('Error System');
        }
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file, $finalPath)
    {
        $fileName = $this->createFilename($file);

        // $mime = str_replace('/', '-', $file->getMimeType());
        // $dateFolder = date("Y-m-W");
        // $filePath = "upload/{$mime}/{$dateFolder}/";
        // $finalPath = storage_path("app/".$filePath);

        // Image::make($file)->save($path. '/' . $fileName);
        $file->move($finalPath, $fileName);

        return $fileName;
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    public function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName());
        $filename .= "_" . md5(time()) . "." . $extension;
        return $filename;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $imageUpload = $this->imageUploadRepo->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $imageUpload,
            ]);
        }

        return view('imageUploads.show', compact('imageUpload'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $imageUpload = $this->imageUploadRepo->find($id);

        return view('imageUploads.edit', compact('imageUpload'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageUploadUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ImageUploadUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $imageUpload = $this->imageUploadRepo->update($request->all(), $id);

            $response = [
                'message' => 'ImageUpload updated.',
                'data'    => $imageUpload->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->imageUploadRepo->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'ImageUpload deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ImageUpload deleted.');
    }
}
