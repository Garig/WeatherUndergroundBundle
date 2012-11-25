WeatherUndergroundBundle
=============

Symfony2 bundle for working with Weather Underground API

Introduction
============

This Bundle enables integration [Weather Underground API](http://www.wunderground.com/weather/api/d/docs) with your Symfony 2 project.

Installation
============

### Add this bundle and kriswallsmith [Buzz](https://github.com/kriswallsmith/Buzz) library to `composer.json` in your project to `require` section:

````
...
    {
        "kriswallsmith/buzz": "0.7",
        "suncat/weather-underground": "dev-master"
    }
...
````

### Add this bundle to your application's kernel:

````
//app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new SunCat\WeatherUndergroundBundle\WeatherUndergroundBundle(),
        // ...
    );
}
````

### Configure the `weather_underground` service in your YAML configuration:

````
#app/config/config.yml
weather_underground:
    apikey: your_api_key
````
### Full conﬁguration

````
#app/conﬁg/conﬁg.yml
weather_underground:
    apikey: your_api_key
    format: json                                                # json/xml
    host_data_features: http://api.wunderground.com             # default: http://api.wunderground.com
    host_autocomlete: http://autocomplete.wunderground.com      # default: http://autocomplete.wunderground.com
````

Usage example
============

``` php

<?php
    // src/Acme/YourBundle/Command/WUForecastCommand.php
    class WUForecastCommand extends ContainerAwareCommand
    {
        /**
        * @see Command
        */
       protected function configure()
       {
           $this
               ->setName('weather_underground:forecast')
               ->setDescription('Import data forecast by cities from api.wunderground.com')
               ->addOption('city', 0, InputOption::VALUE_REQUIRED, 'City name')
               ->setHelp(<<<EOF
   The <info>weather_underground:forecast</info> command import forecast data.

   <info>php app/console weather_underground:forecast --city=Moscow</info>

   EOF
               );
       }

        /**
         * {@inheritdoc}
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $wuApi = $this->getContainer()->get('weather_underground.data_features');
            $wuApi->setFeatures(array('forecast'));
            $cityName = $input->getOption('city');

            if(!$cityName){
                throw new \Exception('Enter city name');
            }

            $wuApi->setQuery('/Russia/' . $cityName, true);
            $data = $wuApi->getData();

            //
            // put your code
            //
        }

    }
```

Run command:

``` php
    php app/console weather_underground:forecast --city=Moscow
```

Data Features examples
============

``` php
    $wuApi->setRequestData(
        array('forecast', 'geolookup'),     // Features
        array('lang' => 'RU'),              // Settings
        'Russia/Moscow'                     // Query
    );
    $data = $wuApi->getData();
```

``` php
    $wuApi->setFeatures(array('forecast', 'geolookup'));     // Features
    $wuApi->setQuery('Russia/Moscow', true);                 // Query
    $data = $wuApi->getData();
```

AutoComplete example
============

``` php
    $wuAutocomplete = $this->getContainer()->get('weather_underground.autocomplete');
    $wuAutocomplete->setOptions(array('c' => 'RU', 'cities' => 1, 'query' => 'Mosc'));
    $data = $wuAutocomplete->getData();
```

Weather Underground API Documentation
============

[Data Features](http://www.wunderground.com/weather/api/d/docs?d=data/index)

[AutoComplete API](http://www.wunderground.com/weather/api/d/docs?d=autocomplete-api)