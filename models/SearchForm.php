<?php

namespace app\models;

use app\lib\HttpClient;
use yii\base\Model;

/**
 * SearchForm is the model behind the Deals Search.
 *
 */
class SearchForm extends Model
{
    const API_URL = 'https://offersvc.expedia.com/offers/v2/getOffers';
    
    public $uid;
    public $page;
    
    public $destinationName;
    public $destinationCountry;
    public $destinationCity;
    
    public $productType;
    
    public $minTripStartDate;
    public $maxTripStartDate;
    
    public $lengthOfStay;
    
    public $minStarRating;
    public $maxStarRating;
    
    public $minTotalRate;
    public $maxTotalRate;
    
    public $minGuestRating;
    public $maxGuestRating;
    
    public $scenario;
    
    public function init()
    {
        $this->productType = 'Hotel';
        $this->uid         = \Yii::$app->user->isGuest?'Guest':\Yii::$app->user->name;;
        $this->page        = 1;
        $this->scenario    ='deal-finder';
    }
    
    /**
     *
     * Create Validation Rule for Each attr
     * @return array the validation rules.
     */
    public function rules()
    {
        
        return [
            [['uid','page'],'required'],
            [['destinationName','destinationCountry','destinationCity'],'string'],
            [['destinationName','destinationCountry','destinationCity'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['productType', 'in', 'range' => ['Hotel','Flight','Package']],
            [['minTripStartDate','maxTripStartDate'], 'date','format' => 'yyyy-MM-dd'],
            [['lengthOfStay'],'integer' ,'min' => 1],
            [['minStarRating','maxStarRating'],'integer' ,'min' => 0],
            [['minTotalRate','maxTotalRate'],'integer' ,'min' => 0],
            [['minTotalRate','maxTotalRate'],'totalRate' ,'skipOnEmpty' => true,'skipOnError'=>true],
            [['minGuestRating','maxGuestRating'],'integer' ,'min' => 0],
            [['minTripStartDate','maxTripStartDate'],'validateDate' ,'skipOnEmpty' => true,],
        ];
    }
    /**
     * @param $attr validator Attribute
     *The Attribute time should not be less than current day
     */
    public function validateDate($attr)
    {
        if (strtotime($this->$attr) < strtotime(date('Y-m-d 00:00:00')) ) {
            $this->addError($attr, 'No need to look back You should focus on future');
        }
    }
    
    public function totalRate($attr) {
        if (!empty($this->maxTotalRate) && $this->maxTotalRate < $this->minTotalRate) {
            $this->addError($attr, 'Min Total Rate Should be less than Max Total Rate');
        }
    }
    
    /**
     * Date should start with ':'
     * @param $attr
     * @return string
     */
    public function dateFormat($str) {
    
        if (strpos($str, ':') !== 0) {
            return ':' .$str;
        }
        return $str;
        
    }
    /**
     * Search for Deals based on productType
     * @return \stdClass array of offers based on  productType
     */
    public function search() {
        // Get match result from API response format
        try {
            $params = $this->attributes;
            //Check if the Date was format correctly
            if (!empty($params['minTripStartDate'])) {
                $params['minTripStartDate']=$this->dateFormat($params['minTripStartDate']);
            }
            if (!empty($params['maxTripStartDate'])) {
                $params['maxTripStartDate']=$this->dateFormat($params['maxTripStartDate']);
            }
            $response = HttpClient::get(self::API_URL, $params, [], [CURLOPT_TIMEOUT => 20]);
            // Check if the return request is Success
            if ($response['info']['code'] == 200) {
                if (!empty($this->productType) && isset($response['response']->offers->{$this->productType}))
                    return $response['response']->offers->{$this->productType};
                return $response['response']->offers;
            }
        } catch (\Exception $e) {
            // Sometime return Exception if API is Down
            \Yii::info("Search Deal Exception {$e->getMessage()}");
        }
        return [];
    }
    
}