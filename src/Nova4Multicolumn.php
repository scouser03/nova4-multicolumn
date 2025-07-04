<?php

namespace Scouser03\Nova4Multicolumn;

use Laravel\Nova\Fields\Field;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

class Nova4Multicolumn extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova4-multicolumn';

    public function addField($fieldConfig)
    {
        $config = $this->normaliseFieldConfig($fieldConfig);

        $fields = (array_key_exists('sub_fields', $this->meta))
            ? $this->meta['sub_fields']
            : [];

        array_push($fields, $config);

        return $this->withMeta([
            'sub_fields' => $fields,
        ]);
    }

    public function addButtonText($text)
    {
        return $this->withMeta([
            'add_button_text' => $text
        ]);
    }

    public function displayStackedForm()
    {
        return $this->withMeta([
            'display_stacked' => true
        ]);
    }

    public function summaryLabel($label)
    {
        return $this->withMeta([
            'summary_label' => $label
        ]);
    }

    public function initialRows($count)
    {
        return $this->withMeta([
            'initial_rows' => $count
        ]);
    }

    public function maximumRows($count)
    {
        return $this->withMeta([
            'maximum_rows' => $count
        ]);
    }

    public function heading($heading)
    {
        return $this->withMeta([
            "heading" => $heading
        ]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request,
                                                $requestAttribute,
                                                $model,
                                                $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute]);
        }
    }

    public function resolveAttribute($resource, ?string $attribute = null): mixed
    {
        $value = parent::resolveAttribute($resource, $attribute);

        return json_encode($value ?? []);
    }

    private function normaliseFieldConfig($fieldConfig)
    {
        $allowedKeys = ['label', 'name', 'placeholder', 'attributes', 'type', 'width', 'options'];
        $config = array_intersect_key($fieldConfig, array_flip($allowedKeys));

        if(! isset($config['name'])){
            $config['name'] = Str::slug($config['label'], '_');
        }
        if(! isset($config['placeholder'])){
            $config['placeholder'] = $config['label'];
        }
        if(! isset($config['type'])){
            $config['type'] = 'text';
        }
        if(! isset($config['width'])){
            $config['width'] = null;
        }
        if(! isset($config['options'])){
            $config['options'] = [];
        }

        return $config;
    }
}
