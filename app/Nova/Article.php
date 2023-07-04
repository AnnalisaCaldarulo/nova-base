<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;


class Article extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Article>
     */
    public static $model = \App\Models\Article::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'subtitle'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Titolo', 'title')
                ->sortable()
                ->rules('required', 'max:20'),
            Text::make('Sottotitolo', 'subtitle')
                ->sortable()
                ->rules('required', 'max:100'),
            Text::make('Testo', 'body')->rules('required', 'min:10')->hideFromIndex(),
            Boolean::make('Pubblicato', 'is_published')->readonly(function ($request) {
                return !$request->user()->is_editor();
            }),

            Date::make('Creato il', 'created_at')->onlyOnDetail(),
            Date::make('Modificato il', 'updated_at')->onlyOnDetail(),

            Date::make(__('Pubblicato il'), 'published_at')
                ->readOnly(function ($request) {
                    return !$request->user()->is_editor();
                }),
            KeyValue::make('Meta', 'meta')
                ->keyLabel('Proprietà') //nome del campo chiave
                ->valueLabel('Valore') //nome del campo valore
                ->actionText('Aggiungi elemento') //azione del +
                ->rules('json'),
            BelongsTo::make('Autore', 'user', \App\Nova\User::class)
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
