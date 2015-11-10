#README FILE

## Understanding about the Test
### Tasks:
- create test cases for test APIs REST (sonar service)
- use behat to automate it (coding with php)

### Learning:
I started reading about the service (api rest) that I have to test, to understand the logic and domain required.
I read and researched how to code with PHP *(I never coded with that languaje)*.
	
## Installation
### How to install Behat:
I went to the oficial documentation page and I got these steps:
-`curl -sS https://getcomposer.org/installer | php`
-`php composer.phar require behat/behat='~3.0.6'`

### How to install PHP Coding Standards Fixer:
-`./composer.phar global require fabpot/php-cs-fixer`

### Solutions for posible issues during installation:
- The requested PHP extension ext-mbstring * is missing from your system.
		`yum install php-mbstring`
- phpunit/phpunit 4.8.9 requires ext-dom * -> the requested PHP extension dom is missing from your system.
		`yum install php-dom`

## Features and scenarios creation
Once Behat was installed, I created one feature for each API rest to test (PUT, GET, DELETE and GET using UUID).
For each feature, I wrote all scenarios that I believed that are needed.
For more code legibility, I created a "RestClient" class with the functions to call the Rest API using curl command.
Also, there is another class (ProviderPlaceService), where I create the functions required across the different features, that are specific for this Technical Test.
The idea is to have a clear code and could find quickly and easily the functions required.

## Usage
### Running PHP Coding Standards Fixer:
`php php-cs-fixer fix Vendor/Features --level=psr2`

###Running Behat scenarios:
*go to functional folder and run*
1. For run all scenarios and features:
`../../bin/behat`
2. For run all scenarios for a particular feature:
`../../bin/behat --tags=<get | put | delete | uuid>`


## To finish 
I know that there is still room for improvement since it was my first code with PHP, but I'm sure that this code is strong enough.




 