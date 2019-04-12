<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Loz's F1 stat project</h1>
    <br>
</p>

The project born with the will to aggregate the more of the free informations available for the F1 world championship.

Services used are:

[![Yii2](http://www.yiiframework.com/)](http://www.yiiframework.com/)
[![Ergast](http://ergast.com/mrd/)](http://ergast.com/mrd/)
[![Chart.js](https://www.chartjs.org/)](https://www.chartjs.org/)
[![My weather](http://www.myweather2.com/developer/)](http://www.myweather2.com/developer/)
[![TimezoneDB](https://timezonedb.com)](https://timezonedb.com)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      sources/            contains files for integrations
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The platform has been developed and tested on the following stack:

Apache 2.x
PHP 7.x
Maria DB 10.x


INSTALLATION
------------

### Packages

Install Yii2 basic package following the instructions (the preferred way should be via composer) [![Yii2 installation](https://www.yiiframework.com/doc/guide/2.0/en/start-installation)](https://www.yiiframework.com/doc/guide/2.0/en/start-installation).

Download [![Ergast DB](http://ergast.com/mrd/db/)](http://ergast.com/mrd/db/) and install it.
 
Download [![Timezone DB](https://timezonedb.com/download)](https://timezonedb.com/download) and install it.

### Actions

Register an API key for [![My weather](https://developer.weatherunlocked.com/signup)](https://developer.weatherunlocked.com/signup) service.

### DB modifications

If you plan to install the software from scratch you have to be aware that not all the data from Ergast DB are correct, expecially the circuit countries. 
In order to match ergast records with timezone DB the following corrections are due
~~~
UPDATE circuits SET country = 'United States' WHERE country='USA';
UPDATE circuits SET country = 'United Kingdom' WHERE country='UK';
UPDATE circuits SET country = 'South Korea' WHERE country='Korea';
UPDATE circuits SET country = 'United Arab Emirates' WHERE country='UAE';
~~~
Thus is possible to have the correct timezone for the GP timetable

In order to visualize the correct flags for every nation run the query inside sources/nationalitynation.sql

The following SQL commands fix some ergast issues
~~~
INSERT INTO `status` (`status`) VALUES ('Damage');
UPDATE `races` SET `time` = '14:10:00' WHERE `raceId` = 1012;
~~~


