## Installation and setup 

Clone Repository 
```
git clone https://github.com/Drooggie/CRM-api.git
``` 

Move into Repository 
```
cd CRM-api
``` 


Run this command for building and starting containers
```
docker compose up -d --build && docker compose logs -f app
```  
<br />

Then you can see your app in <a href="http://localhost:8888/"> localhost:8888</a>

## Commands
I manually created commands for modules manipulation. You can exec theme for creating new modules or deleting. Here is structure of this command.
```
php artisan make:module {name} {folder} --all
```
`name`, `folder` and third argument are necessary for results. All created files will be stored in `Modules` folder and `folder` argument creates name of the folders that will contain everything created by command. Third arguments changeable and defines creation of all module or part of it. Here is available options: <br />
`--all` - creates everything
`--api` - creates api
`--model` - creates model
`--migration` - creates migration
`--controller` - creates controller

