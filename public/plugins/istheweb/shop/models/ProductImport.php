<?php namespace Istheweb\Shop\Models;

use Model;
use Backend\Models\ImportModel;
use ApplicationException;

/**
 * ProductImport Model
 */
class ProductImport extends ImportModel
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'istheweb_shop_products';

    /**
     * Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required',
    ];

    protected $categoryNameCache = [];

    protected $filterNameCache = [];

    protected $featureNameCache = [];

    public function getProductCategoriesOptions()
    {
        return Category::lists('name', 'id');
    }

    public function getProductFiltersOptions()
    {
        return Filter::lists('name', 'id');
    }

    public function getProductFeaturesOptions()
    {
        return Feature::lists('name', 'id');
    }

    public function importData($results, $sessionKey = null)
    {
        $firstRow = reset($results);

        /*
         * Validation
         */
        if ($this->auto_create_categories && !array_key_exists('categories', $firstRow)) {
            throw new ApplicationException('Please specify a match for the Categories column.');
        }

        if ($this->auto_create_filters && !array_key_exists('filters', $firstRow)) {
            throw new ApplicationException('Please specify a match for the Filters column.');
        }

        if ($this->auto_create_features && !array_key_exists('features', $firstRow)) {
            throw new ApplicationException('Please specify a match for the Features column.');
        }

        /*
         * Import
         */
        foreach ($results as $row => $data) {
            try {

                if (!$name = array_get($data, 'name')) {
                    $this->logSkipped($row, 'Missing Product name');
                    continue;
                }

                if(!$slug = array_get($data, 'slug')) {
                    $this->logSkipped($row, 'Missing Product slug');
                    continue;
                }

                /*
                 * Find or create
                 */
                $product = Product::make();

                if ($this->update_existing) {
                    $product = $this->findDuplicateProduct($data) ?: $product;
                }

                $productExists = $product->exists;

                /*
                 * Set attributes
                 */
                $except = ['id', 'categories', 'filters', 'features'];

                foreach (array_except($data, $except) as $attribute => $value) {
                    $product->{$attribute} = $value ?: null;
                }

                $product->forceSave();

                if ($categoryIds = $this->getCategoryIdsForProduct($data)) {
                    $product->categories()->sync($categoryIds, false);
                }

                if ($filterIds = $this->getFilterIdsForProduct($data)) {
                    $product->filters()->sync($filterIds, false);
                }

                if ($featureIds = $this->getFeatureIdsForProduct($data)) {
                    $product->features()->sync($featureIds, false);
                }

                /*
                 * Log results
                 */
                if ($productExists) {
                    $this->logUpdated();
                }
                else {
                    $this->logCreated();
                }
            }
            catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }

    protected function findDuplicateProduct($data)
    {
        if ($id = array_get($data, 'id')) {
            return Product::find($id);
        }

        $name = array_get($data, 'name');
        $product = Product::where('name', $name);

        if ($slug = array_get($data, 'slug')) {
            $product->orWhere('slug', $slug);
        }

        return $product->first();
    }

    protected function getCategoryIdsForProduct($data)
    {
        $ids = [];

        if ($this->auto_create_categories) {
            $categoryNames = $this->decodeArrayValue(array_get($data, 'categories'));

            foreach ($categoryNames as $name) {
                if (!$name = trim($name)) continue;

                if (isset($this->categoryNameCache[$name])) {
                    $ids[] = $this->categoryNameCache[$name];
                }
                else {
                    $newCategory = Category::firstOrCreate(['name' => $name]);
                    $ids[] = $this->categoryNameCache[$name] = $newCategory->id;
                }
            }
        }
        elseif ($this->categories) {
            $ids = (array) $this->categories;
        }

        return $ids;
    }

    protected function getFilterIdsForProduct($data)
    {
        $ids = [];

        if ($this->auto_create_filters) {
            $filterNames = $this->decodeArrayValue(array_get($data, 'filters'));

            foreach ($filterNames as $name) {
                if (!$name = trim($name)) continue;

                if (isset($this->filterNameCache[$name])) {
                    $ids[] = $this->filterNameCache[$name];
                }
                else {
                    $newFilter = Filter::firstOrCreate(['name' => $name]);
                    $ids[] = $this->filterNameCache[$name] = $newFilter->id;
                }
            }
        }
        elseif ($this->filters) {
            $ids = (array) $this->filters;
        }

        return $ids;
    }

    protected function getFeatureIdsForProduct($data)
    {
        $ids = [];

        if ($this->auto_create_features) {
            $featureNames = $this->decodeArrayValue(array_get($data, 'features'));

            foreach ($featureNames as $name) {
                if (!$name = trim($name)) continue;

                if (isset($this->featureNameCache[$name])) {
                    $ids[] = $this->featureNameCache[$name];
                }
                else {
                    $newFeature = Feature::firstOrCreate(['name' => $name]);
                    $ids[] = $this->featureNameCache[$name] = $newFeature->id;
                }
            }
        }
        elseif ($this->features) {
            $ids = (array) $this->features;
        }

        return $ids;
    }

}