## Project Setup Instructions

1. Assuming Vagrant/Homestead is installed on your machine
3. Add your local site details in the Homestead.yaml file after clone of repository & do your local site entry in windows hosts file.
4. copy `.env.example` and rename it to `.env` and keep on same root as `composer.json`.
5. Run Command `php -r "require 'vendor/autoload.php'; echo str_random(32).PHP_EOL;"` via cmd to generate your APP_KEY and replace in your .env file.
6. Navigate to `cd ~/Homestead` and type `vagrant ssh`
7. Now type navigate to your local site path i.e: `cd ~/code/MovingRobot`
8. Run command `composer update` it will download all the composer dev dependencies and repositories.
9. Hit the URL `http://robot.local` in your browser/POSTMAN.
10. If all installation steps done correctly you will see `Lumen (5.8.4) (Laravel Components 5.8.*)` in browser/POSTMAN.
11. You are all done with installation.