# Sendlane Sample Project
This readme should hopefully serve as a complete guide to get the Sendlane Sample Project up and running. It is assumed that the project will be cloned onto a mac device (mine is currently out of date, running High Sierra), and php 7.x is already correctly installed.

#### Notes (since this is a sample app, never intended for production...):
- I didn't secure mysql installation
- I bypassed the .env system for most configs, since .env is ignored by git
- Emails are using log driver, and should appear in laravel.log

## Initial Yak Shaving
When reading about valet, I discovered it will not work if something is already listening for connections on port 80. When I checked, using the following command: "sudo lsof -i :80" I determined apache was running for whatever reason.  I had to do the following to stop apache (when stopping normally via the service, it kept restarting):
sudo launchctl unload -w /System/Library/LaunchDaemons/org.apache.httpd.plist

## MySQL (install/run MySQL 5.7)

### Install
brew install mysql@5.7
echo 'export PATH="/usr/local/opt/mysql@5.7/bin:$PATH"' >> /Users/<username>/.bash_profile

### Start MySQL
/usr/local/opt/mysql@5.7/bin/mysql.server start

### Stop MySQL
/usr/local/opt/mysql@5.7/bin/mysql.server stop

## Redis (install/run Redis):
### Install
brew install redis
pecl install redis
ln -sfv /usr/local/opt/redis/*.plist ~/Library/LaunchAgents

### Autostart
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.redis.plist

### Test (run on the command line to ensure Redis is working)
redis-cli ping
SHOULD RETURN: PONG

### Remove Autostart (if you no longer wish to have Redis auto start)
launchctl unload ~/Library/LaunchAgents/homebrew.mxcl.redis.plist

### Uninstall (if you wish to uninstall Redis)
brew uninstall redis
$ rm ~/Library/LaunchAgents/homebrew.mxcl.redis.plist

## Copy project to local computer
- via git clone
- via download zip file
- or however you want to do it

### Install dependencies
Navigate to project root and run: "composer install"

## Setup/Start Valet
echo 'export PATH="~/.composer/vendor/bin:$PATH"' >> /Users/<username>/.bash_profile
valet install
cd /path/to/project
valet link project
valet start

## Create/Seed Database
- create new database called "sendlane" on locally running mysql instance
- navigate back to project root and run: "php artisan migrate --seed"

## Install Horizon
Navigate to project root and run the following:
- composer require laravel/horizon
- php artisan horizon:install

## Populate Queue (takes a couple min for 150k records)
php artisan sendEmails:welcome

## Start Queue Manager
php artisan horizon

## Monitor Queue
Open Browser and navigate to:
http://<project_name>.test/horizon
