<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ImagesCreateRequest;
use App\Http\Requests\ImagesUpdateRequest;
use App\Repositories\ImagesRepository;
use App\Validators\ImagesValidator;

/**
 * Class ImagesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ImagesController extends Controller
{
    /**
     * @var ImagesRepository
     */
    protected $repository;

    /**
     * @var ImagesValidator
     */
    protected $validator;

    /**
     * ImagesController constructor.
     *
     * @param ImagesRepository $repository
     * @param ImagesValidator $validator
     */
    public function __construct(ImagesRepository $repository, ImagesValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $images = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $images,
            ]);
        }

        return view('images.index', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImagesCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ImagesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $image = $this->repository->create($request->all());

            $response = [
                'message' => 'Images created.',
                'data'    => $image->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $image,
            ]);
        }

        return view('images.show', compact('image'));
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
        $image = $this->repository->find($id);

        return view('images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImagesUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ImagesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $image = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Images updated.',
                'data'    => $image->toArray(),
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Images deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Images deleted.');
    }
}
