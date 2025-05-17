<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

abstract class BaseBackendController extends Controller
{
    /**
     * The model class name.
     */
    protected string $modelClass;

    /**
     * The view path for this resource.
     */
    protected string $viewPath;

    /**
     * The redirect path after store/update/delete.
     */
    protected string $redirectPath;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $items = $this->getModelQuery()->get();
        $viewData = $this->prepareViewData($items);

        return view($this->getIndexViewPath(), $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory|Application
    {
        $viewData = $this->prepareCreateViewData();

        return view($this->getFormViewPath(), $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(): Application|Redirector|RedirectResponse
    {
        $model = $this->createModel();

        $this->fillBasicAttributes($model);
        $this->processAdditionalData($model);

        $model->save();

        return redirect($this->redirectPath);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View|Factory|Application
    {
        $model = $this->findModel($id);
        $viewData = $this->prepareEditViewData($model);

        return view($this->getFormViewPath(), $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id): Application|Redirector|RedirectResponse
    {
        $model = $this->findModel($id);

        $this->fillBasicAttributes($model);
        $this->processAdditionalData($model);

        $model->save();

        return redirect($this->redirectPath);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): Application|Redirector|RedirectResponse
    {
        $model = $this->findModel($id);
        $model->delete();

        return redirect($this->redirectPath);
    }

    /**
     * Get the model query builder.
     */
    protected function getModelQuery()
    {
        return app($this->modelClass)::query();
    }

    /**
     * Find a model by its ID.
     */
    protected function findModel($id): Model
    {
        return app($this->modelClass)::findOrFail($id);
    }

    /**
     * Create a new model instance.
     */
    protected function createModel(): Model
    {
        return new $this->modelClass;
    }

    /**
     * Fill basic model attributes from request.
     */
    protected function fillBasicAttributes(Model $model): void
    {
        // To be implemented by child classes
    }

    /**
     * Process additional data for the model.
     */
    protected function processAdditionalData(Model $model): void
    {
        // To be implemented by child classes
    }

    /**
     * Prepare data for the index view.
     */
    protected function prepareViewData($items): array
    {
        return [
            strtolower(class_basename($this->modelClass)).'s' => $items,
        ];
    }

    /**
     * Prepare data for the create view.
     */
    protected function prepareCreateViewData(): array
    {
        return [];
    }

    /**
     * Prepare data for the edit view.
     */
    protected function prepareEditViewData(Model $model): array
    {
        return [
            strtolower(class_basename($this->modelClass)) => $model,
        ];
    }

    /**
     * Get the index view path.
     */
    protected function getIndexViewPath(): string
    {
        return $this->viewPath.'.index';
    }

    /**
     * Get the form view path.
     */
    protected function getFormViewPath(): string
    {
        return $this->viewPath.'.'.strtolower(class_basename($this->modelClass));
    }
}
