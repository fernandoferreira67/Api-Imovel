<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RealState;
use App\Http\Requests\RealStateRequest;
use App\Api\ApiMessages;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
		$this->realState = $realState;
    }

    public function index()
    {
    	//$realStates = auth('api')->user()->real_state();
        //return response()->json($realStates->paginate(10), 200);

        $realState = $this->realState->paginate('10');
        return response()->json($realState,200);
    }

    public function show($id)
    {
        try{
            $realState = $this->realState->findOrFail($id);

		    return response()->json([
			    'data' => $realState
			    ]
		    , 200);

	    } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
		    return response()->json($message->getMessage(), 401);
	    }
    }

    public function store(RealStateRequest $request)
    {
        $data = $request->all();

        try {

            $realState = $this->realState->create($data);

            return response()->json([
    			'data' => [
    				'msg' => 'Imóvel cadastrado com sucesso!'
			    ]
		    ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
		    return response()->json($message->getMessage(), 401);
        }

    }

    public function update($id, RealStateRequest $request)
    {
	    $data = $request->all();


	    try{
            $realState = $this->realState->findOrFail($id);
			$realState->update($data);

		    return response()->json([
			    'data' => [
				    'msg' => 'Imóvel atualizado com sucesso!'
			    ]
		    ], 200);

	    } catch (\Exception $e) {
		    $message = new ApiMessages($e->getMessage());
		    return response()->json($message->getMessage(), 401);
	    }
    }

    public function destroy($id)
	{
		try{

			$realState = $this->realState->findOrFail($id);

			$realState->delete();

			return response()->json([
				'data' => [
					'msg' => 'Imóvel removido com sucesso!'
				]
			], 200);

		} catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
		    return response()->json($message->getMessage(), 401);
		}
	}
}
