# Project Title

Moving Robot Problem

### Prerequisites

* Git, Composer, Vagrant and Homestead must be installed on your machine.

## Installation

* Clone the repository to your Machine.
* Add your local site details in the Homestead.yaml file as per your system path to repository & do your local site entry in windows hosts file.
* copy `.env.example` and rename it to `.env` and keep on same root as `composer.json`.
* Navigate to your Homestead directory e.g: `cd ~/Homestead` and type `vagrant ssh`.
* Now type navigate to your repository path i.e: `cd ~/code/MovingRobot`.
* Run command `composer update` it will download all the composer dev dependencies and repositories.
* Execute the artisan command: `php artisan route:call /` to check your installation.
* If all installation steps done correctly you will see `Lumen (5.8.12) (Laravel Components 5.8.*)` on CLI.
* You are all done with installation.

## About The Implementation

* The Implementation is done via `Lumen Laravel Micro Framework`.
* The Route: `run/{fileName}` e.g: `run/sample01` is available for Checking whole process of Moving Robot. 
* Exeute the Command on Project Root `php artisan route:call run/sample01` to check `sample01` file commands.
* Sample Robot Moving Commands files are available here [commandFiles](https://github.com/faisalsiddiq87/MovingRobot/tree/master/public/commandFiles).
* All test cases are available here [tests](https://github.com/faisalsiddiq87/MovingRobot/tree/master/tests).
* Execute command `vendor/bin/phpunit` to check all test cases output.
* For executing single test case from each test case file Execute Command `vendor/bin/phpunit --filter withValidCommands`.
* Please Note: All these commands must be executed after `vagrant ssh` if you configured project via Homestead.