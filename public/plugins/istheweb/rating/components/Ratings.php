<?php namespace Istheweb\Rating\Components;

use Auth;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Str;

use Istheweb\Rating\Models\Rating;
use Istheweb\Shop\Models\Product;
use RainLab\User\Models\Settings as UserSettings;
use RainLab\User\Models\User;

class Ratings extends ComponentBase
{
    public $symbol;
    public $toolsize;
    public $rankId;
    public $rank;
    public $step;

    public $model;
    public $user;
    /**
     * @var
     */
    public $averageRating;

    /**
     * @var
     */
    public $ratingCount;

    public $countsByStar;

    public $ratings;

    public function componentDetails()
    {
        return [
            'name'        => 'istheweb.rating::lang.components.ratings.name',
            'description' => 'istheweb.rating::lang.components.ratings.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'symbol'    => [
                'title'         =>  'istheweb.rating::lang.symbol.title',
                'description'   =>  'istheweb.rating::lang.symbol.description',
                'default'       =>  '&#xf005;',
                'type'          =>  'dropdown',
                'options'       =>  ['&#xf005;' =>'Stars','&#xf004;'=>'Hearts','&#xf06d;'=>'Fire', '&#xf164;'=>'Thumbs up']

            ],
            'toolsize'  => [
                'title'         =>  'istheweb.rating::lang.toolsize.title',
                'description'   =>  'istheweb.rating::lang.toolsize.description',
                'default'       =>  'sm',
                'type'          =>  'dropdown',
                'options'       =>  ['xs' => 'Extra Small' ,'sm'=>'Small', 'md' =>'Medium', 'lg' => 'Large', 'xl'=>'Extra Large']
            ],
            'step'  => [
                'title'         =>  'istheweb.rating::lang.step.title',
                'description'   =>  'istheweb.rating::lang.step.description',
                'default'       => '0.5',
                'type'          => 'dropdown',
                'options'       =>  ['0.5' =>'Half stars','1'=>'One complete stars','0.3'=>'One third star']
            ]
        ];
    }

    public function onRun()
    {
        $this->addJs('/plugins/istheweb/rating/assets/js/star-rating.min.js');
        $this->addCss('/plugins/istheweb/rating/assets/css/star-rating.min.css');
        $this->addCss('/plugins/istheweb/rating/assets/themes/krajee-fa/theme.min.css');
        $this->addJs('/plugins/istheweb/rating/assets/themes/krajee-fa/theme.min.js');
        $this->symbol = $this->property('symbol');
        $this->toolsize = $this->property('toolsize');
        $this->step = $this->property('step');

        $this->model = $this->page['product'] ?: $this->page['post'] ;
        $this->user = $this->page['user'];

        if($this->model){
            $this->averageRating = $this->page['averageRating'] = $this->model->averageRating();
            $this->ratingCount = $this->page['ratingCount'] = $this->model->countRatings();
            if($this->ratingCount > 0){
                $this->getModelStars();
                $this->getModelRatings();
            }
        }
    }

    protected function getModelRatings(){
        $ratings = $this->model->ratings()
            ->with('author')
            ->get();
        $this->ratings = $this->page['ratings'] = $ratings;
    }

    protected function getModelStars(){
        for($i = 1; $i < 6; $i++){
            $this->countsByStar[] = $this->model->countRatingByRate($i);
        }
        $this->page['countsByStar'] = $this->countsByStar;
    }

    public function onRating()
    {
        $model = Product::find(post('modelId'));
        $user = User::find(post('userId'));

        if(post('email')){
            $rating = $model->rating([
                'rating' => post('rate'),
                'review' => post('review')
            ], $user);
        } else {
            $rating = null;
        }

        return $rating;
    }
}