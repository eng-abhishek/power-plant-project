<?php
use App\Models\Setting;

if (! function_exists('admin_url')) {
    function admin_url()
    {
        $admin_url = 'backend';
        return $admin_url;   
        // try{
        //     $general_settings = \App\Models\Setting::where('key', 'admin')->first();
        //     if($general_settings){
        //         $admin_url = json_decode($general_settings->value)->admin_url;
        //     }
        //     return $admin_url;
        // }catch(\Exception $e){
        //     return $admin_url;
        // }
    }
}

function getNormalImage($document_path,$img_name)
{
    if($img_name != '' && \Storage::exists($document_path.'/'.$img_name)){

        $image = asset('storage/'.$document_path.'/'.$img_name);

        return $image;
    }else{
        return asset('assets/frontend/images/logo/featured-crypto-exchange.png');
    }
}


if (! function_exists('user')) {
  function user($user_id = null)
  {
    if(!is_null($user_id)){

      $user = \App\User::firstOrCreate([
        'name' => $user_id,
        'is_admin' => 'N'
    ]);
      
      return $user;

  }else{

     if(\Cookie::has('unique_user_id') && \Cookie::get('unique_user_id') != ''){
      // if(isset($_COOKIE['unique_user_id'])){
        $cookie_user = \App\User::firstOrCreate([
          'name' => \Cookie::get('unique_user_id'),
          'is_admin' => 'N'
      ]);
    }else{

        do {
          $unique_id = uniqid();

      } while (\App\User::where('name', $unique_id)->exists());

        \Cookie::queue('unique_user_id', $unique_id, time() + (365*24*60*60), '/'); // It generates encrypted cookie

        $cookie_user = new \App\User;
        $cookie_user->name = $unique_id;
        $cookie_user->is_admin = 'N';
        $cookie_user->save();
    }

    return $cookie_user;
}
}
}


function get_order_status($status){

    if($status == 'CREATED' || $status == 'AWAITING_INPUT' || $status == 'wait'){
      return 'Waiting';

  }elseif($status == 'CONFIRMING_INPUT' || $status == 'confirmation'){
      return 'Confirmation';

  }elseif($status == 'CONFIRMING_SEND' || $status == 'confirmed'){
      return 'Confirmed';

  }elseif($status == 'EXCHANGING' || $status == 'exchanging'){
      return 'Exchanging';

  }elseif($status == 'COMPLETE' || $status == 'success' || $status == 'sending_confirmation' || $status =='sending'){
      return 'Completed';

  }elseif($status == 'CANCELLED' || $status =='error'){
     return 'Cancelled';

 }elseif($status == 'REFUNDED' || $status =='refunded' || $status =='refund'){
    return 'Refunded';

}elseif($status == 'overdue'){

    return 'Cancelled';

}else{

  return 'Processing'; 
}  
}

function get_exch_referral(){
    $setting = Setting::take(1)->orderBy('id','desc')->first();
    return isset($setting) ? ( isset(json_decode($setting['data'])->exch_referral_id) ? json_decode($setting['data'])->exch_referral_id : '') : '';
}

function get_godex_referral(){
    $setting = Setting::take(1)->orderBy('id','desc')->first();
    return isset($setting) ? ( isset(json_decode($setting['data'])->godex_referral_id ) ? json_decode($setting['data'])->godex_referral_id : '') : '';
}

function get_api_type(){
    $setting = Setting::take(1)->orderBy('id','desc')->first();
    return isset($setting) ? (isset( json_decode($setting['data'])->user_api_type ) ? json_decode($setting['data'])->user_api_type : '') : '';
}

function get_api_code(){
  $setting = Setting::take(1)->orderBy('id','desc')->first();

  if(isset($setting)){

    if(isset(json_decode($setting['data'])->user_api_type)){

       if(json_decode($setting['data'])->user_api_type == 'godex_api'){
          return 200;
      }else{
          return 401;
      }
  }else{
    return '';
}
}else{
  return '';
}
}

function get_exchange_api($api_name){
 if($api_name == 'godex_api'){
     return "Godex APIs";
 }elseif($api_name == 'exch_api'){
    return "Exch APIs";
}else{
    return "N/A";
}
}

function get_coinranking_key(){
   $setting = Setting::take(1)->orderBy('id','desc')->first();
   return isset($setting) ? (isset( json_decode($setting['data'])->coinranking_api_key ) ? json_decode($setting['data'])->coinranking_api_key : '') : '';
}

if (! function_exists('organization_jsonld')) {
    function organization_jsonld()
    {
        $metadataJson = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Chainswap auto no kyc crypto exchange',
            'alternateName' => 'Chainswap auto no kyc crypto exchange',
            'url' => route('home'),
            'logo' => asset('assets/frontend/images/logo/chainswap.png'),
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'email' => 'Info@chainswap.io',
                    'contactType' => 'email',
                    'areaServed' => [
                        "India",
                        "United States",
                        "Canada",
                        "United Kingdom",
                        "Australia",
                        "New Zealand",
                        "Germany",
                        "Saudi Arabia",
                        "United Arab Emirates",
                        "Japan",
                        "Russia",
                        "Ukraine",
                        "France",
                        "Germany",
                        "Italy",
                        "Portugal",
                        "Spain",
                        "Czech Republic",
                        "Poland",
                        "Turkey",
                        "China",
                        "South Korea",
                        "Brazil",
                        "Argentina",
                        "Netherlands",
                        "Indonesia",
                        "Philippines"
                    ],
                    'availableLanguage' => [
                        "English",
                        "Russian",
                        "French",
                        "Japanese",
                        "German",
                        "Spanish",
                        "Korean"
                    ]
                ]
            ],
            'sameAs' => [
                "https://twitter.com/chainswap_ex",
                "https://t.me/ChainSwap_Ex",
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '3.5',
                'reviewCount' => '50'
            ]
        ];

        return \sprintf(
          "<script type=\"application/ld+json\">%s</script>",
          stripslashes(json_encode($metadataJson, JSON_PRETTY_PRINT))
      );
    }
}

if (! function_exists('breadcrumbs_jsonld')) {
    function breadcrumbs_jsonld($items)
    {
        $metadataJson = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        foreach ($items as $i => $item) {
          $i++;
          $ldItem = [
            '@type' => 'ListItem',
            'position' => $i,
            'name' => $item['title'],
        ];

        if (!empty($item['url'])) {
            $ldItem['item'] = $item['url'];
        }

        $metadataJson['itemListElement'][] = $ldItem;
    }

    return \sprintf(
        "<script type=\"application/ld+json\">%s</script>",
        stripslashes(json_encode($metadataJson, JSON_PRETTY_PRINT))
    );
}
}