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

		if($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

		$transformer = $collection->first()->transformer;

		$collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
		$collection = $this->transformData($collection, $transformer);
		return $this->successResponse($collection, $code);
	}

	protected function showOne(Model $model, $code = 200) {

		$transformer = $model->transformer;

		$model = $this->transformData($model, $transformer);

		return $this->successResponse($model, $code);
	}

	protected function showMessage($message, $code = 200) {
		return $this->successResponse(['data' => $message], $code);
	}

	public function transformData($data, $transformer) {

		$transformation = fractal($data, new $transformer);

		return $transformation->toArray();

	}

	protected function sortData(Collection $collection, $transformer) {
		if(request()->has('sort_by')) {
			$attr = $transformer::originalAttribute(request()->sort_by);
			$collection = $collection->sortBy->{$attr};
		}
		return $collection;
	}

	protected function filterData(Collection $collection, $transformer) {

		foreach(request()->query() as $attribute => $value) {
			$attribute = $transformer::originalAttribute($attribute);
			if(isset($attribute, $value)) {
				$collection = $collection->where($attribute, $value);
			}
		}
		return $collection;
	}
}

?>