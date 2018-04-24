# Dara Child theme


## Workflow
This project is setup with the gulp task runner, the gulp recipe is based in Ahmad Awais WPGULP https://labs.ahmadawais.com/WPGulp/

#### Step 1. Download the Required Files
Download gulpfile.js, package.json, and .gitignore files inside the root folder of your WordPress plugin or WordPress theme
If you have cURL installed then you can run the following command to download all three files in one go (just make sure you open the root folder of your WordPress plugin or WordPress theme and download these files in the root):
```
curl -O https://raw.githubusercontent.com/ahmadawais/WPGulp/master/package.json && curl -O https://raw.githubusercontent.com/ahmadawais/WPGulp/master/gulpfile.js && curl -O https://raw.githubusercontent.com/ahmadawais/WPGulp/master/.gitignore```

#### STEP 2: Editing the Project Variables
Configure the project variables E.g. paths, translation data, etc. in gulpfile.js. Project variables can be found in the following two comments
```
// START Editing Project Variables.
{PROJECT VARIABLES}
// STOP Editing Project Variables.
```
#### STEP 3: Installing NodeJS, NPM and Gulp
You need to have NodeJS & NPM installed. If it is installed, skip to installing Gulp. Otherwise, download NodeJS and install it. After installing NodeJS, you can verify the install of both NodeJS and Node Package Manager by typing the following commands. This step needs to be followed only once if you don't have NodeJS installed. No need to repeat it ever again.
```
node -v
# Results into v4.2.6

npm -v
# Results into 3.9.0
```
NodeJS and NPM are installed, now we need to install Gulp globally. To do that, run the following command
```
# For MAC OS X; run the following command with super user.
sudo npm install --global gulp

# For Linux; run the following command.
npm install --global gulp
```

#### STEP 4: Installing Node Dependencies
We are in the root folder of our WordPress plugin or WordPress theme at the moment, let's install the Node Dependencies. In the terminal run this command and wait for it to download all the NodeJS dependencies. It's a one-time process and can take about 5 minutes depending on the internet speed of your connection.
```
# For MAC OS X run the following command with super user.
sudo npm install

# For Linux run the following command.
npm install

```
#### STEP 5: Run Gulp
Once the NodeJS dependencies are downloaded just run the following command to get up and running with WPGulp
```
# To start gulp
gulp

# To stop gulp press CTRL (⌃) + C

```
Images and Translation
To optimize images and generate WP POT translation file, you can run the following commands

```
# To optimize images
gulp images

# To generate WP POT translation file.
gulp translate
```
## Troubleshoots

Load certain *npm* Packages on Mac can cause an issue running gulp-sass package, if this is the case, finish npm install and after that install only gulp-sass:
```bash
npm install --save gulp-sass --unsafe-perm
```
