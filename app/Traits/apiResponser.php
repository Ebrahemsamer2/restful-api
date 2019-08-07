<?php


namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser {

	protected function successResponse($data, $code) {
		return response()->json($data, $code);
	}


	protected function errorResponse($errorMsg, $code) {
		return response()->json(['error' => $errorMsg, 'code' => $code], $code);
	}

	protected function showAll(Collection $collection, $code = 200) {
		return $this->successResponse(['data' => $collection], $code);
	}

	protected function showOne(Model $model, $code = 200) {
		return $this->successResponse(['data' => $model], $code);
	}

	protected function showMessage($message, $code = 200) {
		return $this->successResponse(['data' => $message], $code);
	}

}

?>